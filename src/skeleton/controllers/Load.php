<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends KB_Controller
{
	public function index()
	{
		echo 'load index';
	}

	public function styles()
	{
		// Files to load.
		$files = $this->input->get('load');
		if (empty($files))
		{
			die();
		}

		// Explode files.
		$files = array_map('trim', explode(',', $files));

		// Compress?
		$compress = ($this->input->get('c') == '1');

		// Set header.
		header('content-type: text/css');
		ob_start('ob_gzhandler');
		header('Cache-Control: max-age=31536000, must-revalidate');

		// Prepare output.
		$output = "/*! This file is auto-generated */\n";

		foreach ($files as $file)
		{
			$file = ($compress === true) ? $file.'.min' : $file;
			$output .= @file_get_contents(base_url("content/common/css/{$file}.css"));
		}
		echo $output;
		die();
	}

	public function scripts()
	{
		// Files to load.
		$files = $this->input->get('load');
		if (empty($files))
		{
			die();
		}

		// Explode files.
		$files = array_map('trim', explode(',', $files));

		// Compress?
		$compress = ($this->input->get('c') == '1');

		// Set header.
		header('content-type: text/javascripts');
		ob_start('ob_gzhandler');
		header('Cache-Control: max-age=31536000, must-revalidate');

		// Prepare output.
		$output = "/*! This file is auto-generated */\n";

		foreach ($files as $file)
		{
			$file = ($compress === true) ? $file.'.min' : $file;
			$output .= @file_get_contents(base_url("content/common/js/{$file}.js"));
		}
		echo $output;
		die();
	}
}

/* End of file Load.php */
/* Location: ./application/controllers/Load.php */
