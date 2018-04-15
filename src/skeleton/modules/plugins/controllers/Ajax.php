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
 * Plugins Module - Ajax Controller.
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
class Ajax extends AJAX_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent constructor, load language file and add our safe methods.
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
		
		// Make sure to load plugins admin language file.
		$this->load->language('plugins/plugins');

		// Protected AJAX methods.
		array_unshift($this->safe_admin_methods, 'activate', 'deactivate', 'delete');
	}

	// ------------------------------------------------------------------------
	// Administration methods.
	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activating the selected plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	AJAX_Controller::response()
	 */
	public function activate($plugin = null)
	{
		// Default header status code.
		$this->response->header = 406;

		// No plugin slug provided?
		if (empty($plugin) OR ! is_string($plugin))
		{
			$this->response->header  = 412;
			$this->response->message = lang('spg_plugin_missing');
			return;
		}

		// Successfully activated?
		if ($this->kbcore->plugins->activate($plugin))
		{
			$this->response->header   = 200;
			$this->response->message = lang('spg_plugin_activate_success');

			// Get the plugin data from database to log the activity.
			$p = $this->kbcore->plugins->get_plugin_info($plugin);
			log_activity($this->c_user->id, 'lang:act_plugin_activate::'.$p['name']);

			return;
		}

		// Otherwise, the plugin could not be activated.
		$this->response->message = lang('spg_plugin_activate_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * deactivate
	 *
	 * Method for deactivating the selected plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	AJAX_Controller::response()
	 */
	public function deactivate($plugin)
	{
		// Default header status code.
		$this->response->header = 406;

		// No plugin slug provided?
		if (empty($plugin) OR ! is_string($plugin))
		{
			$this->response->header  = 412;
			$this->response->message = lang('spg_plugin_missing');
			return;
		}

		// Successfully activated?
		if ($this->kbcore->plugins->deactivate($plugin))
		{
			$this->response->header   = 200;
			$this->response->message = lang('spg_plugin_deactivate_success');

			// Get the plugin data from database to log the activity.
			$p = $this->kbcore->plugins->get_plugin_info($plugin);
			log_activity($this->c_user->id, 'lang:act_plugin_deactivate::'.$p['name']);
			return;
		}

		// Otherwise, the plugin could not be deactivated.
		$this->response->message = lang('spg_plugin_deactivate_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected plugin and all its data.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	AJAX_Controller::response()
	 */
	public function delete($plugin)
	{
		// Default header status code.
		$this->response->header = 406;

		// No plugin slug provided?
		if (empty($plugin) OR ! is_string($plugin))
		{
			$this->response->header  = 412;
			$this->response->message = lang('spg_plugin_missing');
			return;
		}

		// Successfully deleted?
		if ($this->kbcore->plugins->delete($plugin))
		{
			$this->response->header   = 200;
			$this->response->message = lang('spg_plugin_delete_success');

			// Get the plugin data from database to log the activity.
			$p = $this->kbcore->plugins->get_plugin_info($plugin);
			log_activity($this->c_user->id, 'lang:act_plugin_delete::'.$p['name']);
			return;
		}

		// Otherwise, the plugin could not be deleted.
		$this->response->message = lang('spg_plugin_delete_error');
	}

}
