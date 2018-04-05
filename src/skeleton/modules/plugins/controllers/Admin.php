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
 * Plugins Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
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
		
		// Make sure to load plugins admin language file.
		$this->load->language('plugins/plugins');
	}
	/**
	 * List of available plugins.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Get all plugins.
		$data['plugins'] = $this->kbcore->plugins->get_plugins();

		// Add action buttons.
		if ($data['plugins'])
		{
			foreach ($data['plugins'] as &$plugin)
			{
				// Activation/Deactivation link.
				$plugin['actions'][] = ($plugin['enabled'])
					? safe_admin_anchor('plugins/deactivate/'.$plugin['folder'], lang('deactivate'))
					: safe_admin_anchor('plugins/activate/'.$plugin['folder'], lang('activate'));

				// Plugin settings link.
				if ($plugin['has_settings'])
				{
					$plugin['actions'][] = admin_anchor('plugins/settings/'.$plugin['folder'], lang('settings'));
				}

				// Plugin delete button.
				$plugin['actions'][] = safe_admin_anchor(
					'plugins/delete/'.$plugin['folder'],
					lang('delete'),
					array(
						'class'        => 'text-danger',
						'data-confirm' => sprintf(lang('plugins_delete_confirm'), $plugin['name']),
					)
				);
			}
		}

		// Set page title and load view.
		$this->theme
			->set_title(lang('manage_plugins'))
			// ->set_view('index')
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Display plugin's settings page.
	 * @access 	public
	 * @param 	string 	$plugin 	the plugin's name.
	 * @return 	void
	 */
	public function settings($plugin = null)
	{
		$data['plugin'] = $this->kbcore->plugins->get_plugin($plugin);

		/**
		 * We must check two things:
		 * 1. The plugin mast exist.
		 * 2. The plugin must be activated.
		 */
		if ( ! $data['plugin'])
		{
			set_alert(lang('missing_plugin'), 'error');
			redirect('admin/plugins');
			exit;
		}
		if ( ! $data['plugin']['enabled'])
		{
			set_alert(lang('plugin_disabled'), 'error');
			redirect('admin/plugins');
			exit;
		}
		if ( ! $data['plugin']['has_settings'])
		{
			set_alert(lang('plugin_with_no_settings'), 'error');
			redirect('admin/plugins');
			exit;
		}

		$this->theme
			->set_title(lang('plugin_settings'))
			->render($data);

	}

	// ------------------------------------------------------------------------

	/**
	 * Activate an existing plugin.
	 * @access 	public
	 * @param 	string 	$plugin 	THe plugin's folder name
	 * @return 	void
	 */
	public function activate($plugin)
	{
		// Check safe URL first.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
		}

		// Was the plugin activated?
		elseif ($this->kbcore->plugins->activate($plugin))
		{
			set_alert(lang('plugins_activate_success'), 'success');
		}

		// None of the above?
		else
		{
			set_alert(lang('plugins_activate_error'), 'error');
		}

		// Redirect back to admin plugins page.
		redirect('admin/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Deactivate an existing plugin.
	 * @access 	public
	 * @param 	string 	$plugin 	THe plugin's folder name
	 * @return 	void
	 */
	public function deactivate($plugin)
	{
		// Check safe URL first.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
		}

		// Was the plugin deactivated?
		elseif ($this->kbcore->plugins->deactivate($plugin))
		{
			set_alert(lang('plugins_deactivate_success'), 'success');
		}

		// None of the above?
		else
		{
			set_alert(lang('plugins_deactivate_error'), 'error');
		}

		// Redirect back to admin plugins page.
		redirect('admin/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete an existing plugin.
	 * @access 	public
	 * @param 	string 	$plugin 	THe plugin's folder name
	 * @return 	void
	 */
	public function delete($plugin)
	{
		// Check safe URL first.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
		}

		// Was the plugin deactivated?
		elseif ($this->kbcore->plugins->delete($plugin))
		{
			set_alert(lang('plugins_delete_success'), 'success');
		}

		// None of the above?
		else
		{
			set_alert(lang('plugins_delete_error'), 'error');
		}

		// Redirect back to admin plugins page.
		redirect('admin/plugins');
		exit;
	}

}
