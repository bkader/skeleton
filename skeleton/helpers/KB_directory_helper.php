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
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_directory_helper
 *
 * Extends CodeIgniter directory helper.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.3
 * @version 	2.1.0
 */

if ( ! function_exists('directory_delete'))
{
	/**
	 * Delete all directory's files and subdirectories.
	 * @param 	string 	$dir 	The directory path to delete.
	 * @return 	bool 	true if delete, else false.
	 */
	function directory_delete($dir)
	{
		// We make sure $dir is a valid directory first.
		if (is_dir($dir))
		{
			// Let's collect its elements.
			$elements = scandir($dir);
			foreach ($elements as $element)
			{
				// We ignore some of elements.
				if ( ! in_array($element, array('.', '..', '.git', '.github')))
				{
					// Directory?
					if (is_dir($dir.'/'.$element))
					{
						directory_delete($dir.'/'.$element);
					}
					// A file?
					else
					{
						unlink($dir.'/'.$element);
					}
				}
			}

			// Now we remove the main directory.
			rmdir($dir);
			return true;
		}

		return false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('directory_files'))
{
	/**
	 * Returns a list of all files in the selected directory and all its 
	 * subdirectories up to 100 levels deep.
	 *
	 * @since 	1.3.4
	 *
	 * @param 	string 	$path 	The full path to the directory.
	 * @param 	int 	$levels 	How deeper we shall go.
	 * @param 	array 	$exclude 	Array of folders/files to skip.
	 * @return 	mixed 	Array of files if found, else false.
	 */
	function directory_files($path = '', $levels = 100, $exclude = array())
	{
		// Nothing to do if no path or levels provided.
		if (empty($path) OR ! $levels)
		{
			return false;
		}

		// We format path and prepare an empty files array.
		$path  = rtrim($path, '/\\').'/';
		$files = array();

		// We open the directory and make sure it's valid.
		$dir = @opendir($path);
		if (false !== $dir)
		{
			while (false !== ($file = readdir($dir)))
			{
				/**
				 * We make sure to skip current and parent folders links, as well
				 * as hidden and excluded files.
				 */
				if (in_array($file, array('.', '..'), true) 
					OR ('.' === $file[0] OR in_array($file, $exclude, true)))
				{
					continue;
				}

				// In case of a directory, we list its files.
				if (is_dir($path.$file))
				{
					$files2 = directory_files($path.$file, $levels - 1);
					if ( ! empty($files2))
					{
						$files = array_merge($files, $files2);
					}
					else
					{
						$files[] = $path.$file.'/';
					}
				}
				// Is is a file?
				else
				{
					$files[] = $path.$file;
				}
			}
		}

		// We close the directory and return files.
		@closedir($dir);
		return $files;
	}
}
