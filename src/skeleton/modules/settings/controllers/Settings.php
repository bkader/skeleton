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
 * Settings Module - Settings Controller
 *
 * This controller allow regular users to update their account details,
 * change password, email address and update their avatars.
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
class Settings extends User_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure to load settings_lib.
		$this->load->library('settings/settings_lib', null, 'settings');
	}

	// ------------------------------------------------------------------------

	/**
	 * This method redirect to profile settings.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		redirect('settings/profile');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update user's profile.
	 * @access 	public
	 * @return 	void
	 */
	public function profile()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'first_name',
					'label' => 'lang:first_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:last_name',
					'rules' => 'required|max_length[32]'),
		));

		// Clone the current user.
		$user = clone $this->c_user;

		// Get user's metadata.
		if ( ! empty($meta = $this->kbcore->metadata->get_many('guid', $user->id)))
		{
			foreach ($meta as $single)
			{
				$user->{$single->name} = $single->value;
			}
		}

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name', $user->first_name))
			);
			$data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name', $user->last_name))
			);
			$data['company'] = array_merge(
				$this->config->item('company', 'inputs'),
				array('value' => set_value('company', @$user->company))
			);
			$data['phone'] = array_merge(
				$this->config->item('phone', 'inputs'),
				array('value' => set_value('phone', @$user->phone))
			);
			$data['location'] = array_merge(
				$this->config->item('location', 'inputs'),
				array('value' => set_value('location', @$user->location))
			);

			// Use any filter targeting these fields.
			$data = apply_filters('user_profile_form_fields', $data);

			// CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('set_profile_title'))
				->render($data);
		}
		// After form processing.
		else
		{
			$post = apply_filters('user_profile_update_fields', array(
				'first_name',
				'last_name',
				'company',
				'phone',
				'location',
			));

			$data = $this->input->post($post, true);

			$this->settings->update_profile($user->id, $data);
			redirect('settings/profile', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Change account password.
	 * @access 	public
	 * @return 	void
	 */
	public function password()
	{
		// Prepare form validation.
		$this->prep_form(array(
			// New password field.
			array(	'field' => 'npassword',
					'label' => 'lang:new_password',
					'rules' => 'required|min_length[8]|max_length[20]'),
			// Confirm password field.
			array(	'field' => 'cpassword',
					'label' => 'lang:confirm_password',
					'rules' => 'required|min_length[8]|max_length[20]|matches[npassword]'),
			// Current password field.
			array(	'field' => 'opassword',
					'label' => 'lang:current_password',
					'rules' => 'required|current_password'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['npassword'] = array_merge(
				$this->config->item('npassword', 'inputs'),
				array('value' => set_value('npassword'))
			);
			$data['cpassword'] = array_merge(
				$this->config->item('cpassword', 'inputs'),
				array('value' => set_value('cpassword'))
			);
			$data['opassword'] = array_merge(
				$this->config->item('opassword', 'inputs'),
				array('value' => set_value('opassword'))
			);

			// Add CSRF protected.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('set_password_title'))
				->render($data);
		}
		else
		{
			// Proceed to update.
			$this->settings->change_password(
				$this->auth->user_id(),
				$this->input->post('npassword', true)
			);

			// Redirect back to same page.
			redirect('settings/password', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Change account email address.
	 * @access 	public
	 * @return 	void
	 */
	public function email()
	{
		// Simple clean of old email requests.
		$this->settings->purge_email_codes();

		// Prepare form validation.
		$this->prep_form(array(
			// New email field.
			array(	'field' => 'nemail',
					'label' => 'lang:new_email_address',
					'rules' => 'trim|required|valid_email|unique_email'),
			// Current password field.
			array(	'field' => 'opassword',
					'label' => 'lang:current_password',
					'rules' => 'required|current_password'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['nemail'] = array_merge(
				$this->config->item('nemail', 'inputs'),
				array('value' => set_value('nemail'))
			);
			$data['opassword'] = array_merge(
				$this->config->item('opassword', 'inputs'),
				array('value' => set_value('opassword'))
			);

			// Add CSRF protected.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('set_email_title'))
				->render($data);
		}
		else
		{
			// Prepare email change.
			$this->settings->prep_change_email(
				$this->auth->user_id(),
				$this->input->post('nemail', true)
			);

			// Redirect back to same page.
			redirect('settings/email', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Change profile avatar.
	 * @access 	public
	 * @return 	void
	 */
	public function avatar()
	{
		//TODO: develop this method.
	}

}
