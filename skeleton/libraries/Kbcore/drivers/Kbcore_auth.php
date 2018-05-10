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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Authenticate Library.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Kbcore_auth extends CI_Driver
{
	/**
	 * Holds the currently logged in user's object.
	 * @var object
	 */
	private $user;

	/**
	 * Holds the current user's IP address.
	 * @since 	1.3.3
	 * @var 	string
	 */
	private $ip_address;

	// ------------------------------------------------------------------------

	/**
	 * initialize
	 *
	 * Initialize this class.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function initialize()
	{
		// Always store the ip address.
		$this->ip_address = $this->ci->input->ip_address();

		// Make sure to load users language file.
		$this->ci->load->language('csk_users');

		// Attempt to authenticate the current user.
		$this->_authenticate();
	}

	// ------------------------------------------------------------------------

	/**
	 * Attempt to authenticate the current user.
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function _authenticate()
	{
		// Let's make sure the cookie is set first.
		list($user_id, $token, $random) = $this->_get_cookie();
		if (empty($user_id) OR empty($token))
		{
			return;
		}

		// Let's get the variable from database.
		$var = $this->_parent->variables->get_by(array(
			'guid'          => $user_id,
			'name'          => 'online_token',
			'BINARY(value)' => $token,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));
		if ( ! $var)
		{
			return;
		}

		// Let's get the user from database.
		$user = $this->_parent->users->get($user_id);
		if ( ! $user)
		{
			return;
		}

		/**
		 * This is useful if the user is disabled, deleted or
		 * banned  while he/she is logged in, we log him/her out.
		 */
		if ($user->enabled < 1 OR $user->deleted > 0)
		{
			$this->logout($user_id);
			return;
		}

		// If the session is already set, nothing to do.
		if ($this->ci->session->user_id)
		{
			return;
		}

		// If the session is not set, we set it.
		$this->_set_session($user->id, true, $token, $user->language);
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the currently logged in user's object.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Switched to config instead of options.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	object if found, else false.
	 */
	public function user()
	{
		// If the user is already cached, nothing to do.
		if (isset($this->user))
		{
			return $this->user;
		}

		// Unset any previously cached user.
		$this->user = false;

		// Make sure required data are stored in session.
		if ( ! $this->ci->session->user_id OR ! $this->ci->session->token)
		{
			return false;
		}

		/**
		 * If multiple sessions are not allowed, we compare 
		 * stored tokens and make sure only a single user 
		 * per session is allowed.
		 */
		if (false === $this->ci->config->item('allow_multi_session'))
		{
			// Get the variable from database.
			$var = $this->_parent->variables->get_by(array(
				'guid'  => $this->ci->session->user_id,
				'name'  => 'online_token',
				'value' => $this->ci->session->token,
			));
			if ( ! $var)
			{
				return false;
			}
		}

		// Get the user from database.
		$user = $this->_parent->users->get($this->ci->session->user_id);
		if ( ! $user)
		{
			return false;
		}

		/**
		 * This is useful if the user is disabled, deleted or
		 * banned  while he/she is logged in, we log him/her out.
		 */
		if ($user->enabled < 1 OR $user->deleted > 0)
		{
			$this->logout($user->id);
			return false;
		}

		// Everthing went right, cache the user.
		$this->user = $user;
		return $this->user;

	}

	// ------------------------------------------------------------------------

	/**
	 * Whether the current user is logged in.
	 * @access 	public
	 * @param 	none
	 * @return 	bool
	 */
	public function online()
	{
		return (bool) $this->user();
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns true if the current user is an admin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Reversed check condition.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	bool
	 */
	public function is_admin()
	{
		return (true === $this->online() && true === $this->user->admin);
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the current user's ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Reversed check condition.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	int
	 */
	public function user_id()
	{
		return (true === $this->online()) ? $this->user()->id : false;
	}

	// ------------------------------------------------------------------------
	// Authentication methods.
	// ------------------------------------------------------------------------

	/**
	 * Login method.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Log activity was moved from "_set_session" to "login", and
	 *         			added a check to see who deleted the user.
	 * 
	 * @access 	public
	 * @param 	string 	$identity 	username or emaila address.
	 * @param 	string 	$password 	the password.
	 * @param 	bool 	$remember 	whether to remember the user.
	 * @return 	bool
	 */
	public function login($identity, $password, $remember = false)
	{
		if (empty($identity) OR empty($password))
		{
			set_alert(lang('CSK_ERROR_FIELDS_REQUIRED'), 'error');
			return false;
		}

		// Fires before processing.
		do_action_ref_array('before_user_login', array(&$identity, &$password));

		// What type of login to use?
		$login_type = $this->ci->config->item('login_type');
		switch ($login_type)
		{
			// Get the user by username.
			case 'username':
				$user = $this->_parent->users
					->get_by('entities.username', $identity);
				if ( ! $user)
				{
					set_alert(lang('us_wrong_credentials'), 'error');
					return false;
				}
				break;

			// Get user by email address.
			case 'email':
				$user = $this->_parent->users
					->get_by('users.email', $identity);
				if ( ! $user)
				{
					set_alert(lang('us_wrong_credentials'), 'error');
					return false;
				}
				break;

			// Get user by username or email address.
			case 'both':
			default:
				$user = $this->_parent->users
					->get($identity);

				if ( ! $user)
				{
					set_alert(lang('us_wrong_credentials'), 'error');
					return false;
				}

				break;
		}

		// Check the password.
		if ( ! password_verify($password, $user->password))
		{
			set_alert(lang('us_wrong_credentials'), 'error');
			return false;
		}

		// Make sure the account is enabled.
		if ($user->enabled == 0)
		{
			set_alert(sprintf(
				lang('us_account_disabled'),
				anchor('register/resend', lang('click_here'))
			), 'error');
			return false;
		}

		// Make sure the account is not banned.
		if ($user->enabled < 0)
		{
			set_alert(lang('us_account_banned'), 'error');
			return false;
		}

		// Make sure the account is not deleted.
		if ($user->deleted > 0)
		{
			// Check who deleted the user.
			$log = $this->_parent->activities->get_by(array(
				'module'     => 'users',
				'controller' => 'admin',
				'method'     => 'delete',
				'activity'   => 'lang:act_user_delete::'.$user->id,
			));

			// An admin did it? No way to restore it.
			if (false !== $log)
			{
				set_alert(lang('us_account_deleted_admin'), 'error');
			}
			// Otherwise, the user can restore his/her account.
			else
			{
				set_alert(sprintf(
					lang('us_account_deleted'),
					anchor('login/restore', lang('click_here'))
				), 'error');
			}
			
			return false;
		}

		// Proceed
		$this->delete_password_codes($user->id);

		// Setup the session.
		if (true === $this->_set_session($user->id, $remember, null, $user->language))
		{
			// Log the activity.
			$this->_parent->activities->log_activity($user->id, 'lang:act_user_login');

			return true;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick login method without passing by all filters found in login().
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added a little check.
	 * @since 	2.0.0 	Added language selection.
	 * 
	 * @access 	public
	 * @param 	object 	$user 	the user's object to login.
	 * @return 	bool
	 */
	public function quick_login($user, $language = null)
	{
		// ID, username or email provided?
		if ( ! $user instanceof KB_User OR ! is_object($user))
		{
			$user = $this->_parent->users->get($user);
		}

		// Make sure the user exists.
		if (false === $user)
		{
			return false;
		}

		$language OR $language = $user->language;

		if (false !== $this->_set_session($user->id, true, null, $language))
		{
			// Change users language if needed.
			if ($language !== $user->language 
				&& in_array($language, $this->ci->config->item('languages')))
			{
				$user->update('language', $language);
			}

			return true;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Logout method.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function logout()
	{
		// Catch the user's ID for later use.
		$user_id = 0;
		(true === $this->online()) && $user_id = $this->user()->id;

		// Fires before logging out the user.
		do_action('before_user_logout', $user_id);

		// Delete the cookie.
		$this->ci->input->set_cookie('c_user', '', '');

		// Delete online tokens.
		$this->delete_online_tokens($user_id);

		// Put the user offline.
		$this->_parent->users->update($user_id, array('online' => 0));

		// Destroy the session.
		$this->ci->session->sess_destroy();

		// Fires After user is logged out, cookie deleted and session destroyed.
		do_action('after_user_logout', $user_id);
	}

	// ------------------------------------------------------------------------
	// Session and Cookie Management.
	// ------------------------------------------------------------------------

	/**
	 * Setup session data at login and autologin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Log activity was moved from "_set_session" to "login".
	 * 
	 * @access 	private
	 * @param 	int 	$user_id 	the user's ID.
	 * @param 	bool 	$remember 	whether to remember the user.
	 * @param 	string 	$token 		the user's online token.
	 * @param 	string 	$language 	the user's language.
	 * @return 	bool
	 */
	private function _set_session($user_id, $remember = false, $token = null, $language = null)
	{
		// Make sure all neded data are present.
		if (empty($user_id))
		{
			return false;
		}

		// If no $token is provided, we generate a new one.
		if (empty($token))
		{
			(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
			$token = $this->ci->hash->hash($user_id.session_id().rand());
		}

		// Fires before logging in the user.
		do_action('after_user_login', $user_id);

		// Prepare session data.
		$sess_data = array(
			'user_id'  => $user_id,
			'token'    => $token,
		);

		// Add user language only if available.
		if ($language && in_array($language, $this->ci->config->item('languages')))
		{
			$sess_data['language'] = $language;
		}

		// Now we set session data.
		$this->ci->session->set_userdata($sess_data);

		// Now we create/update the variable.
		$this->_parent->variables->set_var($user_id, 'online_token', $token, $this->ip_address);

		// Put the user online.
		$this->_parent->users->update($user_id, array('online' => 1));

		// The return depends on $remember.
		return (true === $remember) ? $this->_set_cookie($user_id, $token) : true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets the cookie for the user after a login.
	 * @access 	private
	 * @param 	int 	$user_id 	the user's ID.
	 * @param 	string 	$token 		the user's online token.
	 * @return 	bool
	 */
	private function _set_cookie($user_id, $token)
	{
		// If no data provided, nothing to do.
		if (empty($user_id) OR empty($token))
		{
			return false;
		}

		/**
		 * The idea behind this is to generate a new random string
		 * and append it to the user's ID and token then encode
		 * everything. IT will be harder to crack the cookie and when
		 * we try to get the cookie back, we only need the two first
		 * elements of the exploded cookie.
		 */
		(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
		$random = $this->ci->hash->random(128);
		$cookie_value = $this->ci->hash->encode($user_id, $token, $random);

		// Allow themes and plug-ins to alter the cookie name.
		$cookie_name = apply_filters('user_cookie_name', 'c_user');

		// Allow themes and plug-ins to alter the cookie expiration time.
		$cookie_expire = apply_filters('user_cookie_life', MONTH_IN_SECONDS * 2);

		// Now we set the cookie.
		$this->ci->input->set_cookie($cookie_name, $cookie_value, $cookie_expire);
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Attempt to retrieve and decode the current user's cookie.
	 * @access 	private
	 * @param 	none
	 * @return 	array if found, else false.
	 */
	private function _get_cookie()
	{
		// Allow themes and plug-ins to alter the cookie name.
		$cookie_name = apply_filters('user_cookie_name', 'c_user');

		// Check whether the cookie exists.
		$cookie = $this->ci->input->cookie($cookie_name, true);
		if ( ! $cookie)
		{
			return false;
		}

		// We load the hash library and decode the cookie.
		(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
		$cookie = $this->ci->hash->decode($cookie);

		/**
		 * For the cookie to be valid, it has to not to be
		 * empty and MUST contain three (3) elements:
		 * 1. The user's ID.
		 * 2. The online token.
		 * 3. The random string generated when encoding the cookie.
		 */
		return (empty($cookie) OR count($cookie) !== 3) ? false : $cookie;
	}

	// ------------------------------------------------------------------------
	// General Cleaners.
	// ------------------------------------------------------------------------

	/**
	 * Delete user's online token and perform a clean up of older tokens.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @return 	void
	 */
	public function delete_online_tokens($user_id = 0)
	{
		if (is_numeric($user_id) && $user_id > 0)
		{
			$this->_parent->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'online_token',
			));
		}

		// Perform a clean up of older tokens.
		$this->_parent->variables->delete_by(array(
			'name' => 'online_token',
			'created_at <' => time() - (MONTH_IN_SECONDS * 2)
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete user's password code and perform a clean up of older ones.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @return 	void
	 */
	public function delete_password_codes($user_id = 0)
	{
		if (is_numeric($user_id) && $user_id > 0)
		{
			$this->_parent->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'password_code',
			));
		}

		// Perform a clean up of older tokens.
		$this->_parent->variables->delete_by(array(
			'name' => 'password_code',
			'created_at <' => time() - (DAY_IN_SECONDS * 2)
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete account's activation code and clean up old ones.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @return 	void
	 */
	public function delete_activation_codes($user_id)
	{
		if (is_numeric($user_id) && $user_id > 0)
		{
			$this->_parent->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'activation_code',
			));
		}

		// Perfrom a clean up of older activation codes.
		$this->_parent->variables->delete_by(array(
			'name'         => 'activation_code',
			'created_at <' => time() - (DAY_IN_SECONDS * 2)
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete old captcha from database.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function delete_captcha()
	{
		// Delete captcha of the current ip address.
		$this->_parent->variables->delete_by(array(
			'name'   => 'captcha',
			'params' => $this->ci->input->ip_address(),
		));

		// Delete old captcha.
		$this->_parent->variables->delete_by(array(
			'name'         => 'captcha',
			'created_at <' => time() - 7200
		));
	}

}
