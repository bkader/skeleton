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
 * Bkader_activities Class
 *
 * Handles all operations done on site's activities and logs.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Bkader_activities extends CI_Driver
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		// Make sure to load activities model.
		$this->ci->load->model('bkader_activities_m');

		log_message('info', 'Bkader_activities Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Magic __call method to use activities model methods too.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_activities_m, $method))
		{
			return call_user_func_array(
				array($this->ci->bkader_activities_m, $method),
				$params
			);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
	}

	// --------------------------------------------------------------------

	/**
	 * Quick access to log activity.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @param 	string 	$activity
	 * @param 	string 	$controller 	the controller details
	 * @return 	int 	the activity id.
	 */
	public function log_activity($user_id, $activity)
	{
		if (empty($user_id) OR empty($activity))
		{
			return false;
		}

		return $this->ci->bkader_activities_m->insert(array(
			'user_id'    => $user_id,
			'module'     => $this->ci->router->fetch_module(),
			'controller' => $this->ci->router->fetch_class(),
			'method'     => $this->ci->router->fetch_method(),
			'activity'   => strval($activity),
			'ip_address' => $this->ci->input->ip_address(),
		));
	}

}

// --------------------------------------------------------------------

if ( ! function_exists('log_activity'))
{
	/**
	 * Log user's activity.
	 * @param 	int 	$user_id
	 * @param 	string 	$activity
	 * @return 	int 	the activity id.
	 */
	function log_activity($user_id, $activity)
	{
		return get_instance()->app->activities->log_activity($user_id, $activity);
	}
}
