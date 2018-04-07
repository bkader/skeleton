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
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Module - Language Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.2
 */
class Language extends KB_Controller
{
	/**
	 * Array of method that accept only AJAX requests.
	 * @var array
	 */
	protected $ajax_methods = array('line');

	/**
	 * Class constructor.
	 *
	 * @since 	1.3.2
	 *
	 * @access 	public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->language('language/language');
	}

	// ------------------------------------------------------------------------

	/**
	 * Switch site language.
	 * @access 	public
	 * @param 	string 	$folder The language's folder name.
	 * @return 	void
	 */
	public function switch($folder = null)
	{
		// Prepare redirection.
		$redirect = ($this->input->get_post('next'))
			? $this->input->get_post('next')
			: $this->input->referrer('/', true);

		// No language set? Nothing to do.
		if (empty($folder))
		{
			redirect($redirect);
			exit;
		}

		// Language not available? Nothing to do.
		if (in_array($folder, $this->config->item('languages')))
		{
			$this->session->set_userdata('language', $folder);
		}

		redirect($redirect);
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for getting language lines using AJAX.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.2 	Rewritten so it can be used.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function line()
	{
		// Should we load a file?
		if ($file = $this->input->post('file'))
		{
			$this->load->language($file);
		}

		// We make sure a line is requested.
		$line = $this->input->post('line');
		if (empty($line))
		{
			return;
		}

		// We set status code and translate the line.
		$this->response->header = 200;
		$this->response->message = $this->lang->line($line);
	}

}
