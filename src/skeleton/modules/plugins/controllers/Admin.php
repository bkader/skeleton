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
		// Get plugins stored in database and plugins folder.
		$db_plugins     = $this->kbcore->options->get('plugins');
		$folder_plugins = $this->kbcore->plugins->get_plugins();

		// If the options is not set, we create it.
		if (false === $db_plugins)
		{
			$this->kbcore->options->create(array(
				'name'  => 'plugins',
				'value' => $folder_plugins,
				'tab'   => 'plugin',
			));

			// Then we get it.
			$db_plugins = $this->kbcore->options->get('plugins');
		}
		// Was plugins folder updated for some reason?
		elseif ($folder_plugins <> $db_plugins->value)
		{
			// we make sure to update in databae.
			$db_plugins->set('value', $folder_plugins);
			$db_plugins->save();
		}

		// Let's get our plugins.
		$plugins = $db_plugins->value;

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
			foreach ($plugins as $slug => &$p)
			{
				if (isset($this->lang->language[$p['language_index']]['plugin_name']))
				{
					$p['name'] = line('plugin_name', $p['language_index']);
				}
				if (isset($this->lang->language[$p['language_index']]['plugin_description']))
				{
					$p['description'] = line('plugin_description', $p['language_index']);
				}

				// Increment counters.
				$count_all++;
				(true === $p['enabled']) && $count_active++;
				(false === $p['enabled']) && $count_inactive++;

				if (true === $p['enabled'] && 'inactive' === $filter)
				{
					unset($plugins[$slug]);
					continue;
				}

				if (false === $p['enabled'] && 'active' === $filter)
				{
					unset($plugins[$slug]);
					continue;
				}
				
				// So we can reset things.
				$p['actions'] = array();

				// Activate/Deactivate plugin.
				$_status = (true === $p['enabled']) ? 'deactivate' : 'activate';
				$p['actions'][] = safe_ajax_anchor("plugins/{$_status}/{$slug}", lang('spg_plugin_'.$_status), "class=\"plugin-{$_status}\"");

				// Does the plugin have a settings page?
				if (true === $p['has_settings'])
				{
					$p['actions'][] = admin_anchor('plugins/settings/'.$slug, lang('spg_plugin_settings'));
				}

				// We add the delete plugin only if the plugin is not enabled.
				if (true !== $p['enabled'])
				{
					$p['actions'][] = safe_ajax_anchor(
						"plugins/delete/{$slug}",
						lang('spg_plugin_delete'),
						'class="plugin-delete text-danger" data-plugin="'.$slug.'"'
					);
				}

				// Plugin details.
				$p['details'] = array();
				if ( ! empty($p['version']))
				{
					$p['details'][] = line('spg_version', null, null, ': '.$p['version']);
				}

				if ( ! empty($p['author']))
				{
					$p['details'][] = (empty($p['author_uri'])) 
						? $p['author'] 
						: sprintf(line('spg_plugin_author'), $p['author'], $p['author_uri']);
				}

				// Does it have a license?
				if ( ! empty($p['license']))
				{
					$license = (empty($p['license_uri'])) ? $p['license'] : sprintf(line('spg_plugin_license'), $p['license'], $p['license_uri']);
					$p['details'][] = sprintf(lang('spg_license_name'), $license);
					// Reset license.
					$license = null;
				}

				// Did the user provide external details link?
				if ( ! empty($p['plugin_uri']))
				{
					$p['details'][] = sprintf(lang('spg_plugin_author_uri'), $p['plugin_uri']);
				}

				// Does the user provide a support email address?
				if ( ! empty($p['author_email']))
				{
					$p['details'][] = sprintf(lang('spg_plugin_author_email'), $p['author_email'], rawurlencode('Support: '.$p['name']));
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

	/**
	 * install
	 *
	 * Method for installing plugins from future server or upload ZIP plugins.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.4
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function install()
	{
		// We prepare form validation.
		$this->prep_form();

		// Add our CSRF token
		$data['hidden'] = $this->create_csrf();

		// Set page title and load view.
		$this->theme
			->set_title(lang('spg_plugin_add'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for uploading themes using ZIP archives.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.4
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function upload()
	{
		// We check CSRF token validity.
		if ( ! $this->check_csrf())
		{
			set_alert(lang('error_csrf'), 'error');
			redirect('admin/plugins/install', 'refresh');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['pluginzip']['name']))
		{
			set_alert(lang('spg_plugin_upload_error'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(lang('spg_plugin_upload_error'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Load upload library.
		$this->load->library('upload', array(
			'upload_path'   => FCPATH.'content/uploads/temp/',
			'allowed_types' => 'zip',
		));

		// Error uploading?
		if (false === $this->upload->do_upload('pluginzip') OR ! class_exists('ZipArchive', false))
		{
			set_alert(lang('spg_plugin_upload_error'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Prepare data for later use.
		$data = $this->upload->data();

		// Catch the upload status and delete the temporary file anyways.
		$status = unzip_file($data['full_path'], FCPATH.'content/plugins/');
		@unlink($data['full_path']);
		
		// Successfully installed?
		if (true === $status)
		{
			set_alert(lang('spg_plugin_upload_success'), 'success');
			redirect('admin/plugins');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(lang('spg_plugin_upload_error'), 'error');
		redirect('admin/plugins/install');
		exit;
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
