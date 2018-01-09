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
 * Bader_variabls Class
 *
 * Handles all operations done on site temporary variables.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraryes
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Bkader_variables extends CI_Driver
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		// Make sure to load entities model.
		$this->ci->load->model('bkader_variables_m');

		log_message('debug', 'Bkader_variables Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use variables model methods too.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_variables_m, $method))
		{
			return call_user_func_array(
				array($this->ci->bkader_variables_m, $method),
				$params
			);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a variable OR update it if it exists.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's guid.
	 * @param 	string 	$name 	the variable's name.
	 * @param 	mixed 	$value 	the variable's value.
	 * @return 	int if the variable is created, else false.
	 */
	public function create_or_update($guid, $name, $value = null)
	{
		$var = $this->ci->bkader_variables_m->get_by(array(
			'guid' => $guid,
			'name' => $name,
		));

		// Exists and same value? Nothing to do.
		if ($var && $var->value === $value)
		{
			return true;
		}

		// Exists? update it.
		if ($var)
		{
			return $this->ci->bkader_variables_m->update($var->id, array('value' => $value));
		}

		return $this->ci->bkader_variables_m->insert(array(
			'guid'  => $guid,
			'name'  => $name,
			'value' => $value,
		));
	}

}
