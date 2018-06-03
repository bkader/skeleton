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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Users extends Admin_Controller {

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
		('add' === $this->router->fetch_method()) && $this->_jquery_validate();

		// We add users JS file.
		$this->scripts[] = 'users';

		// Default page icon, title and help.
		$this->data['page_icon']  = 'users';
		$this->data['page_title'] = __('CSK_USERS_MANAGE_USERS');
		$this->data['page_help'] = 'https://github.com/bkader/skeleton/wiki/Users';
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

		// Users filter.
		$where = array();

		// Filter by role (subtype).
		if (null !== ($role = $this->input->get('role', true)))
		{
			$where['subtype'] = $role;
		}

		// Account status.
		if (null !== ($status = $this->input->get('status', true)))
		{
			switch ($status) {
				case 'deleted':
					$where['deleted'] = 1;
					break;
				case 'active':
					$where['enabled'] = 1;
					break;
				case 'inactive':
					$where['enabled'] = 0;
					break;
				case 'banned':
					$where['enabled'] = -1;
					break;
			}
		}

		// Pagination configuration.
		$config['base_url']   = $config['first_link'] = admin_url('users');
		$config['total_rows'] = $this->kbcore->users->count($where);
		$config['per_page']   = $this->config->item('per_page');

		// Initialize pagination.
		$this->pagination->initialize($config);

		// Create pagination links.
		$this->data['pagination'] = $this->pagination->create_links();

		// Display limit.
		$limit = $config['per_page'];

		// Prepare offset.
		$offset = 0;
		if ($this->input->get('page'))
		{
			$offset = $config['per_page'] * ($this->input->get('page') - 1);
		}

		// Get all users.
		$this->data['users'] = $this->kbcore->users->get_many($where, null, $limit, $offset);

		/**
		 * Cache users actions.
		 * @since 	2.1.1
		 */
		$actions = array('activate', 'deactivate', 'delete', 'restore', 'remove');
		$action  = $this->input->get('action');
		$user    = (int) $this->input->get('user', true);

		if (($action && in_array($action, $actions))
			&& ($user && $user > 0)
			&& check_nonce_url('user-'.$action.'_'.$user)
			&& method_exists($this, '_'.$action))
		{
			return call_user_func_array(array($this, '_'.$action), array($user));
		}

		// Set page title and render view.
		$this->theme
			->set_title(__('CSK_USERS_MANAGE_USERS'))
			->render($this->data);
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
					'label' => 'lang:CSK_INPUT_FIRST_NAME',
					'rules' => 'trim|required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:CSK_INPUT_LAST_NAME',
					'rules' => 'trim|required|max_length[32]'),
			array(	'field' => 'email',
					'label' => 'lang:CSK_INPUT_EMAIL_ADDRESS',
					'rules' => 'trim|required|valid_email|unique_email'),
			array(	'field' => 'username',
					'label' => 'lang:CSK_INPUT_USERNAME',
					'rules' => 'trim|required|alpha_dash|min_length[5]|max_length[32]|unique_username'),
			array(	'field' => 'password',
					'label' => 'lang:CSK_INPUT_PASSWORD',
					'rules' => 'trim|required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:CSK_INPUT_CONFIRM_PASSWORD',
					'rules' => 'trim|required|matches[password]'),
		), '#add-user');

		// Before form processing
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$this->data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name'))
			);
			$this->data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name'))
			);
			$this->data['email'] = array_merge(
				$this->config->item('email', 'inputs'),
				array('value' => set_value('email'))
			);
			$this->data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username'))
			);
			$this->data['password'] = array_merge(
				$this->config->item('password', 'inputs'),
				array('value' => set_value('password'))
			);
			$this->data['cpassword'] = array_merge(
				$this->config->item('cpassword', 'inputs'),
				array('value' => set_value('cpassword'))
			);

			// Page icon and title.
			$this->data['page_icon'] = 'user-plus';
			$this->data['page_title'] = __('CSK_USERS_ADD_USER');

			$this->theme
				->set_title($this->data['page_title'])
				->render($this->data);
		}
		// Process form.
		else
		{
			if (true !== $this->check_nonce('add-user'))
			{
				set_alert(__('CSK_ERROR_CSRF'), 'error');
				redirect(KB_ADMIN.'/users/add', 'refresh');
				exit;
			}

			$data = $this->input->post(array(
				'first_name',
				'last_name',
				'email',
				'username',
				'password'
			), true);

			$data['enabled'] = ($this->input->post('enabled') == '1') ? 1 : 0;
			($this->input->post('admin') == '1') && $data['subtype'] = 'administrator';

			if (false !== ($guid = $this->kbcore->users->create($data)))
			{
				set_alert(__('CSK_USERS_ADMIN_SUCCESS_ADD'), 'success');
				redirect(KB_ADMIN.'/users', 'refresh');
				exit;
			}

			set_alert(__('CSK_USERS_ADMIN_ERROR_ADD'), 'error');
			redirect(KB_ADMIN.'/users/add', 'refresh');
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
		$this->data['user'] = $this->kbcore->users->get($id);
		if ( ! $this->data['user'])
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		$this->data['user']->admin = ($this->data['user']->subtype === 'administrator');

		// Prepare form validation.
		$rules = array(
			array(	'field' => 'first_name',
					'label' => 'lang:CSK_INPUT_FIRST_NAME',
					'rules' => 'trim|required|min_length[1]|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:CSK_INPUT_LAST_NAME',
					'rules' => 'trim|required|min_length[1]|max_length[32]'),
		);

		// Using a new email address?
		$email_rules = 'trim|required|valid_email';
		if ($this->input->post('email'))
		{
			if ($this->input->post('email') !== $this->data['user']->email)
			{
				$email_rules .= '|unique_email';
			}

			$rules[] = array(
				'field' => 'email',
				'label' => 'lang:CSK_INPUT_EMAIL_ADDRESS',
				'rules' => $email_rules,
			);
		}

		// Using a different username?
		$username_rules = 'trim|required|min_length[5]|max_length[32]';
		if ($this->input->post('username'))
		{
			if ($this->input->post('username') !== $this->data['user']->username)
			{
				$username_rules .= '|unique_username';
			}

			$rules[] = array(
				'field' => 'username',
				'label' => 'lang:CSK_INPUT_USERNAME',
				'rules' => $username_rules,
			);
		}

		// Changing password?
		if ($this->input->post('password'))
		{
			$rules[] = array(
				'field' => 'password',
				'label' => 'lang:CSK_INPUT_PASSWORD',
				'rules' => 'trim|required|min_length[8]|max_length[20]'
			);
			$rules[] = array(
				'field' => 'cpassword',
				'label' => 'lang:CSK_INPUT_CONFIRM_PASSWORD',
				'rules' => 'trim|required|min_length[8]|max_length[20]|matches[password]'
			);
		}

		// Prepare form validation and rules.
		$this->prep_form($rules, '#edit-user');

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
				? $this->data['user']->{$name}
				: $this->kbcore->metadata->get_meta($this->data['user']->id, $name, true);

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
			array('selected' => $this->data['user']->gender)
		);

		// Let's now add our generated inputs to view.
		$this->data['inputs'] = $inputs;

		// Before form processing
		if ($this->form_validation->run() == false)
		{
			$this->data['page_icon'] = 'user';
			$this->data['page_title'] = sprintf(__('CSK_USERS_EDIT_USER_NAME'), $this->data['user']->username);

			// Set page title and render view.
			$this->theme
				->set_title($this->data['page_title'])
				->render($this->data);
		}
		// Process form.
		else
		{
			if (true !== $this->check_nonce('edit-user_'.$id))
			{
				set_alert(__('CSK_ERROR_CSRF'), 'error');
				redirect(KB_ADMIN.'/users/edit/'.$id, 'refresh');
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
				if ($user_data[$_field] == $this->data['user']->{$_field})
				{
					unset($user_data[$_field]);
				}
			}

			/**
			 * For the password, we make sure to remove it if it's empty
			 * of if it's the same as the old one.
			 */
			if (empty($user_data['password']) 
				OR password_verify($user_data['password'], $this->data['user']->password))
			{
				unset($user_data['password']);
			}

			// Successful or nothing to update?
			if (empty($user_data) OR true === $this->kbcore->users->update($id, $user_data))
			{
				set_alert(__('CSK_USERS_ADMIN_SUCCESS_EDIT'), 'success');

				// Log the activity.

				redirect(KB_ADMIN.'/users', 'refresh');
			}
			// Something went wrong?
			else
			{
				set_alert(__('CSK_USERS_ADMIN_ERROR_EDIT'), 'error');
				redirect(KB_ADMIN.'/users/edit/'.$this->data['user']->id, 'refresh');
			}
			exit;
		}
	}

	// ------------------------------------------------------------------------
	// Quick-access methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for activating the given user.
	 *
	 * @since 	2.1.1
	 *
	 * @access 	protected
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	protected function _activate($id)
	{
		// No action done on own account.
		if ($id == $this->c_user->id)
		{
			set_alert(__('CSK_USERS_ADMIN_ERROR_ACTIVATE_OWN'), 'error');
		}

		// Make sure the user exists.
		elseif (false === ($user = $this->kbcore->users->get($id)))
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
		}

		// Successfully activated?
		elseif (0 == $user->enabled && false !== $user->update('enabled', 1))
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_SUCCESS_ACTIVATE'), $user->username), 'success');
		}

		// An error occurred somewhere?
		else
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_ERROR_ACTIVATE'), $user->username), 'error');
		}

		redirect($this->redirect);
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deactivating the given user.
	 *
	 * @since 	2.1.1
	 *
	 * @access 	protected
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	protected function _deactivate($id)
	{
		// No action done on own account.
		if ($id == $this->c_user->id)
		{
			set_alert(__('CSK_USERS_ADMIN_ERROR_DEACTIVATE_OWN'), 'error');
		}

		// Make sure the user exists.
		elseif (false === ($user = $this->kbcore->users->get($id)))
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
		}

		// Successfully activated?
		elseif (1 == $user->enabled && false !== $user->update('enabled', 0))
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_SUCCESS_DEACTIVATE'), $user->username), 'success');
		}

		// An error occurred somewhere?
		else
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_ERROR_DEACTIVATE'), $user->username), 'error');
		}

		redirect($this->redirect);
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting the given user.
	 *
	 * @since 	2.1.1
	 *
	 * @access 	protected
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	protected function _delete($id)
	{
		// No action done on own account.
		if ($id == $this->c_user->id)
		{
			set_alert(__('CSK_USERS_ADMIN_ERROR_DELETE_OWN'), 'error');
		}

		// Make sure the user exists.
		elseif (false === ($user = $this->kbcore->users->get($id)))
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
		}

		// Successfully activated?
		elseif (0 == $user->deleted && false !== $this->kbcore->users->delete($id))
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_SUCCESS_DELETE'), $user->username), 'success');
		}

		// An error occurred somewhere?
		else
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_ERROR_DELETE'), $user->username), 'error');
		}

		redirect($this->redirect);
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for restoring the given user.
	 *
	 * @since 	2.1.1
	 *
	 * @access 	protected
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	protected function _restore($id)
	{
		// No action done on own account.
		if ($id == $this->c_user->id)
		{
			set_alert(__('CSK_USERS_ADMIN_ERROR_RESTORE_OWN'), 'error');
		}

		// Make sure the user exists.
		elseif (false === ($user = $this->kbcore->users->get($id)))
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
		}

		// Successfully activated?
		elseif (1 == $user->deleted && false !== $this->kbcore->users->restore($id))
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_SUCCESS_RESTORE'), $user->username), 'success');
		}

		// An error occurred somewhere?
		else
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_ERROR_RESTORE'), $user->username), 'error');
		}

		redirect($this->redirect);
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for permanently delete the given user.
	 *
	 * @since 	2.1.1
	 *
	 * @access 	protected
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	protected function _remove($id)
	{
		// No action done on own account.
		if ($id == $this->c_user->id)
		{
			set_alert(__('CSK_USERS_ADMIN_ERROR_REMOVE_OWN'), 'error');
		}

		// Make sure the user exists.
		elseif (false === ($user = $this->kbcore->users->get($id)))
		{
			set_alert(__('CSK_USERS_ERROR_ACCOUNT_MISSING'), 'error');
		}

		// Successfully activated?
		elseif (false !== $this->kbcore->users->remove($id))
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_SUCCESS_REMOVE'), $user->username), 'success');
		}

		// An error occurred somewhere?
		else
		{
			set_alert(sprintf(__('CSK_USERS_ADMIN_ERROR_REMOVE'), $user->username), 'error');
		}

		redirect($this->redirect);
		exit;
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
		$lines = deep_htmlentities(array(
			'activate'   => __('CSK_USERS_ADMIN_CONFIRM_ACTIVATE'),
			'deactivate' => __('CSK_USERS_ADMIN_CONFIRM_DEACTIVATE'),
			'delete'     => __('CSK_USERS_ADMIN_CONFIRM_DELETE'),
			'restore'    => __('CSK_USERS_ADMIN_CONFIRM_RESTORE'),
			'remove'     => __('CSK_USERS_ADMIN_CONFIRM_REMOVE'),
		), ENT_QUOTES, 'UTF-8');

		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= 'csk.i18n.users = '.json_encode($lines).';';
		$output .= '</script>';

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * _subhead
	 *
	 * Add some buttons to dashboard subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		if ('index' !== $this->router->fetch_method())
		{
			add_action('admin_subhead', function () {
				$this->_btn_back('users');
			});
			return;
		}

		add_action('admin_subhead', function () {

			// Add user button.
			echo html_tag('a', array(
				'href' => admin_url('users/add'),
				'class' => 'btn btn-success btn-sm btn-icon mr-2'
			), fa_icon('plus-circle').__('CSK_USERS_ADD_USER'));

			do_action('in_users_subhead');

		});
	}

}
