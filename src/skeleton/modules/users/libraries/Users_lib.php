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
 * Users Module - Users Library.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
class Users_lib
{
	/**
	 * Instance of CI object.
	 * @var object
	 */
	private $ci;

	/**
	 * Class constructor
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Make sure the kbcore is loaded.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function __construct($config = array())
	{
		if (isset($config['kbcore']))
		{
			$this->kbcore =& $config['kbcore'];
			$this->ci =& $this->kbcore->ci;
		}
		else
		{
			$this->ci =& get_instance();
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * New account registration.
	 * @access 	public
	 * @param 	array 	$data 	array of user's data.
	 * @return 	int 	the user's id if created, else false.
	 */
	public function create_user(array $data = array())
	{
		if (empty($data))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// User created successfully?
		if (false !== $guid = $this->ci->kbcore->users->create($data))
		{
			// Require email activation or manual activation?
			$require_activation = ( ! isset($data['enabled']) && false !== $this->ci->kbcore->options->item('email_activation'));
			$manual_activation = (false !== $this->ci->kbcore->options->item('manual_activation'));

			// Requires manual activation?
			if (true === $require_activation && true === $manual_activation)
			{
				$this->_send_email('manual', $guid, array('name' => $data['first_name']));
				set_alert(lang('us_register_info_manual'), 'info');
			}
			// Require an email activation?
			elseif (true === $require_activation)
			{
				// Generate a new activation code and insert it into database.
				(function_exists('random_string')) OR $this->ci->load->helper('string');
				$code = random_string('alnum', 40);
				$this->ci->kbcore->variables->add_var($guid, 'activation_code', $code, $this->ci->input->ip_address());

				// We send the email to user.
				$this->_send_email('activation', $guid, array(
					'name' => $data['first_name'],
					'link' => anchor('register/activate/'.$code, '', 'target="_blank"')
				));

				// Set the alert message.
				set_alert(lang('us_register_info'), 'info');
			}
			// Otherwise, the user may log in.
			else
			{
				$this->_send_email('welcome', $guid);
				set_alert(lang('us_register_success'), 'success');
			}

			// Log the activity.
			$this->ci->kbcore->activities->log_activity($guid, 'lang:act_user_register');
		}
		else
		{
			set_alert(lang('us_register_error'), 'error');
		}

		return $guid;
	}

	// ------------------------------------------------------------------------
	// Account activation.
	// ------------------------------------------------------------------------

	/**
	 * Resend account activation link.
	 * @access 	public
	 * @param 	string 	$identity 	username or email address.
	 * @return 	bool
	 */
	public function resend_link($identity)
	{
		// All fields are required.
		if (empty($identity))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// Get the user from database.
		$user = $this->ci->kbcore->users->get($identity);
		if ( ! $user)
		{
			set_alert(lang('us_wrong_credentials'), 'error');
			return false;
		}

		// User already enabled?
		if ($user->enabled == 1)
		{
			set_alert(lang('us_resend_enabled'), 'error');
			return false;
		}

		// Process status.
		$status = false;

		// Check if a variable already exists.
		$var = $this->ci->kbcore->variables->get_by(array(
			'guid' => $user->id,
			'name' => 'activation_code',
		));
		// Exists an valid?
		if ($var && $var->created_at > (time() - (DAY_IN_SECONDS * 2)))
		{
			$activation_code = $var->value;
			$status          = true;
		}
		else
		{
			(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
			$activation_code = $this->ci->hash->random(40);

			// If the variable exists, update it.
			if ($var)
			{
				$status = (bool) $this->ci->kbcore->variables->update($var->id, array(
					'value'      => $activation_code,
					'params'     => $this->ci->input->ip_address(),
					'created_at' => time(),
				));
			}
			// Create it.
			else
			{
				$status = (bool) $this->ci->kbcore->variables->add_var(
					$user->id,
					'activation_code',
					$activation_code,
					$this->ci->input->ip_address()
				);
			}
		}

		// Send the activation code to user.

		if (true === $status)
		{
			set_alert(lang('us_resend_success'), 'success');

			// Log the activity.
			$this->ci->kbcore->activities->log_activity($user->id, "lang:act_user_resend::{$activation_code}::".substr($activation_code, 0, 8));

			// Purge user's captcha and old ones.
			$this->delete_captcha();

			// Send email to use.
			$ip_address = $this->ci->input->ip_address();
			$this->_send_email('new_activation', $user, array(
				'link'    => anchor('register/activate/'.$activation_code, '', 'target="_blank"'),
				'ip_link' => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));
		}
		else
		{
			set_alert(lang('us_resend_error'), 'error');
		}

		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore deleted account.
	 * @access 	public
	 * @param 	string 	$identity 	username or email address.
	 * @param 	string 	$password 	user's password.
	 * @return 	bool
	 */
	public function restore_account($identity, $password)
	{
		if (empty($identity) OR empty($password))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// Get the user from database.
		$user = $this->ci->kbcore->users->get($identity);
		if ( ! $user)
		{
			set_alert(lang('us_wrong_credentials'), 'error');
			return false;
		}

		// Check the password.
		if ( ! password_verify($password, $user->password))
		{
			set_alert(lang('us_wrong_credentials'), 'error');
			return false;
		}

		// The user is not really deleted?
		if ($user->deleted == 0)
		{
			set_alert(lang('us_restore_deleted'), 'error');
			return false;
		}

		// Restore the user and quick-login.
		if (true === $this->ci->kbcore->entities->restore($user->id))
		{
			// Send email to user
			$ip_address = $this->ci->input->ip_address();
			$this->_send_email('restore', $user, array(
				'ip_link' => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));

			// Log the activity.
			$this->ci->kbcore->activities->log_activity($user->id, 'lang:act_user_restore');

			// Purge user's captcha and old ones.
			$this->delete_captcha();

			return $this->ci->auth->quick_login($user);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Actite user account by given activation code.
	 * @access 	public
	 * @param 	string 	$code
	 * @return 	bool
	 */
	public function activate_by_code($code = null)
	{
		// Check whether it's set and check its length.
		if (empty($code) OR strlen($code) !== 40)
		{
			set_alert(lang('us_activate_invalid_key'), 'error');
			return false;
		}

		// Get the variable from database.
		$var = $this->ci->kbcore->variables->get_by(array(
			'name'          => 'activation_code',
			'BINARY(value)' => $code,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));
		if ( ! $var)
		{
			set_alert(lang('us_activate_invalid_key'), 'error');
			return false;
		}

		$status = $this->ci->kbcore->entities->update($var->guid, array('enabled' => 1));

		// Everything went well?
		if (true === $status)
		{
			// Send email to user.
			$this->_send_email('activated', $var->guid, array('login_url' => site_url('login')));

			// Set alert message.
			set_alert(lang('us_activate_success'), 'success');

			// Log the activity and purge codes.
			$this->ci->kbcore->activities->log_activity($var->guid, 'lang:act_user_activated');
			$this->delete_activation_codes($var->guid);
		}
		else
		{
			set_alert(lang('us_activate_error'), 'error');
		}

		return $status;
	}

	// ------------------------------------------------------------------------
	// Password management methods.
	// ------------------------------------------------------------------------

	/**
	 * Prepare password reset.
	 * @access 	public
	 * @param 	string 	$identity 	username or email address.
	 * @return 	bool
	 */
	public function prep_password_reset($identity)
	{
		// $identity is empty?
		if (empty($identity))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// Get the user from database.
		$user = $this->ci->kbcore->users->get($identity);
		if ( ! $user)
		{
			set_alert(lang('us_wrong_credentials'), 'error');
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
			set_alert(sprintf(
				lang('us_account_deleted'),
				anchor('login/restore', lang('click_here'))
			), 'error');
			return false;
		}

		// Prepare process status.
		$status = false;

		// Check if there is an existing password code.
		$var = $this->ci->kbcore->variables->get_by(array(
			'guid' => $user->id,
			'name' => 'password_code',
		));

		// Found?
		if ($var && $var->created_at > time() - (DAY_IN_SECONDS * 2))
		{
			$password_code = $var->value;
			$status        = true;
		}
		else
		{
			(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
			$password_code = $this->ci->hash->random(40);

			// If the variable exists, update it.
			if ($var)
			{
				$status = (bool) $this->ci->kbcore->variables->update($var->id, array(
					'value'      => $password_code,
					'params' => $this->ci->input->ip_address(),
					'created_at' => time(),
				));
			}
			// Create it.
			else
			{
				$status = (bool) $this->ci->kbcore->variables->add_var(
					$user->id,
					'password_code',
					$password_code,
					$this->ci->input->ip_address()
				);
			}
		}

		// Send the activation code to user.

		if (true === $status)
		{
			// Send email to user.
			$ip_address = $this->ci->input->ip_address();
			$this->_send_email('recover', $user, array(
				'link'    => anchor('login/reset/'.$password_code, '', 'target="_blank"'),
				'ip_link' => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));

			// Set alert and log the activity.
			set_alert(lang('us_recover_success'), 'success');

			// Log the activity.
			$this->ci->kbcore->activities->log_activity(
				$user->id,
				"lang:act_user_recover::{$password_code}::".substr($password_code, 0, 8)
			);
		}
		else
		{
			set_alert(lang('us_recover_error'), 'error');
		}

		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks the password reset code.
	 * @access 	public
	 * @param 	string 	$password_code
	 * @return 	int 	the user's ID if found, else false.
	 */
	public function check_password_code($code = null)
	{
		// First we check if set and check the length.
		if (empty($code) OR strlen($code) !== 40)
		{
			return false;
		}

		// Attempt to get the variable from database.
		$var = $this->ci->kbcore->variables->get_by(array(
			'name'          => 'password_code',
			'BINARY(value)' => $code,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));

		return (false !== $var) ? $var->guid : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Reset user's password after recover.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @param 	string 	$password
	 * @return 	bool
	 */
	public function reset_password($user_id, $password)
	{
		// Make sure all data are provided.
		if (empty($user_id) OR empty($password))
		{
			set_alert(lang('us_reset_error'), 'error');
			return false;
		}

		// Attempt to update password.
		$status = $this->ci->kbcore->users->update($user_id, array('password' => $password));

		// Done?
		if (true === $status)
		{
			// Send email to user.
			$ip_address = $this->ci->input->ip_address();
			$this->_send_email('password', $user_id, array(
				'login_url' => site_url('login'),
				'ip_link'    => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));
			// Set success message.
			set_alert(lang('us_reset_success'), 'success');

			// Log the activity.
			$this->ci->kbcore->activities->log_activity($user_id, 'lang:act_user_reset');

			// Delete all password codes.
			$this->delete_password_codes($user_id);
		}
		// Error somewhere?
		else
		{
			// Set error message.
			set_alert(lang('us_reset_error'), 'error');
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------
	// Cleaners.
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
			$this->ci->kbcore->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'online_token',
			));
		}

		// Perform a clean up of older tokens.
		$this->ci->kbcore->variables->delete_by(array(
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
			$this->ci->kbcore->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'password_code',
			));
		}

		// Perform a clean up of older tokens.
		$this->ci->kbcore->variables->delete_by(array(
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
			$this->ci->kbcore->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'activation_code',
			));
		}

		// Perfrom a clean up of older activation codes.
		$this->ci->kbcore->variables->delete_by(array(
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
		$this->ci->kbcore->variables->delete_by(array(
			'name'   => 'captcha',
			'params' => $this->ci->input->ip_address(),
		));

		// Delete old captcha.
		$this->ci->kbcore->variables->delete_by(array(
			'name'         => 'captcha',
			'created_at <' => time() - 7200
		));
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for sending emails to users.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	private
	 * @param 	string 	$type 	The message type to send.
	 * @param 	mixed 	$user 	The user object, ID, username or email address.
	 * @param 	array 	$data 	Array of data to pass to subject and message.
	 * @return 	bool 	true if the email was sent, else false.
	 */
	private function _send_email($type, $user, $data = array())
	{
		// Nothing provided? Nothing to do.
		if (empty($type) OR empty($user))
		{
			return false;;
		}

		// get the user by his/her id or username?
		if ( ! $user Instanceof KB_User OR ! is_object($user))
		{
			$user = $this->ci->kbcore->users->get($user);
		}

		// We make sure the user exists on database.
		if (false === $user)
		{
			return false;
		}

		// Prepare default variables to be replaced.
		$email     = (isset($data['email'])) ? $data['email'] : $user->email;
		$name      = ' '.(isset($data['name']) ? $data['name'] : $user->first_name);
		$site_name = $this->ci->config->item('site_name');
		$site_link = anchor('', $site_name, 'target="_blank"');
		
		$search  = array('{name}', '{site_name}', '{site_link}');
		$replace = array($name, $site_name, $site_link);

		// We load emails language file.
		$this->ci->load->language('users/emails');

		// Prepare email subject and body templates.
		$subject = lang('us_email_'.$type.'_subject');
		$message = lang('us_email_'.$type.'_message');

		// Additional $data?
		if ( ! empty($data))
		{
			foreach ($data as $key => $val)
			{
				array_push($search, '{'.$key.'}');
				array_push($replace, $val);
			}
		}

		// Parse email subject and message.
		$subject = str_replace($search, $replace, $subject);
		$message = str_replace($search, $replace, $message);

		// Now we send the message.
		return $this->ci->kbcore->send_email($email, $subject, nl2br($message));
	}

}
