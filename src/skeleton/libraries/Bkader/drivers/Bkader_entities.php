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
class Bkader_entities extends CI_Driver
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
			->get('entities')
			->result();

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
			OR ( ! isset($data['subtype']) OR ! in_array($data['subtype'], array('user', 'group', 'object'))) 
			OR ! isset($data['subtype']) 
			OR (isset($data['username']) && $this->get_by('username', $data['username'])))
		{
			return false;
		}

		// Make sure add the date of creation.
		(isset($data['created_at'])) OR $data['created_at'] = time();

		// Let's now created the entity and return the ID.
		$this->ci->db->insert('entities', $data);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single entity by its ID or username.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID (or username).
	 * @param 	array 	$data 	The array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		return (is_numeric($id))
			? $this->update_by(array('id', $id), $data)
			: $this->update_by(array('username', $id), $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple entities by arbitrary WHERE clause.
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

		// The data to set is always the last argument.
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// Make sure to add the update date.
		(isset($data['updated_at'])) OR $data['updated_at'] = time();

		// Proceed to update.
		$this->ci->db->set($data);

		// If there are arguments left, use them as WHERE clause.
		if ( ! empty($args))
		{
			// Get rid of deep nasty array.
			(is_array($args[0])) && $args = $args[0];
			$this->ci->db->where($args);
		}

		// Update the table.
		$this->ci->db->update('entities');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Soft delete an existing entity by its ID or username.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return (is_numeric($id))
			? $this->delete_by('id', $id)
			: $this->delete_by('username', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Soft delete a single or multiple entities by arbitrary WHERE clause.
	 * @access 	public
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// Prepare our WHERE clause.
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

		// Proceed to sort delete.
		$this->ci->db
			->set('deleted', 1)
			->set('deleted_at', time())
			->update('entities');

		// Return TRUE if there are some affected rows.
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Once the entity is remove, we remove everything that is
	 * related to it: users, groups, objects, metadata, variables
	 * and relations.
	 * @access 	public
	 * @param 	int 	$id 	the entity's ID.
	 * @return 	bool
	 */
	public function remove($id)
	{
		return (is_numeric($id))
			? $this->remove_by('id', $id)
			: $this->remove_by('username', $id);	}

	// ------------------------------------------------------------------------

	/**
	 * Unlike the delete method, this one completely remove the entities from 
	 * database and makes sure to delete anything related to id.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field = null, $match = null)
	{
		// Collect all entities first and make sure there are some.
		$ents = $this->get_many($field, $match);
		if (empty($ents))
		{
			return false;
		}

		// Let's loop through all and prepare our delete.
		$ids = array();
		foreach ($ents as $ent)
		{
			$ids[] = $ent->id;
		}

		// Now we delete entities.
		$this->ci->db->where_in('id', $ids)->delete('entities');

		// Prepare the process status.
		$status = ($this->ci->db->affected_rows() > 0);

		// If deleted, we remove everything related to them.
		if ($status === true)
		{
			// Activities.
			$this->ci->db->where_in('user_id', $ids)->delete('activities');

			// Owner and children entities.
			$this->remove_by('parent_id', $ids);
			$this->remove_by('owner_id', $ids);

			// Groups.
			$this->ci->db->where_in('guid', $ids)->delete('groups');
			
			// Metadata.
			$this->ci->db->where_in('guid', $ids)->delete('metadata');

			// Objects.
			$this->ci->db->where_in('guid', $ids)->delete('objects');

			// Relations.
			$this->ci->db
				->where_in('guid_from', $ids)
				->or_where_in('guid_to', $ids)
				->delete('relations');

			// Users.
			$this->ci->db->where_in('guid', $ids)->delete('users');

			// Variables.
			$this->ci->db->where_in('guid', $ids)->delete('variables');
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single entity by its ID OR username.
	 * @access 	public
	 * @param 	int 	$id 	The entity's ID or username.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		return (is_numeric($id))
			? $this->get_by('id', $id)
			: $this->get_by('username', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single entity by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	The column name or associative array.
	 * @param 	mixed 	$field 	The comparison value.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Turn things into an array.
		(is_array($field)) OR $field = array($field => $match);

		// Use the get many to make sure to find only a single entity.
		$ent = $this->get_many($field);

		/**
		 * The reason we are doing this is to make sure the found 
		 * entity is unique, so if we find more than one, it means 
		 * that we better use the get_many.
		 */
		return (count($ent) == 1) ? $ent[0] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple entities by arbitrary WHER clause.
	 * @access 	public
	 * @param 	mixed 	$field 	The column name or associative array.
	 * @param 	mixed 	$field 	The comparison value.
	 * @return 	array ofbjects if found, else null.
	 */
	public function get_many($field = null, $match = null)
	{
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

		return $this->ci->db->get('entities')->result();
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

if ( ! function_exists('update_entity'))
{
	/**
	 * Update a single entity by its ID or username.
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
	 * Delete a single entity by its ID or username.
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
