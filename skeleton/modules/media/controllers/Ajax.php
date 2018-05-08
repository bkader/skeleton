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
 * @link 		https://goo.gl/wGXHO9
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
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.3
 * @version 	1.5.0
 */
class Ajax extends AJAX_Controller {

	/**
	 * __construct
	 *
	 * Simply calling parent's constructor, add AJAX methods and make sure
	 * to load media module language file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
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
		$this->safe_methods[] = 'upload';
		$this->safe_methods[] = 'delete';
		$this->safe_methods[] = 'update';
		$this->safe_methods[] = 'get';
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for AJAX uploading a media file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
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
		// Is it set to data/month structure?
		$date_path = (true === get_option('upload_year_month', true)) ? date('Y/m/') : '';
		$upload_url  = get_upload_url($date_path);

		/**
		 * Fires before uploading files to allow users add extension.
		 * @since 1.4.0
		 */
		$_allowed_types = array('png', 'jpg', 'jpeg', 'gif');
		$allowed_types = apply_filters('media_upload_types', $_allowed_types);
		(empty($allowed_types)) && $allowed_types = $_allowed_types;

		$config['allowed_types']    = implode('|', $allowed_types);
		$config['file_ext_tolower'] = true;
		$config['encrypt_name']     = true;
		$config['remove_spaces']    = true;

		// Load upload library.
		$this->load->library('upload', $config);

		// An error occured? Return it to browser.
		if ( ! $this->upload->do_upload('file'))
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message =$this->upload->display_errors();
			return;
		}
		
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
			'content'    => get_upload_url($date_path.$data['file_name']),
			'media_meta' => array(
				'width'     => $data['image_width'],
				'height'    => $data['image_height'],
				'file_name' => $data['file_name'],
				'file_size' => $data['file_size'],
				'file_ext'  => $data['file_ext'],
				'full_path' => $data['full_path'],
				'file_path' => $data['file_path'],
				'file_url'  => $upload_url,
				'is_image'  => $data['is_image'],
				'file_mime' => $data['file_type'],
				'file_url'  => $upload_url,
				'sizes'     => array(),
			),
		);

		// Proceed to creating media object.
		$media_id = $this->kbcore->media->create($media);
		if (false === $media_id)
		{
			$this->response->header  = self::HTTP_CONFLICT;
			$this->response->message = line('smd_media_upload_error');
			return;
		}

		// Grab back the media item.
		$media['id'] = $media_id;
		$db_media = get_media($media_id);

		/**
		 * We added default thumbnails sizes for dashboard usage.
		 * @since 	1.4.0
		 */
		$crop = get_option('image_thumbnail_crop', true);
		$db_sizes = array(
			'thumbnail' => array(
				'width'  => get_option('image_thumbnail_w', 150),
				'height' => get_option('image_thumbnail_h', 150),
				'crop'   => $crop,
			),
			'medium' => array(
				'width'  => get_option('image_medium_w', 300),
				'height' => get_option('image_medium_h', 300),
				'crop'   => $crop,
			),
			'large' => array(
				'width'  => get_option('image_large_h', 1024),
				'height' => get_option('image_large_w', 1024),
			),
		);

		/**
		 * We retrieve all current theme's images sizes from
		 * database. If there are any, we creation thumbnails.
		 */
		$sizes = get_option('theme_images_'.get_option('theme'), array());
		$sizes = array_merge($sizes, $db_sizes);

		class_exists('CI_Image_lib', false) OR $this->load->library('image_lib');

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
			$new_image = str_replace(
				$data['raw_name'],
				$data['raw_name'].'-'.$details['width'].'x'.$details['height'],
				$data['full_path']
			);

			$config['image_library']  = 'gd2';
			$config['source_image']   = $data['full_path'];
			$config['new_image']      = $new_image;
			$config['maintain_ratio'] = true;
			$config['width']          = $details['width'];
			$config['height']         = $details['height'];

			$this->image_lib->initialize($config);

			if (false === $this->image_lib->process())
			{
				$this->response->header  = self::HTTP_CONFLICT;
				$this->response->message = line('smd_media_upload_error');
				return;
			}

			if (isset($details['crop']) && true === $details['crop'])
			{
				$config['maintain_ratio'] = false;
				$this->image_lib->initialize($config);
				$this->image_lib->process();
			}
			
			$media_sizes[$name] = array(
				'file_name' => basename($new_image),
				'width'     => $details['width'],
				'height'    => $details['height'],
				'file_mime' => $data['file_type'],
			);
		}

		if ( ! empty($media_sizes))
		{
			$media['media_meta']['sizes'] = $media_sizes;
			$db_media->update('media_meta', $media['media_meta']);
		}

		$media['thumbnail']    = get_media_src($db_media, 'thumbnail');
		$media['delete_nonce'] = create_nonce('delete_media_'.$media_id);
		
		log_activity($this->c_user->id, 'lang:act_media_upload::'.$media_id);

		$this->response->header  = self::HTTP_OK;
		$this->response->message = line('smd_media_upload_success');
		$this->response->results = $media;
	}

	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected media file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	void
	 */
	public function delete($id = 0)
	{
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = self::HTTP_BAD_REQUEST;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		if (false === ($media = get_media($id)))
		{
			$this->response->header  = self::HTTP_NOT_FOUND;
			$this->response->message = line('smd_media_missing');
			return;
		}

		if (true !== $this->auth->is_admin() 
			OR $this->c_user->id != $media->owner_id)
		{
			$this->response->header  = self::HTTP_UNAUTHORIZED;
			$this->response->message = line('smd_media_delete_permission');
			return;
		}

		if (false !== $this->kbcore->media->delete($id))
		{
			log_activity($this->c_user->id, 'lang:act_media_delete::'.$id);			
		
			$this->response->header  = self::HTTP_OK;
			$this->response->message = line('smd_media_delete_success');
			return;
		}

		$this->response->message = line('smd_media_delete_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * update
	 *
	 * Method for updating the selected media file details.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The media ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function update($id = 0)
	{
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header = self::HTTP_BAD_REQUEST;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		if (false === $media = (get_media($id)))
		{
			$this->response->header = self::HTTP_NOT_FOUND;
			$this->response->message = line('smd_media_missing');
			return;
			
		}

		if (true !== $this->auth->is_admin() 
			OR $this->c_user->id != $media->owner_id)
		{
			$this->response->header  = self::HTTP_UNAUTHORIZED;
			$this->response->message = line('smd_media_update_permission');
			return;
		}

		$data = $this->input->post(array('name', 'description'), true);

		if (empty($data['name']))
		{
			$this->response->header  = self::HTTP_NO_CONTENT;
			$this->response->message = line('smd_media_update_error');
			return;
		}

		if (false !== $media->update($data))
		{
			log_activity($this->c_user->id, 'lang:act_media_update::'.$id);
			
			$this->response->header  = self::HTTP_OK;
			$this->response->message = line('smd_media_update_success');
			return;
		}

		$this->response->message = line('smd_media_update_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * get
	 *
	 * Method for retrieving all media from the server.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.4.0
	 * @since 	1.5.0 	Format returned medias array.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	AJAX_Controller::response().
	 */
	public function get()
	{
		$db_media = $this->kbcore->media->get_all();
		if (false === $db_media)
		{
			$this->response->header  = self::HTTP_NOT_FOUND;
			$this->response->message = line('smd_media_missing');
			return;
		}

		$media = array();
		$this->load->helper('number');
		/**
		 * Prepare medias before returning them.
		 * @since 	1.5.0
		 */
		foreach ($db_media as $item)
		{
			$_item = $item->to_array();
			$_item['details']    = $item->media_meta;
			$_item['created_at'] = date('Y/m/d H:i', $_item['created_at']);
			$_item['file_size']  = byte_format($_item['details']['file_size'] * 1024, 2);
			$_item['thumbnail']  = (isset($_item['details']['sizes']['thumbnail']))
				? $_item['details']['file_url'].$_item['details']['sizes']['thumbnail']['file_name']
				: $_item['content'];
			
			$media['media'][] = $_item;
		}
		
		$this->response->header = self::HTTP_OK;
		$this->response->results = $media;
	}

	// ------------------------------------------------------------------------

	/**
	 * item
	 *
	 * Retrieve a single media by its ID.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	int 	$id The media id.
	 * @return 	AJAX_Controller::response().
	 */
	public function item($id = 0)
	{
		if ( ! is_numeric($id) OR $id <= 0)
		{
			$this->response->header = self::HTTP_BAD_REQUEST;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		if (false === $media = $this->kbcore->media->get($id))
		{
			$this->response->header = self::HTTP_NOT_FOUND;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		// Cache details to reduce DB access.
		$media->details = $media->media_meta;
		$media->created_at = date('Y/m/d H:i', $media->created_at);

		$this->load->helper('number');
		$media->file_size = byte_format($media->details['file_size'] * 1024, 2);

		$media->delete_btn = safe_ajax_anchor(
			'media/delete/'.$id,
			'delete_media_'.$id,
			line('delete'),
			array(
				'class'    => 'btn btn-danger btn-sm pull-right media-delete',
				'data-id'  => $id,
				'tabindex' => '-1',
			)
		);

		$this->load->helper('form');

		$media->form_nonce = form_nonce('update_media_'.$id);

		$this->response->header = self::HTTP_OK;
		$this->response->message = false;
		$this->response->results = $media;
		return;
	}

}
