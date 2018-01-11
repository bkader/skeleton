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
 * Bkader_options Class
 *
 * Handles all operations done on options stored in database.
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
class Bkader_options extends CI_Driver
{
	/**
	 * Array of cached options to reduce DB access.
	 * @var array
	 */
	private $cached;

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use options model methods as well.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	array or method arguments.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_options_m, $method))
		{
			return call_user_func_array(array($this->ci->bkader_options_m, $method), $params);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all autoloaded options from database and assign
	 * them to CodeIgniter config array.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function initialize()
	{
		// Make sure to load options model.
		$this->ci->load->model('bkader_options_m');

		// Get all options from database.
		$rows = $this->ci->bkader_options_m->get_all();

		foreach ($rows as $row)
		{
			// Cache them first.
			$this->cached[$row->name] = $row->value;

			// Assign them to config array.
			$this->ci->config->set_item($row->name, $row->value);
		}

		log_message('info', 'Bkader_options Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new option item.
	 * @access 	public
	 * @param 	string 	$name 	the option's name.
	 * @param 	mixed 	$value 	the option's value.
	 * @return 	bool
	 */
	public function create($name, $value = null)
	{
		$this->ci->bkader_options_m->insert(array(
			'name'  => $name,
			'value' => $value,
		));

		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update an option item if it exists.
	 * @access 	public
	 * @param 	string 	$name 		the item name.
	 * @param 	mixed 	$new_value 	the new value.
	 * @return 	bool
	 */
	public function set_item($name, $new_value = null)
	{
		return $this->ci->bkader_options_m->update($name, array('value' => $new_value));
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single option item from cached array if found,
	 * then database then config array.
	 * @access 	public
	 * @param 	string 	$name
	 * @param 	mixed 	$default 	the default value to use if not found.
	 * @return 	mixed 	depends on the item's value
	 */
	public function item($name, $default = false)
	{
		// Cached? Get it.
		if (isset($this->cached[$name]))
		{
			return $this->cached[$name];
		}

		// Attempt to get it from database.
		$row = $this->ci->bkader_options_m->get($name);

		// Found? Return it.
		if ($row)
		{
			return $row->value;
		}

		// Found in CodeIgniter config?
		if ($item = $this->ci->config->item($name))
		{
			// Cached it first.
			$this->cached[$name] = $item;
			return $item;
		}

		return $default;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all options by tab.
	 * @access 	public
	 * @param 	string 	$tab 	default: general
	 */
	public function get_by_tab($tab = 'general')
	{
		return $this->ci->bkader_options_m->get_many_by('tab', $tab);
	}

}

// --------------------------------------------------------------------

if ( ! function_exists('get_option'))
{
	/**
	 * Retrieve a single option item.
	 * @param 	string 	$name 	 	the option's name.
	 * @param 	mixed 	$default 	the default value to use.
	 * @return 	mixed 	depends on the option.
	 */
	function get_option($name, $default = false)
	{
		return get_instance()->app->options->item($name, $default);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_option'))
{
	/**
	 * Create a new option item.
	 * @param 	string 	$name 	the option's name.
	 * @param 	mixed 	$value 	the option's value.
	 * @return 	bool
	 */
	function add_option($name, $value = null)
	{
		return get_instance()->app->options->create($name, $value);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_option'))
{
	/**
	 * Update a single option item.
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$new_value 	the new option value.
	 * @return 	bool
	 */
	function set_option($name, $new_value = null)
	{
		return get_instance()->app->options->set_item($name, $new_value);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('delete_option'))
{
	/**
	 * Delete a single option item from database.
	 * @param 	string 	$name 	the option name.
	 * @return 	bool
	 */
	function delete_option($name)
	{
		return get_instance()->app->options->delete($name);
	}
}
