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
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://github.com/bkader
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Load Controller
 *
 * This controller load styles, scripts and other assets dynamically.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Load extends KB_Controller
{
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		ob_start('ob_gzhandler');
		$this->output->set_header('Cache-Control: max-age=31536000, must-revalidate');
	}

	// ------------------------------------------------------------------------

	/**
	 * Simple method that does absolutely nothing.
	 * @return 	void
	 */
	public function index()
	{
		show_404();
	}

	// ------------------------------------------------------------------------

	/**
	 * Loading StyleSheets.
	 * @access 	public
	 * @param 	none 	All params are $_GET.
	 * @return 	void
	 */
	public function styles()
	{
		// Let's first make sure there are files first.
		$files = $this->input->get('load');

		// None? Nothing to do.
		if (empty($files))
		{
			die();
		}

		// Let's explode and trim files names.
		$files = array_map('trim', explode(',', $files));

		// Should we use the minified version?
		if ($this->input->get('c') == '1')
		{
			$files = $this->_set_min($files);
		}

		// Prepare output.
		$output = '';

		foreach ($files as $file)
		{
			$output .= $this->_load_file('content/common/css/'.$file.'.css');
		}

		if (empty($output))
		{
			die();
		}
		else
		{
			$output  = "/*! This file is auto-generated */\n".$output;
		}

		// Set header content type and output it.
		$this->output
			->set_content_type('css')
			->set_output($output);
	}

	// ------------------------------------------------------------------------

	/**
	 * Loading JavaScripts.
	 * @access 	public
	 * @param 	none 	All params are $_GET.
	 * @return 	void
	 */
	public function scripts()
	{
		// Let's first make sure there are files first.
		$files = $this->input->get('load');

		// None? Nothing to do.
		if (empty($files))
		{
			die();
		}

		// Let's explode and trim files names.
		$files = array_map('trim', explode(',', $files));

		// Should we use the minified version?
		if ($this->input->get('c') == '1')
		{
			$files = $this->_set_min($files);
		}

		// Prepare output.
		$output = '';

		foreach ($files as $file)
		{
			$output .= $this->_load_file('content/common/js/'.$file.'.js');
		}

		if (empty($output))
		{
			die();
		}
		else
		{
			$output  = "/*! This file is auto-generated */\n".$output;
		}

		// Set header content type and output it.
		$this->output
			->set_content_type('js')
			->set_output($output);
	}

	// ------------------------------------------------------------------------

	/**
	 * Simply appends ".min" to files.
	 * @access 	private
	 * @param 	mixed 	$files 	strings or array.
	 * @return 	the same that was passed.
	 */
	private function _set_min($files)
	{
		if (is_array($files))
		{
			foreach($files as &$file)
			{
				$file .= '.min';
			}
		}
		else
		{
			$files .= '.min';
		}

		return $files;
	}

	// ------------------------------------------------------------------------

	/**
	 * Handles file loading.
	 * @access 	private
	 * @param 	string 	$file
	 * @return 	string
	 */
	private function _load_file($file)
	{
		// Prepare an empty output.
		$output = '';
		// Make sure it's a full URL.
		if (filter_var($file, FILTER_VALIDATE_URL) === FALSE)
		{
			$file = base_url($file);
		}

		if (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $file);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			$output .= curl_exec($curl);
			curl_close($curl);
		}
		else
		{
			$output .= file_get_contents($file);
		}

		return $output;
	}
}
