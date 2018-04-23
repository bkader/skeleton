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
 * Users Module - Process Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.4.0
 */
class Process extends Process_Controller {

	/**
	 * __constructr
	 *
	 * Simply call parent constructor and make sure to load users_lib
	 * if it's not loaded.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Users_lib not loaded?
		if ( ! class_exists('Users_lib', false))
		{
			$this->load->library('users/users_lib', null, 'users');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activation the newly created account that requires activation
	 * if the email verification is enabled.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$code 	The account's activation code.
	 * @return 	void
	 */
	public function activate($code = null)
	{
		// Attempt to activate the account.
		$status = $this->users->activate_by_code($code);

		// The redirection depends on the activation status.
		redirect(($status === true ? 'login' : ''), 'refresh');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * email
	 *
	 * Method for processing user's email change.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	void
	 */
	public function email($code = null)
	{
		if (strlen($code) !== 40)
		{
			set_alert(line('set_email_invalid_key'), 'error');
			redirect('settings/email');
			exit;
		}

		// Get the variable and make sure it exists.
		$var = $this->kbcore->variables->get_by(array(
			'name' => 'email_code',
			'value' => $code,
			'created_at >' => time() - (DAY_IN_SECONDS * 2)
		));

		if (false === $var)
		{
			set_alert(line('set_email_invalid_key'), 'error');
			redirect('settings/email');
			exit;
		}

		// Get user and make sure he/she exists;
		$user = $this->kbcore->users->get($var->guid);
		if (false === $user)
		{
			set_alert(line('us_account_missing'), 'error');
			redirect('settings/email');
			exit;
		}

		// Successfully proceed?
		if (false !== $user->update('email', $var->params))
		{
			// Delete the variable and log the activity.
			$this->kbcore->variables->delete($var->id);
			log_activity($user->id, 'lang:act_settings_user::'.__FUNCTION__);

			// Send email to user.
			$ip_address = $this->input->ip_address();
			$this->users->send_email('email', $user, array(
				'ip_link' => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));

			// Set flash alert and redirect to email settings.
			set_alert(line('set_email_success'), 'success');
			redirect('settings/email');
			exit;
		}

		// Otherwise, email could not be changed.
		set_alert(line('set_email_error'), 'error');
		redirect('settings/email');
		exit;
	}

}
