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
 * @since 		1.0.0
 * @version 	1.3.3
 */
class Settings extends User_Controller
{
	/**
	 * Class constructor
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
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

			// Log the activity.
			log_activity($this->c_user->id, 'updated profile');

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
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
			}
			// Proceed to update.
			else
			{
				$this->settings->change_password(
					$this->auth->user_id(),
					$this->input->post('npassword', true)
				);

				// Log the activity.
				log_activity($this->c_user->id, 'changed password');
			}

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
			// We first check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
			}
			// Prepare email change.
			else
			{
				$this->settings->prep_change_email(
					$this->auth->user_id(),
					$this->input->post('nemail', true)
				);

				// Log the activity.
				log_activity($this->c_user->id, 'changed email address');
			}

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
		// Prepare form validation.
		$this->prep_form(array(
			array(	'field' => 'user_id',
					'label' => 'ID',
					'rules' => 'required')
		));

		// Before submitting the form.
		if ($this->form_validation->run() == false)
		{
			// Add data to form.
			$data['hidden'] = $this->create_csrf();
			$data['hidden']['user_id'] = $this->c_user->id;

			// Set page title and render view.
			$this->theme
				->set_title(lang('update_avatar'))
				->render($data);
		}
		else
		{
			return $this->up_avatar();
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Upload and update avatar.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function up_avatar()
	{
		// Make sure CSRF if valid.
		if ( ! $this->check_csrf())
		{
			set_alert(lang('error_csrf'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Collect data first.
		$user_id = (int) $this->input->post('user_id', true);
		$use_gravatar = ($this->input->post('gravatar') == '1');

		// Make sure the user is updating his/her avatar.
		if ($user_id !== $this->c_user->id)
		{
			set_alert(lang('error_csrf'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Using gravatar instead? Simply delete uploaded avatar.
		if ($use_gravatar === true)
		{
			@unlink(FCPATH."content/uploads/avatars/{$this->c_user->avatar}.jpg");
			set_alert(lang('set_avatar_success'), 'success');

			// Log the activity.
			log_activity($this->c_user->id, 'updated avatar to use gravatar');

			redirect('settings/avatar');
			exit;
		}

		// We generate the file name based on user's email address.
		$file_name = $this->c_user->avatar.'.jpg';

		$config['upload_path']   = './content/uploads/avatars/';
		$config['file_name']     = $file_name;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite']     = true;

		$this->load->library('upload', $config);
		unset($config);

		// Proceed to upload.
		if ( ! $this->upload->do_upload('avatar'))
		{
			log_message('error', $this->upload->display_errors());
			set_alert(lang('set_avatar_error'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Everything went well, proceed.
		$data = $this->upload->data();

		$this->load->library('image_lib');

		$config['image_library']  = 'GD2';
		$config['source_image']   = $data['full_path'];
		$config['maintain_ratio'] = true;

		if ($data['image_width'] > $data['image_height'])
		{
			$config['height'] = 100;
			$config['width'] = ($data['image_width'] * 100) / $data['image_height'];
		}
		else
		{
			$config['width'] = 100;
			$config['height'] = ($data['image_height'] * 100) / $data['image_width'];
		}
		$this->image_lib->initialize($config);

		// Error resizing?
		if ( ! $this->image_lib->resize())
		{
			set_alert(lang('set_avatar_error'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Continue.
		$this->image_lib->clear();

		$config['width']  = 100;
		$config['height'] = 100;
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->crop())
		{
			log_message('error', $this->upload->display_errors());
			set_alert(lang('set_avatar_error'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Log the activity.
		log_activity($this->c_user->id, 'updated avatar');

		set_alert(lang('set_avatar_success'), 'success');
		redirect('settings/avatar');
		exit;
	}

}
