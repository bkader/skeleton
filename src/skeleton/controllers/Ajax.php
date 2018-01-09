<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Ajax Controller
 *
 * @package 	CodeIgniter
 * @category 	Controllers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Ajax extends Ajax_Controller
{
	/**
	 * This method is here to avoid error 404
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		show_error('Looking for something?', 400);
	}

}
