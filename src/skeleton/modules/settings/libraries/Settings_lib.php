<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Module - Settings Library
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Settings_lib
{
	/**
	 * Instance of CI object.
	 * @var object
	 */
	private $ci;

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		$this->ci =& get_instance();
	}

	// ------------------------------------------------------------------------

	public function update_profile($user_id, array $data = array())
	{
		if (empty($user_id) OR empty($data))
		{
			set_alert(__('error_fields_required'), 'error');
			return false;
		}

		$status = $this->ci->app->users->update($user_id, $data);

		if ($status === true)
		{
			set_alert(__('set_profile_success'), 'success');

			// Log the activity.
			log_activity($user_id, 'updated profile');
		}
		else
		{
			set_alert(__('set_profile_error'), 'error');
		}

		return $status;
	}

}
