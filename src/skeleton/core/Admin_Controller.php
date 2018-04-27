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
 * Admin_Controller Class
 *
 * Controllers extending this class requires a logged in user of rank "admin".
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @since 		1.3.3 	Added dynamic assets loading.
 * 
 * @version 	1.3.3
 */
class Admin_Controller extends User_Controller
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

		if ( ! $this->auth->is_admin())
		{
			set_alert(lang('error_permission'), 'error');
			redirect('');
			exit;
		}

		if (null !== $this->router->fetch_module())
		{
			if (false === $this->module)
			{
				show_error(line('manifest_missing_message'), 500, line('manifest_missing_heading'));
			}
			// Disabled module.
			if (true !== $this->module['enabled'])
			{
				set_alert(line('module_disabled_message'), 'warning');
				redirect('admin');
				exit;
			}
		}
		
		add_filter('admin_head', array($this, 'csk_globals'), 0);
		add_filter('admin_head', array($this, 'admin_head'), 99);
		$this->load->helper('admin');
		$this->_admin_menu();
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
				if ('rtl' === langinfo('direction'))
				{
					array_push($this->styles, 'bootstrap-rtl', 'admin-rtl');
				}

				$this->styles = array_map('trim', $this->styles);
				$this->styles = array_filter($this->styles);
				$this->styles = array_unique($this->styles);
				$this->styles = implode(',', $this->styles);

				$this->theme
					->no_extension()
					->add('css', site_url("load/styles?load=".rawurlencode($this->styles)), null, null, true);
			}

			// Do we have any JS files to laod?
			if ( ! empty($this->scripts))
			{
				$this->scripts = array_map('trim', $this->scripts);
				$this->scripts = array_filter($this->scripts);
				$this->scripts = array_unique($this->scripts);
				$this->scripts = implode(',', $this->scripts);
				$this->theme
					->no_extension()
					->add('js', site_url("load/scripts?load=".rawurlencode($this->scripts)), null, null, true);
			}

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
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	string 	$output 	StyleSheets output.
	 * @return 	void
	 */
	public function csk_globals($output)
	{
		$config = array(
			'siteURL'    => site_url(),
			'baseURL'    => base_url(),
			'adminURL'   => admin_url(),
			'currentURL' => current_url(),
			'ajaxURL'    => ajax_url(),
			'lang'       => $this->lang->languages($this->session->language),
		);

		$output .= '<script type="text/javascript">';
		$output .= 'var csk = window.csk = window.csk || {};';
		$output .= ' csk.i18n = csk.i18n || {};';
		$output .= ' csk.config = '.json_encode($config).';';
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
	 * @link 	https://github.com/bkader
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
		$modules = $this->router->list_modules(true);
		if ( ! $modules)
		{
			return;
		}

		foreach ($modules as $folder => $module)
		{
			if ($this->router->has_admin($folder))
			{
				add_action('admin_menu', function() use ($module) {
					return module_menu($module);
				}, $module['admin_order'], 1);
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
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @copyright 	Matias Meno (https://github.com/enyo)
	 * @link 		https://github.com/enyo/dropzone
	 *
	 * @access 	protected
	 * @param 	bool 	$lazyload 	Whether to enqueue LazyLoad.
	 * @return 	void
	 */
	protected function _dropzone($lazyload = false)
	{
		$this->styles[]  = 'dropzone';
		$this->scripts[] = 'dropzone';
		
		(true === $lazyload) && $this->_lazyload();
		
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _garlic
	 *
	 * Method to enqueue Garlic.js file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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
		$this->scripts[] = 'garlic';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _handlebars
	 *
	 * Method to enqueue handlebars file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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
		$this->scripts[] = 'handlebars';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _jquery_ui
	 *
	 * Method to enqueue jQuery UI assets with option use of jQuery TouchPunch.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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
		$this->styles[]  = 'jquery-ui';
		$this->scripts[] = 'jquery-ui';
		(true === $touch_punch) && $this->scripts[] = 'jquery.ui.touch-punch';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _lazyload
	 *
	 * Method to enqueue LazyLoad library.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @copyright 	Andrea Verlicchi (https://github.com/verlok)
	 * @link 		https://github.com/verlok/lazyload
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _lazyload()
	{
		$this->scripts[] = 'lazyload';
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _select2
	 *
	 * Method to enqueue Select2 files with optional Bootstrap theme.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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
		$this->styles[]  = 'select2';
		$this->scripts[] = 'select2';

		if ('english' !== $this->config->item('language'))
		{
			$this->scripts[] = 'select2/'.$this->lang->lang('code');
		}

		(true === $bootstrap) && $this->styles[] = 'select2-bootstrap';

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * _summernote
	 *
	 * Method for queuing Summernote JS.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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
		$this->styles[]  = 'summernote';
		$this->scripts[] = 'summernote';
		if ('english' !== $this->config->item('language'))
		{
			$this->scripts[] = 'summernote/summernote-'.$this->lang->lang('locale');
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
	 * @link 	https://github.com/bkader
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
		$this->styles[]  = 'zoom';
		$this->scripts[] = 'zoom';
		return $this;
	}

}
