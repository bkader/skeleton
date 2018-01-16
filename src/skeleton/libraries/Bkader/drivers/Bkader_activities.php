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
		log_message('info', 'Bkader_activities Class Initialized');
	}

	// ------------------------------------------------------------------------
	// CRUD Interface.
	// ------------------------------------------------------------------------

	/**
	 * Create a new activity log.
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	int 	The new activity ID if created, else FALSE.
	 */
	public function create(array $data = array())
	{
		// Without $data, nothing to do.
		if (empty($data))
		{
			return FALSE;
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
		(isset($data['module']))     OR $data['module']     = $this->ci->router->fetch_module();
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
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @return 	object if found, else NULL.
	 */
	public function get($id)
	{
		return $this->get_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single activity by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or NULL.
	 * @return 	object if found, else NULL.
	 */
	public function get_by($field, $match = NULL)
	{
		// The WHERE clause depends on $field and $match.
		(is_array($field)) OR $field = array($field => $match);

		foreach ($field as $key => $val)
		{
			if (is_array($field))
			{
				$this->ci->db->where_in($key, $val);
			}
			else
			{
				$this->ci->db->where($key, $val);
			}
		}

		// Order activities and retrieve the last one.
		return $this->ci->db
			->order_by('id', 'DESC')
			->limit(1)
			->get('activities')->row();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple activities by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or NULL.
	 * @return 	array of objects if found, else NULL.
	 */
	public function get_many($field = NULL, $match = NULL)
	{
		if ( ! empty($field))
		{
			// Turn things into an array.
			(is_array($field)) OR $field = array($field => $match);

			foreach ($field as $key => $val)
			{
				if (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		return $this->ci->db
			->order_by('id', 'DESC')
			->get('activities')
			->result();
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single entity by it's ID.
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		return $this->update_by(array('id', $id), $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple activities by arbitrary WHERE clause.
	 * @access 	public
	 * @return 	boolean
	 */
	public function update_by()
	{
		// Collect arguments first and make sure there are some.
		$args = func_get_args();
		if (empt($args))
		{
			return FALSE;
		}

		// Data to set is always the last argument.
		$data = array_pop($args);
		if ( ! is_array($data) OR empt($data))
		{
			return FALSE;
		}

		// Start updating/
		$this->ci->db->update($data);

		// If there are arguments left, use the as WHERE clause.
		if ( ! empty($args))
		{
			// Get rid of nasty deep array.
			(is_array($args[0])) && $args = $args[0];

			foreach ($args as $key => $val)
			{
				if (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		// Proceed to update.
		$this->ci->db->update('activities');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single activity by its ID.
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->delete_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple activities by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or NULL.
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		if ( ! empty($field))
		{
			// Turn things into an array.
			(is_array($field)) OR $field = array($field => $match);

			foreach ($field as $key => $val)
			{
				if (is_array($val))
				{
					$this->ci->db->where_in($key, $val);
				}
				else
				{
					$this->ci->db->where($key, $val);
				}
			}
		}

		// Proceed to deletion.
		$this->ci->db->delete('activities');
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
			return FALSE;
		}

		return $this->create(array(
			'user_id'  => $user_id,
			'activity' => $activity,
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

// ------------------------------------------------------------------------

if ( ! function_exists('get_activity'))
{
	/**
	 * Retrieve a single activity by its ID or arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	ID, column name or associative array.
	 * @param 	mixed 	$match 	Comparison value, array or NULL.
	 * @return 	object if found, else NULL.
	 */
	function get_activity($field, $match = null)
	{
		// In case of using the ID.
		if (is_numeric($field))
		{
			return get_instance()->app->activities->get($field);
		}

		return get_instance()->app->activities->get_by($field, $match);
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
	 * @param 	mixed 	$match 	Comparison value, array or NULL.
	 * @return 	array of objects if found, else NULL.
	 */
	function get_activities($field = null, $match = null)
	{
		return get_instance()->app->activities->get_many($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_activity'))
{
	/**
	 * Update a single activity by its ID.
	 * @param 	int 	$id 	The activity's ID.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	function update_activity($id, array $data = array())
	{
		return get_instance()->app->activities->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_activity_by'))
{
	/**
	 * Update a single activity, multiple activities by arbitrary WHERE 
	 * clause, or even update all activities.
	 * @return 	boolean
	 */
	function update_activity_by()
	{
		return call_user_func_array(
			array(get_instance()->app->activities, 'update_by'),
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
	 * @return 	boolean
	 */
	function update_activities()
	{
		return call_user_func_array(
			array(get_instance()->app->activities, 'update_by'),
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
	 * @return 	boolean
	 */
	function delete_activity($id)
	{
		return get_instance()->app->activities->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_activity_by'))
{
	/**
	 * Delete a single activity, multiple activities by arbitrary WHERE
	 * clause or even delete all activities.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_activity_by($field = null, $match = null)
	{
		return get_instance()->app->activities->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_activities'))
{
	/**
	 * Delete a single activity, multiple activities by arbitrary WHERE
	 * clause or even delete all activities.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_activities($field = null, $match = null)
	{
		return get_instance()->app->activities->delete_by($field, $match);
	}
}
