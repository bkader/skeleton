<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Controllers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
// Content

class Admin extends Admin_Controller
{
	/**
	 * List all site users.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Create pagination.
		$this->load->library('pagination');

		// Pagination configuration.
		$config['base_url']   = $config['first_link'] = admin_url('users');
		$config['total_rows'] = $this->app->users->count_all();
		$config['per_page']   = $this->config->item('per_page');

		// Initialize pagination.
		$this->pagination->initialize($config);

		// Create pagination links.
		$data['pagination'] = $this->pagination->create_links();

		// Prepare offset.
		$offset = ($this->input->get('page'))
			? $config['per_page'] * ($this->input->get('page') - 1)
			: 0;

		// Display limit.
		$limit = $config['per_page'];

		// Get all users.
		$data['users'] = $this->app->users->get_all_users($limit, $offset);
		$this->theme
			->set_title(__('us_manage_users'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Add a new account.
	 *
	 * @access 	public
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
					'rules' => 'trim|required|min_length[5]|max_length[32]|unique_username'),
			array(	'field' => 'password',
					'label' => 'lang:password',
					'rules' => 'required|min_length[8]|max_length[20]'),
			array(	'field' => 'cpassword',
					'label' => 'lang:confirm_password',
					'rules' => 'required|matches[password]'),
		));

		// Were form fields stored in session?
		if (is_array($this->session->flashdata('form')))
		{
			extract($this->session->flashdata('from'));
		}

		// Before form processing
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name', @$first_name))
			);
			$data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name', @$last_name))
			);
			$data['email'] = array_merge(
				$this->config->item('email', 'inputs'),
				array('value' => set_value('email', @$email))
			);
			$data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username', @$username))
			);
			$data['password'] = array_merge(
				$this->config->item('password', 'inputs'),
				array('value' => set_value('password', @$password))
			);
			$data['cpassword'] = array_merge(
				$this->config->item('cpassword', 'inputs'),
				array('value' => set_value('cpassword', @$cpassword))
			);

			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(__('add_user'))
				->render($data);
		}
		// Process form.
		else
		{
			// Passed CSRF?
			if ( ! $this->check_csrf())
			{
				// Store form values in session
				$this->session->set_flashdata('form', $this->input->post(null, true));

				set_alert(__('error_csrf'), 'error');
				redirect('admin/users/add', 'refresh');
				exit;
			}

			$user_data            = $this->input->post(array('first_name', 'last_name', 'email', 'username', 'password'), true);
			$user_data['enabled'] = ($this->input->post('enabled') == '1') ? 1 : 0;
			$user_data['subtype'] = ($this->input->post('admin') == '1') ? 'admin' : 'regular';

			$guid = $this->users->create_user($user_data);
			redirect(($guid > 0) ? 'admin/users' : 'admin/users/add', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit an existing user.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function edit($id = 0)
	{
		// Get the user from database.
		$data['user'] = $this->app->users->get($id);
		if ( ! $data['user'])
		{
			set_alert(__('error_account_missing'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		$data['user']->admin = ($data['user']->subtype === 'admin');

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
				'rules' => 'trim|required|valid_email|is_unique[users.email]|is_unique[variables.params]|is_unique[metadata.value]',
			);
		}

		// Using a different username?
		if ($this->input->post('username') && $this->input->post('username') <> $data['user']->username)
		{
			$rules[] = array(
				'field' => 'username',
				'label' => 'lang:username',
				'rules' => 'trim|required|min_length[5]|max_length[32]|is_unique[entities.username]',
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

		// Were form fields stored in session?
		if ($this->session->flashdata('form'))
		{
			extract($this->session->flashdata('from'));
		}

		// Before form processing
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name', $data['user']->first_name))
			);
			$data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name', $data['user']->last_name))
			);
			$data['email'] = array_merge(
				$this->config->item('email', 'inputs'),
				array('value' => set_value('email', $data['user']->email))
			);
			$data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username', $data['user']->username))
			);
			$data['password']  = $this->config->item('password', 'inputs');
			$data['cpassword'] = $this->config->item('cpassword', 'inputs');
			$data['gender']    = array_merge(
				$this->config->item('gender', 'inputs'),
				array('selected' => $data['user']->gender)
			);

			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(__('edit_user'))
				->render($data);
		}
		// Process form.
		else
		{
			// Passed CSRF?
			if ( ! $this->check_csrf())
			{
				// Store form values in session
				$this->session->set_flashdata('form', $this->input->post(null, true));

				set_alert(__('error_csrf'), 'error');
				redirect($this->agent->referrer(), 'refresh');
				exit;
			}

			$user_data = $this->input->post(array('first_name', 'last_name', 'email', 'username', 'password', 'gender'), true);
			$user_data['enabled'] = ($this->input->post('enabled') == '1') ? 1 : 0;
			$user_data['subtype']   = ($this->input->post('admin') == '1') ? 'admin' : 'regular';

			// Remove username if it's the same.
			if ($user_data['username'] == $data['user']->username)
			{
				unset($user_data['username']);
			}

			// Remove email address if it's the same.
			if ($user_data['email'] == $data['user']->email)
			{
				unset($user_data['email']);
			}

			// Remove password if empty!
			if (empty($user_data['password']))
			{
				unset($user_data['password']);
			}

			// Remove user type if the same.
			if ($user_data['subtype'] == $data['user']->subtype)
			{
				unset($user_data['subtype']);
			}

			$status = $this->app->users->update($id, $user_data);

			if ($status == true)
			{
				set_alert(__('us_admin_edit_success'), 'success');
				redirect('admin/users', 'refresh');
			}
			else
			{
				set_alert(__('us_admin_edit_error'), 'error');
				redirect('admin/users/edit/'.$user->id, 'refresh');
			}
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Activate a user.
	 *
	 * @access 	public
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function activate($id = 0)
	{
		/**
		 * We check few conditions:
		 * 1. The ID is set.
		 * 2. THe URL passes security process.
		 * 3.  The user is not targeting his/her own account.
		 */
		if ($id < 0
			OR ! check_safe_url()
			OR $id == $this->c_user->id)
		{
			set_alert(__('error_safe_url'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->app->users->get($id);
		if ( ! $user OR $user->enabled <> 0)
		{
			set_alert(__('us_admin_activate_error'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		// Enabled the users.
		$status = $this->app->entities->update($id, array('enabled' => 1));

		if ($status === true)
		{
			set_alert(__('us_admin_activate_success'), 'success');
		}
		else
		{
			set_alert(__('us_admin_activate_error'), 'error');
		}

		redirect($this->agent->referrer());
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Deactivate a user.
	 *
	 * @access 	public
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function deactivate($id = 0)
	{
		/**
		 * We check few conditions:
		 * 1. The ID is set.
		 * 2. THe URL passes security process.
		 * 3.  The user is not targeting his/her own account.
		 */
		if ($id < 0
			OR ! check_safe_url()
			OR $id == $this->c_user->id)
		{
			set_alert(__('error_safe_url'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->app->users->get($id);
		if ( ! $user OR $user->enabled <> 1)
		{
			set_alert(__('us_admin_deactivate_error'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		// Enabled the users.
		$status = $this->app->entities->update($id, array('enabled' => 0));

		if ($status === true)
		{
			set_alert(__('us_admin_deactivate_success'), 'success');
		}
		else
		{
			set_alert(__('us_admin_deactivate_error'), 'error');
		}

		redirect($this->agent->referrer());
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete existing user.
	 * @access 	public
	 * @param 	int 	$id 	user's ID.
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return 	void.
	 */
	public function delete($id = 0)
	{
		/**
		 * We check few conditions:
		 * 1. The ID is set.
		 * 2. THe URL passes security process.
		 * 3.  The user is not targeting his/her own account.
		 */
		if ($id < 0
			OR ! check_safe_url()
			OR $id == $this->c_user->id)
		{
			set_alert(__('error_safe_url'), 'error');
			redirect($this->agent->referrer());
			exit;
		}

		// Could not be deleted?
		if ( ! $this->app->users->remove($id))
		{
			set_alert(__('us_admin_delete_error'), 'error');
		}
		else
		{
			set_alert(__('us_admin_delete_success'), 'success');
		}

		redirect($this->agent->referrer());
		exit;
	}

}
