<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function index()
	{
		$this->load->view('test_view', array(
			'path' => 'application/modules/test/controllers/Test.php'
		));
	}
}
