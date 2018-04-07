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
 * Settings Module - Settings Library
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Settings_lib
{
	/**
	 * Instance of CI object.
	 * @var object
	 */
	private $ci;

	// ------------------------------------------------------------------------

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		$this->ci =& get_instance();

		// Make sure to load settings language file.
		$this->ci->load->language('settings/settings');

		// We purge old email codes when this library is called.
		$this->purge_email_codes();
	}

	// ------------------------------------------------------------------------

	/**
	 * Update user's profile.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update_profile($id, array $data = array())
	{
		if (empty($id) OR empty($data))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		$status = $this->ci->kbcore->users->update($id, $data);

		if ($status === true)
		{
			set_alert(lang('set_profile_success'), 'success');
		}
		else
		{
			set_alert(lang('set_profile_error'), 'error');
		}

		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update account password.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @param 	string 	$password
	 * @return 	boolean
	 */
	public function change_password($id, $password = null)
	{
		// Both ID and password are required.
		if (empty($id) OR empty($password))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// We make sure to the user exists.
		$user = $this->ci->kbcore->users->get($id);
		if (false === $user)
		{
			set_alert(lang('us_account_missing'), 'error');
			return false;
		}

		/**
		 * If the user uses the same password, nothing to do. We 
		 * simply tell him that he changed it.
		 */
		if (password_verify($password, $user->password))
		{
			set_alert(lang('set_password_success'), 'success');
			return true;
		}

		// Proceed to password change.
		$user->password = $password;
		$status = $user->save();

		// Successfully changed?
		if ($status === true)
		{
			// Set alert message.
			set_alert(lang('set_password_success'), 'success');
		}
		// Something went wrong?
		else
		{
			set_alert(lang('set_password_error'), 'error');
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------
	// Change email methods.
	// ------------------------------------------------------------------------

	/**
	 * Prepare email address to be changed.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @param 	string 	$email 	The new email address.
	 * @return 	boolean
	 */
	public function prep_change_email($id, $email)
	{
		// Both ID and password are required.
		if (empty($id) OR empty($email))
		{
			set_alert(lang('error_fields_required'), 'error');
			return false;
		}

		// Process status.
		$status = false;

		// Try to see if a variable exists.
		$var = $this->ci->kbcore->variables->get_by(array(
			'guid' => $id,
			'name' => 'email_code',
		));

		/**
		 * The variable is valid if it's still alive and it 
		 * holds the same email address the user wants to use.
		 */
		if ($var 
			&& $var->created_at > time() - (DAY_IN_SECONDS * 2) 
			&& $var->params === $email)
		{
			$email_code = $var->value;
			$status = true;
		}
		else
		{
			// Generate a new email code for later use.
			(function_exists('random_string')) OR $this->ci->load->helper('string');
			$email_code = random_string('alnum', 40);

			// The variable was found by not valid? Update it.
			if ($var)
			{
				$status = $this->ci->kbcore->variables->update($var->id, array(
					'value'      => $email_code,
					'params'     => $email,
					'created_at' => time(),
				));
			}
			// Not found? Create a new one.
			else
			{
				$status = (bool) $this->ci->kbcore->variables->create(array(
					'guid'   => $id,
					'name'   => 'email_code',
					'value'  => $email_code,
					'params' => $email,
				));
			}
		}

		// Everything went well?
		if ((bool) $status)
		{
			// Set alert message.
			set_alert(lang('set_email_info'), 'info');

			// TODO: Send the link to user.
		}
		// Something went wrong?
		else
		{
			set_alert(lang('set_email_error'), 'error');
		}

		// Return the process status.
		return (bool) $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Change user's email address by provided new email code.
	 * @access 	public
	 * @param 	string 	$code 	The new email code.
	 * @return 	boolean
	 */
	public function change_email($code = null)
	{
		// Make sure the code is valid first.
		if (empty($code) OR strlen($code) !== 40)
		{
			set_alert(lang('set_email_invalid_key'), 'error');
			return false;
		}

		// Try to get the variable from database.
		$var = $this->ci->kbcore->variables->get_by(array(
			'name'          => 'email_code',
			'BINARY(value)' => $code,
			'created_at >'  => time() - (DAY_IN_SECONDS * 2),
		));

		// Not found? Nothing to do.
		if ( ! $var)
		{
			set_alert(lang('set_email_invalid_key'), 'error');
			return false;
		}

		// We make sure the user exists.
		$user = $this->ci->kbcore->users->get($var->guid);
		if (false === $user)
		{
			set_alert(lang('us_account_missing'), 'error');
			return false;
		}

		// Change user's email address.
		$user->email = $var->params;
		$status = $user->save();

		// Updated?
		if ($status === true)
		{
			// Delete the variable.
			$this->ci->kbcore->variables->delete($var->id);

			// TODO: Send email to user about this change.

			// Set flash alert.
			set_alert(lang('set_email_success'), 'success');
		}
		// Something went wrong?
		else
		{
			set_alert(lang('set_email_error'), 'error');
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete all old new email codes.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function purge_email_codes()
	{
		$this->ci->kbcore->variables->delete_by(array(
			'name'         => 'email_code',
			'created_at <' => time() - (DAY_IN_SECONDS * 2)
		));
	}

}
