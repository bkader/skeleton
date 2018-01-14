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
	 * Get all autoloaded options from database and assign
	 * them to CodeIgniter config array.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function initialize()
	{
		// Assign all options to config.
		foreach ($this->get_many() as $row)
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
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$value 		the option's value.
	 * @param 	string 	$tab 		Where the option should be listed.
	 * @param 	string 	$field_type What type of filed input to display
	 * @param 	mixed 	$options 	Options to display on settings page.
	 * @param 	bool 	$required 	Whether to make the field required.
	 * @return 	bool
	 */
	public function create(
		$name, 
		$value = null, 
		$tab = '', 
		$field_type = 'text', 
		$options = null, 
		$required = true)
	{
		$this->ci->db->insert('options', array(
			'name'       => strtolower($name),
			'value'      => to_bool_or_serialize($value),
			'tab'        => $tab,
			'field_type' => $field_type,
			'options'    => to_bool_or_serialize($options),
			'required'   => ($required === true) ? 1 : 0,
		));

		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single option item by it's name.
	 * @access 	public
	 * @param 	mixed 	$name 	string|string[]
	 * @return 	boolean
	 */
	public function delete($name)
	{
		return $this->delete_by('name', $name);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple options by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// Arguments provided?
		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->ci->db->where($field);
			}
			elseif (is_array($match))
			{
				$this->ci->db->where_in($field, $match);
			}
			else
			{
				$this->ci->db->where($field, $match);
			}
		}

		// Proceed to deleting.
		$this->ci->db->delete('options');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update an option item if it exists or create it if it does not.
	 * @access 	public
	 * @param 	string 	$name 		the item name.
	 * @param 	mixed 	$new_value 	the new value.
	 * @return 	bool
	 */
	public function set_item($name, $new_value = null)
	{
		// Not found? Create it.
		if ( ! $this->item($name, false))
		{
			return $this->create($name, $new_value);
		}

		// Found? update it.
		$this->ci->db
			->where('LOWER(name)', strtolower($name))
			->set('value', to_bool_or_serialize($new_value));

		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single option item by it's name (primary key)
	 * @access 	public
	 * @param 	string 	$name 	The item's name.
	 * @return 	object if found, else null
	 */
	public function get($name)
	{
		$row = $this->ci->db
			->where('LOWER(name)', strtolower($name))
			->get('options')
			->row();

		// Found? cache it then return it.
		if ($row)
		{
			$row->value = from_bool_or_serialize($row->value);
			$this->cached[$name] = $row->value;
		}

		return $row;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple options by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null)
	{
		// Arguments passed?
		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->ci->db->where($field);
			}
			elseif (is_array($match))
			{
				$this->ci->db->where_in($field, $match);
			}
			else
			{
				$this->ci->db->where($field, $match);
			}
		}

		$rows = $this->ci->db->get('options')->result();

		// Found any? Format them.
		if ($rows)
		{
			foreach ($rows as &$row)
			{
				(empty($row->value)) OR $row->value = from_bool_or_serialize($row->value);
				(empty($row->options)) OR $row->options = from_bool_or_serialize($row->options);
			}
		}

		// Return the final result.
		return $rows;
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

		// Try to get it.
		if ($item = $this->get($name))
		{
			return $item->value;
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
		return $this->get_many('tab', $tab);
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

// ------------------------------------------------------------------------

if ( ! function_exists('get_options'))
{
	/**
	 * Retrieve multiple options by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	array of objects if found, else null.
	 */
	function get_options($field = null, $match = null)
	{
		return get_instance()->app->options->get_many($field, $match);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_option'))
{
	/**
	 * Create a new option item.
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$value 		the option's value.
	 * @param 	string 	$tab 		Where the option should be listed.
	 * @param 	string 	$field_type What type of filed input to display
	 * @param 	mixed 	$options 	Options to display on settings page.
	 * @param 	bool 	$required 	Whether to make the field required.
	 * @return 	bool
	 */
	function add_option(
		$name, 
		$value = null, 
		$tab = '', 
		$field_type = 'text', 
		$options = null, 
		$required = true)
	{
		return get_instance()->app->options->create($name, $value, $tab, $field_type, $options, $required);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_option'))
{
	/**
	 * Update a single option item if found, else creates it.
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

// ------------------------------------------------------------------------

if ( ! function_exists('delete_option_by'))
{
	/**
	 * Delete a single or multiple options by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_option_by($field, $match = null)
	{
		return get_instance()->app->options->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_options'))
{
	// Alias of the function above.
	function delete_options($field, $match = null)
	{
		return get_instance()->app->options->delete_by($field, $match);
	}
}
