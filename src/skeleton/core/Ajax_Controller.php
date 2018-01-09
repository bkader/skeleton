<?php
defined('BASEPATH') OR exit('No direct script access allowed');
defined('DOING_AJAX') OR define('DOING_AJAX', true);

/**
 * Ajax_Controller Class
 *
 * Controllers extending this class accept only AJAX requests.
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Ajax_Controller extends KB_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		/**
		 * Here we make sure that the controller accepts only
		 * AJAX requests and the parameter 'action' is set.
		 */
		if ( ! $this->input->is_ajax_request() OR empty($_REQUEST['action']))
		{
			show_error('0', 400);
		}
	}
}
