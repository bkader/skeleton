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
 * Bkader_objects Class
 *
 * Handles operations done on any thing tagged as a object.
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
class Bkader_objects extends CI_Driver
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
		log_message('info', 'Bkader_objects Class Initialized');
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

		// Insert the object.
		$this->ci->db->insert('objects', $object);

		// Some metadata?
		if ( ! empty($meta))
		{
			$this->_parent->metadata->create($guid, $meta);
		}

		return $guid;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single object by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id 	The object's ID or username.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// Getting by ID?
		if (is_numeric($id))
		{
			return $this->get_by('entities.id', $id);
		}

		// Retrieve by username.
		if (is_string($id))
		{
			return $this->get_by('entities.username', $id);
		}

		// Fall-back to get_by method.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single object by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Try to get the object and make sure only one row it found.
		$object = $this->get_many($field, $match);
		return ($object && count($object) === 1) ? $object[0] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple objects by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Prepare entities type.
		$this->ci->db->where('entities.type', 'object');

		// There some arguments?
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

		// Is there a limit?
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		// Proceed to join and get.
		return $this->ci->db
			->join('objects', 'objects.guid = entities.id')
			->get('entities')
			->result();
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
	 * Update a single object.
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

		if ( ! empty($object))
		{
			$this->ci->db->update('objects', $object, array('guid' => $id));
		}

		// Some metadata?
		if ( ! empty($meta))
		{
			$this->_parent->metadata->update($id, $meta);
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single object by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return (is_numeric($id))
			? $this->_parent->entities->delete_by('id', $id)
			: $this->_parent->entities->delete_by('username', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple objects by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// See if objects exist.
		$objects = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($objects)
		{
			$ids = array();
			foreach ($objects as $user)
			{
				$ids[] = $user->id;
			}

			return $this->_parent->entities->delete_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single object by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function remove($id)
	{
		return (is_numeric($id))
			? $this->_parent->entities->remove_by('id', $id)
			: $this->_parent->entities->remove_by('username', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove multiple objects by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field = null, $match = null)
	{
		// See if objects exist.
		$objects = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($objects)
		{
			$ids = array();
			foreach ($objects as $user)
			{
				$ids[] = $user->id;
			}

			return $this->_parent->entities->remove_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft-deleted object.
	 * @access 	public
	 * @param 	int 	$id 	The object's ID.
	 * @return 	boolean
	 */
	public function restore($id)
	{
		// Restore only entities of type "object".
		return $this->_parent->entities->restore_by(array(
			'id'   => $id,
			'type' => 'object',
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted objects.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null)
	{
		// Collect objects.
		$objects = $this->get_many($field, $match);

		if ($objects)
		{
			$ids = array();
			foreach ($objects as $user)
			{
				if ($user->deleted > 0)
				{
					$ids[] = $user->id;
				}
			}

			// Restore objects in IDS.
			return ( ! empty($ids))
				? $this->_parent->entities->restore_by('id', $ids)
				: false;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all objects.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	public function count($field = null, $match = null)
	{
		$this->ci->db->where('entities.type', 'object');

		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->ci->db->where($field);
			}
			elseif (is_array($match))
			{
				$this->ci->db->where($field, $match);
			}
			else
			{
				$this->ci->db->where($field, $match);
			}
		}

		$rows = $this->ci->db
			->join('objects', 'objects.guid = entities.id')
			->get('entities');

		return $rows->num_rows();
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
		return get_instance()->app->objects->create($data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_object'))
{
	/**
	 * Update a single object by ID.
	 * @param 	int 	$id 	The object's ID.
	 * @param 	array 	$data 	Array of data to set.
	 * @return 	boolean
	 */
	function update_object($id, array $data = array())
	{
		return get_instance()->app->objects->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_object'))
{
	/**
	 * Delete a single object by ID or username.
	 * @param 	mixed 	$id 	ID or username.
	 * @return 	boolean
	 */
	function delete_object($id)
	{
		return get_instance()->app->objects->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_object_by'))
{
	/**
	 * Soft delete multiple objects by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_object_by($field, $match = null)
	{
		return get_instance()->app->objects->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_objects'))
{
	/**
	 * Soft delete multiple or all objects by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_objects($field = null, $match = null)
	{
		return get_instance()->app->objects->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_object'))
{
	/**
	 * Completely remove a object from database.
	 * @param 	int 	$id 	The object's ID or username.
	 * @return 	boolean
	 */
	function remove_object($id)
	{
		return get_instance()->app->objects->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_object_by'))
{
	/**
	 * Completely remove multiple objects from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_object_by($field, $match = null)
	{
		return get_instance()->app->objects->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_objects'))
{
	/**
	 * Completely remove multiple or all objects from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_objects($field = null, $match = null)
	{
		return get_instance()->app->objects->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_object'))
{
	/**
	 * Restore a previously soft-deleted object.
	 * @access 	public
	 * @param 	int 	$id 	The object's ID.
	 * @return 	boolean
	 */
	function restore_object($id)
	{
		return get_instance()->app->objects->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_object_by'))
{
	/**
	 * Restore multiple soft-deleted objects.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_object_by($field, $match = null)
	{
		return get_instance()->app->objects->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_objects'))
{
	/**
	 * Restore multiple or all soft-deleted objects.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_objects($field, $match = null)
	{
		return get_instance()->app->objects->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_objects'))
{
	/**
	 * Count all objects on database with arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	function count_objects($field = null, $match = null)
	{
		return get_instance()->app->objects->count($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_object'))
{
	/**
	 * Retrieve a single object by ID, objectname, email or arbitrary
	 * WHERE clause if $id an array.
	 * @param 	mixed 	$id
	 * @return 	object if found, else null.
	 */
	function get_object($id)
	{
		return get_instance()->app->objects->get($id);
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
		return get_instance()->app->objects->get_by($field, $match);
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
		return get_instance()->app->objects->get_many($field, $match, $limit, $offset);
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
		return get_instance()->app->objects->get_all($limit, $offset);
	}
}
