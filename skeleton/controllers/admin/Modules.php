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
 * Modules Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Modules extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Load needed files.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		// Call parent constructor.
		parent::__construct();

		$this->load->language('csk_modules');

		// Add our head string.
		add_filter('admin_head', array($this, '_admin_head'));
		$this->scripts[] = 'modules';

		// Default page title and icon.
		$this->data['page_icon']  = 'cubes';
		$this->data['page_title'] = __('CSK_MODULES_MODULES');
		$this->data['page_help']  = 'https://goo.gl/Pyw7vE';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * List all available modules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		$modules = $this->router->list_modules(true);
		$i18n = $this->lang->lang('folder');

		foreach ($modules as $folder => &$m)
		{
			// Attempt to translate name and description.
			if ('english' !== $i18n)
			{
				if (isset($m['translations'][$i18n]['name'])) {
					$m['name'] = $m['translations'][$i18n]['name'];
				}
				if (isset($m['translations'][$i18n]['description'])) {
					$m['description'] = $m['translations'][$i18n]['description'];
				}
				if (isset($m['translations'][$i18n]['license'])) {
					$m['license'] = $m['translations'][$i18n]['license'];
				}
				if (isset($m['translations'][$i18n]['author'])) {
					$m['author'] = $m['translations'][$i18n]['author'];
				}
			}

			// Add module actions.
			$m['actions'] = array();

			if (true === $m['enabled'] && true === $m['has_settings'])
			{
				$m['actions'][] = html_tag('a', array(
					'href'  => admin_url('settings/'.$folder),
					'class' => 'btn btn-default btn-xs btn-icon ml-2',
					'aria-label' => sprintf(__('CSK_BTN_SETTINGS_COM'), $m['name']),
				), fa_icon('cogs').__('CSK_MODULES_SETTINGS'));
			}

			if (true === $m['enabled'])
			{
				$m['actions'][] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => esc_url(nonce_admin_url(
						'modules?action=deactivate&module='.$folder,
						'module-deactivate_'.$folder
					)),
					'class' => 'btn btn-default btn-xs btn-icon module-deactivate ml-2',
					'aria-label' => sprintf(__('CSK_BTN_DEACTIVATE_COM'), $m['name']),
				), fa_icon('times text-danger').__('CSK_MODULES_DEACTIVATE'));
			}
			else
			{
				$m['actions'][] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => esc_url(nonce_admin_url(
						'modules?action=activate&module='.$folder,
						'module-activate_'.$folder
					)),
					'class' => 'btn btn-default btn-xs btn-icon module-activate ml-2',
					'aria-label' => sprintf(__('CSK_BTN_ACTIVATE_COM'), $m['name']),
				), fa_icon('check text-success').__('CSK_MODULES_ACTIVATE'));
			}

			$m['actions'][] = html_tag('button', array(
				'type' => 'button',
				'data-endpoint' => esc_url(nonce_admin_url(
					'modules?action=delete&module='.$folder,
					'module-delete_'.$folder
				)),
				'class' => 'btn btn-danger btn-xs btn-icon module-delete ml-2',
				'aria-label' => sprintf(__('CSK_BTN_REMOVE_COM'), $m['name']),
			), fa_icon('trash-o').__('CSK_MODULES_DELETE'));

			// Module details.
			$details = array();

			if ( ! empty($m['version'])) {
				$details[] = sprintf(__('CSK_MODULES_VERSION_NUM'), $m['version']);
			}
			if ( ! empty($m['author'])) {
				$author = (empty($m['author_uri'])) 
					? $m['author'] 
					: sprintf(__('CSK_MODULES_AUTHOR_URI'), $m['author'], $m['author_uri']);
				$details[] = sprintf(__('CSK_MODULES_AUTHOR_NAME'), $author);
			}
			if ( ! empty($m['license'])) {
				$license = empty($m['license_uri'])
					? $m['license']
					: sprintf(__('CSK_MODULES_LICENSE_URI'), $m['license'], $m['license_uri']);
				$details[] = sprintf(__('CSK_MODULES_LICENSE_NAME'), $license);
				// Reset license.
				$license = null;
			}
			if ( ! empty($m['module_uri'])) {
				$details[] = html_tag('a', array(
					'href'   => $m['module_uri'],
					'target' => '_blank',
					'rel'    => 'nofollow',
				), __('CSK_BTN_WEBSITE'));
			}
			if ( ! empty($m['author_email'])) {
				$details[] = sprintf(
					__('CSK_MODULES_AUTHOR_EMAIL_URI'),
					$m['author_email'],
					rawurlencode('Support: '.$m['name'])
				);
			}

			$m['details'] = $details;
		}

		/**
		 * Catch modules actions.
		 * @since 	2.1.0
		 */
		$action = $this->input->get('action', true);
		$module = $this->input->get('module', true);

		if (($action && in_array($action, array('activate', 'deactivate', 'delete')))
			&& ($module && isset($modules[$module]))
			&& check_nonce_url("module-{$action}_{$module}")
			&& method_exists($this, '_'.$action))
		{
			return call_user_func_array(array($this, '_'.$action), array($module));
		}

		$this->data['modules'] = $modules;
		
		$this->theme
			->set_title(__('CSK_MODULES_MODULES'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * install
	 *
	 * Method for installing modules from future server or upload ZIP modules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
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
			->set_title(__('CSK_MODULES_ADD'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for uploading modules using ZIP archives.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function upload()
	{
		// We check CSRF token validity.
		if ( ! $this->check_nonce('upload-module'))
		{
			set_alert(__('CSK_ERROR_NONCE_URL'), 'error');
			redirect(KB_ADMIN.'/modules/install');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['modulezip']['name']))
		{
			set_alert(__('CSK_MODULES_ERROR_UPLOAD'), 'error');
			redirect(KB_ADMIN.'/modules/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(__('CSK_MODULES_ERROR_UPLOAD'), 'error');
			redirect(KB_ADMIN.'/modules/install');
			exit;
		}

		// Load upload library.
		$this->load->library('upload', array(
			'upload_path'   => FCPATH.'content/uploads/temp/',
			'allowed_types' => 'zip',
		));

		// Error uploading?
		if (false === $this->upload->do_upload('modulezip') 
			OR ! class_exists('ZipArchive', false))
		{
			set_alert(__('CSK_MODULES_ERROR_UPLOAD'), 'error');
			redirect(KB_ADMIN.'/modules/install');
			exit;
		}

		// Prepare data for later use.
		$data = $this->upload->data();

		$location = ('0' === $this->input->post('location'))
			? APPPATH.'modules/'
			: FCPATH.'content/modules/';

		// Catch the upload status and delete the temporary file anyways.
		$status = unzip_file($data['full_path'], $location);
		@unlink($data['full_path']);
		
		// Successfully installed?
		if (true === $status)
		{
			set_alert(__('CSK_MODULES_SUCCESS_UPLOAD'), 'success');
			redirect(KB_ADMIN.'/modules');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(__('CSK_MODULES_ERROR_UPLOAD'), 'error');
		redirect(KB_ADMIN.'/modules/install');
		exit;
	}

	// ------------------------------------------------------------------------
	// Modules activation, deactivate and deletion.
	// ------------------------------------------------------------------------

	/**
	 * Method for activating the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _activate($folder)
	{
		$details = module_details($folder);
		$i18n    = $this->config->item('language');

		// Attempt to translate name and description.
		if ('english' !== $i18n && isset($details['translations'][$i18n]['name']))
		{
			$details['name'] = $details['translations'][$i18n]['name'];
		}
		
		$name = $details['name'];
		
		if ( ! module_is_active($folder) && activate_module($folder))
		{
			set_alert(sprintf(__('CSK_MODULES_SUCCESS_ACTIVATE'), $name), 'success');
			redirect(KB_ADMIN.'/modules');
			exit;
		}

		set_alert(sprintf(__('CSK_MODULES_ERROR_ACTIVATE'), $name), 'error');
		redirect(KB_ADMIN.'/modules');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deactivating the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _deactivate($folder)
	{
		$details = module_details($folder);
		$i18n    = $this->config->item('language');

		// Attempt to translate name and description.
		if ('english' !== $i18n && isset($details['translations'][$i18n]['name']))
		{
			$details['name'] = $details['translations'][$i18n]['name'];
		}
		
		$name = $details['name'];
		
		if (module_is_active($folder) && deactivate_module($folder))
		{
			set_alert(sprintf(__('CSK_MODULES_SUCCESS_DEACTIVATE'), $name), 'success');
			redirect(KB_ADMIN.'/modules');
			exit;
		}

		set_alert(sprintf(__('CSK_MODULES_ERROR_DEACTIVATE'), $name), 'error');
		redirect(KB_ADMIN.'/modules');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _delete($folder)
	{
		$details = module_details($folder);
		$i18n    = $this->config->item('language');

		// Attempt to translate name and description.
		if ('english' !== $i18n && isset($details['translations'][$i18n]['name']))
		{
			$details['name'] = $details['translations'][$i18n]['name'];
		}
		
		$name = $details['name'];

		if (module_is_active($folder))
		{
			set_alert(sprintf(__('CSK_MODULES_ERROR_DELETE_ACTIVE'), $name), 'error');
			redirect(KB_ADMIN.'/modules');
			exit;
		}

		function_exists('directory_delete') OR $this->load->helper('directory');
		
		if (false !== directory_delete($details['full_path']))
		{
			set_alert(sprintf(__('CSK_MODULES_SUCCESS_DELETE'), $name), 'success');
			redirect(KB_ADMIN.'/modules');
			exit;
		}

		set_alert(sprintf(__('CSK_MODULES_ERROR_DELETE'), $name), 'error');
		redirect(KB_ADMIN.'/modules');
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
			'activate'    => __('CSK_MODULES_CONFIRM_ACTIVATE'),
			'deactivate'  => __('CSK_MODULES_CONFIRM_DEACTIVATE'),
			'delete'      => __('CSK_MODULES_CONFIRM_DELETE'),
		);

		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.modules = '.json_encode($lines).';';
		$output .= '</script>';

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * _subhead
	 *
	 * Display admin subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		if ('install' === $this->router->fetch_method())
		{
			$this->data['page_title'] = __('CSK_MODULES_ADD');

			// Subhead.
			add_action('admin_subhead', function() {

				// Upload module button.
				echo html_tag('button', array(
					'role' => 'button',
					'class' => 'btn btn-success btn-sm btn-icon mr-2',
					'data-toggle' => 'collapse',
					'data-target' => '#module-install'
				), fa_icon('upload').__('CSK_MODULES_UPLOAD'));

				// Back button.
				$this->_btn_back('modules');

			});
		}
		else
		{
			add_action('admin_subhead', function() {
				echo html_tag('a', array(
					'href'  => admin_url('modules/install'),
					'class' => 'btn btn-success btn-sm btn-icon mr-2',
				), fa_icon('plus-circle').__('CSK_MODULES_ADD'));
			});
		}
	}

}
