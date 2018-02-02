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
 * Media Class
 *
 * Manage site's media files.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		// Add AJAX methods.
		array_unshift(
			$this->ajax_methods,
			'create',
			'show',
			'update',
			'delete'
		);
		parent::__construct();

		// Make sure to load media library.
		$this->load->language('media/media_admin');

		$this->theme->add('js', get_common_url('js/media'), 'media');
	}

	// ------------------------------------------------------------------------

	/**
	 * List site's uploaded media.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Make sure to load Dropzone CSS and JS files.
		$this->theme
			->add('css', get_common_url('css/dropzone'), 'dropzone')
			->add('js', get_common_url('js/dropzone'), 'dropzone');

		// Prepare form validation.
		$this->prep_form();

		// Load all media from database.
		$data['media'] = $this->kbcore->media->get_all();

		// Set page title and load view.
		$this->theme
			->set_title(lang('media_library'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	public function create_new()
	{}

	// ------------------------------------------------------------------------

	public function edit($id = 0)
	{
		echo "edit media #{$id}";
	}

	// ------------------------------------------------------------------------

	public function show($id = 0)
	{
		$media = $this->kbcore->media->get($id);
		if ( ! $media)
		{
			return;
		}

		$media->created_at = date('Y/m/d', $media->created_at);
		$media->details = $this->kbcore->metadata->get_meta($id, 'media_meta')->value;

		$this->response->header = 200;
		$this->response->message = json_encode($media);
	}

	// ------------------------------------------------------------------------
	// AJAX Methods.
	// ------------------------------------------------------------------------

	public function create()
	{
		// Make sure to create the upload folder if not found.
		if ( ! is_dir(FCPATH.'content/uploads/'.date('Y/m/')))
		{
			mkdir(FCPATH.'content/uploads/'.date('Y/m/'), 0777, true);
		}

		// We prepare upload library configuration.
		$config['upload_path']      = './content/uploads/'.date('Y/m/');
		$config['allowed_types']    = 'gif|jpg|png';
		$config['file_ext_tolower'] = true;
		$config['encrypt_name']     = true;
		$config['remove_spaces']    = true;

		// Load upload library.
		$this->load->library('upload', $config);

		// An error occured? Return it to browser.
		if ( ! $this->upload->do_upload('file'))
		{
			$this->response->header = 500;
			$this->response->message = $this->upload->display_errors();
		}
		// File uploaded? Proceed.
		else
		{
			// Collect data returned by upload library.
			$data = $this->upload->data();

			/**
			 * Here we are preparing the data of the new attachment
			 * details. Yes, media are also stored in database.
			 */
			$media = array(
				'username' => base_url('content/uploads/'.date('Y/m/').$data['file_name']),
				'name'    => $data['raw_name'],
				'content' => $data['raw_name'],
				'media_meta' => array(
					'width' => $data['image_width'],
					'height' => $data['image_height'],
					'file_name' => $data['file_name'],
					'file_size' => $data['file_size'],
					'file_ext' => $data['file_ext'],
					'file_path' => $data['full_path'],
					'is_image' => $data['is_image'],
					'file_mime' => $data['file_type'],
				),
			);

			// Proceed to creating media object.
			$media_id = $this->kbcore->media->create($media);
			if ( ! $media_id)
			{
				$this->response->header = 500;
				return;
			}

			/**
			 * We retrieve all current theme's images sizes from
			 * database. If there are any, we creation thumbnails.
			 */
			$sizes = get_option('theme_images_'.get_option('theme'));
			if ( ! empty($sizes))
			{
				// Load Image_lib library.
				$this->load->library('image_lib');

				// Loop through all sizes and prepare for creation.
				foreach ($sizes as $name => $details)
				{
					/**
					 * Because we are in a foreach loop, we make sure to
					 * clear the library to avoid issues.
					 */
					$this->image_lib->clear();

					// Prepare image library configuration.
					$config['upload_path']    = './content/uploads/'.date('Y/m/');
					$config['image_library']  = 'gd2';
					$config['source_image']   = $data['full_path'];
					$config['maintain_ratio'] = $details['crop'];
					$config['width']          = $details['width'];
					$config['height']         = $details['height'];
					$config['create_thumb']   = true;
					$config['thumb_marker']   = '-'.$details['width'].'x'.$details['height'];

					// Initialize library and resize the image.
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				}
			}

			// Simple message that's is return to use.
			$this->response->header  = 200;
			$this->response->message = lang('media_upload');
		}
	}

	// ------------------------------------------------------------------------

	public function update($id)
	{
		$_put = file_get_contents('php://input');
		// $temp_data = $data = array();
		// parse_str($_put, $temp_data);

		// foreach ($temp_data as $key => $val)
		// {
		// 	$data[$key] = $temp_data[$key][0]['value'];
		// }
		$this->response->header = 200;
		$this->response->message = 'updated';
	}

	// ------------------------------------------------------------------------

	public function delete($id = 0)
	{
		if ( ! is_numeric($id) OR $id <= 0)
		{
			return;
		}

		// Make sure the file exists.
		$media = $this->kbcore->media->get($id);
		if ( ! $media)
		{
			// $this->response->header = 400;
			return;
		}

		// Proceed to remove from database.
		if ($this->kbcore->media->delete($id))
		{
			$this->response->header = 200;
			$this->response->message = lang('media_delete_success');

			// Make sure to delete the file.
			@array_map(
				'unlink',
				glob(FCPATH.'content/uploads/'.date('Y/m/', $media->created_at).$media->content.'*.*')
			);
		}
		else
		{
			$this->response->header = 500;
			$this->response->message = lang('media_delete_error');
		}
	}

}
