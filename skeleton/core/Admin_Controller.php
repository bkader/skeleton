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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
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
		if (true !== $this->kbcore->auth->online())
		{
			redirect('admin-login?next='.rawurlencode(uri_string()),'refresh');
			exit;
		}

		if ( ! $this->kbcore->auth->is_admin())
		{
			set_alert(lang('CSK_ERROR_PERMISSION'), 'error');
			redirect('');
			exit;
		}

		$this->load->language('csk_admin');

		if (null !== $this->router->fetch_module())
		{
			if (false === $this->module)
			{
				show_error(line('CSK_ADMIN_MANIFEST_MISSING'));
			}
			// Disabled module.
			if (true !== $this->module['enabled'])
			{
				set_alert(line('CSK_ADMIN_COMPONENT_DISABLED'), 'warning');
				redirect('admin');
				exit;
			}
		}
		
		add_filter('admin_head', array($this, 'csk_globals'), 0);
		add_filter('admin_head', array($this, 'admin_head'), 99);
		$this->_admin_menu();
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
					->add('css', admin_url("load/styles?load=".rawurlencode($this->styles)), null, null, true);
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
					->add('js', admin_url("load/scripts?load=".rawurlencode($this->scripts)), null, null, true);
			}

			/**
			 * We make sure to make theme library put back extensions.
			 * @since 	1.5.0
			 */
			$this->theme->do_extension();

			// If we have a heading method, use it.
			method_exists($this, '_subhead') && $this->_subhead();

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
		$lang = $this->config->item('language');

		if ( ! $modules)
		{
			return;
		}

		foreach ($modules as $folder => $module)
		{
			// we make sure the module is enabled!
			if (true !== $module['enabled'])
			{
				continue;
			}

			foreach ($module['contexts'] as $context => $status)
			{
				// No context? Ignore it.
				if (false === $status OR in_array($folder, $ignored_contexts))
				{
					unset($modules['contexts'][$context]);
					continue;
				}

				// Help context.
				if ('help' === $context && true !== $status)
				{
					add_action('help_menu', function() use ($module, $status, $lang) {
						$title_line = isset($module['help_menu']) ? 'help_menu' : 'admin_menu';
						$title = isset($module['translations'][$title_line][$lang])
							? $module['translations'][$title_line][$lang]
							: $module[$title_line];

						echo html_tag('a', array(
							'href' => $status,
							'target' => '_blank',
							'class' => 'dropdown-item',
						), $title);
					}, $module['admin_order']);
					continue;
				}

				// Add other context.
				add_action($context.'_menu', function() use ($module, $status, $context, $lang) {
					$uri = $module['folder'];
					('admin' !== $context) && $uri = $context.'/'.$uri;

					$title_line = isset($module[$context.'_menu']) ? $context.'_menu' : 'admin_menu';
					if (isset($module['translations'][$title_line][$lang])) {
						$title = $module['translations'][$title_line][$lang];
					} elseif (1 === sscanf($title_line, 'lang:%s', $line)) {
						$title = line($line);
						(false !== strpos($title, 'FIXME')) && $title = ucwords($module[$title_line]);
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
		in_array('dropzone', $this->styles) OR $this->styles[]  = 'dropzone';
		in_array('dropzone', $this->scripts) OR $this->scripts[] = 'dropzone';
		
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
	 * _lazyload
	 *
	 * Method to enqueue LazyLoad library.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
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
		in_array('lazyload', $this->scripts) OR $this->scripts[] = 'lazyload';
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
		), fa_icon($icon).line('CSK_ADMIN_BTN_BACK'));

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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Content_Controller extends Admin_Controller {

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
		$this->load->language('csk_content');
	}

}

// ------------------------------------------------------------------------

/**
 * Help_Controller Class
 *
 * Only "Help.php" controllers should extend this class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
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
		$this->data['page_title'] = line('CSK_ADMIN_HELP');
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
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
		$this->data['page_title'] = line('CSK_ADMIN_REPORTS');
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
		$output .= ' csk.i18n.reports.delete = "'.line('CSK_REPORTS_CONFIRM_DELETE').'";';
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Settings_Controller extends Admin_Controller {

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
		$this->data['page_title'] = line('CSK_ADMIN_BTN_SETTINGS');
		$this->data['page_help']  = 'https://goo.gl/H9giKR';
	}

}
