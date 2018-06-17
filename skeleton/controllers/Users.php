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
 * Users Module - Users Controllers
 *
 * This module allow users to exists on the website. It handles users 
 * registration, activation, authentication and password management.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */
class Users extends KB_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent's constructor and allow access to logout method
	 * only for already logged-in users.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure the user is not logged in.
		if ($this->kbcore->auth->online() 
			&& 'logout' !== $this->router->fetch_method())
		{
			set_alert(line('CSK_ERROR_LOGGED_IN'), 'error');
			redirect('');
			exit;
		}

		/**
		 * Front-end login layout.
		 * @since 	2.0.0
		 */
		$default_layout = 'clean';
		$login_layout   = apply_filters('login_layout', 'clean');
		empty($login_layout) OR $this->theme->set_layout($login_layout);

		$this->load->language('csk_users');

		/**
		 * If the view does not exists within the theme's folder,
		 * we make sure to use our default one.
		 */
		if (true !== $this->theme->view_exists())
		{
			remove_all_filters();
			$this->load->helper('admin');

			/**
			 * The layout to use for users authentication.
			 * @since 	2.0.0
			 */
			$default_layout = 'clean';
			$login_layout   = apply_filters('login_layout', 'clean');
			empty($login_layout) && $login_layout = $default_layout;
			$this->theme->set_layout($login_layout);

			/**
			 * StyleSheets to load on the login page.
			 * @since 	2.0.0
			 */
			$default_styles = array(
				'fontawesome' => $this->theme->common_url('css/font-awesome.min.css'),
				'bootstrap'   => $this->theme->common_url('css/bootstrap.min.css'),
				'admin'       => $this->theme->common_url('css/admin.min.css'),
			);

			// RTL languages.
			if ('rtl' === $this->lang->lang('direction'))
			{
				$default_styles['bootstrap'] = $this->theme->common_url('css/bootstrap-rtl.min.css');
			}

			$login_styles = apply_filters('login_styles', array());
			if (empty($login_styles) OR ! is_array($login_styles))
			{
				$login_styles = $default_styles;
			}
			else
			{
				$login_styles = array_merge($default_styles, $login_styles);
			}
			$this->theme->add('css', $login_styles);

			/**
			 * Scripts to load on the login page.
			 * @since 	2.0.0
			 */
			$default_scripts = array(
				'popper'    => $this->theme->common_url('js/popper.min.js'),
				'bootstrap' => $this->theme->common_url('js/bootstrap.min.js'),
				'admin'     => $this->theme->common_url('js/admin.min.js'),
			);
			$login_scripts = apply_filters('login_scripts', array());
			if (empty($login_scripts) OR ! is_array($login_scripts))
			{
				$login_scripts = $default_scripts;
			} else
			{
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

			/**
			 * Fixed views and layouts if theme doesn't have theme.
			 * @since 	2.1.5
			 */
			add_filter('theme_layouts_path', function($path) {
				return KBPATH.'views/layouts';
			});

			add_filter('theme_views_path', function($path) {
				return KBPATH.'views';
			});
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Method kept as a backup only, it does absolutely nothing.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index() {}

	// ------------------------------------------------------------------------
	// Account management methods.
	// ------------------------------------------------------------------------

	/**
	 * register
	 *
	 * Method for users registration on the site.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function register()
	{
		// Are registrations allowed?
		if (true !== get_option('allow_registration', false))
		{
			redirect('');
			exit;
		}

		// Prepare form validation and form helper.
		$rules = array(
			array(	'field' => 'first_name',
					'label' => 'lang:CSK_INPUT_FIRST_NAME',
					'rules' => 'trim|required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:CSK_INPUT_LAST_NAME',
					'rules' => 'trim|required|max_length[32]'),
			array(	'field' => 'email',
					'label' => 'lang:CSK_INPUT_EMAIL',
					'rules' => 'trim|required|valid_email|unique_email'),
			array(	'field' => 'username',
					'label' => 'lang:CSK_INPUT_USERNAME',
					'rules' => 'trim|required|min_length[5]|max_length[32]|unique_username'),
			array(	'field' => 'password',
					'label' => 'lang:CSK_INPUT_PASSWORD',
					'rules' => 'trim|required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:CSK_INPUT_CONFIRM_PASSWORD',
					'rules' => 'trim|required|min_length[8]|max_length[20]|matches[password]'),
			array(	'field' => 'gender',
					'label' => 'lang:CSK_INPUT_GENDER',
					'rules' => 'trim|required|in_list[male,female]'),
		);

		if (true === get_option('use_captcha', false))
		{
			$rules[] = array(
				'field' => 'captcha',
				'label' => 'lang:CSK_INPUT_CAPTCHA',
				'rules' => 'trim|required|callback_check_captcha'
			);
		}

		$this->prep_form($rules, '#register');

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name'))
			);
			$this->data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name'))
			);
			$this->data['email'] = array_merge(
				$this->config->item('email', 'inputs'),
				array('value' => set_value('email'))
			);
			$this->data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username'))
			);
			$this->data['password'] = array_merge(
				$this->config->item('password', 'inputs'),
				array('value' => set_value('password'))
			);
			$this->data['cpassword'] = array_merge(
				$this->config->item('cpassword', 'inputs'),
				array('value' => set_value('cpassword'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$this->data['captcha'] = $captcha['captcha'];
			$this->data['captcha_image'] = $captcha['image'];

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_BTN_REGISTER'))
				->render($this->data);
		}
		// After the form is processed.
		else
		{
			if (true !== $this->check_nonce('user-register'))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('register', 'refresh');
				exit;
			}

			// Attempt to register the user.
			$this->kbcore->users->register($this->input->post(array(
               'first_name',
               'last_name',
               'email',
               'username',
               'password',
               'gender'
            ), true));

            // Redirect back to registration page.
			redirect('register', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activating a user by the given activation code.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function activate()
	{
		$code = $this->input->get('code', true);

		// No code provided? Safely redirect to homepage.
		if (empty($code))
		{
			redirect('');
			exit;
		}

		// Successfully enabled?
		if (false !== $this->kbcore->users->activate_by_code($code))
		{
			redirect('login');
			exit;
		}

		// Otherwise, simply redirect to homepage.
		redirect('');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * resend
	 *
	 * Method for resend account activation links.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function resend()
	{
		// Are registrations allowed?
		if (true !== get_option('allow_registration', false))
		{
			redirect('');
			exit;
		}

		// Prepare form validation and rules.
		$rules[] = array(
			'field' => 'identity',
			'label' => 'lang:CSK_INPUT_IDENTITY',
			'rules' => 'trim|required|min_length[5]'
		);

		if (true === get_option('use_captcha', false))
		{
			$rules[] = array(
				'field' => 'captcha',
				'label' => 'lang:CSK_INPUT_CAPTCHA',
				'rules' => 'trim|required|callback_check_captcha'
			);
		}

		$this->prep_form($rules, '#resend');

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$this->data['captcha'] = $captcha['captcha'];
			$this->data['captcha_image'] = $captcha['image'];

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_USERS_RESEND_LINK'))
				->render($this->data);
		}
		// After form processing.
		else
		{
			if (true !== $this->check_nonce('user-resend-link'))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('resend-link', 'refresh');
				exit;
			}

			// Attempt to resend activation link.
			$this->kbcore->users->resend_link($this->input->post('identity', true));

			// Redirect back to the same page.
			redirect('resend-link', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * restore
	 *
	 * Method for restoring a previously soft-deleted account.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function restore()
	{
		// Prepare form validation.
		$rules[] = array(
			'field' => 'identity',
			'label' => 'lang:CSK_INPUT_IDENTITY',
			'rules' => 'trim|required|min_length[5]|max_length[32]'
		);
		$rules[] = array(
			'field' => 'password',
			'label' => 'lang:CSK_INPUT_PASSWORD',
			'rules' => 'trim|required|min_length[8]|max_length[20]'
		);

		if (true === get_option('use_captcha', false))
		{
			$rules[] = array(
				'field' => 'captcha',
				'label' => 'lang:CSK_INPUT_CAPTCHA',
				'rules' => 'trim|required|callback_check_captcha'
			);
		}

		$this->prep_form($rules, '#restore');

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);
			$this->data['password'] = $this->config->item('password', 'inputs');

			// Prepare captcha if enabled.
			$captcha                     = $this->create_captcha();
			$this->data['captcha']       = $captcha['captcha'];
			$this->data['captcha_image'] = $captcha['image'];

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_USERS_RESTORE_ACCOUNT'))
				->render($this->data);
		}
		// After form processing.
		else
		{
			// Check CSRF token.
			if ( ! $this->check_nonce('user-restore'))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('restore-account', 'refresh');
				exit;
			}

			// Attempt to restore the account.
			$status = $this->kbcore->users->restore_account(
				$this->input->post('identity', true),
				$this->input->post('password', true)
			);

			// The redirection depends on the restore status.
			redirect((false !== $status ? '' : 'restore-account'), 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------
	// Authentication methods.
	// ------------------------------------------------------------------------

	/**
	 * login
	 *
	 * Method for site's members login.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function login()
	{
		// Prepare empty validation rules.
		$rules = array();

		// What type of login to use?
		$login_type = get_option('login_type', 'both');
		switch ($login_type)
		{
			case 'username':
				$login_type = 'username';
				$rules[]    = array(
					'field' => 'username',
					'label' => 'lang:CSK_INPUT_USERNAME',
					'rules' => 'trim|required|min_length[5]|max_length[32]|user_exists'
				);
				break;

			case 'email':
				$login_type = 'email';
				$rules[]    = array(
					'field' => 'email',
					'label' => 'lang:CSK_INPUT_EMAIL_ADDRESS',
					'rules' => 'trim|required|valid_email|user_exists'
				);
				break;

			case 'both':
			default:
				$login_type = 'identity';
				$rules[]    = array(
					'field' => 'identity',
					'label' => 'lang:CSK_INPUT_IDENTITY',
					'rules' => 'trim|required|min_length[5]|user_exists'
				);
				break;
		}

		// Add password.
		$rules[] = array(
			'field' => 'password',
			'label' => 'lang:CSK_INPUT_PASSWORD',
			'rules' => "trim|required|min_length[8]|max_length[20]|check_credentials[{$login_type}]"
		);

		// Prepare form validation and pass rules.
		$this->prep_form($rules, '#login');

		// Before form processing!
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['login_type'] = $login_type;
			$this->data['login'] = array_merge(
				$this->config->item($login_type, 'inputs'),
				array('value' => set_value($login_type))
			);
			$this->data['password'] = $this->config->item('password', 'inputs');

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_BTN_LOGIN'))
				->render($this->data);
		}
		// After the form is processed.
		else
		{
			if (true !== $this->check_nonce('user-login'))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('login');
				exit;
			}

			// Attempt to login the current user.
			$status = $this->kbcore->auth->login(
				$this->input->post($login_type, true),
				$this->input->post('password', true),
				$this->input->post('remember') == '1'
			);

			// Success? Redirect to homepage, else, back to login page.
			redirect(($status === true ? $this->redirect : 'login'), 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * logout
	 *
	 * Method for logging out already logged in users.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function logout()
	{
		// Logout the current user.
		$this->kbcore->auth->logout();

		// Redirect the user to homepage.
		redirect('');
		exit;
	}

	// ------------------------------------------------------------------------
	// Password management methods.
	// ------------------------------------------------------------------------

	/**
	 * recover
	 *
	 * Method for requesting a password reset link.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function recover()
	{
		// Prepare form validation and rules.
		$rules[] = array(
			'field' => 'identity',
			'label' => 'lang:CSK_INPUT_IDENTITY',
			'rules' => 'trim|required|min_length[5]|user_exists'
		);

		if (true === get_option('use_captcha', false))
		{
			$rules[] = array(
				'field' => 'captcha',
				'label' => 'lang:CSK_INPUT_CAPTCHA',
				'rules' => 'trim|required|callback_check_captcha'
			);
		}

		$this->prep_form($rules, '#recover');

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$this->data['captcha'] = $captcha['captcha'];
			$this->data['captcha_image'] = $captcha['image'];

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_BTN_LOST_PASSWORD'))
				->render($this->data);
		}
		// After the form is processed.
		else
		{
			// Check nonce.
			if (true !== $this->check_nonce('user-lost-password'))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('lost-password', 'refresh');
				exit;
			}

			// Attempt to prepare password reset.
			$this->kbcore->users->prep_password_reset($this->input->post('identity', true));

			// Redirect back to the same page.
			redirect('lost-password', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * reset
	 *
	 * Method for resetting account's password.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	void
	 * @return 	void
	 */
	public function reset()
	{
		$code = $this->input->get('code', true);

		// No code provided? Safely redirect to homepage.
		if (empty($code))
		{
			redirect('');
			exit;
		}

		// The code is invalid?
		if (false === ($guid = $this->kbcore->users->check_password_code($code)))
		{
			set_alert(line('CSK_USERS_ERROR_RESET_CODE'), 'error');
			redirect('');
			exit;
		}

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'npassword',
					'label' => 'lang:CSK_INPUT_NEW_PASSWORD',
					'rules' => 'trim|required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:CSK_INPUT_CONFIRM_PASSWORD',
					'rules' => 'trim|required|min_length[8]|max_length[20]|matches[npassword]'),
		), '#reset');

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			$this->data['code'] = $code;

			// Prepare form fields.
			$this->data['npassword'] = $this->config->item('npassword', 'inputs');
			$this->data['cpassword'] = $this->config->item('cpassword', 'inputs');

			// Set page title and render view.
			$this->theme
				->set_title(line('CSK_BTN_RESET_PASSWORD'))
				->render($this->data);
		}
		// After the form is processed.
		else
		{
			// Check nonce.
			if (true !== $this->check_nonce('user-reset-password_'.$code, false))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('reset-password?code='.$code);
				exit;
			}

			// Attempt to reset password.
			$status = $this->kbcore->users->reset_password(
				$guid,
				$this->input->post('npassword', true)
			);

			// The redirection depends on the process status.
			redirect(($status === true ? 'login' : 'reset-password?code='.$code), 'refresh');
			exit;
		}
	}

}
