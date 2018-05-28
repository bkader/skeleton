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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2003, 2005, 2006, 2009 Danilo Segan <danilo@kvota.net>.
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gettext_reader Class
 *
 * Provides a simple gettext replacement that works independently from
 * the system's gettext abilities.
 * It can read MO files and use them for translating strings.
 * The files are passed to Gettext_reader as a Stream.
 * 
 * This version has the ability to cache all strings and translations to
 * speed up the string lookup.
 * While the cache is enabled by default, it can be switched off with the
 * second parameter in the constructor (e.g. when using very large MO files
 * that you don't want to keep in memory)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.0
 * @version 	2.1.0
 */
class Gettext_reader
{
	/**
	 * Holds the error code.
	 * @var integer
	 */
	private $error = 0;
	
	private $byteorder = 0;
	private $stream = null;
	private $short_circuit = false;
	private $cache = false;

	/**
	 * Holds the offset of the original table.
	 */
	private $originals = null;

	/**
	 * Holds the offset of the translation table.
	 */
	private $translations = null;

	/**
	 * Caches the header field for plural forms.
	 * @var string
	 */
	private $plural_header = null;

	/**
	 * Holds the total string count.
	 * @var integer
	 */
	private $total = 0;

	/**
	 * Holds the table for original strings (offsets).
	 * @var array
	 */
	private $table_originals = null;

	/**
	 * Holds a table for translated strings (offsets).
	 * @var array
	 */
	private $table_translations = null;

	/**
	 * Holds a mapping of original to translated strings.
	 * @var array
	 */
	private $cache_translations = null;
	
	/**
	 * Reads a 32bit integer from the Stream.
	 * @access 	private
	 * @param 	none
	 * @return 	int 	Integer from the Stream.
	 */
	private function readint()
	{
		$input = ($this->byteorder == 0)
			? unpack('V', $this->stream->read(4)) 	// Low endian.
			: unpack('N', $this->stream->read(4)); 	// Big endian.
		
		return array_shift($input);
	}

	// ------------------------------------------------------------------------

	/**
	 * Reads byts using Stream_reader::read method.
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	public function read($bytes)
	{
		return $this->stream->read($bytes);
	}

	// ------------------------------------------------------------------------

	/**
	 * Reads an array of integers from the Stream.
	 * @access 	public
	 * @param 	int 	$count 	How many elements should be read.
	 * @return 	array 	Array of integers.
	 */
	public function readintarray($count)
	{
		return ($this->byteorder == 0)
			 ? unpack('V'.$count, $this->stream->read(4 * $count)) 		// Low endian
			 : unpack('N'.$count, $this->stream->read(4 * $count)); 	// Big endian
	}

	// ------------------------------------------------------------------------

	/**
	 * Class constructor.
	 * @access 	public
	 * @param 	object 	$reader 	The Stream_reader object.
	 * @param 	bool 	$cache
	 */
	public function __construct($reader, $cache = true)
	{
		// If there isn't a Stream_reader, turn on short circuit mode.
		if ( ! $reader OR isset($reader->error))
		{
			$this->short_circuit = true;
			return;
		}

		// Caching can be turned off.
		$this->cache = $cache;
		
		// $MAGIC1 = (int)0x950412de; //bug in PHP 5
		$MAGIC1 = "\x95\x04\x12\xde";

		// $MAGIC2 = (int)0xde120495; //bug
		$MAGIC2 = "\xde\x12\x04\x95";
		
		$this->stream = $reader;
		$magic = $this->read(4);
		
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
			$this->error = 1; // Not .mo file.
			return false;
		}
		
		// FIXME: Do we care about revision? We should.
		$revision = $this->readint();
		
		$this->total = $this->readint();
		$this->originals = $this->readint();
		$this->translations = $this->readint();
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Loads the translation tables from the MO file into the cache If caching is
	 * enabled, also loads all strings into a cache to speed up translation lookups.
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function load_tables()
	{
		if (is_array($this->cache_translations) 
			&& is_array($this->table_originals) 
			&& is_array($this->table_translations))
		{
			return;
		}
		
		// Get original and translations tables.
		if ( ! is_array($this->table_originals))
		{
			$this->stream->seekto($this->originals);
			$this->table_originals = $this->readintarray($this->total * 2);
		}

		if ( ! is_array($this->table_translations))
		{
			$this->stream->seekto($this->translations);
			$this->table_translations = $this->readintarray($this->total * 2);
		}
		
		// If cache is turned on, we read strings in it.
		if ($this->cache)
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

	// ------------------------------------------------------------------------

	/**
	 * Returns a string from the "originals" table
	 * @access 	private
	 * @param 	int 	$num 	Offset number of original string.
	 * @return 	string 	Requested string if found, otherwise ''
	 */
	private function get_original_string($num)
	{
		$length = $this->table_originals[$num * 2 + 1];
		$offset = $this->table_originals[$num * 2 + 2];
		
		if ( ! $length)
		{
			return '';
		}
		
		$this->stream->seekto($offset);
		$data = $this->stream->read($length);
		return (string) $data;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns a string from the "translations" table
	 * @access 	private
	 * @param 	int 	$num 	Offset number of original string.
	 * @return 	string 	Requested string if found, otherwise ''.
	 */
	private function get_translation_string($num)
	{
		$length = $this->table_translations[$num * 2 + 1];
		$offset = $this->table_translations[$num * 2 + 2];
		
		if ( ! $length)
		{
			return '';
		}
		
		$this->stream->seekto($offset);
		$data = $this->stream->read($length);
		return (string) $data;
	}

	// ------------------------------------------------------------------------

	/**
	 * Binary search for string.
	 * @access 	private
	 * @param 	string 	$string
	 * @param 	int 	$start 	(internally used in recursive function)
	 * @param 	int 	$end 	(internally used in recursive function)
	 * @return 	int 	string number (offset in originals table)
	 */
	private function find_string($string, $start = -1, $end = -1)
	{
		// find_string is called with only one parameter, set start end end.
		if (($start == -1) OR ($end == -1))
		{
			$start = 0;
			$end   = $this->total;
		}

		// We're done, now we either found the string, or it doesn't exist.
		if (abs($start - $end) <= 1)
		{
			$txt = $this->get_original_string($start);
			return ($string == $txt) ? $start : -1;
		}
		// start > end -> turn around and start over.
		else if ($start > $end)
		{
			return $this->find_string($string, $end, $start);
		}
		// Divide table in two parts.
		else
		{
			$half = (int) (($start + $end) / 2);
			$cmp  = strcmp($string, $this->get_original_string($half));

			// string is exactly in the middle => return it.
			if ($cmp == 0)
			{
				return $half;
			}
			// The string is in the upper half.
			else if ($cmp < 0)
			{
				return $this->find_string($string, $start, $half);
			}
			// The string is in the lower half.
			else
			{
				return $this->find_string($string, $half, $end);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Translates a string.
	 * @access 	public
	 * @param  	string 	$string to be translated
	 * @return 	string 	Translated string (or original, if not found)
	*/
	public function translate($string)
	{
		if ($this->short_circuit)
		{
			return $string;
		}
		
		$this->load_tables();
		
		// Caching enabled, get translated string from cache.
		if ($this->cache)
		{
			return (array_key_exists($string, $this->cache_translations))
				? $this->cache_translations[$string]
				: $string;
		}

		// Caching not enabled, try to find string
		$num = $this->find_string($string);
		return ($num == -1) ? $string : $this->get_translation_string($num);
	}

	// ------------------------------------------------------------------------

	/**
	 * Sanitizes plural form expressions.
	 * @access 	private
	 * @param 	string 	$expression 	The plural form expression.
	 * @return 	string 	The sanitized plural form expression.
	 */
	public function sanitize_plural_expression($expr)
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
					$res .= str_repeat(')', $p).';';
					$p = 0;
					break;
				default:
					$res .= $ch;
			}
		}

		return $res;
	}

	// ------------------------------------------------------------------------

	/**
	 * Extracts plural forms from po header.
	 * @access 	private
	 * @param 	string 	$header
	 * @return 	string 	Plural form expression.
	 */
	private function extract_plural_forms_header_from_po_header($header)
	{
		$expression = (preg_match("/(^|\n)plural-forms: ([^\n]*)\n/i", $header, $regs))
			? $regs[2]
			: "nplurals=2; plural=n == 1 ? 0 : 1;";

		return $expression;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get possible plural forms from MO header.
	 * @access 	private
	 * @return 	string 	Flural form header.
	*/
	private function get_plural_forms()
	{
		// We assume message number 0 is header this is true, right?
		$this->load_tables();
		
		// Cache header field for plural forms.
		if ( ! is_string($this->plural_header))
		{
			$header = ($this->cache) 
				? $this->cache_translations[""]
				: $this->get_translation_string(0);

			$expr = $this->extract_plural_forms_header_from_po_header($header);
			$this->plural_header = $this->sanitize_plural_expression($expr);
		}

		return $this->plural_header;
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Detects which plural form to take.
	 * @access 	private
	 * @param 	int 	$count
	 * @return 	int 	Array index of the right plural form
	*/
	private function select_string($n)
	{
		$string = $this->get_plural_forms();
		$string = str_replace('nplurals', "\$total", $string);
		$string = str_replace("n", $n, $string);
		$string = str_replace('plural', "\$plural", $string);
		
		$total  = 0;
		$plural = 0;
		
		eval("$string");
		
		($plural >= $total) && $plural = $total - 1;

		return $plural;
	}

	// ------------------------------------------------------------------------

	/**
	 * Plural version of gettext.
	 * @access 	public
	 * @param 	string 	$single
	 * @param 	string 	$plural 
	 * @param 	int 	$number
	 * @return 	string 	Translated plural form.
	 */
	public function ngettext($single, $plural, $number)
	{
		if ($this->short_circuit)
		{
			return ($number != 1) ? $plural : $single;
		}
		
		// Find out the appropriate form.
		$select = $this->select_string($number);
		
		// This should contains all strings separated by NULLs.
		$key = $single.chr(0).$plural;

		if ($this->cache)
		{
			if ( ! array_key_exists($key, $this->cache_translations))
			{
				return ($number != 1) ? $plural : $single;
			}
			else
			{
				$result = $this->cache_translations[$key];
				$list = explode(chr(0), $result);
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

	// ------------------------------------------------------------------------

	/**
	 * Context version of gettext.
	 * @access 	public
	 * @param 	string 	$context
	 * @param 	string 	$msgid
	 * @return 	string 	Translated string.
	*/
	public function pgettext($context, $msgid)
	{
		$key = $context.chr(4).$msgid;
		$ret = $this->translate($key);

		return (strpos($ret, "\004") !== false) ? $msgid : $ret;
	}

	// ------------------------------------------------------------------------

	/**
	 * Plural version of pgettext.
	 * @access 	public
	 * @param 	string 	$context
	 * @param 	string 	$single
	 * @param 	string 	$plural 
	 * @param 	int 	$number
	 * @return 	string 	Translated plural form.
	*/
	public function npgettext($context, $singular, $plural, $number)
	{
		$key = $context.chr(4).$singular;
		$ret = $this->ngettext($key, $plural, $number);

		return (strpos($ret, "\004") !== false) ? $singular : $ret;
	}

}
