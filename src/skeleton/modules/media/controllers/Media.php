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
 * Media Module - Media Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */
class Media extends KB_Controller {

	/**
	 * Method for displaying a media item (experimental).
	 * @access 	public
	 * @param 	mixed 	$media 	The media ID or username.
	 * @return 	void
	 */
	public function index($media = null)
	{
		// If nothing provided, nothing to show.
		if (null === $media)
		{
			die();
		}

		// We remove any extension and hold the size just in case.
		$media = preg_replace('/\\.[^.\\s]{3,4}$/', '', $media);
		$size  = null;

		// Is the size provided?
		if (false !== strpos($media, '-'))
		{
			$exp = explode('-', $media);
			$media = $exp['0'];
			$size = $exp['1'];
		}

		// we prepare and empty 1x1 PNG in case of failure.
		$content = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
		$content_type = 'png';

		// Get the media from database.
		$media = $this->kbcore->media->get($media);

		// Found? proceed.
		if (false !== $media)
		{
			// We store the media path without extension for later use.
			$file_path        = $media->media_meta['file_path'];
			$file_path_no_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_path);

			// we hold the extension for later use.
			$file_ext  = $media->media_meta['file_ext'];

			// Prepare the path to the media file.
			$file_path = $file_path_no_ext.(null === $size ? '' : '-'.$size).$file_ext;

			// Not found with size? Attempt with original file.
			(is_file($file_path)) OR $file_path = $file_path_no_ext.$file_ext;

			// If the file is found, update the content and content type.
			if (is_file($file_path))
			{
				$content = file_get_contents($file_path);
				$content_type = $media->media_meta['file_mime'];
			}
		}

		// Set the output content and display it.
		$this->output
			->set_content_type($content_type)
			->set_output($content);
	}

}
