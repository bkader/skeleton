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
 * @since 		1.3.4
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_file_helper
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.4
 * @version 	1.3.4
 */

if ( ! function_exists('validate_file'))
{
	/**
	 * Functions for validating a file name and path against an allowed set of rules.
	 * @param 	string 	$file 			The file path.
	 * @param 	array 	$allowed_files 	Array of allowed files.
	 * @return 	bool 	returns TRUE if valid, else FALSE.
	 */
	function validate_file($file, $allowed_files = array())
	{
		$status = TRUE;

		// "../" on its own is not allowed:
		if ('../' === $file)
		{
			$status = FALSE;
		}

		// More than one occurence of "../" is not allowed:
		elseif (preg_match_all('#\.\./#', $file, $matches, PREG_SET_ORDER) && (count($matches) > 1))
		{
			$status = FALSE;
		}

		// "../" which does not occur at the end of the path is not allowed:
		elseif (FALSE !== strpos($file, '../') && '../' !== mb_substr($file, -3, 3))
		{
			$status = FALSE;
		}

		// Files not in the allowed file list are not allowed:
		elseif ( ! empty($allowed_files) && ! in_array($file, $allowed_files))
		{
			$status = FALSE;
		}

		// Absolute Windows drive paths are not allowed:
		elseif (':' == substr($file, 1, 1))
		{
			$status = FALSE;
		}

		return $status;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('check_file_md5'))
{
	/**
	 * Calculates the MD5 of the selected file then compares it to
	 * the expected value.
	 * @param 	string 	$filename 	The file to check MD5 for.
	 * @param 	string 	$expected_md5 	Value used for comparison.
	 * @return 	bool 	TRUE if the MD5 is valid, else FALSE.
	 */
	function check_file_md5($filename, $expected_md5)
	{
		// Valid 32 characters md5 format?
		if (32 === strlen($expected_md5))
		{
			$expected_raw_md5 = pack('H*', $expected_md5);
		}
		// base64 format?
		elseif (24 === strlen($expected_md5))
		{
			$expected_raw_md5 = base64_encode($expected_md5);
		}
		// Unknown format? Nothing to do.
		else
		{
			return FALSE;
		}

		// We md5_file the filename and compare to expected one.
		return (md5_file($filename, TRUE) === $expected_raw_md5);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_file_data'))
{
	/**
	 * Retrieve metadata from the selected file.
	 * @param 	string 	$file 	The full path to the file.
	 * @param 	array 	$default_headers 	Key/value pairs of default headers.
	 * @param 	string 	$context 			If specified, adds a filter hook.
	 * @return 	array 	Array of file headers if successful, else FALSE.
	 */
	function get_file_data($file, $default_headers, $context = '')
	{
		// We attempt to open the file for reading.
		$fp = fopen($file, 'r');

		// We pull only the first 8kiB of the file.
		$file_data = fread($fp, 8192);

		// We close the file because we no longer need it.
		fclose($fp);

		// We make sure to use only CR-only lie endings.
		$file_data = str_replace("\r", "\n", $file_data);

		// If we provided a content and extra headers, we use them.
		if ($context && $extra_headers = apply_filters("extra_{$context}_headers", array()))
		{
			$extra_headers = array_combine($extra_headers, $extra_headers);
			$all_headers   = array_merge($extra_headers, (array) $default_headers);
		}
		// Otherwise, we simply use default headers.
		else
		{
			$all_headers = $default_headers;
		}

		// Now we format the final output before returning it.
		foreach ($all_headers as $key => $val)
		{
			if (preg_match('/^[ \t\/*#@]*'.preg_quote($val, '/').':(.*)$/mi', $file_data, $match)
				&& $match[1])
			{
				$all_headers[$key] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
			}
			else
			{
				$all_headers[$key] = '';
			}
		}

		return $all_headers;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('unzip_file'))
{
	/**
	 * Unzips a specified ZIP file to a location on the disk.
	 * @param 	string 	$file 	Full path and filename of zip archive.
	 * @param	string 	$path 	Full path to extract archive to.
	 * @return 	bool 	TRUE if everything is okey, else false.
	 */
	function unzip_file($file, $path)
	{
		// Prepare an array directories to be created.
		$needed_dirs = array();

		// Format our path.
		$path = rtrim($path, '/\\');

		// Determine any needed parent directories.
		if (FALSE !== is_dir($path))
		{
			$_path = preg_split('![/\\\]!', $path);
			$path_len = count($_path);
			for ($i = $path_len; $i >= 0; $i--)
			{
				if (empty($_path[$i]))
				{
					continue;
				}

				$dir = implode('/', array_slice($_path, 0, $i + 1));

				// Ignore it if it looks like Windows Drive letter.
				if (preg_match('!^[a-z]:$!i', $dir))
				{
					continue;
				}

				// The folder does not exist? Add it.
				if (FALSE === is_dir($dir))
				{
					$needed_dirs[] = $dir;
				}
				// Otherwise, no further action needed.
				else
				{
					break;
				}
			}
		}

		return (class_exists('ZipArchive', FALSE))
			? _unzip_file_ziparchive($file, $path.DIRECTORY_SEPARATOR, $needed_dirs)
			: _unzip_file_pclzip($file, $path.DIRECTORY_SEPARATOR, $needed_dirs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_unzip_file_ziparchive'))
{
	/**
	 * Function for unzipping an archive using the ZipArhive class.
	 * @param 	string 	$file 			The full path to the file.
	 * @param 	string 	$path 			Full path where the archive should be extracted.
	 * @param 	array 	$needed_dirs 	Array of required folders to be created.
	 * @return 	bool 	TRUE if everything goes well, else false.
	 * NOTE: make sure to use "unzip_file" instead, it handles things better.
	 */
	function _unzip_file_ziparchive($file, $path, $needed_dirs = array())
	{
		// Prepare instance of ZipArchive class.
		$zip = new ZipArchive();

		// We open the file and make sure it exists.
		$zip_open = $zip->open($file, ZIPARCHIVE::CHECKCONS);
		if (TRUE !== $zip_open)
		{
			return FALSE;
		}

		// Prepare uncompressed file size.
		$uncompressed_size = 0;

		// We make sure to keep only valid files.
		for ($i = 0; $i < $zip->numFiles; $i++)
		{
			// Could not retrieve file from archive?
			if (FALSE === $info = $zip->statIndex($i))
			{
				return FALSE;
			}

			/**
			 * Now we make sure to skip the OS X-Created __MACOSX directory
			 * then make sure the file is valid, otherwise, skip it.
			 */
			if ('__MACOSX/' === substr($info['name'], 0, 9) 
				OR TRUE !== validate_file($info['name']))
			{
				continue;
			}

			// Increment uncompressed size.
			$uncompressed_size += $info['size'];

			// Is it a directory? Added to needed_dirs array.
			if ('/' === substr($info['name'], -1))
			{
				$needed_dirs[] = $path.rtrim($info['name'], '/\\');
			}
			// Path to a file?
			elseif ('.' !== $dirname = dirname($info['name']))
			{
				$needed_dirs[] = $path.rtrim($dirname, '/\\');
			}
		}

		// We make sure we have enough disk space to proceed.
		$disk_space = @disk_free_space($path);
		if ($disk_space && $disk_space < ($uncompressed_size * 2.1))
		{
			return false;
		}

		// We make sure to keep unique values.
		$needed_dirs = array_unique($needed_dirs);

		// We make sure parent folder or folders all exists within the array.
		foreach ($needed_dirs as $dir)
		{
			/**
			 * We simply skip the working directory because it exists or 
			 * will be created. we also skip the directory if it is not
			 * within the working directory.
			 */
			if (rtrim($path, '/\\') == $dir OR false === strpos($dir, $path))
			{
				continue;
			}

			// We make sure the parent folder is within the array.
			$parent_folder = dirname($dir);
			while ( ! empty($parent_folder) 
				&& rtrim($path, '/\\') != $parent_folder 
				&& ! in_array($parent_folder, $needed_dirs))
			{
				$needed_dirs[] = $parent_folder;
				$parent_folder = dirname($parent_folder);
			}
		}

		// Sort an array and maintain index association.
		asort($needed_dirs);

		// Now we make sure to create directory if needed.
		foreach ($needed_dirs as $_dir)
		{
			if (true !== is_dir($_dir) && false === mkdir($_dir, 0755))
			{
				return false;
			}
		}

		// No longer needed, we remove it.
		unset($needed_dirs);

		// We proceed to creating files.
		for ($i = 0; $i < $zip->numFiles; $i++)
		{
			// Invalid file? Nothing to do.
			if (false === $info = $zip->statIndex($i))
			{
				return false;
			}

			// We skip directories, Mac OSX directory and make sure the file is valid.
			if ('/' == substr($info['name'], -1) 
				OR '__MACOSX/' === substr($info['name'], 0, 9) 
				OR true !== validate_file($info['name']))
			{
				continue;
			}

			// Get file contents and stop if invalid or couldn't be written.
			$contents = $zip->getFromIndex($i);
			if (false === $contents 
				OR false === file_put_contents($path.$info['name'], $contents, 0644))
			{
				return false;
			}
		}

		// We are cool, we close the zip and return TRUE.
		$zip->close();
		return true;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_unzip_file_pclzip'))
{
	/**
	 * Function for unzipping an archive using the PclZip library.
	 * @param 	string 	$file 			The full path to the file.
	 * @param 	string 	$path 			Full path where the archive should be extracted.
	 * @param 	array 	$needed_dirs 	Array of required folders to be created.
	 * @return 	bool 	TRUE if everything goes well, else false.
	 * NOTE: make sure to use "unzip_file" instead, it handles things better.
	 */
	function _unzip_file_pclzip($file, $path, $needed_dirs = array())
	{
		// We make sure to load pclzip file if the class is missing.
		class_exists('PclZip', false) OR import('pclzip/pclzip.lib.php', 'third_party');

		// We create instance of the class then prepare all files.
		$zip = new PclZip($file);
		$zip_files = $zip->extract(PCLZIP_OPT_EXTRACT_AS_STRING);

		// Make sure $zip_files is an array and it contain files.
		if ( ! is_array($zip_files) OR 0 == count($zip_files))
		{
			return false;
		}

		// Prepare uncompressed files size.
		$uncompressed_size = 0;

		// we now determine children directories we need to create.
		foreach ($zip_files as $file)
		{
			// we skip Mac OS X-create folder.
			if ('__MACOSX/' === substr($file['filename'], 0, 9))
			{
				continue;
			}

			// Increment size and add directories.
			$uncompressed_size += $file['size'];
			$needed_dirs[] = $path.rtrim($file['folder'] ? $file['filename'] : dirname($file['filename']), '/\\');
		}

		// We make sure we have enough disk space to proceed.
		$disk_space = @disk_free_space($path);
		if ($disk_space && $disk_space < ($uncompressed_size * 2.1))
		{
			return false;
		}

		// We make sure to keep unique values.
		$needed_dirs = array_unique($needed_dirs);

		// We make sure parent folder or folders all exists within the array.
		foreach ($needed_dirs as $dir)
		{
			/**
			 * We simply skip the working directory because it exists or 
			 * will be created. we also skip the directory if it is not
			 * within the working directory.
			 */
			if (rtrim($path, '/\\') == $dir OR false === strpos($dir, $path))
			{
				continue;
			}

			// We make sure the parent folder is within the array.
			$parent_folder = dirname($dir);
			while ( ! empty($parent_folder) 
				&& rtrim($path, '/\\') != $parent_folder 
				&& ! in_array($parent_folder, $needed_dirs))
			{
				$needed_dirs[] = $parent_folder;
				$parent_folder = dirname($parent_folder);
			}
		}

		// Sort an array and maintain index association.
		asort($needed_dirs);

		// Now we make sure to create directory if needed.
		foreach ($needed_dirs as $_dir)
		{
			if (true !== is_dir($_dir) && false === mkdir($_dir, 0755))
			{
				return false;
			}
		}

		// No longer needed, we remove it.
		unset($needed_dirs);

		// Now we extract files from the archive.
		foreach ($zip_files as $file)
		{
			/**
			 * We make sure to ignore directories, Mac OSX folder and 
			 * make sure the file is valid.
			 */
			if ($file['folder'] 
				OR '__MACOSX/' === substr($file['filename'], 0, 9) 
				OR true !== validate_file($file['filename']))
			{
				continue;
			}

			// Get file contents and stop if invalid or couldn't be written.
			$contents = $zip->getFromIndex($i);
			if (false === $contents 
				OR false === file_put_contents($path.$info['name'], $contents, 0644))
			{
				return false;
			}
		}

		return true;
	}
}
