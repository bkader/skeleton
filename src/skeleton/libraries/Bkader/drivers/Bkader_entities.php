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
 * Bkader_entities Class
 *
 * Handles all operations done on entities which are users, groups and objects.
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
class Bkader_entities extends CI_Driver implements CRUD_interface
{
	/**
	 * Holds entities table fields.
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
		log_message('info', 'Bkader_entities Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Return an array of entities table fields.
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

		$this->fields = $this->ci->db->list_fields('entities');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of stored entities.
	 * @access 	public
	 * @return 	array
	 */
	public function get_all_ids()
	{
		// Prepare an empty $ids array.
		$ids = array();


		// Try to get all entities.
		$entities = $this->ci->db
			->select('id')
			->get_all();

		// If found any, store their IDs.
		if ($entities)
		{
			foreach ($entities as $ent)
			{
				$ids[] = $ent->id;
			}
		}

		// Return the final result.
		return $ids;
	}

	// ------------------------------------------------------------------------
	// Create Entities.
	// ------------------------------------------------------------------------

	/**
	 * Create a new entity.
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	int 	The entity's ID.
	 */
	public function create(array $data = array())
	{
		/**
		 * There are several things we need to check:
		 * 1. $data is never empty.
		 * 2. Entity's type is one of the allowed types.
		 * 3. Entity's subtype is always provided.
		 * 4. The entity username is available.
		 */
		if (empty($data) 
			OR ( ! isset($data['type']) OR ! in_array($data['type'], array('user', 'group', 'object'))) 
			OR ! isset($data['subtype']) 
			OR (isset($data['username']) && $this->get_by('username', $data['username'])))
		{
			return false;
		}

		// Add date of created.
		(isset($data['created_at'])) OR $data['created_at'] = time();

		// Proceed to insert.
		$this->ci->db->insert('entities', $data);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------
	// Getters.
	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single entity by its ID.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		return $this->get_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single entity by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if a single row if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Use the get many to make sure to find only a single entity.
		$ent = $this->get_many($field, $match);

		/**
		 * The reason we are doing this is to make sure the found 
		 * entity is unique, so if we find more than one, it means 
		 * that we better use the get_many.
		 */
		return ($ent && count($ent) == 1) ? $ent[0] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple entities by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or array.
	 * @param 	mixed 	$match 	Comparison value or null.
	 * @param 	int 	$limit 	Limit of rows to retrieve.
	 * @param 	int 	$offset MySQL offset.
	 * @return 	array of objects if found, else null
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Prepare the WHERE clause.
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

		// Is limit provided?
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		return $this->ci->db->get('entities')->result();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all entities from table.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------
	// Update Entities.
	// ------------------------------------------------------------------------

	/**
	 * Update a single entity by its ID.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID (or username).
	 * @param 	array 	$data 	The array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		if ( ! empty($id))
		{
			return (is_numeric($id))
				? $this->update_by(array('id' => $id), $data)
				: $this->update_by(array('username' => $id), $data);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single, all or multiple entities by arbitrary WHERE clause.
	 * @access 	public
	 * @return 	boolean
	 */
	public function update_by()
	{
		// Collect arguments and make sure there are some.
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


		// Make sure to add the update date.
		(isset($data['updated_at'])) OR $ata['updated_at'] = time();

		// Prepare out update statement.
		$this->ci->db->set($data);

		// Are there where conditions?
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

		// Proceed to update.
		return $this->ci->db->update('entities');
	}

	// ------------------------------------------------------------------------
	// Delete Entities.
	// ------------------------------------------------------------------------

	/**
	 * Soft delete a single entity by its ID.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		if ( ! empty($id))
		{
			// Prepare the column to target.
			$column = (is_numeric($id)) ? 'id' : 'username';
			return $this->delete_by($column, $id);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single, all or multiple entities by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	This is required to avoid deleting all.
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		if ( ! empt($field))
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

		// Process to soft-delete.
		$this->ci->db
			->where('deleted', 0)
			->set('deleted', 1)
			->set('deleted_at', time())
			->update('entities');

		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------
	// Remove Entities.
	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single entity by its ID.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	public function remove($id)
	{
		if (empty($id))
		{
			return false;
		}

		// Get the entity so we can delete everything related to it.
		$ent = (is_numeric($id))
			? $this->get_by('id', $id)
			: $this->get_by('username', $id);

		// The entity not found?
		if ( ! $ent)
		{
			return false;
		}

		// Get the ID for later use.
		(is_numeric($id)) OR $id = $ent->id;

		// Attempt to delete the entity.
		$this->ci->db->delete('entities', array('id' => $id));

		// Not deleted? Nothing to do.
		if ($this->ci->db->affected_rows() < 1)
		{
			return false;
		}

		// Everything went well, we proceed to remove everything.
		switch ($ent->type)
		{
			/**
			 * NOTE:
			 * Because users, objects and groups libraries have their delete
			 * methods that will call this class methods, the final result 
			 * will be FALSE, because when the entity is removed and we 
			 * target others tables (users, objects and group) to delete rows 
			 * they will return FALSE and rows are not deleted (soft-delete).
			 * This is why with are using below:
			 * 
			 * $this->ci->db->delete('users' ...);
			 * $this->ci->db->delete('object' ...);
			 * $this->ci->db->delete('groups' ...);
			 *
			 * Instead of calling libraries methods.
			 */

			// In case of a user.
			case 'user':
				// Delete all activities.
				$this->_parent->activities->delete_by('user_id', $id);

				// Remove user from "users" table.
				$this->ci->db->delete('users', array('guid' => $id));
				break;

			// In case of a group.
			case 'group':
				$this->ci->db->delete('groups', array('guid' => $id));
				break;

			// In case of an object.
			case 'object':
				$this->ci->db->delete('objects', array('guid' => $id));
				break;
		}

		// Delete all entities having this entity as parent or owner.
		$this->remove_by('parent_id', $id);
		$this->remove_by('owner_id', $id);

		// Delete metadata and variables.
		$this->_parent->metadata->delete_by('guid', $id);
		$this->_parent->variables->delete_by('guid', $id);

		// Now delete all relations.
		$this->_parent->relations->delete_by('guid_from', $id);
		$this->_parent->relations->delete_by('guid_to', $id);

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Complete remove a single, all or multiple entities by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	This is required to avoid deleting all.
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field, $match = null)
	{
		// Get all entities first.
		$entities = $this->get_many($field, $match);

		if ( ! $entities)
		{
			return false;
		}

		foreach ($entities as $ent)
		{
			$this->remove($ent->id);
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft deleted entity by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	public function restore($id)
	{
		return (is_numeric($id))
			? $this->restore_by('id', $id)
			: $this->restore_by('username', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple entities previously soft deleted by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null)
	{
		// Prepare our WHERE clause.
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

		// Proceed to sort delete.
		$this->ci->db
			->where('deleted', 1)
			->set('deleted', 0)
			->set('deleted_at', 0)
			->update('entities');

		// Return TRUE if there are some affected rows.
		return ($this->ci->db->affected_rows() > 0);
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entities_ids'))
{
	/**
	 * Returns an array of all availables entities.
	 * @param 	none
	 * @return 	array
	 */
	function get_entities_ids()
	{
		return get_instance()->app->entities->get_all_ids();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('add_entity'))
{
	/**
	 * Create a new entity.
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	int 	The entity's ID if created, else false.
	 */
	function add_entity(array $data = array())
	{
		return get_instance()->app->entities->create($data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entity'))
{
	/**
	 * Retrieve a single entity byt its ID or username.
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	object if found, else null.
	 */
	function get_entity($id)
	{
		return get_instance()->app->entities->get($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entity_by'))
{
	/**
	 * Retrieve a single entity by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	function get_entity_by($field, $match = null)
	{
		return get_instance()->app->entities->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entities'))
{
	/**
	 * Retrieve multiple entities by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	array of object if found, else null.
	 */
	function get_entities($field = null, $match = null)
	{
		return get_instance()->app->entities->get_many($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_entity'))
{
	/**
	 * Update a single entity by its ID.
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	function update_entity($id, array $data = array())
	{
		return get_instance()->app->entities->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_entity_by'))
{
	/**
	 * Update a single or multiple entities by arbitrary WHERE clause.
	 * @return 	boolean
	 */
	function update_entity_by()
	{
		return call_user_func_array(
			array(get_instance()->app->entities, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_entities'))
{
	/**
	 * Update a single or multiple entities by arbitrary WHERE clause.
	 * @return 	boolean
	 */
	function update_entities()
	{
		return call_user_func_array(
			array(get_instance()->app->entities, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_entity'))
{
	/**
	 * Delete a single entity by its ID.
	 * @param 	mixed 	$id 	The entity's ID or username
	 * @return 	boolean
	 */
	function delete_entity($id)
	{
		return get_instance()->app->entities->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_entity_by'))
{
	/**
	 * Soft delete a single or multiple entities by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_entity_by($field = null, $match = null)
	{
		return get_instance()->app->entities->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_entities'))
{
	/**
	 * Soft delete a single or multiple entities by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_entities($field = null, $match = null)
	{
		return get_instance()->app->entities->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_entity'))
{
	/**
	 * Completely remove a single entity and all what's related to it.
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	function remove_entity($id)
	{
		return get_instance()->app->entities->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_entity_by'))
{
	/**
	 * Completely remove a single or multiple entities and all what's 
	 * related to them by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_entity_by($field = null, $match = null)
	{
		return get_instance()->app->entities->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_entities'))
{
	/**
	 * Completely remove a single or multiple entities and all what's 
	 * related to them by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_entities($field = null, $match = null)
	{
		return get_instance()->app->entities->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_entity'))
{
	/**
	 * Restore a previously soft deleted entity by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	function restore_entity($id)
	{
		return get_instance()->app->entities->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_entity_by'))
{
	/**
	 * Restore a single or multiple entities previously soft deleted 
	 * by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @return 	boolean
	 */
	function restore_entity_by($field = null, $match = null)
	{
		return get_instance()->app->entities->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_entities'))
{
	/**
	 * Restore a single or multiple entities previously soft deleted 
	 * by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @return 	boolean
	 */
	function restore_entities($field = null, $match = null)
	{
		return get_instance()->app->entities->restore_by($field, $match);
	}
}
