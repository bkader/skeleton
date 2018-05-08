<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

		// Default page title and icon.
		$this->data['page_icon']  = 'plug';
		$this->data['page_title'] = line('CSK_PLUGINS_PLUGINS');
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

			// Filter displayed plugins.
			$filter = $this->input->get('status');
			if ( ! in_array($filter, array('active', 'inactive')))
			{
				$filter = null;
			}

			// Add action buttons.
			if ($plugins)
			{
				foreach ($plugins as $folder => &$p)
				{
					if (('active' === $filter && ! $p['enabled']) 
						OR ('inactive' === $filter && $p['enabled']))
					{
						unset($plugins[$folder]);
						continue;
					}

					// Add plugin actions.
					$p['actions'] = array();
					$action = (true === $p['enabled']) ? 'deactivate' : 'activate';
					$p['actions'][] = nonce_admin_anchor(
						"plugins/{$action}/{$folder}",
						"{$action}-plugin_{$folder}",
						line('CSK_PLUGINS_'.$action)
					);
					if (true === $p['has_settings'])
					{
						$p['actions'][] = html_tag('a', array(
							'href' => admin_url('plugins/settings/'.$folder)
						), line('CSK_PLUGINS_SETTINGS'));
					}
					if (true !== $p['enabled'])
					{
						$p['actions'][] = nonce_admin_anchor(
							"plugins/delete/{$folder}",
							"delete-plugin_{$folder}",
							line('CSK_PLUGINS_DELETE'),
							'class="text-danger plugin-delete"'
						);
					}

					// Module details.
					$details = array();

					if ( ! empty($p['version'])) {
						$details[] = sprintf(line('CSK_PLUGINS_VERSION_NUM'), $p['version']);
					}
					if ( ! empty($p['author'])) {
						$author = (empty($p['author_uri'])) 
							? $p['author'] 
							: sprintf(line('CSK_PLUGINS_AUTHOR_URI'), $p['author'], $p['author_uri']);
						$details[] = sprintf(line('CSK_PLUGINS_AUTHOR_NAME'), $author);
					}
					if ( ! empty($p['license'])) {
						$license = empty($p['license_uri'])
							? $p['license']
							: sprintf(line('CSK_PLUGINS_LICENSE_URI'), $p['license'], $p['license_uri']);
						$details[] = sprintf(line('CSK_PLUGINS_LICENSE_NAME'), $license);
						// Reset license.
						$license = null;
					}
					if ( ! empty($p['plugin_uri'])) {
						$details[] = html_tag('a', array(
							'href'   => $p['plugin_uri'],
							'target' => '_blank',
							'rel'    => 'nofollow',
						), line('CSK_ADMIN_BTN_WEBSITE'));
					}
					if ( ! empty($p['author_email'])) {
						$details[] = sprintf(
							line('CSK_PLUGINS_AUTHOR_EMAIL_URI'),
							$p['author_email'],
							rawurlencode('Support: '.$p['name'])
						);
					}

					$p['details'] = $details;
				}
			}

			// Data to pass to view.
			$this->data['plugins']        = $plugins;
			$this->data['filter']         = $filter;

			// Set page title and load view.
			$this->theme
				->set_title(line('CSK_PLUGINS'))
				->render($this->data);
		}
		else
		{
			if (true !== $this->check_nonce('bulk-update-plugins'))
			{
				set_alert(line('CSK_ERROR_NONCE_URL'), 'error');
				redirect('admin/plugins');
				exit;
			}

			$action = $this->input->post('action');
			$action = str_replace('-selected', '', $action);
			$selected = $this->input->post('selected', true);
			if (empty($selected))
			{
				set_alert(line('CSK_PLUGINS_ERROR_'.$action), 'error');
				redirect('admin/plugins');
				exit;
			}

			if (false !== $this->kbcore->plugins->{$action}($selected))
			{
				set_alert(line('CSK_PLUGINS_SUCCESS_'.$action), 'success');
				redirect('admin/plugins');
				exit;
			}

			set_alert(line('CSK_PLUGINS_ERROR_'.$action), 'error');
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
			set_alert(line('CSK_PLUGINS_ERROR_PLUGIN_MISSING'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// Disabled? It needs to be enabled first.
		if ( ! $plugin['enabled'])
		{
			set_alert(line('CSK_PLUGINS_ERROR_SETTINGS_DISABLED'), 'error');
			redirect('admin/plugins');
			exit;
		}

		// It does not have a settings page?
		if ( ! $plugin['has_settings'])
		{
			set_alert(line('CSK_PLUGINS_ERROR_SETTINGS_MISSING'), 'error');
			redirect('admin/plugins');
			exit;
		}

		$this->data['page_title'] = sprintf(line('CSK_PLUGINS_SETTINGS_NAME'), $plugin['name']);
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
			->set_title(line('CSK_PLUGINS_ADD'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for uploading themes using ZIP archives.
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
			set_alert(line('CSK_ERROR_NONCE_URL'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['pluginzip']['name']))
		{
			set_alert(line('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
			redirect('admin/plugins/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(line('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
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
			set_alert(line('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
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
			set_alert(line('CSK_PLUGINS_SUCCESS_UPLOAD'), 'success');
			redirect('admin/plugins');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(line('CSK_PLUGINS_ERROR_UPLOAD'), 'error');
		redirect('admin/plugins/install');
		exit;
	}

	// ------------------------------------------------------------------------
	// Quick access methods.
	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activating the selected plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	void
	 */
	public function activate($name = null)
	{
		if (true !== $this->check_nonce('activate-plugin_'.$name))
		{
			set_alert(line('CSK_ERROR_NONCE_URL'), 'error');
			redirect('admin/plugins');
			exit;
		}

		if (($name && is_string($name)) 
			&& false !== $this->kbcore->plugins->activate($name))
		{
			set_alert(line('CSK_PLUGINS_SUCCESS_ACTIVATE'), 'success');
			redirect('admin/plugins');
			exit;
		}
		
		set_alert(line('CSK_PLUGINS_ERROR_ACTIVATE'), 'error');
		redirect('admin/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * deactivate
	 *
	 * Method for deactivating the selected plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	void
	 */
	public function deactivate($name = null)
	{
		if (true !== $this->check_nonce('deactivate-plugin_'.$name))
		{
			set_alert(line('CSK_ERROR_NONCE_URL'), 'error');
			redirect('admin/plugins');
			exit;
		}
		
		if (($name && is_string($name)) 
			&& false !== $this->kbcore->plugins->deactivate($name))
		{
			set_alert(line('CSK_PLUGINS_SUCCESS_DEACTIVATE'), 'success');
			redirect('admin/plugins');
			exit;
		}
		
		set_alert(line('CSK_PLUGINS_ERROR_DEACTIVATE'), 'error');
		redirect('admin/plugins');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	void
	 */
	public function delete($name = null)
	{
		if (true !== $this->check_nonce('delete-plugin_'.$name))
		{
			set_alert(line('CSK_ERROR_NONCE_URL'), 'error');
			redirect('admin/plugins');
			exit;
		}
		
		if (($name && is_string($name)) 
			&& false !== $this->kbcore->plugins->delete($name))
		{
			set_alert(line('CSK_PLUGINS_SUCCESS_DELETE'), 'success');
			redirect('admin/plugins');
			exit;
		}
		
		set_alert(line('CSK_PLUGINS_ERROR_DELETE'), 'error');
		redirect('admin/plugins');
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
		$lines = array('delete' => line('CSK_PLUGINS_CONFIRM_DELETE'));
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
		// Page icon, title and help URL.
		$this->data['page_icon']  = 'plug';
		$this->data['page_title'] = line('CSK_PLUGINS_PLUGINS');
		$this->data['page_help']  = 'https://goo.gl/cvLaCz';

		// Displaying buttons depending on the page we are on.
		$method = $this->router->fetch_method();

		switch ($method)
		{
			// Case of plugins install page.
			case 'install':
				$this->data['page_title'] = line('CSK_PLUGINS_ADD');

				// Subhead.
				add_action('admin_subhead', function() {

					// Upload plugin button.
					echo html_tag('button', array(
						'role' => 'button',
						'class' => 'btn btn-primary btn-sm btn-icon mr5',
						'data-toggle' => 'collapse',
						'data-target' => '#plugin-install'
					), fa_icon('upload').line('CSK_PLUGINS_UPLOAD'));

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
					$folder_plugins = $this->kbcore->plugins->get_plugins();
					$active_plugins = $this->kbcore->options->get('active_plugins');
					$filter         = $this->input->get('status');

					$all      = count($folder_plugins);
					$active   = count($active_plugins->value);
					$inactive = $all - $active;

					// Upload new plugin.
					echo html_tag('a', array(
						'href' => admin_url('plugins/install'),
						'class' => 'btn btn-primary btn-sm btn-icon'
					), fa_icon('upload').line('CSK_PLUGINS_ADD')),

					// Filters toolbar.
					'<div class="btn-group ml15" role="group">',

						// All plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins'),
							'class' => 'btn btn-sm btn-'.($filter ? 'default' : 'secondary'),
						), sprintf(line('CSK_PLUGINS_FILTER_ALL'), $all)),

						// Active plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins?status=active'),
							'class' => 'btn btn-sm btn-'.('active' === $filter ? 'secondary' : 'default'),
						), sprintf(line('CSK_PLUGINS_FILTER_ACTIVE'), $active)),

						// Inactive plugins.
						html_tag('a', array(
							'href'  => admin_url('plugins?status=inactive'),
							'class' => 'btn btn-sm btn-'.('inactive' === $filter ? 'secondary' : 'default'),
						), sprintf(line('CSK_PLUGINS_FILTER_INACTIVE'), $inactive)),

					'</div>';
				});
				break;
		}
	}

}
