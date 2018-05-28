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
 * Kbcore_activities Class
 *
 * Handles all operations done on site's activities and logs.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */
class Kbcore_activities extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class preferences.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Loaded activities language earlier so modules can use it.
	 * 
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_activities Class Initialized');
	}

    // ------------------------------------------------------------------------

    /**
     * Generates the SELECT portion of the query
     *
     * @since 	1.3.0
     */
    public function select($select = '*', $escape = null)
    {
    	$this->ci->db->select($select, $escape);
    	return $this;
    }

	// ------------------------------------------------------------------------

	/**
	 * Return an array of activities table fields.
	 *
	 * @since 	1.3.0
	 * 
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

		$this->fields = $this->ci->db->list_fields('activities');
		return $this->fields;
	}

	// ------------------------------------------------------------------------
	// CRUD Interface.
	// ------------------------------------------------------------------------

	/**
	 * Create a new activity log.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to make sure we are using HMVC.
	 * 
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	int 	The new activity ID if created, else false.
	 */
	public function create(array $data = array())
	{
		// Without $data, nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Multiple activities?
		if (isset($data[0]) && is_array($data[0]))
		{
			$ids = array();
			foreach ($data as $_data)
			{
				$ids[] = $this->create($_data);
			}

			return $ids;
		}

		// Let's complete some data.
		if ( ! isset($data['module']))
		{
			$data['module'] = (method_exists($this->ci->router, 'fetch_module'))
				? $this->ci->router->fetch_module()
				: null;
		}
		(isset($data['controller'])) OR $data['controller'] = $this->ci->router->fetch_class();
		(isset($data['method']))     OR $data['method']     = $this->ci->router->fetch_method();
		(isset($data['created_at'])) OR $data['created_at'] = time();
		(isset($data['ip_address'])) OR $data['ip_address'] = $this->ci->input->ip_address();

		// Proceed to creation and return the ID.
		$this->ci->db->insert('activities', $data);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single activity by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "get_by" method.
	 * 
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// Getting by id?
		if (is_numeric($id))
		{
			return $this->get_by('id', $id);
		}

		// Otherwise, let "get_by" method handle the rest.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single activity by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or null.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// We start with an emoty $activity.
		$activity = false;

		// Attempt to get the entity from database.
		$db_activity = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('id', 'DESC')
			->get('activities')
			->row();

		// If found, we create its object.
		if ($db_activity)
		{
			$activity = new KB_Activity($db_activity);
		}

		// Return the final result.
		return $activity;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple activities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance
	 *         			and of let the parent handle the WHERE clause.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or null.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We start with an empty $activities.
		$activities = false;

		// Attempt to get activities from database.
		$db_activities = $this->_parent
			->where($field, $match, $limit, $offset)
			->order_by('id', 'DESC')
			->get('activities')
			->result();

		// If we found any, create their objects.
		if ($db_activities)
		{
			foreach ($db_activities as $db_activity)
			{
				$activities[] = new KB_Activity($db_activity);
			}
		}

		// Return the final result
		return $activities;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all activities.
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
	 * This method is used in order to search activities table.
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
		// We start with empty activities
		$activities = false;

		// Attempt to find activities.
		$db_activities = $this->_parent
			->find($field, $match, $limit, $offset)
			->order_by('id', 'DESC')
			->get('activities')
			->result();

		// If we found any, we create their objects.
		if ($db_activities)
		{
			foreach ($db_activities as $db_activity)
			{
				$activities[] = new KB_Activity($db_activity);
			}
		}

		// Return the final result.
		return $activities;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single entity by it's ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The activity's ID or array of WHERE clause.
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
	 * Update a single or multiple activities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten the let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @return 	bool
	 */
	public function update_by()
	{
		// Collect arguments first and make sure there are some.
		$args = func_get_args();
		if (empty($args))
		{
			return false;
		}

		// Data to set is always the last argument.
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// Start updating/
		$this->ci->db->update($data);

		// If there are arguments left, use the as WHERE clause.
		if ( ! empty($args))
		{
			// Get rid of nasty deep array.
			(is_array($args[0])) && $args = $args[0];

			// Let the parent generate the WHERE clause.
			$this->_parent->where($args);
		}

		// Proceed to update.
		$this->ci->db->update('activities');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single activity by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "delete_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The activity's ID or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete($id)
	{
		// Deleting by ID?
		if (is_numeric($id))
		{
			return $this->delete_by('id', $id, 1, 0);
		}

		// Otherwise, let "delete_by" handle the rest.
		return $this->delete_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple activities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance,
	 *         			add optional limit and offset and let the parent handle
	 *         			generating the WHERE clause.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or null.
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool 	true if any records deleted, else false.
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's delete.
		$this->_parent
			->where($field, $match, $limit, $offset)
			->delete('activities');

		// See if there are affected rows.
		return ($this->ci->db->affected_rows() > 0);
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
		// Both user's ID and activity are required.
		if (empty($user_id) OR empty($activity))
		{
			return false;
		}

		return $this->create(array(
			'user_id'  => $user_id,
			'activity' => $activity,
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Count activities by arbitrary WHERE clause.
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
		// Let's build the query first.
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('activities');

		// We return the count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete all activities of which the entity no longer exist.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance,
	 *         			and add optional limit and offset.
	 *
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function purge($limit = 0, $offset = 0)
	{
		// Get only users IDS.
		$ids = $this->_parent->entities->get_ids('type', 'user');

		// Let's delete.
		$this->_parent
			->where('!user_id', $ids, $limit, $offset)
			->delete('activities');

		return ($this->ci->db->affected_rows() > 0);
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
		return get_instance()->kbcore->activities->log_activity($user_id, $activity);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_activity'))
{
	/**
	 * Retrieve a single activity by its ID or arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	ID, column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or null.
	 * @return 	object if found, else null.
	 */
	function get_activity($field, $match = null)
	{
		// In case of using the ID.
		if (is_numeric($field))
		{
			return get_instance()->kbcore->activities->get($field);
		}

		return get_instance()->kbcore->activities->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_activities'))
{
	/**
	 * Retrieve multiple activities by arbitrary WHERE clause or 
	 * retrieve all activities if no arguments passed.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or null.
	 * @return 	array of objects if found, else null.
	 */
	function get_activities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_activities'))
{
	/**
	 * This function is used in order to search activities.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of activities if found, else null.
	 */
	function find_activities($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_activity'))
{
	/**
	 * Update a single activity by its ID.
	 * @param 	int 	$id 	The activity's ID.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	bool
	 */
	function update_activity($id, array $data = array())
	{
		return get_instance()->kbcore->activities->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_activity_by'))
{
	/**
	 * Update a single activity, multiple activities by arbitrary WHERE 
	 * clause, or even update all activities.
	 * @return 	bool
	 */
	function update_activity_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->activities, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_activities'))
{
	/**
	 * Update a single activity, multiple activities by arbitrary WHERE 
	 * clause, or even update all activities.
	 * @return 	bool
	 */
	function update_activities()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->activities, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_activity'))
{
	/**
	 * Delete a single activity by its ID.
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @return 	bool
	 */
	function delete_activity($id)
	{
		return get_instance()->kbcore->activities->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_activity_by'))
{
	/**
	 * Delete a single activity, multiple activities by arbitrary WHERE
	 * clause or even delete all activities.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_activity_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_activities'))
{
	/**
	 * Delete a single activity, multiple activities by arbitrary WHERE
	 * clause or even delete all activities.
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_activities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_activities'))
{
	/**
	 * Count activities by arbitrary WHERE clause.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	function count_activities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_activities'))
{
	/**
	 * Delete all activities of which the entity no longer exist.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structuer.
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_activities($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->activities->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Activity
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Activity
{
	/**
	 * Activity data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The activity's ID.
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
	 * Retrieves the activity data and passes it to KB_Activity::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Activity's ID, activityname, object or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Activity) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$activity = get_activity($id);
			if ($activity) {
				$this->init($activity->data);
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
	public function init($activity) {
		$this->data = $activity;
		$this->id   = (int) $activity->id;

		// We add user details to the $data object.
		$this->data->user = get_user($activity->user_id);
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

		// Return true only if found in $data or this object.
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
	 * Method for checking the existence of an activity in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the activity exists, else false.
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
	 * Method for updating the activity in database.
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
		$status = update_activity($this->id, $data);

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
			$status = update_activity($this->id, $this->queue);

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
