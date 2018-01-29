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
 * @since 		Version 1.0.0
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Users extends KB_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure the user is not logged in.
		$method = $this->router->fetch_method();
		if ($this->auth->online() 
			&& ! in_array($method, array('logout', 'change_email')))
		{
			set_alert(lang('error_logged_in'), 'error');
			redirect('');
			exit;
		}
	}

	public function index()
	{
		die('here');
	}

	// ------------------------------------------------------------------------
	// Account management methods.
	// ------------------------------------------------------------------------

	/**
	 * Account registration.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function register()
	{
		// Are registrations allowed?
		if (get_option('allow_registration', false) === false)
		{
			redirect('');
			exit;
		}

		// Prepare form validation and form helper.
		$this->prep_form(array(
			array(	'field' => 'first_name',
					'label' => 'lang:first_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:last_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'email',
					'label' => 'lang:email',
					'rules' => 'trim|required|valid_email|unique_email'),
			array(	'field' => 'username',
					'label' => 'lang:username',
					'rules' => 'trim|required|min_length[5]|max_length[32]|unique_username'),
			array(	'field' => 'password',
					'label' => 'lang:password',
					'rules' => 'required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:confirm_password',
					'rules' => 'required|matches[password]'),
			array(	'field' => 'gender',
					'label' => 'lang:gender',
					'rules' => 'required|in_list[male,female]'),
			array(	'field' => 'captcha',
					'label' => 'lang:captcha',
					'rules' => 'callback_check_captcha'),
		));

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name'))
			);
			$data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name'))
			);
			$data['email'] = array_merge(
				$this->config->item('email', 'inputs'),
				array('value' => set_value('email'))
			);
			$data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username'))
			);
			$data['password'] = array_merge(
				$this->config->item('password', 'inputs'),
				array('value' => set_value('password'))
			);
			$data['cpassword'] = array_merge(
				$this->config->item('cpassword', 'inputs'),
				array('value' => set_value('cpassword'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$data['captcha'] = $captcha['captcha'];
			$data['captcha_image'] = $captcha['image'];

			// Set page title and render view.
			$this->theme
				->set_title(lang('us_register_title'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Attempt to register the user.
			$this->users->create_user($this->input->post(array(
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
	 * Activate user account.
	 * @access 	public
	 * @param 	string 	$code 	account activation code.
	 * @return 	void
	 */
	public function activate($code = null)
	{
		// Attempt to activate the account.
		$status = $this->users->activate_by_code($code);

		// The redirection depends on the activation status.
		redirect(($status === true ? 'login' : ''),'refresh');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Resend account activation link.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function resend()
	{
		// Are registrations allowed?
		if (get_option('allow_registration', false) === false)
		{
			redirect('');
			exit;
		}

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'identity',
					'label' => 'lang:identity',
					'rules' => 'required|min_length[5]'),
			array(	'field' => 'captcha',
					'label' => 'lang:captcha',
					'rules' => 'callback_check_captcha'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$data['captcha'] = $captcha['captcha'];
			$data['captcha_image'] = $captcha['image'];

			// CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('resend_link'))
				->render($data);
		}
		// After form processing.
		else
		{
			// Check CSRF token.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('register/resend', 'refresh');
				exit;
			}

			// Attempt to resend activation link.
			$this->users->resend_link($this->input->post('identity', true));

			// Redirect back to the same page.
			redirect('register/resend', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore deleted account.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function restore()
	{
		// Prepare form validation.
		$this->prep_form(array(
			array(	'field' => 'identity',
					'label' => 'lang:identity',
					'rules' => 'required'),
			array(	'field' => 'password',
					'label' => 'lang:password',
					'rules' => 'required'),
			array(	'field' => 'captcha',
					'label' => 'lang:captcha',
					'rules' => 'callback_check_captcha'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);
			$data['password'] = $this->config->item('password', 'inputs');

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$data['captcha'] = $captcha['captcha'];
			$data['captcha_image'] = $captcha['image'];

			// CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('us_restore_title'))
				->render($data);
		}
		// After form processing.
		else
		{
			// Check CSRF token.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('login/restore', 'refresh');
				exit;
			}

			// Attempt to restore the account.
			$status = $this->users->restore_account(
				$this->input->post('identity', true),
				$this->input->post('password', true)
			);

			// The redirection depends on the restore status.
			redirect(($status ? '' : 'login/restore'), 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------
	// Authentication methods.
	// ------------------------------------------------------------------------

	/**
	 * Site's login page.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function login()
	{
		// Prepare empty validation rules.
		$rules = array();

		// What type of login to use?
		switch (get_option('login_type', 'both'))
		{
			case 'username':
				$login = 'username';
				$rules[] = array(
					'field' => 'username',
					'label' => 'lang:username',
					'rules' => 'trim|required|min_length[5]|max_length[32]|user_exists'
				);
				break;

			case 'email':
				$login = 'email';
				$rules[] = array(
					'field' => 'email',
					'label' => 'lang:email_address',
					'rules' => 'trim|required|valid_email|user_exists'
				);
				break;

			case 'both':
			default:
				$login = 'identity';
				$rules[] = array(
					'field' => 'identity',
					'label' => 'lang:identity',
					'rules' => 'required'
				);
				break;
		}

		// Add password.
		$rules[] = array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => "required|check_credentials[{$login}]"
		);

		// Prepare form validation and pass rules.
		$this->prep_form($rules);

		// Before form processing!
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['login_type'] = $login;
			$data['login'] = array_merge(
				$this->config->item($login, 'inputs'),
				array('value' => set_value($login))
			);
			$data['password'] = $this->config->item('password', 'inputs');

			// Set page title and render view.
			$this->theme
				->set_title(lang('us_login_title'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Attempt to login the current user.
			$status = $this->auth->login(
				$this->input->post($login, true),
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
	 * Site's logout method.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function logout()
	{
		// Logout the current user.
		$this->auth->logout();

		// Redirect the user to homepage.
		redirect('');
		exit;
	}

	// ------------------------------------------------------------------------
	// Password management methods.
	// ------------------------------------------------------------------------

	/**
	 * Lost password page.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function recover()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'identity',
					'label' => 'lang:identity',
					'rules' => 'required|min_length[5]'),
			array(	'field' => 'captcha',
					'label' => 'lang:captcha',
					'rules' => 'callback_check_captcha'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['identity'] = array_merge(
				$this->config->item('identity', 'inputs'),
				array('value' => set_value('identity'))
			);

			// Prepare captcha if enabled.
			$captcha = $this->create_captcha();
			$data['captcha'] = $captcha['captcha'];
			$data['captcha_image'] = $captcha['image'];

			// CSRF Security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('us_recover_title'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Check CSRF token.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('login/recover', 'refresh');
				exit;
			}

			// Attempt to prepare password reset.
			$this->users->prep_password_reset($this->input->post('identity', true));

			// Redirect back to the same page.
			redirect('login/recover','refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Reset password page.
	 * @access 	public
	 * @param 	string 	$code 	reset password code.
	 * @return 	void
	 */
	public function reset($code = null)
	{
		// Check password reset code first.
		$user_id = $this->users->check_password_code($code);
		if ( ! $user_id)
		{
			set_alert(lang('us_reset_invalid_key'), 'error');
			redirect('');
			exit;
		}

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'npassword',
					'label' => 'lang:new_password',
					'rules' => 'required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:confirm_password',
					'rules' => 'required|matches[npassword]'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Pass code to view.
			$data['code'] = $code;

			// Prepare form fields.
			$data['npassword'] = $this->config->item('npassword', 'inputs');
			$data['cpassword'] = $this->config->item('cpassword', 'inputs');

			// CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('us_reset_title'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Check CSRF token.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('login/reset/'.$code, 'refresh');
				exit;
			}

			// Attempt to reset password.
			$status = $this->users->reset_password(
				$user_id,
				$this->input->post('npassword', true)
			);

			// The redirection depends on the process status.
			redirect(($status === true ? 'login' : 'login/reset/'.$code), 'refresh');
			exit;
		}
	}

}
