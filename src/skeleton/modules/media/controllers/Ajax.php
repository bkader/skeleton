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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media Module - Ajax Controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.4.0
 */
class Ajax extends AJAX_Controller {

	/**
	 * __construct
	 *
	 * Simply calling parent's constructor, add AJAX methods and make sure
	 * to load media module language file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We make sure to load the media language.
		$this->load->language('media/media');

		// We add our safe AJAX methods.
		array_push($this->safe_methods, 'upload', 'delete', 'update');
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for AJAX uploading a media file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @since 	1.4.0 	Change the response to return the URL of the uploaded image.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	AJAX_Controller::response().
	 */
	public function upload()
	{
		// Default message to return.
		$response = array(
			'uploaded' => false,
			'fileName' => null,
			'url'      => null,
			'message'  => null,
		);

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
			$this->response->header  = 406;
			$response['message']      = $this->upload->display_errors();
			$this->response->message = $response;
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
				'owner_id'   => $this->auth->user_id(),
				'username'   => $data['raw_name'],
				'name'       => $data['raw_name'],
				'content'    => base_url('content/uploads/'.date('Y/m/').$data['file_name']),
				'media_meta' => array(
					'width'     => $data['image_width'],
					'height'    => $data['image_height'],
					'file_name' => $data['file_name'],
					'file_size' => $data['file_size'],
					'file_ext'  => $data['file_ext'],
					'file_path' => $data['full_path'],
					'is_image'  => $data['is_image'],
					'file_mime' => $data['file_type'],
				),
			);

			// Proceed to creating media object.
			$media_id = $this->kbcore->media->create($media);
			if ( ! $media_id)
			{
				$this->response->header = 406;
				$response['message'] = lang('smd_media_upload_error');
				$this->response->message = $response;
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
			log_activity($this->c_user->id, 'lang:act_media_upload::'.$media_id);

			// Simple message that's is return to use.
			$message['uploaded'] = true;
			$message['fileName'] = $data['file_name'];
			$message['url']      = $media['content'];
			$message['message']  = lang('smd_media_upload_success');
			
			$this->response->header  = 200;
			$this->response->message = $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected media file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	void
	 */
	public function delete($id = 0)
	{
		// Default header status code.
		$this->response->header = 406;

		// Did we provide a valid $id?
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// We get the media from database.
		$media = $this->kbcore->media->get($id);

		// Only an admin OR the owner can delete the media.
		if (false === $this->auth->is_admin() 
			OR $this->auth->user_id() != $media->owner_id)
		{
			$this->response->header  = 401;
			$this->response->message = lang('smd_media_delete_permission');
			return;
		}

		// If found and successfully deleted from database.
		if ($media && false !== $this->kbcore->media->delete($id))
		{
			// We set response preferences.
			$this->response->header  = 200;
			$this->response->message = lang('smd_media_delete_success');

			// Make sure to delete the file.
			@array_map(
				'unlink',
				glob(FCPATH.'content/uploads/'.date('Y/m/', $media->created_at).$media->content.'*.*')
			);

			// Log the activity.
			log_activity($this->c_user->id, 'lang:act_media_delete::'.$id);

			return;
		}

		// Otherwise, media could not be deleted.
		$this->response->message = lang('smd_media_delete_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * update
	 *
	 * Method for updating the selected media file details.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function update($id = 0)
	{
		// Default response header code.
		$this->response->header = 406;

		// Did we provide a valid $id?
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Get the media from database.
		$media = $this->kbcore->media->get($id);

		// Only an admin OR the owner can update the media.
		if (true !== $this->auth->is_admin() 
			OR $this->auth->user_id() != $media->owner_id)
		{
			$this->response->header  = 401;
			$this->response->message = lang('smd_media_update_permission');
			return;
		}

		// we collect data first.
		$data = $this->input->post(null, true);

		// We make sure at least the name is provided.
		if (empty($data['name']))
		{
			$this->response->message = lang('smd_media_update_error');
			return;
		}

		// Try to update.
		if (false !== $this->kbcore->media->update($id, $data))
		{
			$this->response->header  = 200;
			$this->response->message = lang('smd_media_update_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_media_update::'.$id);
			return;
		}

		// Otherwise, media could not be updated.
		$this->response->message = lang('smd_media_update_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * get
	 *
	 * Method for retrieving all media from the server.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	AJAX_Controller::response().
	 */
	public function get()
	{
		$media = array();
		$db_media = $this->kbcore->media->get_all();
		if (false === $db_media)
		{
			$this->response->header = 404;
		}
		else
		{
			$this->response->header = 200;
			foreach ($db_media as $item)
			{
				$media['media'][] = $item->to_array();
			}
		}
		$this->response->message = $media;
	}

}
