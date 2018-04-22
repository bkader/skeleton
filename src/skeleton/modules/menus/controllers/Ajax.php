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
 * Menus Module - Ajax Controller.
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
	 * Simply call parent constructor, make sure to load menus language file and 
	 * make sure to add safe admin AJAX methods.
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
		
		// Add AJAX methods.
		array_unshift($this->safe_admin_methods, 'delete');

		// Make sure to load menus language file.
		$this->load->language('menus/menus');
	}

	// ------------------------------------------------------------------------
	// Administration methods.
	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected menu/item from database.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$target 	The target to delete: menu or item.
	 * @param 	int 	$id 		The menu/item ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function delete($target, $id = 0)
	{
		if (true !== $this->check_nonce("delete_{$target}_{$id}"))
		{
			$this->response->header = self::HTTP_BAD_REQUEST;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// We make sure only "menu" or "item" are provided.
		if ( ! $target OR ! in_array($target, array('menu', 'item')))
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// We make sure we provided a valid id.
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Successfully deleted?
		if (false !== $this->kbcore->menus->{"delete_{$target}"}($id))
		{
			$this->response->header = self::HTTP_OK;
			$this->response->message = lang("smn_delete_{$target}_success");

			// We log the activity.
			log_activity($this->c_user->id, "lang:act_menus_delete_{$target}::{$id}");

			return;
		}

		// Otherwise, the item/menu could not be deleted.
		$this->response->message = lang("smn_delete_{$target}_error");
	}

}
