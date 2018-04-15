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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Ajax Controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */
class Ajax extends AJAX_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent constructor and add our AJAX methods.
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

		// We add our safe admin AJAX methods.
		array_push(
			$this->safe_admin_methods,
			'activate',
			'deactivate',
			'delete',
			'restore',
			'remove'
		);
	}

	// ------------------------------------------------------------------------
	// Administration methods.
	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activating the selected user;
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	AJAX_Controller::response().
	 */
	public function activate($id = 0)
	{
		// Default header status code.
		$this->response->header = 409;

		// We make sure $id is valid.
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// The user cannot activate his/her own account.
		if ($id == $this->c_user->id)
		{
			$this->response->header  = 405;
			$this->response->message = lang('us_admin_activate_error_own');
			return;
		}

		// The user does not exist, or already enabled?
		if (false === $this->kbcore->users->get_by(array('id' => $id, 'enabled' => 0)))
		{
			$this->response->message = lang('us_admin_activate_error');
			return;
		}

		// Successfully disabled the user?
		if (false !== $this->kbcore->entities->update($id, array('enabled' => 1)))
		{
			$this->response->header  = 200;
			$this->response->message = lang('us_admin_activate_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_user_activate::'.$id);

			return;
		}

		// Otherwise, user could not be activated.
		$this->response->message = lang('us_admin_activate_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * deactivate
	 *
	 * Method for deactivating the selected user.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	AJAX_Controller::response().
	 */
	public function deactivate($id = 0)
	{
		// Default header status code.
		$this->response->header = 409;

		// We make sure $id is valid.
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// The user cannot deactivate his/her own account.
		if ($id == $this->c_user->id)
		{
			$this->response->header  = 405;
			$this->response->message = lang('us_admin_deactivate_error_own');
			return;
		}

		// The user does not exist, or already disabled?
		if (false === $this->kbcore->users->get_by(array('id' => $id, 'enabled' => 1)))
		{
			$this->response->message = lang('us_admin_deactivate_error');
			return;
		}

		// Successfully disabled the user?
		if (false !== $this->kbcore->entities->update($id, array('enabled' => 0)))
		{
			$this->response->header  = 200;
			$this->response->message = lang('us_admin_deactivate_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_user_deactivate::'.$id);

			return;
		}

		// Otherwise, user could not be activated.
		$this->response->message = lang('us_admin_deactivate_error');
	}

	// --------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for soft-deleting the selected user.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function delete($id = 0)
	{
		// Default response header status code.
		$this->response->header = 409;

		// Did we provide a valid $id?
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// The user cannot delete his/her own account.
		if ($id == $this->c_user->id)
		{
			$this->response->header  = 405;
			$this->response->message = lang('us_admin_delete_error_own');
			return;
		}

		// We attempt to remove the user.
		if (false !== $this->kbcore->users->delete($id))
		{
			$this->response->header  = 200;
			$this->response->message = lang('us_admin_delete_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_user_delete::'.$id);

			return;
		}

		// Otherwise, user could not be deleted.
		$this->response->message = lang('us_admin_delete_error');
	}

	// --------------------------------------------------------------------

	/**
	 * restore
	 *
	 * Method for restoring the selected soft-deleted user.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function restore($id = 0)
	{
		// Default response header status code.
		$this->response->header = 409;

		// Did we provide a valid $id?
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// The user cannot restore his/her own account.
		if ($id == $this->c_user->id)
		{
			$this->response->header  = 405;
			$this->response->message = lang('us_admin_restore_error_own');
			return;
		}

		// We attempt to restore the user.
		if (false !== $this->kbcore->users->restore($id))
		{
			$this->response->header  = 200;
			$this->response->message = lang('us_admin_restore_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_user_restore::'.$id);

			return;
		}

		// Otherwise, user could not be restored.
		$this->response->message = lang('us_admin_restore_error');
	}

	// --------------------------------------------------------------------

	/**
	 * remove
	 *
	 * Method for removing the selected user and all related data.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	AJAX_Controller::response().
	 */
	public function remove($id = 0)
	{
		// Default response header status code.
		$this->response->header = 409;

		// Did we provide a valid $id?
		if ( ! is_numeric($id) OR $id < 0)
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// The user cannot remove his/her own account.
		if ($id == $this->c_user->id)
		{
			$this->response->header  = 405;
			$this->response->message = lang('us_admin_remove_error_own');
			return;
		}

		// We attempt to remove the user.
		if (false !== $this->kbcore->users->remove($id))
		{
			$this->response->header  = 200;
			$this->response->message = lang('us_admin_remove_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_user_remove::'.$id);

			return;
		}

		// Otherwise, user could not be removed.
		$this->response->message = lang('us_admin_remove_error');
	}

}
