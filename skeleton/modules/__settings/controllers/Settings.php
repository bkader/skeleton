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
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.4.0
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

		// Make sure to load settings language file.
		$this->load->language('settings/settings');
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
		$user = $this->c_user;

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
				array('value' => set_value('company', $user->company))
			);
			$data['phone'] = array_merge(
				$this->config->item('phone', 'inputs'),
				array('value' => set_value('phone', $user->phone))
			);
			$data['location'] = array_merge(
				$this->config->item('location', 'inputs'),
				array('value' => set_value('location', $user->location))
			);

			// Use any filter targeting these fields.
			$data = apply_filters('user_profile_form_fields', $data);

			// Set page title and load view.
			$this->theme
				->set_title(line('set_profile_title'))
				->render($data);
		}
		// After form processing.
		else
		{
			if (true !== $this->check_nonce('update_settings_profile_'.$user->id))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('settings/profile');
				exit;
			}

			// Allow hooks alter this.
			$post = apply_filters('user_profile_update_fields', array(
				'first_name',
				'last_name',
				'company',
				'phone',
				'location',
			));

			// Collect data and hold only unchanged ones.
			$user_data = $this->input->post($post, true);
			foreach ($user_data as $key => $val)
			{
				if (to_bool_or_serialize($user->{$key}) === $val)
				{
					unset($user_data[$key]);
				}
			}

			/**
			 * We say that things were updated in case nothing is left;
			 * of everything was successfully updated.
			 */
			if (empty($user_data))
			{
				set_alert(line('set_profile_success'), 'success');
			}
			elseif (false !== $user->update($user_data))
			{
				set_alert(line('set_profile_success'), 'success');
				log_activity($this->c_user->id, 'lang:act_settings_user::'.__FUNCTION__);
			}
			// Otherwise, we set the error message.
			else
			{
				log_message('error', "User {$user->id} could not update profile.");
				set_alert(line('set_profile_error'), 'error');
			}
			
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
				->set_title(line('set_password_title'))
				->render($data);
		}
		else
		{
			if (true !== $this->check_nonce('update_settings_password_'.$this->c_user->id))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('settings/password', 'refresh');
				exit;
			}

			/**
			 * If the user is using the same old password, we don't have to update
			 * or log the activity. Otherwise, catch the process status returned
			 * by the update method.
			 */
			$password = $this->input->post('npassword', true);
			if (false !== password_verify($password, $this->c_user->password))
			{
				set_alert(line('set_password_success'), 'success');
				redirect('settings/password', 'refresh');
				exit;
			}

			// Successfully updated?
			if (false !== $this->c_user->update('password', $password))
			{
				// Log the activity and send email to user.
				log_activity($this->c_user->id, 'lang:act_settings_user::'.__FUNCTION__);
				// Send email to user.
				$ip_address = $this->input->ip_address();
				$this->users->send_email('password', $this->c_user, array(
					'login_url' => site_url('login'),
					'ip_link'    => anchor(
						'https://www.iptolocation.net/trace-'.$ip_address,
						$ip_address,
						'target="_blank"'
					)
				));

				set_alert(line('set_password_success'), 'success');
				redirect('settings/password', 'refresh');
				exit;
			}

			// Log the error for debugging.
			log_message('error', "User {$user->id} could not change password.");
			set_alert(line('set_password_error'), 'error');
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
		// Just to clear old email codes.
		$this->_purge_email_codes();

		$rules = array(
			// New email field.
			array(	'field' => 'nemail',
					'label' => 'lang:new_email_address',
					'rules' => 'trim|required|valid_email'),
			// Current password field.
			array(	'field' => 'opassword',
					'label' => 'lang:current_password',
					'rules' => 'required|current_password'),
		);

		/**
		 * If the user provided a different email address then his/hers, 
		 * we make sure it is a unique email address.
		 */
		if (null !== $set_email = $this->input->post('nemail'))
		{
			$rules[0]['rules'] .= '|unique_email';
		}
		
		// Prepare form validation.
		$this->prep_form($rules);

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

			// Set page title and render view.
			$this->theme
				->set_title(line('set_email_title'))
				->render($data);
		}
		else
		{
			if ( ! $this->check_nonce('update_settings_email_'.$this->c_user->id))
			{
				set_alert(line('CSK_ERROR_CSRF'), 'error');
				redirect('settings/email');
				exit;
			}

			/**
			 * If the user is attempting to use the same email address, we
			 * do like we updated. Otherwise, prepare email change.
			 */
			$email = $this->input->post('nemail', true);
			if ($email === $this->c_user->email)
			{
				set_alert(line('set_email_success'), 'success');
				redirect('settings/email', 'refresh');
				exit;
			}

			if (false !== $this->prep_email($email))
			{
				set_alert(line('set_email_info'), 'info');
				redirect('settings/email', 'refresh');
				exit;
			}

			set_alert(line('set_email_error'), 'error');
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
			array(	'field' => 'avatar',
					'label' => 'avatar',
					'rules' => 'trim')
		));

		// Before submitting the form.
		if ($this->form_validation->run() == false)
		{
			// Set page title and render view.
			$this->theme
				->set_title(line('update_avatar'))
				->render();
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
		if (true !== $this->check_nonce('update_settings_avatar_'.$this->c_user->id))
		{
			set_alert(line('CSK_ERROR_CSRF'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Collect data first.
		$use_gravatar = ($this->input->post('gravatar') == '1');

		// Using gravatar instead? Simply delete uploaded avatar.
		if ($use_gravatar === true)
		{
			@unlink(FCPATH."content/uploads/avatars/{$this->c_user->avatar}.jpg");
			log_activity($this->c_user->id, 'lang:act_settings_user::use_gravatar');

			set_alert(line('set_avatar_success'), 'success');
			redirect('settings/avatar');
			exit;
		}

		// We generate the file name based on user's email address.
		$file_name = $this->c_user->avatar.'.jpg';

		$config['upload_path']   = 'content/uploads/avatars/';
		$config['file_name']     = $file_name;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite']     = true;

		$this->load->library('upload', $config);
		unset($config);

		// Proceed to upload.
		if ( ! $this->upload->do_upload('avatar'))
		{
			log_message('error', $this->upload->display_errors());
			set_alert(line('set_avatar_error'), 'error');
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
			set_alert(line('set_avatar_error'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Continue.
		$this->image_lib->clear();
		$_config = $config;
		unset($config);

		$config['image_library']  = 'GD2';
		$config['source_image']   = $data['full_path'];
		$config['maintain_ratio'] = false;
		$config['width']          = 100;
		$config['height']         = 100;

		if ($_config['width'] > $_config['height'])
		{
			$config['x_axis'] = ($_config['width'] - 100) / 2;
		}
		else
		{
			$config['y_axis'] = ($_config['height'] - 100) / 2;
		}

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->crop())
		{
			log_message('error', $this->upload->display_errors());
			set_alert(line('set_avatar_error'), 'error');
			redirect('settings/avatar');
			exit;
		}

		// Log the activity.
		log_activity($this->c_user->id, 'lang:act_settings_user::'.__FUNCTION__);

		set_alert(line('set_avatar_success'), 'success');
		redirect('settings/avatar');
		exit;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * prep_email
	 *
	 * Method for preparing email change.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	protected
	 * @param 	string 	$email 	The new email address.
	 * @return 	bool 	True if the process is successful.
	 */
	protected function prep_email($email)
	{
		if (false === $this->c_user)
		{
			return false;
		}

		$status = false;

		$var = $this->kbcore->variables->get_by(array(
			'guid' => $this->c_user->id,
			'name' => 'email_code',
		));

		// Variable found and still alive?
		if (false !== $var 
			&& $var->created_at > time() - (DAY_IN_SECONDS * 2) 
			&& $var->params === $email)
		{
			$email_code = $var->value;
			$status = true;
		}
		else
		{
			(function_exists('random_string')) OR $this->load->helper('string');
			$email_code = random_string('alnum', 40);

			if (false !== $var)
			{
				$status = $var->update(array(
					'value'      => $email_code,
					'params'     => $email,
					'created_at' => time(),
				));
			}
			else
			{
				$status = (bool) $this->kbcore->variables->create(array(
					'guid'   => $this->c_user->id,
					'name'   => 'email_code',
					'value'  => $email_code,
					'params' => $email,
				));
			}
		}

		if (false !== $status)
		{
			log_activity($this->c_user->id, 'lang:act_settings_user::'.__FUNCTION__);

			$ip_address = $this->input->ip_address();
			$this->users->send_email('prep_email', $this->c_user, array(
				'link'    => process_anchor('users/email/'.$email_code),
				'ip_link' => anchor('https://www.iptolocation.net/trace-'.$ip_address, $ip_address, 'target="_blank"'),
			));
			
			return true;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * _purge_email_codes
	 *
	 * Method for deleting old email codes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function _purge_email_codes()
	{
		$this->kbcore->variables->delete_by(array(
			'name'         => 'email_code',
			'created_at <' => time() - (DAY_IN_SECONDS * 2),
		));
	}

}
