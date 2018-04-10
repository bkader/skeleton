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
 * @since 		1.0.0
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
 * @since 		1.0.0
 * @version 	1.3.3
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
	public function index($type)
	{
		// We prepare the type of assets to load.
		$type = ('scripts' === $type) ? 'js' : 'css';

		// We make sure to collect files if there are any.
		$files = $this->input->get('load', true);
		if (empty($files))
		{
			exit();
		}

		// We format files.
		$minified = ('1' === $this->input->get('c', true));
		$files = $this->_prep_files($files, $minified);

		// We start benchmarking.
		$this->benchmark->mark("load_assets_{$type}_start");

		// Temporary output.
		$out = '';

		// We loop through files and add them to output.
		foreach ($files as $file)
		{
			$out .= $this->_load_file($file, $type);
		}

		// Still no output?
		if ('' === $out)
		{
			exit();
		}

		// In case of CSS files, we make sure to move all @import to top.
		if ('css' === $type 
			&& preg_match_all('/(;?)(@import (?<url>url\()?(?P<quotes>["\']?).+?(?P=quotes)(?(url)\)))/', $out, $matches))
		{
            // remove from out
            foreach ($matches[0] as $import)
            {
                $out = str_replace($import, '', $out);
            }

            // add to top
            $out = implode(';', $matches[2]).';'.trim($out, ';');
		}

		// We make sure to remove all comments on minified files.
		if (true === $minified)
		{
			$regex = array(
				"`^([\t\s]+)`ism"=>'',
				"`^\/\*(.+?)\*\/`ism"=>"",
				"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
				"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
				"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
			);
			$out = preg_replace(array_keys($regex), $regex, $out);
		}

		// We stop benchmarking and add it to output.
		$this->benchmark->mark("load_assets_{$type}_end");
		$bench = $this->benchmark->elapsed_time(
			"load_assets_{$type}_start",
			"load_assets_{$type}_end"
		);

		// We prepare our initial output.
		$output = "/* This file is auto-generated ({$bench} seconds) */\n".$out;

		// We render our final output.
		$this->output
			->set_content_type($type)
			->set_output($output);

	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Prepare files names from string to return the final array if valid files.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	protected
	 * @param 	string 	$files 		String of comma-separated files.
	 * @param 	bool 	$minified 	Whether to request minified files.
	 * @return 	array 	files array after being prepared.
	 */
	protected function _prep_files($files, $minified = false)
	{
		/**
		 * We explode files string into an array then we remove any white
		 * space then make sure to remove duplicated and empty elements.
		 * @var array
		 */
		$files = explode(',', $files);
		$files = array_map('trim', array_unique($files));
		$files = array_filter($files);

		/**
		 * We now format files names in order to remove any found ".min"
		 * extension and add it back only if minified files are requested.
		 * We don't touch the file if it is a full URL.
		 */
		foreach ($files as &$file)
		{
			if (false === filter_var($file, FILTER_VALIDATE_URL))
			{
				$file = str_replace('.min', '', $file);
				(true === $minified) && $file .= '.min';
			}
			else
			{
				$file = urlencode($file);
			}
		}

		// We return the final result.
		return $files;
	}

	// ------------------------------------------------------------------------

	/**
	 * Handles file loading.
	 * @access 	protected
	 * @param 	string 	$file
	 * @param 	string 	$type
	 * @return 	string
	 */
	protected function _load_file($file, $type)
	{
		// Backup the file for later use.
		$old_file = $file;

		// Is it a url?
		$url_file = urldecode($file);
		$is_url = (false !== filter_var($url_file, FILTER_VALIDATE_URL));

		// Prepare an empty output.
		$output = '';

		// Loading from a URL?
		if (true === $is_url)
		{
			$file_path = $url_file;
		}
		// Otherwise, load from disk.
		else
		{
			// Hold the path to the file.
			$file_path = $this->theme->common_path("{$type}/{$file}.{$type}");

			// The file does not exist?
			if (false === $file_path)
			{
				return '';
			}
		}

		// Use cURL if enabled.
		if (true === $is_url && function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $file_path);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			$output .= curl_exec($curl);
			curl_close($curl);
		}
		// Otherwise, simply use file_get_contents.
		else
		{
			$output .= file_get_contents($file_path);
		}

		/**
		 * Remember, we have backed up the file right?
		 * The reason behind this it to set relative paths inside it.
		 * For instance, if an image or a font is used in the CSS file, you might see 
		 * something like this: url("../"). Here we are simply replacing that relative
		 * path and use an absolute path so images or fonts don't get broken.
		 */
		if (pathinfo($file_path, PATHINFO_EXTENSION) === 'css'
			&& preg_match_all('/url\((["\']?)(.+?)\\1\)/i', $output, $matches, PREG_SET_ORDER))
		{
			$search  = array();
			$replace = array();

			// Things to remove.
			$to_remove = array(basename($file_path), $type);
			if (false === $is_url)
			{
				$to_remove[] = $this->theme->common_path();
			}

			$import_url = str_replace($to_remove, '', $file_path);
			if (false === $is_url)
			{
				$import_url = str_replace(
					array('http:', 'https:'),
					'',
					$this->theme->common_url($import_url)
				);

				$import_url = rtrim($import_url, '\\');
			}

			foreach ($matches as $match)
			{
				$count = substr_count($match[2], '../');
				$search[] = str_repeat('../', $count);
				$temp_import_url = $import_url;
				for ($i=1; $i < $count; $i++) { 
					$temp_import_url = str_replace(basename($temp_import_url), '', $temp_import_url);
				}
				$replace[] = rtrim($temp_import_url, '/').'/';
			}
			// Replace everything if the output.
			$output = str_replace(array_unique($search), array_unique($replace), $output);
		}

		// Return the final output.
		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * This method handles old cached assets deletion.
	 * @access 	protected
	 * @return 	void
	 */
	protected function _delete_cache()
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
						OR filemtime($path.$file) < (time() - 86400))
					{
						@unlink($path.$file);
					}
				}
			}

			closedir($handle);
		}
	}
}
