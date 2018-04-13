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
 * Plugins Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added admin head part and JS file.
	 * 
	 * @return 	void
	 */
	public function __construct()
	{
		// Protected AJAX methods.
		array_unshift($this->safe_ajax_methods, 'activate', 'deactivate', 'delete');

		// Call parent constructor.
		parent::__construct();
		
		// Make sure to load plugins admin language file.
		$this->load->language('plugins/plugins');

		// Add our head string.
		add_filter('admin_head', array($this, '_admin_head'));

		// We add JS file.
		array_push($this->scripts, 'plugins');
	}

	// ------------------------------------------------------------------------

	/**
	 * List of available plugins.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten for better code and active filter.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Get all plugins.
		$plugins = $this->kbcore->plugins->get_plugins();

		// Prepare counters.
		$count_all      = 0;
		$count_active   = 0;
		$count_inactive = 0;

		// Filter displayed plugins.
		$filter = $this->input->get('status');
		if ( ! in_array($filter, array('active', 'inactive')))
		{
			$filter = null;
		}

		// Add action buttons.
		if ($plugins)
		{
			foreach ($plugins as $slug => &$plugin)
			{
				// Increment counters.
				$count_all++;
				(true === $plugin['enabled']) && $count_active++;
				(false === $plugin['enabled']) && $count_inactive++;

				if (true === $plugin['enabled'] && 'inactive' === $filter)
				{
					unset($plugins[$slug]);
					continue;
				}

				if (false === $plugin['enabled'] && 'active' === $filter)
				{
					unset($plugins[$slug]);
					continue;
				}

				// So we can reset things.
				$plugin['actions'] = array();

				// Activate/Deactivate plugin.
				$_status = (true === $plugin['enabled']) ? 'deactivate' : 'activate';
				$plugin['actions'][] = safe_admin_anchor("plugins/{$_status}/{$slug}", lang('spg_'.$_status), "class=\"plugin-{$_status}\"");

				// Does the plugin have a settings page?
				if (true === $plugin['has_settings'])
				{
					$plugin['actions'][] = admin_anchor('plugins/settings/'.$slug, lang('spg_settings'));
				}

				// We add the delete plugin only if the plugin is not enabled.
				if (true !== $plugin['enabled'])
				{
					$plugin['actions'][] = safe_admin_anchor(
						"plugins/delete/{$slug}",
						lang('spg_delete'),
						'class="plugin-delete text-danger" data-plugin="'.$slug.'"'
					);
				}
			}
		}

		// Data to pass to view.
		$data = array(
			'plugins'        => $plugins,
			'filter'         => $filter,
			'count_all'      => $count_all,
			'count_active'   => $count_active,
			'count_inactive' => $count_inactive,
		);

		// Set page title and load view.
		$this->theme
			->set_title(lang('spg_manage_plugins'))
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
		// Get the plugin first.
		$plugin = $this->kbcore->plugins->get_plugin($plugin);

		// The plugin does not exists?
		if ( ! $plugin)
		{
			set_alert(lang('spg_plugin_missing'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// Disabled? It needs to be enabled first.
		if ( ! $plugin['enabled'])
		{
			set_alert(lang('spg_plugin_settings_disabled'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// It does not have a settings page?
		if ( ! $plugin['has_settings'])
		{
			set_alert(lang('spg_plugin_settings_missing'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// Set page title and render view.
		$this->theme
			->set_title(sprintf(lang('spg_plugin_settings_name'), $plugin['name']))
			->render(array('plugin' => $plugin));

	}

	// ------------------------------------------------------------------------
	// AJAX methods.
	// ------------------------------------------------------------------------

	/**
	 * Activate an existing plugin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten to be an AJAX method.
	 * 
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	void
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
	 * Deactivate an existing plugin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten to be an AJAX method.
	 * 
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	void
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
	 * Delete an existing plugin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten to be an AJAX method.
	 * 
	 * @access 	public
	 * @param 	string 	$plugin 	The plugin's folder name
	 * @return 	void
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

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Add some plugin language lines to head section.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		$lines = array('delete' => lang('spg_plugin_delete_confirm'));
		$output .= '<script type="text/javascript">var i18n=i18n||{};i18n.plugins='.json_encode($lines).';</script>';
		return $output;
	}

}
