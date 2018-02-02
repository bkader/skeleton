<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Ajax_Controller
{
	public function __construct()
	{
		// array_unshift(
		// 	$this->actions_post,
		// 	'upload',
		// 	'delete'
		// );
		parent::__construct();

		// Make sure to load media library.
		$this->load->language('media/media_admin');
	}

	// ------------------------------------------------------------------------

	/**
	 * Media upload handler method.
	 * @access 	public
	 * @return 	void
	 */
	public function upload()
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

	public function delete($id)
	{
		// $id = (int) $this->input->post('id', true);
		if ( ! $this->auth->is_admin())
		{
			$this->response->header = 500;
			$this->response->message = lang('error_csrf');
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
		if ($this->kbcore->media->remove($id))
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
