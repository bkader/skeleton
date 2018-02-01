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
		parent::__construct();

		// Make sure to load media library.
		$this->load->language('media/media_admin');
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

		/**
		 * Here we are preparing the upload URL and the
		 * inline dropzone handler script.
		 */
		$upload_url = admin_url('media/upload');
		$dropzone =<<<EOT
\n\t<script>
	var drop = new Dropzone(document.body, {
		url: "{$upload_url}",
		init: function() {
			this.on('thumbnail', function(file, dataUri) {
				$('.attachments').append('<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 attachment attachment"><a href="#" style="background-image: url('+dataUri+')"></a></div>');
			});
		},
		success: function(file, response) {
			location.reload();
		}
	});
	</script>
EOT;
		$this->theme->add_inline('js', $dropzone);

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
			mkdir(FCPATH.'content/uploads/'.date('Y/m/'), 0777);
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
			echo $this->upload->display_errors();
			die();
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
				'name' => $data['raw_name'],
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
			$this->kbcore->media->create($media);

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
			echo lang('media_upload');
			die();
		}
	}
}
