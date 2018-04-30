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
 * Users Module - Admin Controller
 *
 * This controller allow administrators to manage users accounts.
 *
 * @package 	CodeIgniter
 * @subpackage 	SKeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Admin extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent's constructor and add users JS file.
	 * We don't need to load module's language file because it has 
	 * already been loaded on the Auth library.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We add our language lines to head tag.
		add_filter('admin_head', array($this, '_admin_head'));

		// We load jQuery validation in add and edit methods.
		if ('add' === $this->router->fetch_method())
		{
			$this->_jquery_validate();
		}

		// We add users JS file.
		$this->scripts[] = 'users';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Display all site's users accounts.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Create pagination.
		$this->load->library('pagination');

		// Pagination configuration.
		$config['base_url']   = $config['first_link'] = admin_url('users');
		$config['total_rows'] = $this->kbcore->users->count();
		$config['per_page']   = $this->config->item('per_page');

		// Initialize pagination.
		$this->pagination->initialize($config);

		// Create pagination links.
		$data['pagination'] = $this->pagination->create_links();

		// Display limit.
		$limit = $config['per_page'];

		// Prepare offset.
		$offset = 0;
		if ($this->input->get('page'))
		{
			$offset = $config['per_page'] * ($this->input->get('page') - 1);
		}

		// Get all users.
		$data['users'] = $this->kbcore->users->get_all($limit, $offset);

		// Set page title and render view.
		$this->theme
			->set_title(lang('us_manage_users'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * add
	 *
	 * Method for adding a new user's account.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function add()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'first_name',
					'label' => 'lang:first_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:last_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'email',
					'label' => 'lang:email_address',
					'rules' => 'trim|required|valid_email|unique_email'),
			array(	'field' => 'username',
					'label' => 'lang:username',
					'rules' => 'trim|required|alpha_dash|min_length[5]|max_length[32]|unique_username'),
			array(	'field' => 'password',
					'label' => 'lang:password',
					'rules' => 'required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:confirm_password',
					'rules' => 'required|matches[password]'),
		), '#add-user');

		// Before form processing
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

			$this->theme
				->set_title(lang('add_user'))
				->render($data);
		}
		// Process form.
		else
		{
			if (true !== $this->check_nonce('add-user'))
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/users/add', 'refresh');
				exit;
			}

			$user_data            = $this->input->post(array('first_name', 'last_name', 'email', 'username', 'password'), true);
			$user_data['enabled'] = ($this->input->post('enabled') == '1') ? 1 : 0;
			$user_data['subtype'] = ($this->input->post('admin') == '1') ? 'administrator' : 'regular';

			if (false !== ($guid = $this->kbcore->users->create($user_data)))
			{
				log_activity($this->c_user->id, 'lang:act_user_create::'.$guid);
				set_alert(lang('us_admin_add_success'), 'success');
				redirect('admin/users', 'refresh');
				exit;
			}

			set_alert(lang('us_admin_add_error'), 'error');
			redirect('admin/users/add', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * edit
	 *
	 * Edit an existing user's account.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	public function edit($id = 0)
	{
		// Get the user from database.
		$data['user'] = $this->kbcore->users->get($id);
		if ( ! $data['user'])
		{
			set_alert(lang('error_account_missing'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		$data['user']->admin = ($data['user']->subtype === 'administrator');

		// Prepare form validation.
		$rules = array(
			array(	'field' => 'first_name',
					'label' => 'lang:first_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:last_name',
					'rules' => 'required|max_length[32]'),
		);

		// Using a new email address?
		if ($this->input->post('email') && $this->input->post('email') <> $data['user']->email)
		{
			$rules[] = array(
				'field' => 'email',
				'label' => 'lang:email_address',
				'rules' => 'trim|required|valid_email|unique_email',
			);
		}

		// Using a different username?
		if ($this->input->post('username') && $this->input->post('username') <> $data['user']->username)
		{
			$rules[] = array(
				'field' => 'username',
				'label' => 'lang:username',
				'rules' => 'trim|required|min_length[5]|max_length[32]|unique_username',
			);
		}

		// Changing password?
		if ($this->input->post('password'))
		{
			$rules[] = array(
				'field' => 'password',
				'label' => 'lang:password',
				'rules' => 'required|min_length[8]|max_length[20]'
			);
			$rules[] = array(
				'field' => 'cpassword',
				'label' => 'lang:confirm_password',
				'rules' => 'required|matches[password]'
			);
		}

		// Prepare form validation and rules.
		$this->prep_form($rules);

		/**
		 * The reason behind lines you see below is to allow plugins or
		 * themes to add extra fields to users profiles.
		 * As you can see, $_defaults are the fields that will always be
		 * present no matter what.
		 * Right after, we are using $defaults and send it to plugins 
		 * system so that plugins and themes can alter it.
		 * The final result is merged than automatically generated.
		 */

		// Default user fields.
		$_defaults = array('first_name', 'last_name', 'email', 'username');

		// Allow plugins to add extra fields.
		$defaults = apply_filters('users_fields', array());
		$defaults = array_merge($_defaults, $defaults);

		// Let's now generate our form fields.
		foreach ($defaults as $field)
		{
			/**
			 * We first start by getting the name of the input.
			 * NOTE: If you pass arrays as new fields make sure to 
			 * ALWAYS add input names.
			 */
			$name = (is_array($field)) ? $field['name'] : $field;

			/**
			 * Now we store the default value of the field.
			 * If the fields is the $_defaults array, it means it comes
			 * from "users" table. Otherwise, it's a metadata.
			 */
			$value = (in_array($name, $_defaults))
				? $data['user']->{$name}
				: $this->kbcore->metadata->get_meta($data['user']->id, $name, true);

			// In case of an array, use it as-is.
			if (is_array($field))
			{
				$inputs[$name] = array_merge($field, array('value' => set_value($name, $value)));
			}
			/**
			 * In case a string is passed, we make sure it exists first, 
			 * if it does, we add it. Otherwise, we set error.
			 */
			elseif ($item = $this->config->item($name, 'inputs'))
			{
				$inputs[$name] = array_merge($item, array('value' => set_value($name, $value)));
			}
		}

		/**
		 * Fields below are default fields as well, so we don't give 
		 * plugins or themes the right to alter them.
		 */
		$inputs['password']  = $this->config->item('password', 'inputs');
		$inputs['cpassword'] = $this->config->item('cpassword', 'inputs');
		$inputs['gender']    = array_merge(
			$this->config->item('gender', 'inputs'),
			array('selected' => $data['user']->gender)
		);

		// Let's now add our generated inputs to view.
		$data['inputs'] = $inputs;

		// Before form processing
		if ($this->form_validation->run() == false)
		{

			// Set page title and render view.
			$this->theme
				->set_title(lang('edit_user'))
				->render($data);
		}
		// Process form.
		else
		{
			if (true !== $this->check_nonce('edit-user_'.$id))
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/users/edit/'.$id, 'refresh');
				exit;
			}

			/**
			 * Here we make sure to remove the confirm password field.
			 * Otherwise it will be used as a metadata
			 */
			unset($inputs['cpassword']);

			// Collect all user details.
			$user_data = $this->input->post(array_keys($inputs), true);


			// Format "enabled" and user's "subtype".
			$user_data['enabled'] = ($this->input->post('enabled') == '1') ? 1 : 0;
			$user_data['subtype'] = ($this->input->post('admin') == '1') ? 'administrator' : 'regular';

			/**
			 * After form submit. We make sure to remove fields that have 
			 * not been changed: Username, Email address, first name, last name
			 * and user's subtype.
			 */
			$_fields = array(
				'username',
				'email',
				'subtype',
				'first_name',
				'last_name',
				'gender',
				'enabled',
			);
			foreach ($_fields as $_field)
			{
				if ($user_data[$_field] == $data['user']->{$_field})
				{
					unset($user_data[$_field]);
				}
			}

			/**
			 * For the password, we make sure to remove it if it's empty
			 * of if it's the same as the old one.
			 */
			if (empty($user_data['password']) 
				OR password_verify($user_data['password'], $data['user']->password))
			{
				unset($user_data['password']);
			}

			// Successful or nothing to update?
			if (empty($user_data) OR true === $this->kbcore->users->update($id, $user_data))
			{
				set_alert(lang('us_admin_edit_success'), 'success');

				// Log the activity.
				log_activity($this->c_user->id, 'lang:act_user_update::'.$id);

				redirect('admin/users', 'refresh');
			}
			// Something went wrong?
			else
			{
				set_alert(lang('us_admin_edit_error'), 'error');
				redirect('admin/users/edit/'.$data['user']->id, 'refresh');
			}
			exit;
		}
	}

	// ------------------------------------------------------------------------
	// Private Methods.
	// ------------------------------------------------------------------------

	/**
	 * _admin_head
	 *
	 * Method for adding some extra lines to the head section of the output.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$output 	The head part of the output.
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		// Confirmation messages.
		$lines = array(
			'activate'   => htmlentities(lang('us_admin_activate_confirm'), ENT_QUOTES, 'UTF-8'),
			'deactivate' => htmlentities(lang('us_admin_deactivate_confirm'), ENT_QUOTES, 'UTF-8'),
			'delete'     => htmlentities(lang('us_admin_delete_confirm'), ENT_QUOTES, 'UTF-8'),
			'restore'    => htmlentities(lang('us_admin_restore_confirm'), ENT_QUOTES, 'UTF-8'),
			'remove'     => htmlentities(lang('us_admin_remove_confirm'), ENT_QUOTES, 'UTF-8'),
		);

		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= 'csk.i18n.users = '.json_encode($lines).';';
		$output .= '</script>';

		return $output;
	}

}
