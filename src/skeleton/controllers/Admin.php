<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Admin Controller
 *
 * @package 	CodeIgniter
 * @category 	Controllers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Admin extends Admin_Controller
{
	/**
	 * Main admin panel page.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		$data['count_users'] = $this->app->users->count_all();
		$this->theme
			->set_title(__('admin_panel'))
			->render($data);
	}
}
