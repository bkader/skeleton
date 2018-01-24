<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Ajax_Controller
{
	public function __construct()
	{
		array_unshift($this->actions_get, 'activate', 'deactivate', 'delete');
		array_unshift($this->actions_post, 'activate', 'deactivate', 'delete');
		parent::__construct();
		$this->load->language('users/users_admin');

	}

	public function index() 
	{
		// $this->response->message = 'Fuck';
		// $this->response->header = 500;
	}

	public function test()
	{
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
		$url = $this->input->post('next', true);

		// Make sure the user is logged in and is an admin.
		if ( ! $this->auth->is_admin())
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// We make sure the $id is provided.
		if ( ! is_numeric($id) OR $id <= 0)
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// Make sure the user is not deactivating his own account himself/herself.
		if ($id === $this->c_user->id)
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->kbcore->users->get($id);
		if ( ! $user OR $user->enabled <> 0)
		{
			$this->response->message = lang('us_admin_activate_error');
			return;
		}

		// Enabled the users.
		if ($this->kbcore->entities->update($id, array('enabled' => 1)))
		{
			$this->response->status  = true;
			$this->response->message = lang('us_admin_activate_success');

			// Prepare the action.
			$this->response->action =<<<EOT
var row = \$("<tr id='row-{$id}'>");
row.load("{$url} tr#row-{$id} > *", function () {
	\$("tr#row-{$id}").replaceWith(row);
});
EOT;
		}
		else
		{
			$this->response->message = lang('us_admin_activate_error');
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
		$url = $this->input->post('next', true);

		// Make sure the user is logged in and is an admin.
		if ( ! $this->auth->is_admin())
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// We make sure the $id is provided.
		if ( ! is_numeric($id) OR $id <= 0)
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// Make sure the user is not deactivating his own account himself/herself.
		if ($id == $this->c_user->id)
		{
			$this->response->message = lang('error_action_permission');
			return;
		}

		// Make sure the user exists and is deactivated.
		$user = $this->kbcore->users->get($id);
		if ( ! $user OR $user->enabled <> 1)
		{
			$this->response->message = lang('us_admin_deactivate_error');
			return;
		}

		// Attempt to deactivate the user.
		if ($this->kbcore->entities->update($id, array('enabled' => 0)))
		{
			$this->response->status = true;
			$this->response->message = lang('us_admin_deactivate_success');

			// Prepare the action.
			// $this->response->action = '$("tr#row-'.$id.'").load("'.admin_url('users').' tr#row-'.$id.' > *");';
			$this->response->action =<<<EOT
var row = \$("<tr id='row-{$id}'>");
row.load("{$url} tr#row-{$id} > *", function () {
	\$("tr#row-{$id}").replaceWith(row);
});
EOT;
		}
		else
		{
			$this->response->message = lang('us_admin_deactivate_error');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * AJAX delete user handler.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	void
	 */
	public function delete($id)
	{
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
			OR $id === $this->c_user->id)
		{
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Make sure the user exists and is deactivated.
		if ($this->kbcore->users->remove($id))
		{
			$this->response->status = true;
			$this->response->header = 200;
			$this->response->message = lang('us_admin_delete_success');
			$this->response->action =<<<EOT
$("tr#row-{$id}").fadeOut('slow', function() {
	$(this).remove();
});
EOT;
		}
		else
		{
			$this->response->message = lang('us_admin_delete_error');
		}
	}

}
