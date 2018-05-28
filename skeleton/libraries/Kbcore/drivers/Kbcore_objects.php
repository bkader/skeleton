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
 * Kbcore_objects Class
 *
 * Handles operations done on any thing tagged as a object.
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
class Kbcore_objects extends CI_Driver implements CRUD_interface
{
	/**
	 * Holds objects table fields.
	 * @var array
	 */
	private $fields;

	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_objects Class Initialized');
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
	 * Return an array of objects table fields.
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

		$this->fields = $this->ci->db->list_fields('objects');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new object.
	 * @access 	public
	 * @param 	array 	$data
	 * @return 	int 	the object's ID if created, else false.
	 */
	public function create(array $data = array())
	{
		// Nothing provided? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $object, $meta) = $this->_split_data($data);

		// Make sure to alwayas add the entity's type.
		$entity['type'] = 'object';

		// Let's insert the entity first and make sure it's created.
		$guid = $this->_parent->entities->create($entity);
		if ( ! $guid)
		{
			return false;
		}

		// Add the id to object.
		$object['guid'] = $guid;

		/**
		 * Always "htmlspecialchars" the content.
		 * @since 	1.4.0
		 */
		if (isset($object['content']) && ! empty($object['content']))
		{
			$object['content'] = htmlspecialchars(
				$object['content'],
				ENT_QUOTES,
				$this->ci->config->item('charset'));
		}

		// Insert the object.
		$this->ci->db->insert('objects', $object);

		// If the are any metadata, create them.
		if ( ! empty($meta))
		{
			$this->_parent->metadata->add_meta($guid, $meta);
		}

		return $guid;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single object by ID or username.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The object's ID username or array of WHERE clause.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// Getting by ID?
		if (is_numeric($id))
		{
			return $this->get_by('id', $id);
		}

		// Retrieve by username.
		if (is_string($id))
		{
			return $this->get_by('username', $id);
		}

		// Otherwise, let the "get_by" method handle the rest.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single object by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten the let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// We start with an empty object.
		$object = false;

		// We make sure to join "objects" table first.
		$this->ci->db
			->where('entities.type', 'object')
			->join('objects', 'objects.guid = entities.id');

		// Attempt to get the object from database.
		$db_object = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('entities.id', 'DESC')
			->get('entities')
			->row();

		// If found, we create its object.
		if ($db_object)
		{
			$object = new KB_Object($db_object);
		}

		// Return the final result.
		return $object;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple objects by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We start with empty objects.
		$objects = false;

		// We make sure to select objects and join their table.
		$this->ci->db
			->where('entities.type', 'object')
			->join('objects', 'objects.guid = entities.id');

		// Attempt to retrieve objects from database.
		$db_objects = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities')
			->result();

		// If found any, create their objects.
		if ($db_objects)
		{
			foreach ($db_objects as $db_object)
			{
				$objects[] = new KB_Object($db_object);
			}
		}

		// Return the final result.
		return $objects;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all users with optional limit and offset.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * This method is used in order to search objects.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	public function find($field, $match = null, $limit = 0, $offset = 0)
	{
		// We start with a empty $objects.
		$objects = false;

		// Attempt to find objects.
		$db_objects = $this->_parent
			->find($field, $match, $limit, $offset, 'objects')
			->get('entities')
			->result();

		// If we find any, we create their objects.
		if ($db_objects)
		{
			foreach ($db_objects as $db_object)
			{
				$objects[] = new KB_Object($db_object);
			}
		}

		return $objects;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single object.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Fixing type where we were using inexistent model.
	 * 
	 * @access 	public
	 * @param 	int 	$id
	 * @param 	array 	$data
	 * @return 	bool
	 */
	public function update($id, array $data = array())
	{
		// Empty $data? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $object, $meta) = $this->_split_data($data);

		// Update entity.
		if ( ! empty($entity) && ! $this->_parent->entities->update($id, $entity))
		{
			return false;
		}

		// Update objects table.
		if ( ! empty($object) 
			&& ! $this->ci->db->update('objects', $object, array('guid' => $id)))
		{
			return false;
		}

		// If there are any metadata to update.
		if ( ! empty($meta))
		{
			$this->_parent->metadata->update_meta($id, $meta);
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update all or multiple objects by arbitrary WHERE clause.
	 * @access 	public
	 * @return 	bool
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

		// Get objects
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$objects = $this->get_many($args);
		}
		else
		{
			$objects = $this->get_all();
		}

		// If there are any objects, proceed to update.
		if ($objects)
		{
			foreach ($objects as $object)
			{
				return $this->update($object->id, $data);
			}

			return true;
		}

		// Nothing happened, return false.
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single object by ID, username or arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	Object's ID, username or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete($id)
	{
		// Deleting by ID?
		if (is_numeric($id))
		{
			return $this->delete_by('id', $id, 1, 0);
		}

		// Deleting by username?
		if (is_string($id))
		{
			return $this->delete_by('username', $id, 1, 0);
		}

		// Otherwise, let the "delete_by" method handle the rest.
		return $this->delete_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple objects by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code and performance and to 
	 *         			add optional limit and offset.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's find users first.
		$objects = $this->get_many($field, $match, $limit, $offset);

		// If no object found, nothing to do.
		if ( ! $objects)
		{
			return false;
		}

		// Let's prepare objects IDS.
		$ids = array();
		foreach ($objects as $object)
		{
			$ids[] = $object->id;
		}

		// Double check that we have IDs.
		if (empty($ids))
		{
			return false;
		}

		return $this->_parent->entities->delete_by('id', $ids);
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single object by ID, username or arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "remove_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	Object's ID, username or array of WHERE clause
	 * @return 	bool
	 */
	public function remove($id)
	{
		// Removing by ID?
		if (is_numeric($id))
		{
			return $this->remove_by('id', $id, 1, 0);
		}

		// Removing by username?
		if (is_string($id))
		{
			return $this->remove_by('username', $id, 1, 0);
		}

		// Otherwise, let the "remove_by" method handle the rest.
		return $this->remove_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove multiple objects by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better performance and to add optional
	 *         			limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function remove_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// See if objects exist.
		$objects = $this->get_many($field, $match, $limit, $offset);

		// If not objects found, nothing to do.
		if ( ! $objects)
		{
			return false;
		}

		// Collect objects IDs.
		$ids = array();
		foreach ($objects as $object)
		{
			$ids[] = $object->id;
		}

		// Double check users IDs.
		if (empty($ids))
		{
			return false;
		}

		return $this->_parent->entities->remove_by('id', $ids);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft-deleted object.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "restore_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The user's ID, username or WHERE clause.
	 * @return 	bool
	 */
	public function restore($id)
	{
		// Restoring by ID?
		if (is_numeric($id))
		{
			return $this->restore_by('id', $id, 1, 0);
		}

		// Restoring by username?
		if (is_string($id))
		{
			return $this->restore_by('username', $id, 1, 0);
		}

		// Otherwise, let the "restore_by" method handle the rest.
		return $this->restore_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted objects.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better performance and to add optional
	 *         			limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function restore_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Collect objects.
		$objects = $this->get_many($field, $match, $limit, $offset);

		// If not objects found, nothing to do.
		if (empty($objects))
		{
			return false;
		}

		// Collect objects IDs.
		$ids = array();
		foreach ($objects as $object)
		{
			$ids[] = $object->id;
		}

		// Double check users IDs.
		if (empty($ids))
		{
			return false;
		}

		return $this->_parent->entities->restore_by('id', $ids);
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all objects.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance
	 *         			and to add optional limit and offset
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
		// We make sure to select only objects and join their table.
		$this->ci->db
			->where('entities.type', 'object')
			->join('objects', 'objects.guid = entities.id');

		// We run the query now.
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities');

		// We return the count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Deletes objects that have no existing records in "entities".
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
		// We get existing objects IDs.
		$entities_ids = $this->_parent->entities->get_ids('type', 'object');

		// Let's see if there are objects.
		$objects = $this->ci->db
			->where_not_in('guid', $entities_ids)
			->get('objects')
			->result();

		// No objects found? Nothing to do.
		if ( ! $objects)
		{
			return false;
		}

		// Collect objects ids.
		$ids = array();
		foreach ($objects as $object)
		{
			$ids[] = $object->id;
		}

		// Double check $ids array.
		if (empty($ids))
		{
			return false;
		}

		// We delete objects.
		$this->ci->db
			->where_in('guid', $ids)
			->delete('objects');

		// Hold the status for later use.
		$status = ($this->ci->db->affected_rows() > 0);

		// Deleted? Remove everything related to them.
		if ($status === true)
		{
			// Remove any objects or objects owned by objects.
			$this->_parent->entities->remove_by('parent_id', $ids);
			$this->_parent->entities->remove_by('owner_id', $ids);

			// Delete all objects metadata and variables.
			$this->_parent->metadata->delete_by('guid', $ids);
			$this->_parent->variables->delete_by('guid', $ids);

			// Delete all objects relations.
			$this->_parent->relations->delete_by('guid_from', $ids);
			$this->_parent->relations->delete_by('guid_to', $ids);
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Split data upon creation or update into entity and object.
	 * @access 	private
	 * @param 	array 	$data
	 * @return 	array.
	 */
	private function _split_data(array $data = array())
	{
		if (empty($data))
		{
			return $data;
		}

		$_data = array();

		foreach ($data as $key => $val)
		{
			// Entities table.
			if (in_array($key, $this->_parent->entities->fields()))
			{
				$_data[0][$key] = $val;
			}
			// Objects table.
			elseif (in_array($key, $this->fields()))
			{
				$_data[1][$key] = $val;
			}
			// The rest are metadata.
			else
			{
				$_data[2][$key] = $val;
			}
		}

		if (empty($_data))
		{
			return $data;
		}

		// Make sure all three elements are set.
		(isset($_data[0])) OR $_data[0] = array();
		(isset($_data[1])) OR $_data[1] = array();
		(isset($_data[2])) OR $_data[2] = array();

		// Sort things up.
		ksort($_data);

		return $_data;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_object'))
{
	/**
	 * Create a single object.
	 * @param 	array 	$data 	array of data to insert.
	 * @return 	int 	The object's id if created, else false.
	 */
	function add_object(array $data = array())
	{
		return get_instance()->kbcore->objects->create($data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_object'))
{
	/**
	 * Retrieve a single object by ID, username or arbitrary WHERE clause.
	 * @param 	mixed 	$id
	 * @return 	object if found, else null.
	 */
	function get_object($id)
	{
		return get_instance()->kbcore->objects->get($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_object_by'))
{
	/**
	 * Retrieve a single object by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	function get_object_by($field, $match = null)
	{
		return get_instance()->kbcore->objects->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_objects'))
{
	/**
	 * Retrieve multiple objects by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function get_objects($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_all_objects'))
{
	/**
	 * Retrieve all objects with optional limit and offset.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	function get_all_objects($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->get_all($limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_objects'))
{
	/**
	 * This function is used in order to search objects.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function find_objects($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_object'))
{
	/**
	 * Update a single object by ID.
	 * @param 	int 	$id 	The object's ID.
	 * @param 	array 	$data 	Array of data to set.
	 * @return 	bool
	 */
	function update_object($id, array $data = array())
	{
		return get_instance()->kbcore->objects->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_object_by'))
{
	/**
	 * Update a single, all or multiple objects by arbitrary WHERE clause.
	 * @return 	bool
	 */
	function update_object_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->objects, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_objects'))
{
	/**
	 * Update a single, all or multiple objects by arbitrary WHERE clause.
	 * @return 	bool
	 */
	function update_objects()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->objects, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_object'))
{
	/**
	 * Delete a single object by ID or username.
	 * @param 	mixed 	$id 	ID or username.
	 * @return 	bool
	 */
	function delete_object($id)
	{
		return get_instance()->kbcore->objects->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_object_by'))
{
	/**
	 * Soft delete multiple objects by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function delete_object_by($field, $match = null)
	{
		return get_instance()->kbcore->objects->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_objects'))
{
	/**
	 * Soft delete multiple or all objects by arbitrary WHERE clause.
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
	function delete_objects($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_object'))
{
	/**
	 * Completely remove a object from database.
	 * @param 	mixed 	$id 	The object's ID, username or WhERE clause.
	 * @return 	bool
	 */
	function remove_object($id)
	{
		return get_instance()->kbcore->objects->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_object_by'))
{
	/**
	 * Completely remove multiple objects from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function remove_object_by($field, $match = null)
	{
		return get_instance()->kbcore->objects->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_objects'))
{
	/**
	 * Completely remove multiple or all objects from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function remove_objects($field = null, $match = null)
	{
		return get_instance()->kbcore->objects->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_object'))
{
	/**
	 * Restore a previously soft-deleted object.
	 * @access 	public
	 * @param 	mixed 	$id 	The object's ID, username or WHERE clause.
	 * @return 	bool
	 */
	function restore_object($id)
	{
		return get_instance()->kbcore->objects->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_object_by'))
{
	/**
	 * Restore multiple or all soft-deleted objects.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function restore_object_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_objects'))
{
	/**
	 * Restore multiple or all soft-deleted objects.
	 * 
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function restore_objects($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_objects'))
{
	/**
	 * Count all objects on database with arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	function count_objects($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_objects'))
{
	/**
	 * Delete objects that has no records in "entities" table.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_objects($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->objects->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Object
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Object
{
	/**
	 * Object data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The object's ID.
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
	 * Retrieves the object data and passes it to KB_Object::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Object's ID, username, object or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Object) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$object = get_object($id);
			if ($object) {
				$this->init($object->data);
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
	public function init($object) {
		$this->data = $object;
		$this->id   = (int) $object->id;

		/**
		 * We make sure to "htmlspecialchars_decode" the content.
		 * @since 	1.4.0
		 */
		if (isset($this->data->content) && ! empty($this->data->content)) {
			$this->data->content_html = htmlspecialchars_decode(
				$this->data->content,
				ENT_QUOTES
			);
		}
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

		// Found in $data container?
		if (isset($this->data->{$key})) {
			return true;
		}

		// Found as object property?
		if (isset($this->{$key})) {
			return true;
		}

		// Check for metadata.
		return metadata_exists($this->id, $key);
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
		// Otherwise, let's attempt to get the meta.
		else {
			$meta = get_meta($this->id, $key);
			if ($meta) {
				$value = $meta->value;
			}
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
	 * Method for checking the existence of an object in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the object exists, else false.
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
	 * Method for updating the object in database.
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
		$status = update_object($this->id, $data);

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
			$status = update_object($this->id, $this->queue);

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
