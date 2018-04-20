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

		// Make sure the user is an administrator.
		if ( ! $this->auth->is_admin())
		{
			set_alert(lang('error_permission'), 'error');
			redirect('');
			exit;
		}

		// Load admin helper.
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

		// Print admin head part.
		add_filter('admin_head', array($this, 'admin_head'));

		// Prepare dashboard sidebar.
		$this->theme->set('admin_menu', $this->_admin_menu(), true);

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

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Added some needed scripts to the head section.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$output
	 * @return 	string
	 */
	public function admin_head($output)
	{
		// Adding configuration.
		$config = json_encode(array(
			'siteURL'    => site_url(),
			'baseURL'    => base_url(),
			'adminURL'   => admin_url(),
			'currentURL' => current_url(),
			'ajaxURL'    => ajax_url('admin'),
			'lang'       => $this->lang->languages($this->session->language),
		));

		$output .= "\t<script type=\"text/javascript\">var Kbcore=Kbcore||{},Config=Config||{},i18n=i18n||{};Object.assign(Config, {$config});</script>\n";

		// Add support for older browser.
		add_ie9_support($output, (ENVIRONMENT === 'production'));

		// Return the final output.
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
		$menu = array();
		$modules = $this->router->list_modules(true);

		// Sort modules.
		uasort($modules, function($a, $b) {
			return $a['admin_order'] - $b['admin_order'];
		});

		foreach ($modules as $folder => $details)
		{
			if ($this->router->has_admin($folder))
			{
				$menu[$folder] = $details['admin_menu'];
			}
		}

		return $menu;
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
	 * @access 	protected
	 * @param 	bool 	$lazyload 	Whether to enqueue LazyLoad.
	 * @return 	void
	 */
	protected function _dropzone($lazyload = false)
	{
		// We push Dropzone CSS and JS file.
		array_push($this->styles, 'dropzone');
		array_push($this->scripts, 'dropzone');

		// Shall we enqueue LazyLoad?
		(true === $lazyload) && $this->_lazyload();

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
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _handlebars()
	{
		array_splice($this->scripts, 2, 0, array('handlebars'));

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
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _jquery_ui($touch_punch = true)
	{
		// jQuery UI CSS file.
		array_splice($this->styles, 1, 0, array('jquery-ui'));

		// Prepare scripts to be added.
		$scripts = array('jquery-ui');
		(true === $touch_punch) && $scripts[] = 'jquery.ui.touch-punch';
		array_splice($this->scripts, 2, 0, $scripts);

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
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _lazyload()
	{
		array_push($this->scripts, 'lazyload');

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
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _summernote()
	{
		array_splice($this->styles, 2, 0, 'summernote');
		array_splice($this->scripts, 3, 0, 'summernote');
		if ('english' !== $this->config->item('language'))
		{
			$locale = $this->lang->lang('locale');
			array_splice($this->scripts, 4, 0, 'summernote/summernote-'.$locale);
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
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _zoom()
	{
		array_push($this->styles, 'zoom');
		array_push($this->scripts, 'zoom');

		return $this;
	}

}
