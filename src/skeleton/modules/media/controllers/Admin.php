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
 * 
 * @since 		1.0.0
 * @since 		1.3.0 	Rewritten to make it possible to show single item with get parameter "item".
 * @since 		1.3.3 	Added dynamically loaded asset fies.
 * 
 * @version 	1.3.3
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
		array_push($this->ajax_methods, 'create', 'update', 'delete');

		// Add require assets files.
		array_push($this->styles, 'dropzone');
		array_push($this->scripts, 'dropzone', 'media');

		// Call parent constructor.
		parent::__construct();

		// Make sure to load media library.
		$this->load->language('media/media');
	}

	// ------------------------------------------------------------------------

	/**
	 * List site's uploaded media.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to make it possible to show single item with
	 *         			get parameter "item".
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Prepare form validation.
		$this->prep_form();

		// Load all media from database.
		$data['media'] = $this->kbcore->media->get_all();

		// In case of viewing a single item.
		$item = null;
		$item_id = $this->input->get('item', true);
		if (null !== $item_id 
			&& false !== $db_item = $this->kbcore->media->get($item_id))
		{
			$item = $db_item;

			// Cache details to reduce DB access.
			$item->details = $item->media_meta;

			$item->created_at = date('Y/m/d H:i', $item->created_at);

			$this->load->helper('number');
			$item->file_size = byte_format($item->details['file_size'] * 1024, 2);
		}

		// Pass the item to view.
		$data['item'] = $item;

		// Set page title and load view.
		$this->theme
			->set_title(lang('media_library'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// AJAX Methods.
	// ------------------------------------------------------------------------

	/**
	 * Handles media upload operation.
	 *
	 * @since 	1.0.0
	 * TODO: Still under development.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
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
			$this->response->header = 406;
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
				$this->response->header = 406;
				$this->response->message = lang('media_upload_error');
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

				// Prepare media sizes.
				$media_sizes = array();

				// Loop through all sizes and prepare for creation.
				foreach ($sizes as $name => $details)
				{
					/**
					 * Because we are in a foreach loop, we make sure to
					 * clear the library to avoid issues.
					 */
					$this->image_lib->clear();
					unset($config);

					// Prepare image library configuration.
					$config['upload_path']    = './content/uploads/'.date('Y/m/');
					$config['image_library']  = 'gd2';
					$config['source_image']   = $data['full_path'];
					$config['new_image']      = $config['upload_path'].$data['raw_name'].'-'.$details['width'].'x'.$details['height'].$data['file_ext'];
					$config['maintain_ratio'] = true;

					if ($details['crop'])
					{
						if ($data['image_width'] > $data['image_height']) {
							$config['height'] = $details['height'];
							$config['width']  = ($config['height'] * $data['image_height']) / $data['image_width'];
						} else {
							$config['width']  = $details['width'];
							$config['height']  = ($config['width'] * $data['image_width']) / $data['image_height'];
						}

						// Initialize library and resize the image.
						$this->image_lib->initialize($config);

						// Let's resize the image.
						$status = $this->image_lib->resize();

						// Let's crop it now.
						$this->image_lib->clear();

						$config2['image_library']  = 'gd2';
						$config2['source_image']   = $config['new_image'];
						$config2['width']          = $details['width'];
						$config2['height']         = $details['height'];
						$config2['maintain_ratio'] = false;

						$config2['x_axis'] = ($config['width'] > $config['height']) ? (($config['width'] - $details['width']) / 2) : 0;
						$config2['y_axis'] = ($config['height'] > $details['width']) ? (($config['height'] - $details['height']) / 2) : 0;

						$this->image_lib->initialize($config2);

						$status = $this->image_lib->crop();
					}
					else
					{
						$config['width'] = $details['width'];
						$config['height'] = $details['height'];

						// Initialize library and resize the image.
						$this->image_lib->initialize($config);

						// Let's resize the image.
						$status = $this->image_lib->resize();
					}

					// If successful, add sizes.
					if ($status === true)
					{
						$media_sizes[$name] = array(
							'file'      => $data['raw_name'].'-'.$details['width'].'x'.$details['height'].$data['file_ext'],
							'width'     => $details['width'],
							'height'    => $details['height'],
							'file_mime' => $data['file_type'],
						);
					}
				}

				if ( ! empty($media_sizes))
				{
					$media_meta = $media['media_meta'];
					$media_meta['sizes'] = $media_sizes;
					$this->kbcore->metadata->update_meta($media_id, 'media_meta', $media_meta);
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, sprintf(lang('act_media_upload'), $media_id));

			// Simple message that's is return to use.
			$this->response->header  = 200;
			$this->response->message = lang('media_upload_success');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single media details.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use POST method instead of PUT.
	 * 
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	void
	 */
	public function update($id)
	{
		// Default response header code.
		$this->response->header = 406;

		// we collect data first.
		$data = $this->input->post(null, true);

		// We make sure at least the name is provided.
		if (empty($data['name']))
		{
			$this->response->message = lang('media_update_error');
			return;
		}

		// Try to update.
		if (false !== $this->kbcore->media->update($id, $data))
		{
			$this->response->header  = 200;
			$this->response->message = lang('media_update_success');

			// We log the activity.
			log_activity($this->c_user->id, sprintf(lang('act_media_update'), $id));
			return;
		}

		// Otherwise, media could not be updated.
		$this->response->message = lang('media_update_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single media item.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * @since 	1.3.3 	Rewritten - again- for better code readability.
	 * 
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	void
	 */
	public function delete($id = 0)
	{
		// Default header status code.
		$this->response->header = 406;

		// We get the media from database.
		$media = $this->kbcore->media->get($id);

		// If found and successfully deleted from database.
		if ($media && false !== $this->kbcore->media->delete($id))
		{
			// We set response preferences.
			$this->response->header  = 200;
			$this->response->message = lang('media_delete_success');

			// Make sure to delete the file.
			@array_map(
				'unlink',
				glob(FCPATH.'content/uploads/'.date('Y/m/', $media->created_at).$media->content.'*.*')
			);

			// Log the activity.
			log_activity($this->c_user->id, sprintf(lang('act_media_delete'), $id));

			return;
		}

		// Otherwise, media could not be deleted.
		$this->response->message = lang('media_delete_error');
	}

}
