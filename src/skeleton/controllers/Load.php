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

		// Always delete cache.
		$this->_delete_cache();
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

		// Prepare an empty output for later use.
		$output = null;

		// IN PRODUCTION MODE ONLY.
		if (ENVIRONMENT !== 'development')
		{
			// Let's first see if the file was cached or not.
			$cache_file = md5(ENVIRONMENT.implode(',', $files));
			$cache_file_path = APPPATH."cache/assets/{$cache_file}.css";

			// Was the cached file found?
			if (is_file($cache_file_path))
			{
				// Get the content of the file.
				$content = file_get_contents($cache_file_path);

				// Check if the file has expired or not.
				// $expire = substr($content, 0, 10);
				preg_match('/\d+/', $content, $expire);

				/**
				 * If the file is still alive, we make sure to remove 
				 * unnecessary part of content and fill our output.
				 */
				if ((strlen($expire[0]) === 10 && (int) $expire[0] > time() - 86400) 
					&& preg_match('/^(.*)|END-->/', $content, $match))
				{
					$output = trim(str_replace($expire[0].'|END-->', '', $content));
				}
				// Otherwise, delete the file!
				else
				{
					@unlink($cache_file_path);
				}
			}
		}

		// Still no output? Load files then.
		if ($output === null)
		{
			foreach ($files as $file)
			{
				$output .= $this->_load_file('content/common/css/'.$file.'.css');
			}

			// No output? Nothing to do.
			if (empty($output))
			{
				die();
			}

			// We make sure to move all @imports to top.
	        if (preg_match_all('/(;?)(@import (?<url>url\()?(?P<quotes>["\']?).+?(?P=quotes)(?(url)\)))/', $output, $matches)) 
	        {
	            // remove from output
	            foreach ($matches[0] as $import)
	            {
	                $output = str_replace($import, '', $output);
	            }

	            // add to top
	            $output = implode(';', $matches[2]).';'.trim($output, ';');
	        }

			// Prepare our final output.
			$output  = "/*! This file is auto-generated */\n".$output;

			// Prepare the file to be cached.
			if (ENVIRONMENT !== 'development')
			{
				(isset($cache_file_path)) OR $cache_file_path = APPPATH."cache/assets/{$cache_file}.css";
				$cached_output = (time() + 86400).'|END-->'.$output;

				// Let's write the cache file.
				$cache_file_path = fopen($cache_file_path, 'w');
				fwrite($cache_file_path, $cached_output);
				fclose($cache_file_path);
			}
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

		// Prepare an empty output for later use.
		$output = null;

		// IN PRODUCTION MODE ONLY.
		if (ENVIRONMENT !== 'development')
		{
			// Let's first see if the file was cached or not.
			$cache_file = md5(ENVIRONMENT.implode(',', $files));
			$cache_file_path = APPPATH."cache/assets/{$cache_file}.js";

			// Was the cached file found?
			if (is_file($cache_file_path))
			{
				// Get the content of the file.
				$content = file_get_contents($cache_file_path);

				// Check if the file has expired or not.
				// $expire = substr($content, 0, 10);
				preg_match('/\d+/', $content, $expire);

				/**
				 * If the file is still alive, we make sure to remove 
				 * unnecessary part of content and fill our output.
				 */
				if ((strlen($expire[0]) === 10 && (int) $expire[0] > time() - 86400) 
					&& preg_match('/^(.*)|END-->/', $content, $match))
				{
					$output = trim(str_replace($expire[0].'|END-->', '', $content));
				}
				// Otherwise, delete the file!
				else
				{
					// @unlink($cache_file_path);
				}
			}
		}

		// Still no output? Load files then.
		if ($output === null)
		{
			foreach ($files as $file)
			{
				$output .= $this->_load_file('content/common/js/'.$file.'.js');
			}

			// No output? Nothing to do.
			if (empty($output))
			{
				die();
			}

			// Prepare our final output.
			$output  = "/*! This file is auto-generated */\n".$output;

			// Prepare the file to be cached.
			if (ENVIRONMENT !== 'development')
			{
				(isset($cache_file_path)) OR $cache_file_path = APPPATH."cache/assets/{$cache_file}.js";
				$cached_output = (time() + 86400).'|END-->'.$output;

				// Let's write the cache file.
				$cache_file_path = fopen($cache_file_path, 'w');
				fwrite($cache_file_path, $cached_output);
				fclose($cache_file_path);
			}
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
		// Backup the file for later use.
		$old_file = $file;

		// Prepare an empty output.
		$output = '';

		// Make sure it's a full URL.
		if (filter_var($file, FILTER_VALIDATE_URL) === FALSE)
		{
			$file = base_url($file);
		}

		// Check if the file exits first.
		$found = false;
		$file_headers = get_headers($file);
		if (stripos($file_headers[0], '200 OK'))
		{
			$found = true;
		}

		// Not found? Return nothing.
		if ($found === false)
		{
			return "/* Missing file: {$old_file} */";
		}

		// Use cURL if enabled.
		if (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $file);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			$output .= curl_exec($curl);
			curl_close($curl);
		}
		// Otherwise, simply use file_get_contents.
		else
		{
			$output .= file_get_contents($file);
		}

		/**
		 * Remember, we have backed up the file right?
		 * The reason behind this it to set relative paths inside it.
		 * For instance, if an image or a fond is used in the CSS file, 
		 * you might see something like this: url('../').
		 * Here we are simply replacing that relative path and use an
		 * absolute path so image or font don't get broken.
		 */
		if (filter_var($old_file, FILTER_VALIDATE_URL) === FALSE 
			&& pathinfo($file, PATHINFO_EXTENSION) === 'css'
			&& preg_match_all('/url\((["\']?)(.+?)\\1\)/i', $output, $matches, PREG_SET_ORDER))
		{
			$search  = array();
			$replace = array();

			$import_url = str_replace(array('http:', 'https:', basename($file)), '', $file);

			foreach ($matches as $match)
			{
				$count = substr_count($match[2], '../');
				$search[] = str_repeat('../', $count);
				$temp_import_url = $import_url;
				for ($i=1; $i <= $count; $i++) { 
					$temp_import_url = str_replace(basename($temp_import_url), '', $temp_import_url);
				}
				$replace[] = rtrim($temp_import_url, '/').'/';
			}

			// Replace everything if the output.
			$output = str_replace(array_unique($search), array_unique($replace), $output);
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * This method handles old cached assets deletion.
	 * @access 	private
	 * @return 	void
	 */
	private function _delete_cache()
	{
		// Prepare the path to to assets folder.
		$path = APPPATH.'cache/assets/';

		// Let's open the folder to read.
		if ($handle = opendir($path))
		{
			// Loop through all files.
			while(false !== ($file = readdir($handle)))
			{
				/**
				 * Here we are simply ignoring files with .gitkeep extension.
				 * Feel free to remove this check in production environment.
				 */
				if (pathinfo($file, PATHINFO_EXTENSION) !== 'gitkeep')
				{
					/**
					 * If the file is older than 24 hours or we are 
					 * on development environment, we delete file.
					 */
					if (ENVIRONMENT === 'development' 
						OR filemtime($path.$file) < time() - 86400)
					{
						@unlink($path.$file);
					}
				}
			}

			closedir($handle);
		}
	}
}
