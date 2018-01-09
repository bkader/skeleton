<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_Controller Class
 *
 * Controllers extending this class require a logged in user.
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class User_Controller extends KB_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// The user must be logged in.
		if ( ! $this->auth->online())
		{
			set_alert(__('error_logged_out'), 'error');
			redirect('login?next='.rawurlencode(uri_string()),'refresh');
			exit;
		}
	}

}
