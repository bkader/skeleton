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
 * Kbcore_relations Class
 *
 * Handles all operations done on relationships between site entities.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Kbcore_relations extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_relations Class Initialized');
	}

    // ------------------------------------------------------------------------

    /**
     * Generates the SELECT portion of the query
     */
    public function select($select = '*', $escape = null)
    {
    	$this->ci->db->select($select, $escape);
    	return $this;
    }

	// ------------------------------------------------------------------------

	/**
	 * Return an array of relations table fields.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function fields()
	{
		if (isset($this->fields))
		{
			return $this->fields;
		}

		$this->fields = $this->ci->db->list_fields('relations');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a single or multiple relations
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten so that it returns the relation's ID if it
	 *         			exists instead of false.
	 *
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new row ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// Make sure we have data.
		if (empty($data))
		{
			return false;
		}

		// Multiple?
		if (isset($data[0]) && is_array($data[0]))
		{
			$ids = array();
			foreach ($data as $_data)
			{
				$ids[] = $this->create($_data);
			}

			return $ids;
		}

		// Check the integrity of $data.
		if (empty($data) OR ( ! isset($data['relation']) OR empty($data['relation'])))
		{
			return false;
		}

		// Make sure the relation does not already exist.
		$found = $this->get_by(array(
			'guid_from' => $data['guid_from'],
			'relation'  => $data['relation'],
			'guid_to'   => $data['guid_to'],
		));
		if ($found)
		{
			return $found->id;
		}

		// Add the date of creation.
		(isset($data['created_at'])) OR $data['created_at'] = time();

		$this->ci->db->insert('relations', $data);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single relation by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to user "get_by" method and remove the 
	 *         			$single argument.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 		The relation's ID.
	 * @return 	object if found, else null
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
	 * Retrieve a single relation by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance,
	 *         			to remove $single argument and let the parent handle
	 *         			generating the WHERE clause.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// We start with an empty $relation.
		$relation = false;

		// Attempt to get relation from database.
		$db_relation = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('id', 'DESC')
			->get('relations')
			->row();

		// If found, we create its object.
		if ($db_relation)
		{
			$relation = new KB_Relation($db_relation);
		}

		// Return the final result.
		return $relation;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple relations by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance
	 *         			and to let the parent handle generating the WHERE clause,
	 *         			then create KB_Relation objects if found any.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We start with empty $relations.
		$relations = false;

		// Attempt to get relations from database.
		$db_relations = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('relations')
			->result();

		// If found any, create their objects.
		if ($db_relations)
		{
			foreach ($db_relations as $relation)
			{
				$relations[] = new KB_Relation($relation);
			}
		}

		// Return the final result.
		return $relations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all relations.
	 * @access 	public
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * This method is used in order to search relations table.
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
		// We start with empty relations
		$relations = false;

		// Attempt to find relations.
		$db_relations = $this->_parent
			->find($field, $match, $limit, $offset)
			->get('relations')
			->result();

		// If we found any, we create their objects.
		if ($db_relations)
		{
			foreach ($db_relations as $db_relation)
			{
				$relations[] = new KB_Relation($db_relation);
			}
		}

		// Return the final result.
		return $relations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single relation by its primary key.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Update for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
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
	 * Update a single, all or multiple relations by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @return 	boolean
	 */
	public function update_by()
	{
		// Collect arguments first and make sure there are any.
		$args = func_get_args();
		if (empty($args))
		{
			return false;
		}

		// Data to update is always the last element.
		$data = array_pop($args);
		if (empty($data))
		{
			return false;
		}

		// Prepare out update query.
		$this->ci->db->set($data);

		// Get groups
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];

			// Generate where clause.
			$this->_parent->where($args);
		}

		// Proceed to update.
		return $this->ci->db->update('relations');
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single relation by its primary key.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The relation's ID or array of WHERE clause..
	 * @return 	boolean
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
	 * Delete a single, all or multiple relations by arbitrary WHER clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performace,
	 *         			to add optional limit and offset and let the parent
	 *         			handle generating the WHERE clause.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's attempt to delete relations.
		$this->_parent
			->where($field, $match, $limit, $offset)
			->delete('relations');

		// Return true if some rows were affected.
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Count relations.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance,
	 *         			add optional limit and offset and let the parent handle
	 *         			generating the WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	public function count($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's run the query.
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('relations');

		// Return relations count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete all relations of which entities no longer exist.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function purge($limit = 0, $offset = 0)
	{
		// we first get entities IDs.
		$ids = $this->_parent->entities->get_ids();

		// Now we use the "delete_by" method.
		return $this->delete_by(array(
			'!guid_from' => $ids,
			'!guid_to'   => $ids,
		));
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_relation'))
{
	/**
	 * This function creates a single relationship.
	 * @param 	int 	$guid_from 	The entity triggering the creation.
	 * @param 	int 	$guid_to 	The targeted entity.
	 * @param 	string 	$relation 	The relation's type.
	 * @return 	mixed 	The relation's ID, else false.
	 */
	function add_relation($guid_from, $guid_to, $relation)
	{
		return get_instance()->kbcore->relations->create(array(
			'guid_from' => $guid_from,
			'guid_to'   => $guid_to,
			'relation'  => $relation,
		));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_relation'))
{
	/**
	 * Retrieves a single relations by its ID.
	 * @param 	int 	$id 		The relation's ID.
	 * @param 	bool 	$single 	Whether to return the relation type.
	 * @return 	object 	THe relation's objects, else null.
	 */
	function get_relation($id, $single = false)
	{
		return get_instance()->kbcore->relations->get_by('id', $id, $single);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_relation_by'))
{
	/**
	 * Retrieve a single relation by arbitrary WHERE clause.
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	object if found, else null.
	 */
	function get_relation_by($field, $match = null)
	{
		return get_instance()->kbcore->relations->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_relations'))
{
	/**
	 * Retrieve multiple relations by arbitrary WHERE clause.
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	function get_relations($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->relations->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_all_relations'))
{
	/**
	 * Retrieve all relations.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	function get_all_relations($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->relations->get_all($limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_relations'))
{
	/**
	 * This function is used in order to search relations.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of relations if found, else null.
	 */
	function find_relations($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->relations->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_relation'))
{
	/**
	 * Update a single relation by its primary key.
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	function update_relation($id, array $data = array())
	{
		return get_instance()->kbcore->relations->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_relation_by'))
{
	/**
	 * Update a single, all or multiple relations by arbitrary WHERE clause.
	 * @return 	boolean
	 */
	function update_relation_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->relations, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_relations'))
{
	/**
	 * Update a single, all or multiple relations by arbitrary WHERE clause.
	 * @return 	boolean
	 */
	function update_relations()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->relations, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_relation'))
{
	/**
	 * Delete a single relation by its primary key.
	 * @param 	mixed 	$id 	The primary key value.
	 * @return 	boolean
	 */
	function delete_relation($id)
	{
		return get_instance()->kbcore->relations->delete_by('id', $id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_relation_by'))
{
	/**
	 * Delete a single, all or multiple relations by arbitrary WHER clause.
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	boolean
	 */
	function delete_relation_by($field = null, $match = null)
	{
		return get_instance()->kbcore->relations->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_relations'))
{
	/**
	 * Delete a single, all or multiple relations by arbitrary WHER clause.
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	boolean
	 */
	function delete_relations($field = null, $match = null)
	{
		return get_instance()->kbcore->relations->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_relations'))
{
	/**
	 * Count relations.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	function count_relations($field = null, $match = null)
	{
		return get_instance()->kbcore->relations->count($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_relations'))
{
	/**
	 * Delete relations of which entities no longer exist.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_relations($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->relations->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Relation
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Relation
{
	/**
	 * Relation data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The relation's ID.
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
	 * Retrieves the relation data and passes it to KB_Relation::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	User's ID, username, object or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Relation) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$relation = get_relation($id);
			if ($relation) {
				$this->init($relation->data);
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
	public function init($relation) {
		$this->data = $relation;
		$this->id   = (int) $relation->id;
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

		// Return true if found in $data or object properties.
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
	 * Method for checking the existence of an user in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the user exists, else false.
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
	 * Method for updating the user in database.
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
		$status = update_relation($this->id, $data);

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
		// We start if FALSE status.
		$status = false;

		// If there are enqueued changes, apply them.
		if ( ! empty($this->queue)) {
			$status = update_relation($this->id, $this->queue);

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
