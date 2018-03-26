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
 * Kbcore_options Class
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
class Kbcore_options extends CI_Driver implements CRUD_interface
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

		log_message('info', 'Kbcore_options Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new options.
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new row ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// If $data is empty, nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Make sure the name is set and unique.
		if ( ! isset($data['name']) OR $this->get_by('name', $data['name']))
		{
			return false;
		}

		/**
		 * Here we make sure to prepare "value" and "options" if they
		 * are set and not empty.
		 */
		if (isset($data['value']) && ! empty($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}
		if (isset($data['options']) && ! empty($data['options']))
		{
			$data['options'] = to_bool_or_serialize($data['options']);
		}

		// Insert the option into database.
		$this->ci->db->insert('options', $data);
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single row by it's primary ID.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @return 	object if found, else null
	 */
	public function get($id)
	{
		return $this->get_by('name', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single option by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Make everything as an array.
		(is_array($field)) OR $field = array($field => $match);

		foreach ($field as $key => $val)
		{
			if (is_int($key) && is_array($val))
			{
				$this->ci->db->where($val);
			}
			elseif (is_array($val))
			{
				$this->ci->db->where_in($key, $val);
			}
			else
			{
				$this->ci->db->where($key, $val);
			}
		}

		$row = $this->ci->db->get('options')->row();

		// If the row is found, format it.
		if ($row)
		{
			// Prepare the "value" and "options".
			$row->value = from_bool_or_serialize($row->value);
			(empty($row->options)) OR $row->options = from_bool_or_serialize($row->options);

			// Cache the item for eventual use.
			$this->cached[$row->name] = $row->value;
		}

		return $row;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple options by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Prepare WHERE clause.
		if ( ! empty($field))
		{
			(is_array($field)) OR $field = array($field => $match);

			foreach ($field as $key => $val)
			{
				if (is_int($key) && is_array($val))
				{
					$this->ci->db->where($val);
				}
				elseif (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		// Apply limits?
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		// Attempt to retrieve all options.
		$rows = $this->ci->db->get('options')->result();

		// If we found any, format their values and options columns
		if ($rows)
		{
			foreach ($rows as &$row)
			{
				$row->value = from_bool_or_serialize($row->value);
				$row->options = from_bool_or_serialize($row->options);

				// Cache items for eventual use.
				$this->cached[$row->name] = $row->value;
			}
		}

		// Return the final result.
		return $rows;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all options.
	 * @access 	public
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single options by its name.
	 * @access 	public
	 * @param 	mixed 	$id 	The option's name.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		return $this->update_by(array('name' => $id), $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single, all or multiple options by arbitrary WHERE clause.
	 * @access 	public
	 * @return 	boolean
	 */
	public function update_by()
	{
		// Collect function arguments and make sure there are some.
		$args = func_get_args();
		if (empty($args))
		{
			return false;
		}

		// The data is always the last array.
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// Format "value" and "options".
		if (isset($data['value']) && ! empty($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}
		if (isset($data['options']) && ! empty($data['options']))
		{
			$data['options'] = to_bool_or_serialize($data['options']);
		}

		// Prepare the update query.
		$this->ci->db->set($data);

		// All remaining arguments will be used as WHERE clause.
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			foreach ($args as $key => $val)
			{
				if (is_int($key) && is_array($val))
				{
					$this->ci->db->where($val);
				}
				elseif (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		// Proceed to update and return the status.
		$this->ci->db->update('options');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single option by its name.
	 * @access 	public
	 * @param 	mixed 	$id 	The option's name.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->delete_by('name', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single, all or multiple options by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// Prepare WHERE clause.
		if ( ! empty($field))
		{
			(is_array($field)) OR $field = array($field => $match);

			foreach ($field as $key => $val)
			{
				if (is_int($key) && is_array($val))
				{
					$this->ci->db->where($val);
				}
				elseif (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		// Proceed to delete.
		$this->ci->db->delete('options');
		return ($this->ci->db->affected_rows() > 0);
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
	public function add_item(
		$name,
		$value = null,
		$tab = '',
		$field_type = 'text',
		$options = '',
		$required = true)
	{
		return $this->create(array(
			'name'       => strtolower($name),
			'value'      => $value,
			'tab'        => $tab,
			'field_type' => $field_type,
			'options'    => $options,
			'required'   => ($required === true) ? 1 : 0,
		));
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
		if ( ! $this->get($name))
		{
			return $this->add_item($name, $new_value);
		}

		// Found? update it.
		return $this->update($name, array('value' => $new_value));
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

		// Return the fall-back value.
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
		return get_instance()->kbcore->options->item($name, $default);
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
		return get_instance()->kbcore->options->get_many($field, $match);
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
		$options = '',
		$required = true)
	{
		return get_instance()->kbcore->options->add_item($name, $value, $tab, $field_type, $options, $required);
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
		return get_instance()->kbcore->options->set_item($name, $new_value);
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
		return get_instance()->kbcore->options->delete($name);
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
		return get_instance()->kbcore->options->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_options'))
{
	// Alias of the function above.
	function delete_options($field, $match = null)
	{
		return get_instance()->kbcore->options->delete_by($field, $match);
	}
}
