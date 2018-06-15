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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_Controller Class
 *
 * Controllers extending this class requires a logged in user of rank "admin".
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.1
 */
class Admin_Controller extends KB_Controller
{
	/**
	 * Array of CSS files to be loaded.
	 *
	 * @since 	1.3.3
	 * 
	 * @var 	array
	 */
	protected $styles = array(
		'font-awesome',
		'bootstrap',
		'toastr',
		'admin',
	);

	/**
	 * Array of JS files to be loaded.
	 *
	 * @since 	1.3.3
	 *
	 * @var 	array
	 */
	protected $scripts = array(
		'modernizr-2.8.3',
		'jquery-3.2.1',
		'jquery.sprintf',
		'handlebars',
		'popper',
		'bootstrap',
		'toastr',
		'bootbox',
		'admin',
	);

	/**
	 * Class constructor
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added favicon to dashboard, removed loading admin language file
	 *         			and move some actions to "_remap" method.
	 * 
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure the user is logged in.
		if (true !== $this->kbcore->auth->is_admin())
		{
			redirect('admin-login?next='.rawurlencode(uri_string()),'refresh');
			exit;
		}

		if ( ! $this->kbcore->auth->is_admin())
		{
			set_alert(__('CSK_ERROR_PERMISSION'), 'error');
			redirect('');
			exit;
		}

		$this->load->language('csk_admin');
		
		add_filter('admin_head', array($this, 'csk_globals'), 0);
		add_filter('admin_head', array($this, 'admin_head'), 99);
		$this->load->helper('admin');
	}

	// ------------------------------------------------------------------------

	/**
	 * We remap methods so we can do extra actions when we are not on methods
	 * that required AJAX requests.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$method 	The method's name.
	 * @param 	array 	$params 	Arguments to pass to the method.
	 * @return 	mixed 	Depends on the called method.
	 */
	public function _remap($method, $params = array())
	{
		// The method is not found? Nothing to do.
		if ( ! method_exists($this, $method))
		{
			show_404();
		}

		if ( ! $this->input->is_ajax_request())
		{
			// We add favicon.
			$this->theme->add_meta(
				'icon',
				$this->theme->common_url('img/favicon.ico'),
				'rel',
				'type="image/x-icon"'
			);

			// We remove Modernizr and jQuery to dynamically load them.
			$this->theme->remove('js', 'modernizr', 'jquery');

			// Do we have any CSS files to load?
			if ( ! empty($this->styles))
			{
				// Are we using a right-to-left language? Add RTL files.
				if ('rtl' === $this->lang->lang('direction'))
				{
					// Replace Bootstrap.
					if (false !== ($i = array_search('bootstrap', $this->styles)))
					{
						$this->styles[$i] = 'bootstrap-rtl';
					}
				}

				$this->styles = (function_exists('array_clean'))
					? array_clean($this->styles)
					: array_unique(array_filter(array_map('trim', $this->styles)));

				$this->theme->add(
					'css',
					admin_url('load/styles?load='.implode(',', $this->styles), ''),
					null, // No handle.
					null, // No version.
					true // At the top
				);
			}

			// Do we have any JS files to laod?
			if ( ! empty($this->scripts))
			{
				$this->scripts = (function_exists('array_clean'))
					? array_clean($this->scripts)
					: array_unique(array_filter(array_map('trim', $this->scripts)));
				
				$this->theme->add(
					'js',
					admin_url('load/scripts?load='.implode(',', $this->scripts), ''),
					null, // No handle.
					null, // No version.
					true // At the top
				);
			}

			/**
			 * Admin menu is called only of method that load views.
			 * @since 	2.1.0
			 */
			$this->_admin_menu();

			// If we have a heading method, use it.
			method_exists($this, '_subhead') && $this->_subhead();

			/**
			 * We set global variables so they can be found by dashboard partials views.
			 * @since 	2.1.2
			 */
			if ( ! empty($this->data))
			{
				// Then we make all variables global.
				foreach ($this->data as $key => $val)
				{
					$this->load->vars($key, $val);
				}
			}

			/**
			 * Separated dashboard header and footer to allow different layouts.
			 * @since 	2.1.2
			 */
			$this->theme
				->set_layout('default')
				->add_partial('admin_header')
				->add_partial('admin_footer');
	
			// We call the method.
			return call_user_func_array(array($this, $method), $params);
		}

		return parent::_remap($method, $params);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * csk_globals
	 *
	 * Method for adding JS global before anything else.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	string 	$output 	StyleSheets output.
	 * @return 	void
	 */
	public function csk_globals($output)
	{
		// Default configuration.
		$config = array(
			'siteURL'    => site_url(),
			'baseURL'    => base_url(),
			'adminURL'   => admin_url(),
			'currentURL' => current_url(),
			'ajaxURL'    => ajax_url(),
			'lang'       => $this->lang->languages($this->session->language),
		);

		// Generic language lines.
		$lines = array(
			'activate'       => __('CSK_ADMIN_CONFIRM_ACTIVATE'),
			'deactivate'     => __('CSK_ADMIN_CONFIRM_DEACTIVATE'),
			'delete'         => __('CSK_ADMIN_CONFIRM_DELETE'),
			'deleteselected' => __('CSK_ADMIN_CONFIRM_DELETE_SELECTED'),
			'disable'        => __('CSK_ADMIN_CONFIRM_DISABLE'),
			'enable'         => __('CSK_ADMIN_CONFIRM_ENABLE'),
			'install'        => __('CSK_ADMIN_CONFIRM_INSTALL'),
			'remove'         => __('CSK_ADMIN_CONFIRM_DELETE_PERMANENT'),
			'restore'        => __('CSK_ADMIN_CONFIRM_RESTORE'),
			'upload'         => __('CSK_ADMIN_CONFIRM_UPLOAD'),
		);

		$output .= '<script type="text/javascript">';
		$output .= 'var csk = window.csk = window.csk || {};';
		$output .= ' csk.config = '.json_encode($config).';';
		$output .= ' csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.default = '.json_encode($lines).';';
		$output .= '</script>';

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * admin_head
	 *
	 * Method for adding extra stuff to admin output before closing </head> tag.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.3.3
	 *
	 * @since 	1.4.0 	Left only iE9 support and other things moved to "csk_globals".
	 *
	 * @access 	public
	 * @param 	string 	$output 	The admin head output.
	 * @return 	void
	 */
	public function admin_head($output)
	{
		add_ie9_support($output, (ENVIRONMENT === 'production'));
		return $output;
	}

	// ------------------------------------------------------------------------
	// Private Methods.
	// ------------------------------------------------------------------------

	/**
	 * Prepare dashboard sidebar menu.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	protected function _admin_menu()
	{
		global $back_contexts;
		
		$ignored_contexts = array('admin', 'users', 'settings');
		$modules = $this->router->list_modules(true);
		$lang = $this->lang->lang('folder');

		if ( ! $modules)
		{
			return;
		}

		foreach ($modules as $folder => $module)
		{
			// we make sure the module is enabled!
			if ( ! $module['enabled'])
			{
				continue;
			}

			/**
			 * If the module comes with a top level menu item using
			 * "admin_navbar-name" or "admin_navbar_right-name", we make
			 * sure to display the menu then stop the script.
			 * @since 	2.1.0
			 */
			if (has_action('admin_navbar-'.$folder) 
				OR has_action('admin_navbar_right-'.$folder))
			{
				// See if we have a top level menu.
				if (has_action('admin_navbar-'.$folder))
				{
					add_action('_admin_navbar', function() use ($folder) {
						do_action('admin_navbar-'.$folder);
					});
				}

				// See if we have a top level menu (right menu).
				if (has_action('admin_navbar_right-'.$folder))
				{
					add_action('_admin_navbar_right', function() use ($folder) {
						do_action('admin_navbar_right-'.$folder);
					});
				}

				continue;
			}

			// See if we have a top level menu (right menu).
			if (has_action('admin_navbar_right-'.$folder))
			{
				add_action('_admin_navbar_right', function() use ($folder) {
					do_action('admin_navbar_right-'.$folder);
				});

				continue;
			}

			foreach ($module['contexts'] as $context => $status)
			{
				// No context? Ignore it.
				if (false === $status OR in_array($folder, $ignored_contexts))
				{
					continue;
				}

				// Help context.
				if ('help' === $context && true !== $status)
				{
					add_action('_help_menu', function() use ($module, $status, $lang) {
						$title_line = isset($module['help_menu']) ? 'help_menu' : 'admin_menu';
						// Translation present?
						if (isset($module['translations'][$lang][$title_line])) {
							$title = $module['translations'][$lang][$title_line];
						}
						// May be we use 
						elseif (isset($module[$title_line]) && 1 === sscanf($module[$title_line], 'lang:%s', $line)) {
							$title = __($line);
						} else {
							$title = ucwords($module[$title_line]);
						}
						
						echo html_tag('a', array(
							'href' => $status,
							'target' => '_blank',
							'class' => 'dropdown-item',
						), $title);
					}, $module['admin_order']);
					continue;
				}

				// Add other context.
				add_action("_{$context}_menu", function() use ($module, $status, $context, $lang) {
					$uri = $module['folder'];
					('admin' !== $context) && $uri = $context.'/'.$uri;

					$title_line = isset($module[$context.'_menu']) ? $context.'_menu' : 'admin_menu';

					// Translation present?
					if (isset($module['translations'][$lang][$title_line])) {
						$title = $module['translations'][$lang][$title_line];
					}
					// May be we use 
					elseif (isset($module[$title_line]) && 1 === sscanf($module[$title_line], 'lang:%s', $line)) {
						$title = __($line);
					} else {
						$title = ucwords($module[$title_line]);
					}

					echo html_tag('a', array(
						'href' => admin_url($uri),
						'class' => 'dropdown-item',
					), $title);

				}, $module['admin_order']);
			}
		}
	}

	// ------------------------------------------------------------------------
	// Scripts Enqueue.
	// ------------------------------------------------------------------------

	/**
	 * _dropzone
	 *
	 * Method to enqueue Dropzone files with optional LazyLoad use.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 * @since 	2.0.0 	Dropped the LazyLoad. THe dashboard has built-in images lazy loading.
	 *
	 * @copyright 	Matias Meno (https://github.com/enyo)
	 * @link 		https://github.com/enyo/dropzone
	 *
	 * @access 	protected
	 * @param 	void
	 * @return 	void
	 */
	protected function _dropzone()
	{
		in_array('dropzone', $this->styles) OR $this->styles[]  = 'dropzone';
		in_array('dropzone', $this->scripts) OR $this->scripts[] = 'dropzone';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _garlic
	 *
	 * Method to enqueue Garlic.js file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	Guillaume Potier (https://github.com/guillaumepotier)
	 * @link 		https://github.com/guillaumepotier/Garlic.js
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	protected function _garlic()
	{
		in_array('garlic', $this->scripts) OR $this->scripts[] = 'garlic';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _handlebars
	 *
	 * Method to enqueue handlebars file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	Yehuda Katz (https://github.com/wycats)
	 * @link 		https://github.com/wycats/handlebars.js/
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _handlebars()
	{
		if ( ! in_array('handlebars', $this->scripts))
		{
			$this->scripts[] = 'handlebars';
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _highlight
	 *
	 * Method to enqueue highlight file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @copyright 	Ivan Sagalaev (https://github.com/isagalaev)
	 * @link 		https://github.com/isagalaev/highlight.js
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _highlight()
	{
		in_array('highlight', $this->styles) OR $this->styles[]  = 'highlight';
		in_array('highlight', $this->scripts) OR $this->scripts[] = 'highlight';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _jquery_ui
	 *
	 * Method to enqueue jQuery UI assets with option use of jQuery TouchPunch.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	jQuery (https://github.com/jquery)
	 * @link 		https://github.com/jquery/jquery-ui
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _jquery_ui($touch_punch = true)
	{
		in_array('jquery-ui', $this->styles) OR $this->styles[]  = 'jquery-ui';
		in_array('jquery-ui', $this->scripts) OR $this->scripts[] = 'jquery-ui';

		if (true === $touch_punch 
			&& ! in_array('jquery.ui.touch-punch', $this->scripts))
		{
			$this->scripts[] = 'jquery.ui.touch-punch';
		}
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _jquery_validate
	 *
	 * Method to enqueue jQuery validate plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @copyright 	jquery-validation (https://github.com/jquery-validation)
	 * @link 		https://github.com/jquery-validation/jquery-validation
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _jquery_validate()
	{
		if ( ! in_array('jquery.validate', $this->scripts))
		{
			$this->scripts[] = 'jquery.validate';
		}

		if ('en' !== ($code = $this->lang->lang('code')))
		{
			if ( ! in_array('jquery-validate/'.$code, $this->scripts))
			{
				$this->scripts[] = 'jquery-validate/'.$code;
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _jquery_sprintf
	 *
	 * Method for loading jQuery sprintf plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @copyright 	Carl Fürstenberg (https://github.com/azatoth)
	 * @link 		https://github.com/azatoth/jquery-sprintf
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _jquery_sprintf()
	{
		if ( ! in_array('jquery.sprintf', $this->scripts))
		{
			$this->scripts[] = 'jquery.sprintf';
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _select2
	 *
	 * Method to enqueue Select2 files with optional Bootstrap theme.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	Select2 (https://github.com/select2)
	 * @link 		https://github.com/select2/select2
	 *
	 * @access 	public
	 * @param 	bool 	$bootstrap 	Whether to enqueue Bootstrap theme.
	 * @return 	void
	 */
	protected function _select2($bootstrap = true)
	{
		in_array('select2', $this->styles) OR $this->styles[]  = 'select2';
		in_array('select2', $this->scripts) OR $this->scripts[] = 'select2';

		if ('en' !== ($code = $this->lang->lang('code')))
		{
			if ( ! in_array('select2/'.$code, $this->scripts))
			{
				$this->scripts[] = 'select2/'.$code;
			}
		}

		if (true === $bootstrap && ! in_array('select2-bootstrap', $this->scripts))
		{
			$this->styles[] = 'select2-bootstrap';
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _summernote
	 *
	 * Method for queuing Summernote JS.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	Summernote (https://github.com/summernote)
	 * @link 		https://github.com/summernote/summernote
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _summernote()
	{
		in_array('summernote', $this->styles) OR $this->styles[]  = 'summernote';
		in_array('summernote', $this->scripts) OR $this->scripts[] = 'summernote';

		if ('english' !== $this->config->item('language'))
		{
			$locale = $this->lang->lang('locale');
			if ( ! in_array('summernote/summernote-'.$locale, $this->scripts))
			{
				$this->scripts[] = 'summernote/summernote-'.$locale;
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _zoom
	 *
	 * Method to enqueue ZoomJS files.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @copyright 	fat (https://github.com/fat)
	 * @link 		https://github.com/fat/zoom.js/
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _zoom()
	{
		in_array('zoom', $this->styles) OR $this->styles[]  = 'zoom';
		in_array('zoom', $this->scripts) OR $this->scripts[] = 'zoom';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _btn_back
	 *
	 * Method for creating a back to modules main page.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$module 	The module to create back link for.
	 * @param 	bool 	$echo 		Whether to echo the anchor.
	 * @return 	string
	 */
	public function _btn_back($module = null, $echo = true)
	{
		if (null === $module)
		{
			$module = empty($this->uri->segment(3))
				? $this->uri->segment(2)
				: $this->uri->segment(3);
		}

		// Direction of the icon depends on the language.
		$icon = 'caret-'.('rtl' === $this->lang->lang('direction') ? 'right' : 'left');

		$anchor = html_tag('a', array(
			'href' => admin_url($module),
			'class' => 'btn btn-default btn-sm btn-icon',
		), fa_icon($icon).__('CSK_BTN_BACK'));

		if (false === $echo)
		{
			return $anchor;
		}

		echo $anchor;
	}

}

// ------------------------------------------------------------------------

/**
 * Content_Controller Class
 *
 * Only "Content.php" controllers should extend this class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Content_Controller extends Admin_Controller {}

// ------------------------------------------------------------------------

/**
 * Help_Controller Class
 *
 * Only "Help.php" controllers should extend this class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Help_Controller extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Load needed resources only.
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
		parent::__construct();
		$this->load->language('csk_help');
		
		$this->data['page_icon']  = 'question-circle';
		$this->data['page_title'] = __('CSK_ADMIN_HELP');
		$this->data['page_help']  = 'https://goo.gl/dAChV1';
	}

}

// ------------------------------------------------------------------------

/**
 * Reports_Controller Class
 *
 * Only "Reports.php" controllers should extend this class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Reports_Controller extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Load needed resources only.
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
		parent::__construct();
		$this->load->language('csk_reports');
		
		$this->scripts[] = 'reports';
		
		add_action('admin_head', array($this, '_reports_admin_head'), 0);
		
		$this->data['page_icon']  = 'bar-chart';
		$this->data['page_title'] = __('CSK_ADMIN_REPORTS');
		$this->data['page_help']  = 'https://goo.gl/L3cXUb';
	}

	// ------------------------------------------------------------------------

	/**
	 * _reports_admin_head
	 *
	 * Add some JS lines.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _reports_admin_head($output)
	{
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.reports = csk.i18n.reports || {};';
		$output .= ' csk.i18n.reports.delete = "'.__('CSK_REPORTS_CONFIRM_DELETE').'";';
		$output .= '</script>';

		return $output;
	}

}

// ------------------------------------------------------------------------

/**
 * Settings_Controller Class
 *
 * Only "Settings.php" controllers should extend this class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Settings_Controller extends Admin_Controller {

	/**
	 * Array of options tabs and their display order.
	 * @var array
	 */
	protected $_tabs = array();

	/**
	 * __construct
	 *
	 * Load needed resources only.
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
		parent::__construct();
		$this->load->language('csk_settings');
		
		$this->scripts[] = 'settings';

		$this->data['page_icon']  = 'sliders';
		$this->data['page_title'] = __('CSK_BTN_SETTINGS');
		$this->data['page_help']  = 'https://goo.gl/H9giKR';
	}

	// ------------------------------------------------------------------------

	/**
	 * _prep_settings
	 *
	 * Method for preparing all settings data and their form validation rules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added the base controller setting handler.
	 * @since 	2.0.0 	Moved to Settings_Controller class.
	 *
	 * @access 	protected
	 * @param 	string
	 * @return 	array
	 */
	protected function _prep_settings($tab = 'general')
	{
		$settings = $this->kbcore->options->get_by_tab($tab);

		if (false === $settings)
		{
			return array(false, null);
		}

		if (isset($this->_tabs[$tab]) && ! empty($this->_tabs[$tab]))
		{
			$_settings = array();
			$order = array_flip($this->_tabs[$tab]);

			foreach ($settings as $index => $setting)
			{
				$_settings[$order[$setting->name]] = $setting;
			}

			if ( ! empty($_settings))
			{
				ksort($_settings);
				$settings = $_settings;
			}
		}

		// Prepare empty form validation rules.
		$rules = array();

		foreach ($settings as $option)
		{
			$data[$option->name] = array(
				'type'  => $option->field_type,
				'name'  => $option->name,
				'id'    => $option->name,
				'value' => $option->value,
			);

			if ($option->required == 1)
			{
				$data[$option->name]['required'] = 'required';
				$rules[$option->name] = array(
					'field' => $option->name,
					'label' => "lang:CSK_SETTINGS_{$option->name}",
					'rules' => 'required',
				);
			}

			/**
			 * In case of the base controller settings, we make sure to 
			 * grab a list of all available controllers/modules and prepare
			 * the dropdown list.
			 */
			if ('base_controller' === $option->name && empty($option->options))
			{
				// We start with an empty controllers list.
				$controllers = array();

				// We set controllers locations.
				$app_path = rtrim(str_replace('\\', '/', APPPATH.'controllers/'), '/').'/';
				$csk_path = rtrim(str_replace('\\', '/', KBPATH.'controllers/'), '/').'/';
				$locations   = array($app_path => null, $csk_path => null);

				// We add modules locations to controllers locations.
				$modules = $this->router->list_modules(true);
				foreach ($modules as $folder => $details)
				{
					/**
					 * Ignore modules that are disabled or modules that do
					 * not have a controllers directory.
					 */
					if (( ! isset($details['enabled']) OR true !== $details['enabled']) 
						OR true !== is_dir($details['full_path'].'controllers'))
					{
						continue;
					}

					$locations[$details['full_path'].'controllers/'] = $folder;
				}

				// Array of files to be ignored.
				$_to_eliminate = array(
					'.',
					'..',
					'.gitkeep',
					'.htaccess',
					'Users.php',
				);
				
				global $back_contexts, $front_contexts;
				
				$contexts = array_merge($back_contexts, $front_contexts);
				$contexts = array_map(function($key) {
					$key = preg_replace('/.php$/', '', $key).'.php';
					return ucfirst($key);
				}, $contexts);
				
				$_to_eliminate = array_merge($_to_eliminate, $contexts);

				// Fill controllers.
				foreach ($locations as $location => $module)
				{
					// We read the directory.
					if ($handle = opendir($location))
					{
						while (false !== ($file = readdir($handle)))
						{
							// We ignore files to eliminate.
							if ( ! in_array($file, $_to_eliminate))
							{
								// We format the file's name.
								$file = strtolower(str_replace('.php', '', $file));

								/**
								 * If the controller's name is different from module's, we 
								 * make sure to add the module to the start.
								 */
								if (null !== $module && $file <> $module)
								{
									$file = $module.'/'.$file;
								}

								// We fill $controllers array.
								$controllers[$file] = $file;
							}
						}
					}
				}

				// We add controllers list.
				$option->options = $controllers;
			}
			
			if ($option->field_type == 'dropdown' && ! empty($option->options))
			{
				$data[$option->name]['options'] = array_map(function($val) {
					if (is_numeric($val))
					{
						return $val;
					}

					return (sscanf($val, 'lang:%s', $lang_val) === 1) ? __($lang_val) : $val;
				}, $option->options);

				if ( ! empty($option->value))
				{
					$data[$option->name]['selected'] = $option->value;
					$rules[$option->name]['rules'] .= '|in_list['.implode(',', array_keys($option->options)).']';
				}
				else
				{
					$data[$option->name]['selected'] = '';
				}
			}
			else
			{
				$data[$option->name]['placeholder'] = __('CSK_SETTINGS_'.$option->name);
			}
		}

		return array($data, array_values($rules));
	}

	// ------------------------------------------------------------------------

	/**
	 * _save_settings
	 *
	 * Method that handles automatically saving settings.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	protected
	 * @param 	array
	 * @param 	string
	 * @return 	bool
	 */
	protected function _save_settings($inputs, $tab = null)
	{
		// Nothing provided? Nothing to do.
		if (empty($inputs) OR (empty($tab) OR ! array_key_exists($tab, $this->_tabs)))
		{
			set_alert(__('CSK_ERROR_CSRF'), 'error');
			return false;
		}

		// Check nonce.
		if (true !== $this->check_nonce('settings-'.$tab, false))
		{
			set_alert(__('CSK_ERROR_CSRF'), 'error');
			return false;
		}

		/**
		 * We make sure to collect all settings data from the provided
		 * $inputs array (We use their keys).
		 * Then, we loop through all elements and remove those that did
		 * not change to avoid useless update.
		 */
		$settings = $this->input->post(array_keys($inputs), true);
		foreach ($settings as $key => $val)
		{
			if (to_bool_or_serialize($inputs[$key]['value']) === $val)
			{
				unset($settings[$key]);
			}
		}

		/**
		 * If all settings were removed, we will end up with an empty 
		 * array, so we simply fake it :) .. We say everything was updated.
		 */
		if (empty($settings))
		{
			set_alert(__('CSK_SETTINGS_SUCCESS_UPDATE'), 'success');
			return true;
		}

		/**
		 * In case we have some left settings, we make sure to updated them
		 * one by one and stop in case one of them could not be updated.
		 */
		foreach ($settings as $key => $val)
		{
			if (false === $this->kbcore->options->set_item($key, $val))
			{
				log_message('error', "Unable to update setting {$tab}: {$key}");
				set_alert(__('CSK_SETTINGS_ERROR_UPDATE'), 'error');
				return false;
			}
		}

		set_alert(__('CSK_SETTINGS_SUCCESS_UPDATE'), 'success');
		return true;
	}

}
