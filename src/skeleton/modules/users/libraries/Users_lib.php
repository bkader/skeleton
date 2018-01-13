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
 * Users Module - Users Library
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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
	 * @return 	void
	 */
	public function __construct($config = array())
	{
		$this->app =& $config['app'];
		$this->ci =& $this->app->ci;
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
			set_alert(__('error_fields_required'), 'error');
			return false;
		}

		$guid = $this->app->users->create($data);

		if ($guid > 0)
		{
			// Account activation enabled?
			if ( ! isset($data['enabled'])
				&& $this->app->options->item('email_activation', false) === true)
			{
				set_alert(__('us_register_info'), 'info');
			}
			else
			{
				set_alert(__('us_register_success'), 'success');
			}

			// Log the activity.
			log_activity($guid, 'registered');
		}
		else
		{
			set_alert(__('us_register_error'), 'error');
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
			set_alert(__('error_fields_required'), 'error');
			return false;
		}

		// Get the user from database.
		$selects = array(
			'entities.id',
			'entities.username',
			'entities.subtype',
			'entities.enabled',
			'entities.deleted',
			'users.email',
			'users.password',
		);
		$user = $this->app->users
			->select($selects)
			->where('entities.username', $identity)
			->or_where('users.email', $identity)
			->get_all();
		if ( ! $user OR count($user) !== 1)
		{
			set_alert(__('us_wrong_credentials'), 'error');
			return false;
		}

		// Get rid or deep array.
		$user = $user[0];

		// User already enabled?
		if ($user->enabled == 1)
		{
			set_alert(__('us_resend_enabled'), 'error');
			return false;
		}

		// Process status.
		$status = false;

		// Check if a variable already exists.
		$var = $this->app->variables->get_by(array(
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
				$status = (bool) $this->app->variables->update($var->id, array(
					'value'      => $activation_code,
					'params'     => $this->ci->input->ip_address(),
					'created_at' => time(),
				));
			}
			// Create it.
			else
			{
				$status = (bool) $this->app->variables->insert(array(
					'guid'   => $user->id,
					'name'   => 'activation_code',
					'value'  => $activation_code,
					'params' => $this->ci->input->ip_address(),
				));
			}
		}

		// Send the activation code to user.

		if ($status === true)
		{
			set_alert(__('us_resend_success'), 'success');

			// Log the activity.
			log_activity($user->id, 'new activation code: '.$activation_code);
		}
		else
		{
			set_alert(__('us_resend_error'), 'error');
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
			set_alert(__('error_fields_required'), 'error');
			return false;
		}

		// Get the user from database.
		$selects = array(
			'entities.id',
			'entities.username',
			'entities.subtype',
			'entities.enabled',
			'entities.deleted',
			'users.email',
			'users.password',
		);
		$user = $this->app->users
			->select($selects)
			->where('entities.username', $identity)
			->or_where('users.email', $identity)
			->get_all();
		if ( ! $user OR count($user) !== 1)
		{
			set_alert(__('us_wrong_credentials'), 'error');
			return false;
		}

		// Get rid or deep array.
		$user = $user[0];

		// Check the password.
		if ( ! password_verify($password, $user->password))
		{
			set_alert(__('us_wrong_credentials'), 'error');
			return false;
		}

		// The user is not really deleted?
		if ($user->deleted == 0)
		{
			set_alert(__('us_restore_deleted'), 'error');
			return false;
		}

		// Restore the user and quick-login.
		$status = $this->app->entities->update($user->id, array(
			'deleted'    => 0,
			'deleted_at' => 0,
		));

		if ($status === true)
		{
			// Log the activity.
			log_activity($user->id, 'restored account');

			return $this->ci->auth->quick_login($user);
		}

		return $status;
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
			set_alert(__('us_activate_invalid_key'), 'error');
			return false;
		}

		// Get the variable from database.
		$var = $this->app->variables->get_by(array(
			'name'          => 'activation_code',
			'BINARY(value)' => $code,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));
		if ( ! $var)
		{
			set_alert(__('us_activate_invalid_key'), 'error');
			return false;
		}

		$status = $this->app->entities->update($var->guid, array('enabled' => 1));

		// Everything went well?
		if ($status === true)
		{
			set_alert(__('us_activate_success'), 'success');

			// Delete activation code.
			$this->delete_activation_codes($var->guid);

			// Log the activity.
			log_activity($var->guid, 'activation code: '.$code);
		}
		else
		{
			set_alert(__('us_activate_error'), 'error');
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
			set_alert(__('error_fields_required'), 'error');
			return false;
		}

		// Things to select.
		$selects = array(
			'entities.id',
			'entities.subtype',
			'entities.username',
			'entities.enabled',
			'entities.deleted',
			'users.email',
		);

		// Grab the user from database.
		$user = $this->app->users
			->select($selects)
			->where('entities.username', $identity)
			->or_where('users.email', $identity)
			->get_all();

		// The user does not exist?
		if ( ! $user OR count($user) !== 1)
		{
			set_alert(__('us_wrong_credentials'), 'error');
			return false;
		}

		// Get rid of deep array.
		$user = $user['0'];

		// Make sure the account is not banned.
		if ($user->enabled < 0)
		{
			set_alert(__('us_account_banned'), 'error');
			return false;
		}

		// Make sure the account is not deleted.
		if ($user->deleted > 0)
		{
			set_alert(sprintf(
				__('us_account_deleted'),
				anchor('login/restore', __('click_here'))
			), 'error');
			return false;
		}

		// Prepare process status.
		$status = false;

		// Check if there is an existing password code.
		$var = $this->app->variables->get_by(array(
			'guid'          => $user->id,
			'name'          => 'password_code',
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
				$status = (bool) $this->app->variables->update($var->id, array(
					'value'      => $password_code,
					'params' => $this->ci->input->ip_address(),
					'created_at' => time(),
				));
			}
			// Create it.
			else
			{
				$status = (bool) $this->app->variables->insert(array(
					'guid'   => $user->id,
					'name'   => 'password_code',
					'value'  => $password_code,
					'params' => $this->ci->input->ip_address(),
				));
			}
		}

		// Send the activation code to user.

		if ($status === true)
		{
			set_alert(__('us_recover_success'), 'success');

			// Log the activity.
			log_activity($user->id, 'new password code: '.$password_code);
		}
		else
		{
			set_alert(__('us_recover_error'), 'error');
		}

		return $status;
	}

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
		$var = $this->app->variables->get_by(array(
			'name'          => 'password_code',
			'BINARY(value)' => $code,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));

		return ($var) ? $var->guid : false;
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
			set_alert(__('us_reset_error'), 'error');
			return false;
		}

		// Attempt to update password.
		$status = $this->app->users->update($user_id, array('password' => $password));

		// Done?
		if ($status === true)
		{
			// Set success message.
			set_alert(__('us_reset_success'), 'success');

			// Log the activity.
			log_activity($user_id, 'changed password');

			// Delete all password codes.
			$this->delete_password_codes($user_id);
		}
		// Error somewhere?
		else
		{
			// Set error message.
			set_alert(__('us_reset_error'), 'error');
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
			$this->app->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'online_token',
			));
		}

		// Perform a clean up of older tokens.
		$this->app->variables->delete_by(array(
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
			$this->app->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'password_code',
			));
		}

		// Perform a clean up of older tokens.
		$this->app->variables->delete_by(array(
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
			$this->app->variables->delete_by(array(
				'guid' => $user_id,
				'name' => 'activation_code',
			));
		}

		// Perfrom a clean up of older activation codes.
		$this->app->variables->delete_by(array(
			'name'         => 'activation_code',
			'created_at <' => time() - (DAY_IN_SECONDS * 2)
		));
	}
}

/* End of file Users_lib.php */
/* Location: ./application/modules/users/libraries/Users_lib.php */
