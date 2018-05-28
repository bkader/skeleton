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
 * Dashboard login controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.1
 */
class Login extends KB_Controller {

	/**
	 * __construct
	 *
	 * Method for loading needed resources.
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
		$this->load->language('csk_admin');

		// Make sure the user is logged in.
		if (true === $this->kbcore->auth->is_admin())
		{
			set_alert(__('CSK_ERROR_LOGGED_IN'), 'warning');
			redirect(KB_ADMIN);
			exit;
		}

		// Remove all filters applied by themes.
		remove_all_filters();

		/**
		 * The layout to use for dashboard authentication.
		 * @since 	2.0.0
		 */
		$default_layout = 'clean';
		$login_layout   = apply_filters('admin_login_layout', 'clean');
		empty($login_layout) && $login_layout = $default_layout;
		$this->theme->set_layout($login_layout);

		/**
		 * StyleSheets to load on the login page.
		 * @since 	2.0.0
		 */
		$default_styles = array(
			'font-awesome' => $this->theme->common_url('css/font-awesome.min.css'),
			'bootstrap'    => $this->theme->common_url('css/bootstrap.min.css'),
			'admin'        => $this->theme->common_url('css/admin.min.css'),
		);

		$login_styles = apply_filters('login_styles', array());
		if (empty($login_styles) OR ! is_array($login_styles)) {
			$login_styles = $default_styles;
		} else {
			$login_styles = array_merge($default_styles, $login_styles);
		}
		$this->theme->add('css', $login_styles);

		/**
		 * Scripts to load on the login page.
		 * @since 	2.0.0
		 */
		$default_scripts = array(
			'jquery.validate' => $this->theme->common_url('js/jquery.validate.js'),
			'popper'          => $this->theme->common_url('js/popper.min.js'),
			'bootstrap'       => $this->theme->common_url('js/bootstrap.min.js'),
			'admin'           => $this->theme->common_url('js/admin.min.js'),
		);
		$login_scripts = apply_filters('login_scripts', array());
		if (empty($login_scripts) OR ! is_array($login_scripts)) {
			$login_scripts = $default_scripts;
		} else {
			$login_scripts = array_merge($default_scripts, $login_scripts);
		}
		$this->theme->add('js', $login_scripts);

		/**
		 * Login section body class.
		 * @since 	2.0.0
		 */
		$default_class = 'csk-clean';
		$login_body_class = apply_filters('login_body_class', 'csk-clean');
		if (false === strpos($default_class, $login_body_class)) {
			$login_body_class .= ' '.$default_class;
		}
		$this->theme->body_class($login_body_class);
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Dashboard login section.
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
		// Prepare login form validation.
		$this->prep_form(array(
			array(	'field' => 'username',
					'label' => 'lang:CSK_INPUT_USERNAME',
					'rules' => 'required|min_length[5]|max_length[32]|user_exists|user_admin'),
			array(	'field' => 'password',
					'label' => 'lang:CSK_INPUT_PASSWORD',
					'rules' => 'required|min_length[8]|max_length[20]|check_credentials[username]'),
		), '#login');

		// Array of available languages.
		$langs['-1'] = __('CSK_ADMIN_LANGUAGES_DEFAULT');
		$site_languages = $this->config->item('languages');
		if (count($site_languages) >= 2)
		{
			$languages = $this->lang->languages($site_languages);
			if (count($languages) >= 2) {
				foreach ($languages as $folder => $lang) {
					$langs[$folder] = $lang['name_en'].' ('.$lang['name'].')';
				}
			}
		}

		// Before the form is submitted.
		if ($this->form_validation->run() == false)
		{
			// Add the username field.
			$this->data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username'))
			);

			// Add the password field.
			$this->data['password'] = $this->config->item('password', 'inputs');

			// Add languages field only if we have languages.
			$this->data['languages'] = null;
			if (count($langs) >= 2) {
				$this->data['languages'] = array(
					'type'     => 'dropdown',
					'name'     => 'language',
					'id'       => 'language',
					'options'  => $langs,
					'selected' => '-1',
				);
			}

			/**
			 * Filter the login page title.
			 * @since 	2.0.0
			 */
			$login_title = apply_filters('login_title', __('CSK_BTN_LOGIN'));
			$this->theme->set_title($login_title)->render($this->data);
		}
		// After the form is submitted.
		else
		{
			// Did not pass nonce check?
			if (true !== $this->check_nonce('admin-login', false))
			{
				set_alert(__('CSK_ERROR_CSRF'), 'error');
				redirect('admin-login', 'refresh');
				exit;
			}

			// Get the user from data.
			$user = $this->kbcore->users->get($this->input->post('username', true));

			// Format the language.
			$language = $this->input->post('language', true);
			(empty($language) OR $language <= 0) && $language = null;

			// In case the user was not found or could not login.
			if (false === $user 
				OR true !== $this->kbcore->auth->quick_login($user, $language))
			{
				/**
				 * Login error filter.
				 * @since 	2.0.0
				 */
				$login_error = apply_filters('admin_login_failed', __('CSK_ERROR_CSRF'));
				empty($login_error) && $login_error = __('CSK_ERROR_CSRF');
				set_alert($login_error, 'error');
				redirect('admin-login', 'refresh');
				exit;
			}

			/**
			 * Login redirection filter.
			 * @since 	2.0.0
			 */
			$redirect_to = apply_filters('admin_login_redirect', KB_ADMIN);
			redirect($redirect_to);
			exit;
		}

	}
}
