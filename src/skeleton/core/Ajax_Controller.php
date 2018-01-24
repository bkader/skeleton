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
defined('DOING_AJAX') OR define('DOING_AJAX', true);

/**
 * Ajax_Controller Class
 *
 * Controllers extending this class accept only AJAX requests.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Ajax_Controller extends KB_Controller
{
	/**
	 * Array of allowed GET request action.
	 * @var array
	 */
	protected $actions_get = array();

	/**
	 * Array of allowed POST request action.
	 * @var array
	 */
	protected $actions_post = array();

	/**
	 * Default response.
	 * @var object
	 */
	protected $response;

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->response = new stdClass();
		$this->response->status = false;
		$this->response->message = null;

		// We make sure that the controller accepts only AJAX requests.
		// if ( ! $this->input->is_ajax_request())
		// {
		// 	show_404();
		// }

		/**
		 * Disable parsing of the {elapsed_time} and {memory_usage} 
		 * pseudo-variables because we don't need them.
		 */
		$this->output->parse_exec_vars = FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Remapping all method so they always return the response.
	 * @access 	public
	 * @param 	string 	$method 	The called method.
	 * @param 	array 	$params 	 Arguments to pass to method.
	 * @return 	void
	 */
	public function _remap($method, $params = array())
	{
		/**
		 * Here we make sure the action is provided and the 
		 * method to call exists.
		 */
		if ( ! $this->input->request('action') 
			OR ! method_exists($this, $method))
		{
			$this->response->status = false;
			$this->response->message = 'Bad Request';
			return $this->response();
		}

		// We now compare the request method to allowed actions.
		$_action = $this->input->request('action');
		$_method = $this->input->server('REQUEST_METHOD');

		if (($_method == 'GET' && ! in_array($_action, $this->actions_get)) 
			OR ($_method == 'POST' && ! in_array($_action, $this->actions_post)))
		{
			$this->response->status = false;
			$this->response->message = 'Bad Request';
			return $this->response();
		}

		// We first check the authenticity of the safe URL.
		if ( ! check_safe_url())
		{
			$this->response->message = lang('error_safe_url');
		}

		// Call the method.
		call_user_func_array(array($this, $method), $params);
		return $this->response();
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the response.
	 * @access 	protected
	 * @return 	void
	 */
	protected function response()
	{
		if ((isset($this->response->status) && $this->response->status === false) 
			&& ! isset($this->response->message))
		{
			$this->response->message = 'Bad Request';
		}

		// Proceed to output.
		return $this->output
			->set_content_type('json')
			->set_output(json_encode($this->response));
	}

}
