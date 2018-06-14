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
 * Theme package bootstrap file.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Packages
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.3
 * @version 	2.1.3
 */

if ( ! class_exists('Theme_bootstrap')):

class Theme_bootstrap {

	/**
	 * Holds an instance of CI object.
	 * @var object
	 */
	private $CI;

	/**
	 * Class constructor.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	// ------------------------------------------------------------------------

	/**
	 * Initialize class.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function init()
	{
		/**
		 * The reason behind this approach it to avoid initializing the class,
		 * I mean executing this method if it has already executed.
		 */
		static $initialized = false;

		if (true !== $initialized)
		{
			// Register package adding and removal actions.
			add_action('package_added_theme', array($this, 'package_added'));
			add_action('package_removed_theme', array($this, 'package_removed'));

			// We make sure to flag the method as already called.
			$initialized = true;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Fires when the package is added.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function package_added()
	{
		// We load the theme library, helper and language file.
		$this->CI->load->language('theme');
		$this->CI->load->library('theme');
		$this->CI->load->helper('theme');

		$this->CI->theme->initialize();

		// We load library's dependencies.
		function_exists('base_url') OR $this->CI->load->helper('url');
		function_exists('plural') OR $this->CI->load->helper('inflector');
		function_exists('html_tag') OR $this->CI->load->helper('html');
		class_exists('CI_User_agent', false) OR $this->CI->load->library('user_agent');
		class_exists('CI_Session', false) OR $this->CI->load->library('session');
	}

	// ------------------------------------------------------------------------

	/**
	 * Fires upon package removal.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function package_removed()
	{
		return;
	}
}

endif;
