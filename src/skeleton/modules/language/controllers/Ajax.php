<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Ajax_Controller
{
	public function __construct()
	{
		$this->secured = false;
		parent::__construct();
	}

	public function translate()
	{
		$line = $this->input->post('line');
		if (empty($line))
		{
			return;
		}

		$file = $this->input->post('file');
		(empty($file)) OR $this->load->language($file);

		$this->response->header = 200;
		$this->response->message = $this->lang->line($line);
	}
}
