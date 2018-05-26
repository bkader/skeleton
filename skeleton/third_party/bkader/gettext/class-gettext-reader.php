<?php
/**
 * CodeIgniter Skeleton
 *
 * A ready-to-use CodeIgniter skeleton  with tons of new features
 * and a whole new concept of hooks (actions and filters) as well
 * as a ready-to-use and application-free theme and plugins system.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package 	CodeIgniter
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2003, 2005, 2006, 2009 Danilo Segan <danilo@kvota.net>.
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Gettext_reader
{
	private $error = 0;
	
	private $byteorder = 0;
	private $stream = NULL;
	private $short_circuit = false;
	private $enable_cache = false;
	private $originals = NULL;
	private $translations = NULL;
	private $pluralheader = NULL;
	private $total = 0;
	private $table_originals = NULL;
	private $table_translations = NULL;
	private $cache_translations = NULL;
	
	function readint()
	{
		if ($this->byteorder == 0)
		{
			$input = unpack('V', $this->stream->read(4));
			return array_shift($input);
		}
		else
		{
			$input = unpack('N', $this->stream->read(4));
			return array_shift($input);
		}
	}
	
	function read($bytes)
	{
		return $this->stream->read($bytes);
	}
	
	function readintarray($count)
	{
		if ($this->byteorder == 0)
		{
			return unpack('V' . $count, $this->stream->read(4 * $count));
		}
		else
		{
			return unpack('N' . $count, $this->stream->read(4 * $count));
		}
	}
	
	function __construct($reader, $enable_cache = true)
	{
		if (!$reader || isset($reader->error))
		{
			$this->short_circuit = true;
			return;
		}
		
		$this->enable_cache = $enable_cache;
		
		$MAGIC1 = "\x95\x04\x12\xde";
		$MAGIC2 = "\xde\x12\x04\x95";
		
		$this->stream = $reader;
		$magic        = $this->read(4);
		if ($magic == $MAGIC1)
		{
			$this->byteorder = 1;
		}
		elseif ($magic == $MAGIC2)
		{
			$this->byteorder = 0;
		}
		else
		{
			$this->error = 1;
			return false;
		}
		
		$revision = $this->readint();
		
		$this->total        = $this->readint();
		$this->originals    = $this->readint();
		$this->translations = $this->readint();
	}
	
	function load_tables()
	{
		if (is_array($this->cache_translations) && is_array($this->table_originals) && is_array($this->table_translations))
			return;
		
		if (!is_array($this->table_originals))
		{
			$this->stream->seekto($this->originals);
			$this->table_originals = $this->readintarray($this->total * 2);
		}
		if (!is_array($this->table_translations))
		{
			$this->stream->seekto($this->translations);
			$this->table_translations = $this->readintarray($this->total * 2);
		}
		
		if ($this->enable_cache)
		{
			$this->cache_translations = array();
			for ($i = 0; $i < $this->total; $i++)
			{
				$this->stream->seekto($this->table_originals[$i * 2 + 2]);
				$original = $this->stream->read($this->table_originals[$i * 2 + 1]);
				$this->stream->seekto($this->table_translations[$i * 2 + 2]);
				$translation                         = $this->stream->read($this->table_translations[$i * 2 + 1]);
				$this->cache_translations[$original] = $translation;
			}
		}
	}
	
	function get_original_string($num)
	{
		$length = $this->table_originals[$num * 2 + 1];
		$offset = $this->table_originals[$num * 2 + 2];
		if (!$length)
			return '';
		$this->stream->seekto($offset);
		$data = $this->stream->read($length);
		return (string) $data;
	}
	
	function get_translation_string($num)
	{
		$length = $this->table_translations[$num * 2 + 1];
		$offset = $this->table_translations[$num * 2 + 2];
		if (!$length)
			return '';
		$this->stream->seekto($offset);
		$data = $this->stream->read($length);
		return (string) $data;
	}
	
	function find_string($string, $start = -1, $end = -1)
	{
		if (($start == -1) or ($end == -1))
		{
			$start = 0;
			$end   = $this->total;
		}
		if (abs($start - $end) <= 1)
		{
			$txt = $this->get_original_string($start);
			if ($string == $txt)
				return $start;
			else
				return -1;
		}
		else if ($start > $end)
		{
			return $this->find_string($string, $end, $start);
		}
		else
		{
			$half = (int) (($start + $end) / 2);
			$cmp  = strcmp($string, $this->get_original_string($half));
			if ($cmp == 0)
				return $half;
			else if ($cmp < 0)
				return $this->find_string($string, $start, $half);
			else
				return $this->find_string($string, $half, $end);
		}
	}
	
	function translate($string)
	{
		if ($this->short_circuit)
			return $string;
		$this->load_tables();
		
		if ($this->enable_cache)
		{
			if (array_key_exists($string, $this->cache_translations))
				return $this->cache_translations[$string];
			else
				return $string;
		}
		else
		{
			$num = $this->find_string($string);
			if ($num == -1)
				return $string;
			else
				return $this->get_translation_string($num);
		}
	}
	
	function sanitize_plural_expression($expr)
	{
		$expr = preg_replace('@[^a-zA-Z0-9_:;\(\)\?\|\&=!<>+*/\%-]@', '', $expr);
		
		$expr .= ';';
		$res = '';
		$p   = 0;
		for ($i = 0; $i < strlen($expr); $i++)
		{
			$ch = $expr[$i];
			switch ($ch)
			{
				case '?':
					$res .= ' ? (';
					$p++;
					break;
				case ':':
					$res .= ') : (';
					break;
				case ';':
					$res .= str_repeat(')', $p) . ';';
					$p = 0;
					break;
				default:
					$res .= $ch;
			}
		}
		return $res;
	}
	
	function extract_plural_forms_header_from_po_header($header)
	{
		if (preg_match("/(^|\n)plural-forms: ([^\n]*)\n/i", $header, $regs))
			$expr = $regs[2];
		else
			$expr = "nplurals=2; plural=n == 1 ? 0 : 1;";
		return $expr;
	}
	
	function get_plural_forms()
	{
		$this->load_tables();
		
		if (!is_string($this->pluralheader))
		{
			if ($this->enable_cache)
			{
				$header = $this->cache_translations[""];
			}
			else
			{
				$header = $this->get_translation_string(0);
			}
			$expr               = $this->extract_plural_forms_header_from_po_header($header);
			$this->pluralheader = $this->sanitize_plural_expression($expr);
		}
		return $this->pluralheader;
	}
	
	function select_string($n)
	{
		$string = $this->get_plural_forms();
		$string = str_replace('nplurals', "\$total", $string);
		$string = str_replace("n", $n, $string);
		$string = str_replace('plural', "\$plural", $string);
		
		$total  = 0;
		$plural = 0;
		
		eval("$string");
		if ($plural >= $total)
			$plural = $total - 1;
		return $plural;
	}
	
	function ngettext($single, $plural, $number)
	{
		if ($this->short_circuit)
		{
			if ($number != 1)
				return $plural;
			else
				return $single;
		}
		
		$select = $this->select_string($number);
		
		$key = $single . chr(0) . $plural;
		
		
		if ($this->enable_cache)
		{
			if (!array_key_exists($key, $this->cache_translations))
			{
				return ($number != 1) ? $plural : $single;
			}
			else
			{
				$result = $this->cache_translations[$key];
				$list   = explode(chr(0), $result);
				return $list[$select];
			}
		}
		else
		{
			$num = $this->find_string($key);
			if ($num == -1)
			{
				return ($number != 1) ? $plural : $single;
			}
			else
			{
				$result = $this->get_translation_string($num);
				$list   = explode(chr(0), $result);
				return $list[$select];
			}
		}
	}
	
	function pgettext($context, $msgid)
	{
		$key = $context . chr(4) . $msgid;
		$ret = $this->translate($key);
		if (strpos($ret, "\004") !== FALSE)
		{
			return $msgid;
		}
		else
		{
			return $ret;
		}
	}
	
	function npgettext($context, $singular, $plural, $number)
	{
		$key = $context . chr(4) . $singular;
		$ret = $this->ngettext($key, $plural, $number);
		if (strpos($ret, "\004") !== FALSE)
		{
			return $singular;
		}
		else
		{
			return $ret;
		}
		
	}
}
