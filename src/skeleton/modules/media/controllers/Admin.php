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
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Admin extends Admin_Controller {

	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		// Call parent constructor.
		parent::__construct();

		// Make sure to load media library.
		$this->load->language('media/media');

		add_filter('admin_head', array($this, '_admin_head'));

		// Add require assets files.
		$this->_dropzone(true)->_handlebars()->_zoom();
		$this->scripts[] = 'media';
	}

	// ------------------------------------------------------------------------

	/**
	 * List site's uploaded media.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to make it possible to show single item with
	 *         			get parameter "item".
	 * @since 	1.4.0 	Added media thumbnail and delete nonce.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		$this->prep_form();
		$this->load->library('pagination');

		$config['base_url']   = $config['first_link'] = admin_url('media');
		$config['total_rows'] = $this->kbcore->media->count();
		$config['per_page']   = 18;

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$limit = $config['per_page'];
		$offset = 0;
		if ($this->input->get('page'))
		{
			$offset = $config['per_page'] * (intval($this->input->get('page')) - 1);
		}

		$this->load->helper('number');

		$data['media'] = $this->kbcore->media->get_all($limit, $offset);

		if ($data['media'])
		{
			foreach ($data['media'] as &$media)
			{
				$media->details = $media->media_meta;
				$media->thumbnail = (isset($media->media_meta['sizes']['thumbnail']))
					? $media->media_meta['file_url'].$media->media_meta['sizes']['thumbnail']['file_name']
					: $media->content;
				$media->created_at = date('Y/m/d H:i', $media->created_at);
				$media->file_size = byte_format($media->details['file_size'] * 1024, 2);
				$media->delete_nonce = create_nonce('delete_media_'.$media->id);
			}
		}

		// In case of viewing a single item.
		$item = null;
		$item_id = $this->input->get('item', true);
		if (null !== $item_id 
			&& false !== $db_item = $this->kbcore->media->get($item_id))
		{
			$item = $db_item;
			$item->details = $item->media_meta;
			$item->created_at = date('Y/m/d H:i', $item->created_at);
			$item->file_size = byte_format($item->details['file_size'] * 1024, 2);
		}

		// Pass the item to view.
		$data['item'] = $item;

		// Set page title and load view.
		$this->theme
			->set_title(line('smd_media_library'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------
	
	/**
	 * Method to add our confirmations alerts to DOM.
	 *
	 * @since 	1.3.3
	 * @since 	1.4.0 	Added nonce to header.
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		// Lines and nonce.
		$lines = array(
			'delete'      => line('smd_media_delete_confirm'),
			'delete_bulk' => line('smd_media_delete_bulk_confirm'),
		);
		
		// Media object.
		$media = array(
			'uploadUrl'  => ajax_url('media/upload'),
			'previewUrl' => ajax_url('media/item'),
			'deleteUrl' => ajax_url('media/delete'),
		);
		
		// Nonce protection.
		$nonce = array(
			'name' => 'media_upload',
			'value' => create_nonce('media_upload')
		);
		
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.media = '.json_encode($lines).';';
		$output .= ' csk.media = '.json_encode($media).';';
		$output .= ' csk.nonce = '.json_encode($nonce).';';
		$output .= '</script>';
		
		return $output;
	}

}
