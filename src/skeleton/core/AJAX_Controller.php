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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AJAX_Controller Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */
class AJAX_Controller extends KB_Controller
{
	/**
	 * Array of methods that require a logged-in user and
	 * a safe URL with check.
	 * @var array
	 */
	protected $safe_methods = array();

	/**
	 * Array of methods that require a logged-in user of rank admin.
	 * @var array
	 */
	protected $admin_methods = array();

	/**
	 * Array of methods that require a logged-in user of rank admin and
	 * a safe URL check.
	 * @var array
	 */
	protected $safe_admin_methods = array();

	/**
	 * Used by AJAX methods to hold response details.
	 * @var object
	 */
	protected $response;

	// ------------------------------------------------------------------------

	/**
	 * Class constructor.
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We make sure the request is AJAX.
		if ( ! $this->input->is_ajax_request())
		{
			show_404();
		}

		// Prepare $response property object.
		$this->response          = new stdClass();
		$this->response->header  = 400;
		$this->response->type    = 'json';
		$this->response->message = 'Bad Request';
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for catching called methods to check safety and integrity.
	 * @access 	public
	 * @param 	string 	$method 	The requested method.
	 * @param 	array 	$params 	Arguments to pass to the method.
	 * @return 	AJAX_Controller::response().
	 */
	public function _remap($method, $params = array())
	{
		// The method does not exist?
		if ( ! method_exists($this, $method))
		{
			$this->response->header  = 401;
			return $this->response();
		}

		/**
		 * If the method is present in both $safe_methods and 
		 * $admin_methods array we make sure to automatically 
		 * add it to $safe_admin_methods array.
		 */
		if (in_array($method, $this->safe_methods) 
			&& in_array($method, $this->admin_methods))
		{
			array_push($this->safe_admin_methods, $method);
		}

		// Does the requested methods require a safety check?
		if (in_array($method, $this->safe_methods) 
			&& ( ! check_safe_url() OR true !== $this->auth->online()))
		{
			$this->response->header  = 401;
			$this->response->message = lang('error_action_permission');
		}

		// Does the method require an admin user?
		elseif (in_array($method, $this->admin_methods) 
			&& true !== $this->auth->is_admin())
		{
			$this->response->header  = 401;
			$this->response->message = lang('error_action_permission');
		}

		// Does the method require an admin user AND a safety check?
		elseif (in_array($method, $this->safe_admin_methods) 
			&& ( ! check_safe_url() OR true !== $this->auth->is_admin()))
		{
			$this->response->header  = 401;
			$this->response->message = lang('error_action_permission');
		}
		// Otherwise, call the method.
		else
		{
			call_user_func_array(array($this, $method), $params);
		}

		// Always return the final response.
		return $this->response();
	}

	// ------------------------------------------------------------------------

	/**
	 * This method handles the rest of AJAX requests.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	protected function response()
	{
		/**
		 * Disable parsing of the {elapsed_time} and {memory_usage}
		 * pseudo-variables because we don't need them.
		 */
		$this->output->parse_exec_vars = false;

		// Make sure to always have a message and content type.
		(isset($this->response->message)) OR $this->response->message = 'Bad Request';
		(isset($this->response->type)) OR $this->response->type = 'json';

		// Make sure to json_encode message if using JSON.
		if ($this->response->type === 'json')
		{
			$this->response->message = json_encode($this->response->message);
		}

		// Return the final output.
		return $this->output
			->set_content_type($this->response->type)
			->set_status_header($this->response->header)
			->set_output($this->response->message);
	}

}
