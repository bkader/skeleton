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
 * 
 * @since 		1.0.0
 * @since 		1.3.0 	Rewritten to make it possible to show single item with get parameter "item".
 * @since 		1.3.3 	Added dynamically loaded asset files and moved AJAX methods to media Controller.
 * 
 * @version 	1.3.3
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
		array_push($this->styles, 'dropzone');
		array_push($this->scripts, 'dropzone', 'lazyload', 'media');
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
			->set_title(lang('smd_media_library'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------
	
	/**
	 * Method to add our confirmations alerts to DOM.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		$lines = array('delete' => lang('smd_media_delete_confirm'));
		$output .= '<script type="text/javascript">var i18n=i18n||{};i18n.media='.json_encode($lines).';</script>';
		return $output;
	}

}
