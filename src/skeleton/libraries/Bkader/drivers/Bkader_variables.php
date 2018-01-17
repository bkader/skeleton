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
		log_message('info', 'Bkader_variables Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a single variable.
	 * @access 	public
	 * @param 	int 	$guid 		The entity's ID.
	 * @param 	string 	$name 		The variable's name.
	 * @param 	string 	$value 		The variable's value.
	 * @param 	string 	$params 	Variable's params.
	 * @return 	boolean
	 */
	public function create($guid, $name, $value = null, $params = null)
	{
		// We first make sure the entity exists!
		if ( ! $this->_parent->entities->get($guid))
		{
			return false;
		}

		// Let's check if the variable exists.
		$found = $this->get_by(array(
			'guid' => $guid,
			'name' => $name,
		));

		// Found? Nothing to do.
		if ($found)
		{
			return false;
		}

		// Attempt to insert the variable.
		$this->ci->db->insert('variables', array(
			'guid'       => $guid,
			'name'       => strtolower($name),
			'value'      => to_bool_or_serialize($value),
			'params'     => to_bool_or_serialize($params),
			'created_at' => time(),
		));

		// Return TRUE if the variable was created.
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single variable by its ID.
	 * @access 	public
	 * @param 	int 	$id 	The variable's ID.
	 * @param 	bool 	$single Whether to return the value.
	 * @return 	mixed.
	 */
	public function get($id, $single = false)
	{
		$var = $this->get_by('id', $id);

		if ($var && $single === true)
		{
			return $var->value;
		}

		return $var;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single variable by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	The column name or array.
	 * @param 	mixed 	$match 	It can be anything.
	 * @return 	mixed.
	 */
	public function get_by($field, $match = null)
	{
		// Prepare the where array.
		(is_array($field)) OR $field = array($field => $match);

		// Prepare everything so we can accepts arrays as value.
		foreach ($field as $key => &$val)
		{
			if ($key == 'value' OR $key == 'options')
			{
				$val = to_bool_or_serialize($val);
			}
		}

		$var = $this->ci->db
			->where($field)
			->get('variables')
			->row();

		if ($var)
		{
			// Let's first format the value.
			if ( ! empty($var->value))
			{
				$var->value = from_bool_or_serialize($var->value);
			}

			// Let's now format variable options.
			if ( ! empty($var->options))
			{
				$var->options = from_bool_or_serialize($var->options);
			}
		}

		return $var;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple or all variables from database.
	 * @access 	public
	 * @param 	mixed 	$field 	Null, string or associative array.
	 * @param 	mixed 	$match 	It can be anything.
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null)
	{
		// In case $field is an array, we use it as WHERE clause.
		if (is_array($field))
		{
			$this->ci->db->where($field);
		}
		/**
		 * In case $match is an array, we retrieve all variables
		 * where $field is in $match.
		 */
		elseif (is_array($match))
		{
			$this->ci->db->where_in($field, $match);
		}
		// Otherwise, use it as-is.
		elseif ( ! empty($field))
		{
			$this->ci->db->where($field, $match);
		}

		// Attempts to get variables from database.
		$vars = $this->ci->db->get('variables')->result();

		// Found any?
		if ($vars)
		{
			// Loop through variables to prepare them for output.
			foreach ($vars as &$var)
			{
				// Let's first format the value.
				if ( ! empty($var->value))
				{
					$var->value = from_bool_or_serialize($var->value);
				}

				// Let's now format variable options.
				if ( ! empty($var->options))
				{
					$var->options = from_bool_or_serialize($var->options);
				}
			}
		}

		// Return the final result.
		return $vars;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single variable by its ID.
	 * @access 	public
	 * @param 	int 	$id 	The variable's ID.
	 * @param 	mixed 	$value 	The variable's new value or array.
	 * @param 	mixed 	$params	Variable's new value or array.
	 * @return 	boolean
	 */
	public function update($id, $value = null, $params = null)
	{
		return $this->update_by(
			array('id' => $id),
			array('value' => $value, 'params' => $params)
		);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple variables.
	 * @access 	public
	 * @return 	boolean
	 *
	 * @example:
	 * $this->app->variables->update_by(
	 * 		array('guid' => 1, 'name' => 'var_name'),
	 *   	array(
	 *   		'value'  => 'new_value',
	 *   		'params' => 'new_params'
	 *   	)
	 * );
	 */
	public function update_by()
	{
		// Let's first collect method arguments.
		$args = func_get_args();

		// If there are not, nothing to do.
		if (empty($args))
		{
			return false;
		}

		/**
		 * Data to update is always the last argument
		 * and it must be an array.
		 */
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// Prepare the value and params.
		(isset($data['value'])) && $data['value'] = to_bool_or_serialize($data['value']);
		(isset($data['params'])) && $data['params'] = to_bool_or_serialize($data['params']);

		// Always add the update data.
		(isset($data['updated_at'])) OR $data['updated_at'] = time();

		// Prepare our query.
		$this->ci->db->set($data);

		// If there are any arguments left, they will use as WHERE clause.
		if ( ! empty($args))
		{
			// Get rid of nasty deep array.
			(is_array($args[0])) && $args = $args[0];

			// Add the WHERE clause.
			$this->ci->db->where($args);
		}

		// Proceed to update an return TRUE if all went good.
		$this->ci->db->update('variables');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single variable by its ID.
	 * @access 	public
	 * @param 	int 	$id 	The variable's ID.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->delete_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple variables by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The value of comparison.
	 * @return 	boolean
	 */
	public function delete_by($field, $match = null)
	{
		// We prepare our WHERE clause.
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

		// Proceed to deletion.
		$this->ci->db->delete('variables');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a variable OR update it if it exists.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's guid.
	 * @param 	string 	$name 	the variable's name.
	 * @param 	mixed 	$value 	the variable's value.
	 * @param 	mixed 	$params	Variable's params.
	 * @return 	true if the variable is created, else false.
	 */
	public function set($guid, $name, $value = null, $params = null)
	{
		$var = $this->get_by(array(
			'guid' => $guid,
			'name' => $name,
		));

		// Exists and same value AND params? Nothing to do.
		if ($var && ($var->value === $value && $var->params === $params))
		{
			return true;
		}

		// Exists? update it.
		return ($var)
			? $this->update($var->id, $value, $params)
			: $this->create($guid, $name, $value, $params);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete all variables of which the entity no longer exist.
	 * @access 	public
	 * @param 	none
	 * @return 	boolean
	 */
	public function purge()
	{
		$this->ci->db
			->where_not_in('guid', $this->_parent->entities->get_all_ids())
			->delete('variables');

		return ($this->ci->db->affected_rows() > 0);
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_var'))
{
	/**
	 * Create a new variable.
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	string 	$name 	The variable's name.
	 * @param 	string 	$value 	The variable's value.
	 * @param 	string 	$params	Variable's params.
	 * @return 	boolean
	 */
	function add_var($guid, $name, $value = null, $params = null)
	{
		return get_instance()->app->variables->create($guid, $name, $value, $params);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_var'))
{
	/**
	 * Update a single variable by it's ID.
	 * @param 	int 	$id 	The variable's ID.
	 * @param 	mixed 	$value 	The variable's value or associative array.
	 * @param 	mixed 	$params Variable's params (ignored if $value is an array)
	 * @return 	boolean
	 */
	function update_var($id, $value = null, $params = null)
	{
		return get_instance()->app->variables->update($id, $value, $params);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_var_by'))
{
	/**
	 * Update a single or multiple variables by arbitrary WHERE clause.
	 * @param 	mixed
	 * @return 	boolean
	 */
	function update_var_by()
	{
		return call_user_func_array(
			array(get_instance()->app->variables, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_var'))
{
	/**
	 * Create a variable OR update it if it exists.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's guid.
	 * @param 	string 	$name 	the variable's name.
	 * @param 	mixed 	$value 	the variable's value.
	 * @param 	mixed 	$params	Variable's params.
	 * @return 	true if the variable is created, else false.
	 */
	function set_var($guid, $name, $value = null, $params = null)
	{
		return get_instance()->app->variables->set($guid, $name, $value, $params);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_var'))
{
	/**
	 * Delete a single variable by its ID.
	 * @param 	int 	$id 	The variable's ID.
	 * @return 	boolean
	 */
	function delete_var($id)
	{
		return get_instance()->app->variables->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_var_by'))
{
	/**
	 * Delete a single or multiple variables by arbitrary WHERE clause.
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The value of comparison.
	 * @return 	boolean
	 */
	function delete_var_by($field, $match = null)
	{
		return get_instance()->app->variables->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_vars'))
{
	// This is an alias of the function above it.
	function delete_vars($field, $match = null)
	{
		return get_instance()->app->variables->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_var'))
{
	/**
	 * Retrieve a single variable by its ID.
	 * @param 	int 	$id 	The variable's ID.
	 * @param 	bool 	$single Whether to return only the value.
	 * @return 	mixed 	depends of the variable value.
	 */
	function get_var($id, $single = false)
	{
		return get_instance()->app->variables->get($id, $single);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_var_by'))
{
	/**
	 * Retrieve a SINGLE variable by arbitrary WHERE clause.
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The comparison value.
	 * @return 	object if found, else null.
	 */
	function get_var_by($field, $match = null)
	{
		return get_instance()->app->variables->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_vars'))
{
	/**
	 * Retrieve multiple variables by arbitrary WHERE clause.
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The comparison value.
	 * @return 	array of objects if found, else null.
	 */
	function get_vars($field, $match = null)
	{
		return get_instance()->app->variables->get_many($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_vars'))
{
	/**
	 * Delete all variables of which the entity no longer exist.
	 * @return 	boolean
	 */
	function purge_vars()
	{
		return get_instance()->app->variables->purge();
	}
}
