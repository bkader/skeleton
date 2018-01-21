<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Ajax_Controller
{
	public function index() {}

	public function test()
	{
		$this->response['status']  = true;
		$this->response['message'] = 'Fuck';
	}

	// ------------------------------------------------------------------------

	/**
	 * Activate the selected user.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	public function activate($id = 0)
	{
		// Load admin language file.
		$this->load->language('users/users_admin');

		$url = $this->input->post('next', true);

		/**
		 * We check few conditions:
		 * 1. The ID is set.
		 * 2. THe URL passes security process.
		 * 3. The user is an admin.
		 * 4. The user is not targeting his/her own account.
		 */
		if ($id < 0 
			OR ! $this->auth->is_admin() 
			OR ! check_safe_url()
			OR $id == $this->c_user->id)
		{
			$this->response['message'] = lang('error_safe_url');
			return;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->kbcore->users->get($id);
		if ( ! $user OR $user->enabled <> 0)
		{
			$this->response['message'] = lang('us_admin_activate_error');
			return;
		}

		// Enabled the users.
		$status = $this->kbcore->entities->update($id, array('enabled' => 1));

		if ($status === true)
		{
			$this->response['status'] = true;
			$this->response['message'] = lang('us_admin_activate_success');

			// Prepare the action.
			$this->response['action'] =<<<EOT
var row = \$("<tr id='row-{$id}'>");
row.load("{$url} tr#row-{$id} > *", function () {
	\$("tr#row-{$id}").replaceWith(row);
});
EOT;
		}
		else
		{
			$this->response['message'] = lang('us_admin_activate_error');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Deactivate the selected user.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	public function deactivate($id = 0)
	{
		// Load admin language file.
		$this->load->language('users/users_admin');

		$url = $this->input->post('next', true);

		/**
		 * We check few conditions:
		 * 1. The ID is set.
		 * 2. THe URL passes security process.
		 * 3. The user is an admin.
		 * 4. The user is not targeting his/her own account.
		 */
		if ($id < 0 
			OR ! $this->auth->is_admin() 
			OR ! check_safe_url()
			OR $id == $this->c_user->id)
		{
			$this->response['message'] = lang('error_safe_url');
			return;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->kbcore->users->get($id);
		if ( ! $user OR $user->enabled <> 1)
		{
			$this->response['message'] = lang('us_admin_deactivate_error');
			return;
		}

		// Enabled the users.
		$status = $this->kbcore->entities->update($id, array('enabled' => 0));

		if ($status === true)
		{
			$this->response['status'] = true;
			$this->response['message'] = lang('us_admin_deactivate_success');

			// Prepare the action.
			// $this->response['action'] = '$("tr#row-'.$id.'").load("'.admin_url('users').' tr#row-'.$id.' > *");';
			$this->response['action'] =<<<EOT
var row = \$("<tr id='row-{$id}'>");
row.load("{$url} tr#row-{$id} > *", function () {
	\$("tr#row-{$id}").replaceWith(row);
});
EOT;
		}
		else
		{
			$this->response['message'] = lang('us_admin_deactivate_error');
		}
	}

}
