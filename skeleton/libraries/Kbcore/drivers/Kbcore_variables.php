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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Kbcore_variables extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_variables Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new variable
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new row ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// Make sure
		if (empty($data))
		{
			return false;
		}

		// Make sure both guid and name are set.
		if ( ! isset($data['guid']) OR ! isset($data['name']))
		{
			return false;
		}

		// See if the variables exists already.
		$var = $this->get_by(array(
			'guid' => $data['guid'],
			'name' => $data['name'],
		));

		// Found? Cannot create it.
		if ($var)
		{
			return false;
		}

		// Make sure params are set.
		(isset($data['params'])) OR $data['params'] = null;

		$this->ci->db->insert('variables', array(
			'guid'       => $data['guid'],
			'name'       => strtolower($data['name']),
			'value'      => to_bool_or_serialize($data['value']),
			'params'     => to_bool_or_serialize($data['params']),
			'created_at' => time(),
		));

		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single variable by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to user "get_by" method.
	 * 
	 * @access 	public
	 * @param 	int 	$id 	The variable's ID.
	 * @return 	mixed.
	 */
	public function get($id)
	{
		// Getting by ID?
		if (is_numeric($id))
		{
			return $this->get_by('id', $id);
		}

		// Otherwise, let "get_by" method handle the rest.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single variable by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent generate the WHERE clause
	 *         			and create KB_Variable object.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	The column name or array.
	 * @param 	mixed 	$match 	It can be anything.
	 * @return 	mixed.
	 */
	public function get_by($field, $match = null)
	{
		// We start with empty $variable.
		$variable = false;

		// Attempt to get the variable from database.
		$db_variable = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('id', 'DESC')
			->get('variables')
			->row();

		// If found, create its object.
		if ($db_variable)
		{
			$variable = new KB_Variable($db_variable);
		}

		// Return the final result.
		return $variable;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple or all variables from database.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent generate the WHERE clause and
	 *         			to create KB_Variable objects for found variables.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Null, string or associative array.
	 * @param 	mixed 	$match 	It can be anything.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We start with empty variables.
		$variables = false;

		// Attempt to get variables from database.
		$db_variables = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('variables')
			->result();

		// If found any, create their objects.
		if ($db_variables)
		{
			foreach ($db_variables as $variable)
			{
				$variables[] = new KB_Variable($variable);
			}
		}

		// Return the final result.
		return $variables;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all variables.
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
	 * This method is used in order to search variables table.
	 *
	 * @since 	1.3.2
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	mixed 	array of objects if found any, else false.
	 */
	public function find($field, $match = null, $limit = 0, $offset = 0)
	{
		// We start with empty variables
		$variables = false;

		// Attempt to find variables.
		$db_variables = $this->_parent
			->find($field, $match, $limit, $offset)
			->get('variables')
			->result();

		// If we found any, we create their objects.
		if ($db_variables)
		{
			foreach ($db_variables as $db_variable)
			{
				$variables[] = new KB_Variable($db_variable);
			}
		}

		// Return the final result.
		return $variables;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single variable by its primary key.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The variable's ID or array of WHERE clause.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	bool
	 */
	public function update($id, array $data = array())
	{
		// Updating by ID?
		if (is_numeric($id))
		{
			return $this->update_by(array('id' => $id), $data);
		}

		// Otherwise, let "update_by" handle the rest.
		return $this->update_by($id, $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple variables.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @return 	bool
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

			// Generate the WHERE clause.
			$this->_parent->where($args);
		}

		// Proceed to update an return TRUE if all went good.
		$this->ci->db->update('variables');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single variable by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * @access 	public
	 * @param 	int 	$id 	The variable's ID or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete($id)
	{
		// Deleting by ID?
		if (is_numeric($id))
		{
			return $this->delete_by('id', $id);
		}

		// Otherwise, let "delete_by" method handle the rest.
		return $this->delete_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple variables by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause and
	 *         			add optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The value of comparison.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's delete them.
		$this->_parent
			->where($field, $match, $limit, $offset)
			->delete('variables');

		// Return true if rows were affected.
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a single variable.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "create" method.
	 * 
	 * @access 	public
	 * @param 	int 	$guid 		The entity's ID.
	 * @param 	string 	$name 		The variable's name.
	 * @param 	string 	$value 		The variable's value.
	 * @param 	string 	$params 	Variable's params.
	 * @return 	bool
	 */
	public function add_var($guid, $name, $value = null, $params = null)
	{
		return $this->create(array(
			'guid'   => $guid,
			'name'   => $name,
			'value'  => $value,
			'params' => $params,
		));
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
	public function set_var($guid, $name, $value = null, $params = null)
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
		if ($var)
		{
			return $this->update($var->id, array(
				'value'  => $value,
				'params' => $params,
			));
		}

		return $this->create(array(
			'guid'   => $guid,
			'name'   => $name,
			'value'  => $value,
			'params' => $params,
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all variables.
	 *
	 * @since 	1.3.0
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	public function count($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We run the query now.
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('variables');

		// We return the count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete all variables of which the entity no longer exist.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Adding optional limit and offset.
	 * 
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function purge($limit = 0, $offset = 0)
	{
		// We first collect entities IDs.
		$ids = $this->_parent->entities->get_ids();

		// Now we use the "delete_by" method.
		return $this->delete_by('!guid', $ids);
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
	 * @return 	bool
	 */
	function add_var($guid, $name, $value = null, $params = null)
	{
		return get_instance()->kbcore->variables->add_var($guid, $name, $value, $params);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_var'))
{
	/**
	 * Update a single variable by it's ID.
	 * @param 	mixed 	$id 	The variable's ID.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	bool
	 */
	function update_var($id, array $data = array())
	{
		return get_instance()->kbcore->variables->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_var_by'))
{
	/**
	 * Update a single or multiple variables by arbitrary WHERE clause.
	 * @param 	mixed
	 * @return 	bool
	 */
	function update_var_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->variables, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_vars'))
{
	/**
	 * Update a single or multiple variables by arbitrary WHERE clause.
	 * @param 	mixed
	 * @return 	bool
	 */
	function update_vars()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->variables, 'update_by'),
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
		return get_instance()->kbcore->variables->set_var($guid, $name, $value, $params);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_var'))
{
	/**
	 * Delete a single variable by its ID.
	 * @param 	int 	$id 	The variable's ID.
	 * @return 	bool
	 */
	function delete_var($id)
	{
		return get_instance()->kbcore->variables->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_var_by'))
{
	/**
	 * Delete a single or multiple variables by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The value of comparison.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_var_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_vars'))
{
	/**
	 * Delete a single or multiple variables by arbitrary WHERE clause.
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The value of comparison.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_vars($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->delete_by($field, $match, $limit, $offset);
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
		// We get the variable.
		$var = get_instance()->kbcore->variables->get($id, $single);

		// Return only the value?
		if ($var && $single === true)
		{
			return $var->value;
		}

		return $var;
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
		return get_instance()->kbcore->variables->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_vars'))
{
	/**
	 * Retrieve multiple variables by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field 	The column or associative array.
	 * @param 	mixed 	$match 	The comparison value.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function get_vars($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_variables'))
{
	/**
	 * This function is used in order to search variables.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of variables if found, else null.
	 */
	function find_variables($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('variable_exists'))
{
	/**
	 * Checks the existence of a variable.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	string 	$name 	The variable name.
	 * @return 	bool 	true if the variable exists, else false.
	 */
	function variable_exists($guid, $name)
	{
		return (get_var_by(array('guid' => $guid, 'name' => $name)) !== null);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_vars'))
{
	/**
	 * Count all variables on database with arbitrary WHERE clause.
	 *
	 * @since 	1.3.0
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	function count_vars($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_vars'))
{
	/**
	 * Delete all variables of which the entity no longer exist.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_vars($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->variables->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Variable
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Variable
{
	/**
	 * Variable data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The variable's ID.
	 * @var 	integer
	 */
	public $id = 0;

	/**
	 * Array of data awaiting to be updated.
	 * @var 	array
	 */
	protected $queue = array();
	
	/**
	 * Constructor.
	 *
	 * Retrieves the variable data and passes it to KB_Variable::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Variable's ID or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Variable) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$variable = get_variable($id);
			if ($variable) {
				$this->init($variable->data);
			} else {
				$this->data = new stdClass();
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets up object properties.
	 * @access 	public
	 * @param 	object
	 */
	public function init($variable) {
		$this->data = $variable;
		$this->id   = (int) $variable->id;

		// Format value and params.
		$this->data->value  = from_bool_or_serialize($variable->value);
		$this->data->params = from_bool_or_serialize($variable->params);
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for checking the existence of a property.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 * @return 	bool 	true if the property exists, else false.
	 */
	public function __isset($key) {
		// Just make it possible to use ID.
		if ('ID' == $key) {
			$key = 'id';
		}

		// Found in $data container or as object property?
		return (isset($this->data->{$key}) OR isset($this->{$key}));
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for getting a property value.
	 * @access 	public
	 * @param 	string 	$key 	The property key to retrieve.
	 * @return 	mixed 	Depends on the property value.
	 */
	public function __get($key) {
		// We start with an empty value.
		$value = false;

		// Is if found in $data object?
		if (isset($this->data->{$key})) {
			$value = $this->data->{$key};
		}

		// Then we return the final result.
		return $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for setting a property value.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 * @param 	mixed 	$value 	The property value.
	 */
	public function __set($key, $value) {
		// Just make it possible to use ID.
		if ('ID' == $key) {
			$key = 'id';
		}

		// If found, we make sure to set it.
		$this->data->{$key} = $value;

		// We enqueue it for later use.
		$this->queue[$key]  = $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for unsetting a property.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 */
	public function __unset($key) {
		// Remove it from $data object.
		if (isset($this->data->{$key})) {
			unset($this->data->{$key});
		}

		// We remove it if queued.
		if (isset($this->queue[$key])) {
			unset($this->queue[$key]);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for checking the existence of an variable in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the variable exists, else false.
	 */
	public function exists() {
		return ( ! empty($this->id));
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for checking the existence of a property.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 * @return 	bool 	true if the property exists, else false.
	 */
	public function has($key) {
		return $this->__isset($key);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array representation of this object data.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @return 	array
	 */
	public function to_array() {
		return get_object_vars($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for setting a property value.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 * @param 	string 	$value 	The property value.
	 * @return 	object 	we return the object to make it chainable.
	 */
	public function set($key, $value) {
		$this->__set($key, $value);
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for getting a property value.
	 * @access 	public
	 * @param 	string 	$key 	The property key.
	 * @return 	mixed 	Depends on the property's value.
	 */
	public function get($key) {
		return $this->__get($key);
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for updating the variable in database.
	 *
	 * @since 	1.3.0
	 * @since 	1.4.0 	$value can be null if $key is an array
	 * 
	 * @access 	public
	 * @param 	string 	$key 	The field name.
	 * @param 	mixed 	$value 	The field value.
	 * @return 	bool 	true if updated, else false.
	 */
	public function update($key, $value = null) {
		// We make sure things are an array.
		$data = (is_array($key)) ? $key : array($key => $value);

		// Keep the status in order to dequeue the key.
		$status = update_var($this->id, $data);

		if ($status === true) {
			foreach ($data as $k => $v) {
				if (isset($this->queue[$k])) {
					unset($this->queue[$k]);
				}
			}
		}

		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for saving anything changes.
	 * @access 	public
	 * @param 	void
	 * @return 	bool 	true if updated, else false.
	 */
	public function save() {
		// We start if false status.
		$status = false;

		// If there are enqueued changes, apply them.
		if ( ! empty($this->queue)) {
			$status = update_var($this->id, $this->queue);

			// If the update was successful, we reset $queue array.
			if ($status === true) {
				$this->queue = array();
			}
		}

		// We return the final status.
		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for retrieving the array of data waiting to be saved.
	 * @access 	public
	 * @return 	array
	 */
	public function dirty() {
		return $this->queue;
	}

}
