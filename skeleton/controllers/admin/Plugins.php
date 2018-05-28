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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins controller.
 *
 * Because we dropped the "Plugins" module, we use this controller instead.
 * This way we reduce number of modules and make this feature default.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.0
 */
class Plugins extends Admin_Controller
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

		$this->load->language('csk_plugins');

		// Add our head string.
		add_filter('admin_head', array($this, '_admin_head'));
		$this->_jquery_sprintf();
		$this->scripts[] = 'plugins';

		// Page icon, title and help URL.
		$this->data['page_icon']  = 'plug';
		$this->data['page_title'] = __('CSK_PLUGINS_PLUGINS');
		$this->data['page_help']  = 'https://goo.gl/cvLaCz';
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
		$this->prep_form(array(array(
			'field' => '_csknonce',
			'label' => 'Security',
			'rules' => 'required',
		)));

		if ($this->form_validation->run() == false)
		{
			// Let's get our plugins.
			$plugins = $this->kbcore->plugins->list_plugins(true);

			// Filter displayed plugins.
			$filter = $this->input->get('status');

			if ( ! in_array($filter, array('active', 'inactive')))
			{
				$filter = null;
			}

			// Add action buttons.
			if ($plugins)
			{
				$i18n = $this->lang->lang('folder');

				foreach ($plugins as $folder => &$p)
				{
					// Attempt to translate name and description.
					if ('english' !== $i18n)
					{
						if (isset($p['translations'][$i18n]['name'])) {
							$p['name'] = $p['translations'][$i18n]['name'];
						}
						if (isset($p['translations'][$i18n]['description'])) {
							$p['description'] = $p['translations'][$i18n]['description'];
						}
						if (isset($p['translations'][$i18n]['license'])) {
							$p['license'] = $p['translations'][$i18n]['license'];
						}
						if (isset($p['translations'][$i18n]['author'])) {
							$p['author'] = $p['translations'][$i18n]['author'];
						}
					}

					if (('active' === $filter && ! $p['enabled']) 
						OR ('inactive' === $filter && $p['enabled']))
					{
						unset($plugins[$folder]);
						continue;
					}

					// Add plugin actions.
					$p['actions'] = array();

					if (true === $p['enabled'])
					{
						$p['actions'][] = html_tag('button', array(
							'type' => 'button',
							'data-endpoint' => esc_url(nonce_admin_url(
								'plugins?action=deactivate&plugin='.$folder,
								'plugin-deactivate_'.$folder
							)),
							'class' => 'btn btn-default btn-xs btn-icon plugin-deactivate ml-2',
							'aria-label' => sprintf(__('CSK_BTN_DEACTIVATE_COM'), $p['name']),
						), fa_icon('times text-danger').__('CSK_PLUGINS_DEACTIVATE'));
					}
					else
					{
						$p['actions'][] = html_tag('button', array(
							'type' => 'button',
							'data-endpoint' => esc_url(nonce_admin_url(
								'plugins?action=activate&plugin='.$folder,
								'plugin-activate_'.$folder
							)),
							'class' => 'btn btn-default btn-xs btn-icon plugin-activate ml-2',
							'aria-label' => sprintf(__('CSK_BTN_ACTIVATE_COM'), $p['name']),
						), fa_icon('check text-success').__('CSK_PLUGINS_ACTIVATE'));
					}

					if (true === $p['enabled'] && true === $p['has_settings'])
					{
						$p['actions'][] = html_tag('a', array(
							'href'  => admin_url('plugins/settings/'.$folder),
							'class' => 'btn btn-default btn-xs btn-icon ml-2',
							'aria-label' => sprintf(__('CSK_BTN_SETTINGS_COM'), $p['name']),
						), fa_icon('cogs').__('CSK_PLUGINS_SETTINGS'));
					}

					if (true !== $p['enabled'])
					{
						$p['actions'][] = html_tag('button', array(
							'type' => 'button',
							'data-endpoint' => esc_url(nonce_admin_url(
								'plugins?action=delete&plugin='.$folder,
								'plugin-delete_'.$folder
							)),
							'class' => 'btn btn-danger btn-xs btn-icon plugin-delete ml-2',
							'aria-label' => sprintf(__('CSK_BTN_DELETE_COM'), $p['name']),
						), fa_icon('trash-o').__('CSK_PLUGINS_DELETE'));
					}

					// Module details.
					$details = array();

					if ( ! empty($p['version'])) {
						$details[] = sprintf(__('CSK_PLUGINS_VERSION_NUM'), $p['version']);
					}
					if ( ! empty($p['author'])) {
						$author = (empty($p['author_uri'])) 
							? $p['author'] 
							: sprintf(__('CSK_PLUGINS_AUTHOR_URI'), $p['author'], $p['author_uri']);
						$details[] = sprintf(__('CSK_PLUGINS_AUTHOR_NAME'), $author);
					}
					if ( ! empty($p['license'])) {
						$license = empty($p['license_uri'])
							? $p['license']
							: sprintf(__('CSK_PLUGINS_LICENSE_URI'), $p['license'], $p['license_uri']);
						$details[] = sprintf(__('CSK_PLUGINS_LICENSE_NAME'), $license);
						// Reset license.
						$license = null;
					}
					if ( ! empty($p['plugin_uri'])) {
						$details[] = html_tag('a', array(
							'href'   => $p['plugin_uri'],
							'target' => '_blank',
							'rel'    => 'nofollow',
						), __('CSK_BTN_WEBSITE'));
					}
					if ( ! empty($p['author_email'])) {
						$details[] = sprintf(
							__('CSK_PLUGINS_AUTHOR_EMAIL_URI'),
							$p['author_email'],
							rawurlencode('Support: '.$p['name'])
						);
					}

					$p['details'] = $details;
				}
			}

			// Data to pass to view.
			$this->data['plugins'] = $plugins;
			$this->data['filter']  = $filter;

			/**
			 * Catches plugins actions.
			 * @since 	2.1.0
			 */
			$get_action = $this->input->get('action', true);
			$get_plugin = $this->input->get('plugin', true);

			if (($get_action && in_array($get_action, array('activate', 'deactivate', 'delete')))
				&& ($get_plugin && isset($plugins[$get_plugin]))
				&& check_nonce_url("plugin-{$get_action}_{$get_plugin}")
				&& method_exists($this, '_'.$get_action))
			{
				return call_user_func_array(array($this, '_'.$get_action), array($get_plugin));
			}

			// Set page title and load view.
			$this->theme
				->set_title(__('CSK_PLUGINS'))
				->render($this->data);
		}
		else
		{
			if (true !== $this->check_nonce('bulk-update-plugins'))
			{
				set_alert(__('CSK_ERROR_NONCE_URL'), 'error');
				redirect('admin/plugins');
				exit;
			}

			$action = $this->input->post('action');
			$action = str_replace('-selected', '', $action);
			$selected = $this->input->post('selected', true);
			if (empty($selected))
			{
				set_alert(__('CSK_PLUGINS_ERROR_BULK_'.$action), 'error');
				redirect('admin/plugins');
				exit;
			}

			if (false !== $this->kbcore->plugins->{$action}($selected))
			{
				set_alert(__('CSK_PLUGINS_SUCCESS_BULK_'.$action), 'success');
				redirect('admin/plugins');
				exit;
			}

			set_alert(__('CSK_PLUGINS_ERROR_BULK_'.$action), 'error');
			redirect('admin/plugins');
			exit;
		}

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
			set_alert(__('CSK_PLUGINS_ERROR_PLUGIN_MISSING'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// Disabled? It needs to be enabled first.
		if ( ! $plugin['enabled'])
		{
			set_alert(__('CSK_PLUGINS_ERROR_SETTINGS_DISABLED'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// It does not have a settings page?
		if ( ! $plugin['has_settings'])
		{
			set_alert(__('CSK_PLUGINS_ERROR_SETTINGS_MISSING'), 'error');
			redirect('admin/plugins');
			exit;
		}

		if ('english' !== ($lang = $this->lang->lang('folder')))
		{
			if (isset($plugin['translations'][$lang]['name']))
			{
				$plugin['name'] = $plugin['translations'][$lang]['name'];
			}
			if (isset($plugin['translations'][$lang]['description']))
			{
				$plugin['description'] = $plugin['translations'][$lang]['description'];
			}
		}

		// Add link to plugin's help and donation.
		if ( ! empty($plugin['plugin_uri']))
		{
			$this->data['page_help'] = $plugin['plugin_uri'];
		}
		if ( ! empty($plugin['donation_uri']))
		{
			$this->data['page_donate'] = $plugin['donation_uri'];
		}

		$this->data['page_title'] = sprintf(__('CSK_PLUGINS_SETTINGS_NAME'), $plugin['name']);
		$this->data['plugin']     = $plugin;

		// Set page title and render view.
		$this->theme
			->set_title($this->data['page_title'])
			->render($this->data);

	}

	// ------------------------------------------------------------------------

	/**
	 * install
	 *
	 * Method for installing plugins from future server or upload ZIP plugins.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
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

		// Set page title and load view.
		$this->theme
			->set_title(__('CSK_PLUGINS_ADD'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for uploading plugins using ZIP archives.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.3.4
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function upload()
	{
		// We check CSRF token validity.
		if ( ! $this->check_nonce('upload-plugin'))
		{
			set_alert(__('CSK_ERROR_NONCE_URL'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['pluginzip']['name']))
		{
			set_alert(__('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(__('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Load upload library.
		$this->load->library('upload', array(
			'upload_path'   => FCPATH.'content/uploads/temp/',
			'allowed_types' => 'zip',
		));

		// Error uploading?
		if (false === $this->upload->do_upload('pluginzip') 
			OR ! class_exists('ZipArchive', false))
		{
			set_alert(__('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
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
			set_alert(__('CSK_PLUGINS_SUCCESS_UPLOAD'), 'success');
			redirect('admin/plugins');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(__('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
		redirect('admin/plugins/install');
		exit;
	}

	// ------------------------------------------------------------------------
	// Plugins activation, deactivate and deletion.
	// ------------------------------------------------------------------------

	/**
	 * Method for activating the given plugin.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _activate($folder)
	{
		$details = $this->kbcore->plugins->plugin_details($folder);
		$plugin = $details['name'];
		if ('english' !== ($lang = $this->lang->lang('folder')))
		{
			if (isset($details['translations'][$lang]['name']))
			{
				$plugin = $details['translations'][$lang]['name'];
			}
		}

		if (false !== $this->kbcore->plugins->activate($folder))
		{
			set_alert(sprintf(__('CSK_PLUGINS_SUCCESS_ACTIVATE'), $plugin), 'success');
			redirect(KB_ADMIN.'/plugins');
			exit;
		}

		set_alert(sprintf(__('CSK_PLUGINS_ERROR_ACTIVATE'), $plugin), 'error');
		redirect(KB_ADMIN.'/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deactivating the given plugin.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _deactivate($folder)
	{
		$details = $this->kbcore->plugins->plugin_details($folder);
		$plugin = $details['name'];
		if ('english' !== ($lang = $this->lang->lang('folder')))
		{
			if (isset($details['translations'][$lang]['name']))
			{
				$plugin = $details['translations'][$lang]['name'];
			}
		}

		if (false !== $this->kbcore->plugins->deactivate($folder))
		{
			set_alert(sprintf(__('CSK_PLUGINS_SUCCESS_DEACTIVATE'), $plugin), 'success');
			redirect(KB_ADMIN.'/plugins');
			exit;
		}

		set_alert(sprintf(__('CSK_PLUGINS_ERROR_DEACTIVATE'), $plugin), 'error');
		redirect(KB_ADMIN.'/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting the given plugin.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _delete($folder)
	{
		$details = $this->kbcore->plugins->plugin_details($folder);
		$plugin = $details['name'];
		if ('english' !== ($lang = $this->lang->lang('folder')))
		{
			if (isset($details['translations'][$lang]['name']))
			{
				$plugin = $details['translations'][$lang]['name'];
			}
		}

		if (false !== $this->kbcore->plugins->delete($folder))
		{
			set_alert(sprintf(__('CSK_PLUGINS_SUCCESS_DELETE'), $plugin), 'success');
			redirect(KB_ADMIN.'/plugins');
			exit;
		}

		set_alert(sprintf(__('CSK_PLUGINS_ERROR_DELETE'), $plugin), 'error');
		redirect(KB_ADMIN.'/plugins');
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
		$lines = array(
			'activate'   => __('CSK_PLUGINS_CONFIRM_ACTIVATE'),
			'deactivate' => __('CSK_PLUGINS_CONFIRM_DEACTIVATE'),
			'delete'     => __('CSK_PLUGINS_CONFIRM_DELETE'),
		);
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.plugins = '.json_encode($lines).';';
		$output .= '</script>';
		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * _subhead
	 *
	 * Add dashboard subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		// Displaying buttons depending on the page we are on.
		$method = $this->router->fetch_method();

		switch ($method)
		{
			// Case of plugins install page.
			case 'install':
				$this->data['page_title'] = __('CSK_PLUGINS_ADD');

				// Subhead.
				add_action('admin_subhead', function() {

					// Upload plugin button.
					echo html_tag('button', array(
						'role' => 'button',
						'class' => 'btn btn-success btn-sm btn-icon mr-2',
						'data-toggle' => 'collapse',
						'data-target' => '#plugin-install'
					), fa_icon('upload').__('CSK_PLUGINS_UPLOAD'));

					// Back button.
					$this->_btn_back('plugins');

				});
				break;

			// Case of plugin's settings page.
			case 'settings':
				add_action('admin_subhead', function() {
					$this->_btn_back('plugins');
				});
				break;
			
			// Main page.
			default:
				add_action('admin_subhead', function() {
					$folder_plugins = $this->kbcore->plugins->list_plugins();
					$active_plugins = $this->kbcore->options->get('active_plugins');
					$filter         = $this->input->get('status');

					$all      = count($folder_plugins);
					$active   = count($active_plugins->value);
					$inactive = $all - $active;

					// Upload new plugin.
					echo html_tag('a', array(
						'href' => admin_url('plugins/install'),
						'class' => 'btn btn-success btn-sm btn-icon'
					), fa_icon('plus-circle').__('CSK_PLUGINS_ADD')),

					// Filters toolbar.
					'<div class="btn-group ml-3" role="group">',

						// All plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins'),
							'class' => 'btn btn-sm btn-'.($filter ? 'default' : 'secondary'),
						), sprintf(__('CSK_PLUGINS_FILTER_ALL'), $all)),

						// Active plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins?status=active'),
							'class' => 'btn btn-sm btn-'.('active' === $filter ? 'secondary' : 'default'),
						), sprintf(__('CSK_PLUGINS_FILTER_ACTIVE'), $active)),

						// Inactive plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins?status=inactive'),
							'class' => 'btn btn-sm btn-'.('inactive' === $filter ? 'secondary' : 'default'),
						), sprintf(__('CSK_PLUGINS_FILTER_INACTIVE'), $inactive)),

					'</div>';
				});
				break;
		}
	}

}
