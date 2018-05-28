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
 * Kbcore_entities Class
 *
 * Handles all operations done on entities which are users, groups and objects.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.5.0
 */
class Kbcore_entities extends CI_Driver implements CRUD_interface
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
		log_message('info', 'Kbcore_entities Class Initialized');
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
		if (empty($data) // There are $data
			OR ( ! isset($data['type']) // The type is set
				OR ! in_array($data['type'], array('user', 'group', 'object'))) // type is valid.
			OR ! isset($data['subtype'])) // Subtype is set.
		{
			return false;
		}

		// Should we generate another username?
		if (isset($data['username']) && $this->get_by('username', $data['username']))
		{
			// Let's generate the username.
			$slug = $maybe_slug = $data['username'];
			$next = 1;

			while ($this->get_by('username', $slug)) {
				$slug = "{$maybe_slug}-{$next}";
				$next++;
			}

			$data['username'] = $slug;
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
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Method rewriting for larger use.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// If getting the entity by ID.
		if (is_numeric($id))
		{
			return $this->get_by('id', $id);
		}

		// In case of retrieving it with username.
		if (is_string($id))
		{
			return $this->get_by('username', $id);
		}

		// Otherwise, let the "get_by" method handle the rest
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single entity by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	The method was rewritten to let the parent handle
	 *         			the WHERE clause and return an KB_Entity object.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if a single row if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// We start with an empty entity.
		$entity = false;

		// Attempt to get the entity from database.
		$db_entity = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('id', 'DESC')
			->get('entities')
			->row();

		// If found, we create its object.
		if ($db_entity)
		{
			$entity = new KB_Entity($db_entity);
		}

		// Return the final result.
		return $entity;
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
		// We start with empty entities.
		$entities = false;

		// Attempt to get entities from database.
		$db_entities = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities')
			->result();

		// If found any, update $entities object.
		if ($db_entities)
		{
			foreach ($db_entities as $entity)
			{
				$entities[] = new KB_Entity($entity);
			}
		}

		return $entities;
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

	/**
	 * This method is used in order to search entities table.
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
		// We start with empty entities
		$entities = false;

		// Attempt to find entities.
		$db_entities = $this->_parent
			->find($field, $match, $limit, $offset)
			->get('entities')
			->result();

		// If we found any, we create their objects.
		if ($db_entities)
		{
			foreach ($db_entities as $db_entity)
			{
				$entities[] = new KB_Entity($db_entity);
			}
		}

		// Return the final result.
		return $entities;
	}

	// ------------------------------------------------------------------------
	// Update Entities.
	// ------------------------------------------------------------------------

	/**
	 * Update a single entity by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID (or username).
	 * @param 	array 	$data 	The array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		// Updating by id?
		if (is_numeric($id)) {
			return $this->update_by(array('id' => $id), $data);
		}

		// Updating by username?
		if (is_string($id)) {
			return $this->update_by(array('username' => $id), $data);
		}

		// Otherwise, let the "get_by" handle it.
		return $this->update_by($id, $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single, all or multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * 
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

		/**
		 * We make sure the username is always URL-titled and proceed
		 * only if it is not taken.
		 * @since 	1.5.0
		 */
		if (isset($data['username']))
		{
			$data['username'] = url_title($data['username'], '-', true);
			if (false !== $this->get_by('username', $data['username']))
			{
				return false;
			}
		}

		// Prepare out update statement.
		$this->ci->db->set($data);

		// Are there where conditions?
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];

			/**
			 * We let the parent generate the WHERE clause.
			 *
			 * @since 	1.3.0
			 */
			$this->_parent->where($args);
		}

		// Proceed to update.
		return $this->ci->db->update('entities');
	}

	// ------------------------------------------------------------------------
	// Delete Entities.
	// ------------------------------------------------------------------------

	/**
	 * Soft delete a single entity by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten.
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
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

		// Otherwise, we let the "delete_by" handle the rest.
		return $this->delete_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single, all or multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause and
	 *         			we added the optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	This is required to avoid deleting all.
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Did we provide a limit?
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		// Let's prepare the WHERE clause.
		(is_array($field)) OR $field = array($field => $match);

		// We make sure to target only undeleted entities.
		$field['deleted'] = 0;

		// Now we use the "update_by" method.
		return $this->update_by($field, array(
			'deleted'    => 1,
			'deleted_at' => time(),
		));
	}

	// ------------------------------------------------------------------------
	// Remove Entities.
	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single entity by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "remove_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
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

		// Otherwise, we let the "remove_by" method do the rest.
		return $this->remove_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Complete remove a single, all or multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause and 
	 *         			we added optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	This is required to avoid deleting all.
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's first find entities.
		$entities = $this->get_many($field, $match, $limit, $offset);

		// If no entity is found, nothing to do.
		if ( ! $entities)
		{
			return false;
		}

		// Let's delete them one by one.
		foreach ($entities as $e)
		{
			/**
			 * To avoid deleting things if a row is not deleted, we track
			 * the delete status and continue if it's successful.
			 */
			$status = false;

			/**
			 * NOTE:
			 * Because users, objects and groups have their delete methods
			 * calling this class method, if we call them, they will get 
			 * soft deleted only. To override this, we simply use CodeIgniter
			 * to delete them from database.
			 */
			switch ($e->type)
			{
				/**
				 * In case of deleting a user, we make sure to remove data
				 * from "users" table and all user's "activities" table data.
				 */
				case 'user':
					// Now we remove the user from table.
					$status = $this->ci->db->delete('users', array('guid' => $e->id));
					
					// We delete activities only if the user was deleted.
					if ($status === true)
					{
						$this->_parent->activities->delete_by('user_id', $e->id);
					}
					break;

				/**
				 * In case of deleting a group or an object, we simply delete
				 * them from their respective tables, unless, you implement
				 * activities for groups or objects.
				 */
				case 'group':
					$status = $this->ci->db->delete('groups', array('guid' => $e->id));
					break;
				case 'object':
					$status = $this->ci->db->delete('objects', array('guid' => $e->id));
					break;
			}

			/**
			 * Now we check if the process was successful. If it was, we proceed
			 * with deleting everything related to the entity.
			 */
			if ($status === true)
			{
				// We delete entities having this one as parent or owner.
				$this->remove_by('parent_id', $e->id);
				$this->remove_by('owner_id', $e->id);

				// We remove all entity's meta and variables.
				$this->_parent->metadata->delete_by('guid', $e->id);
				$this->_parent->variables->delete_by('guid', $e->id);

				// Now we remove all entity's relations.
				$this->_parent->relations->delete_by('guid_from', $e->id);
				$this->_parent->relations->delete_by('guid_to', $e->id);

				// And finally, we remove the entity from "entities" table.
				$this->ci->db->delete('entities', array('id' => $e->id));
			}
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft deleted entity by ID or username.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "restore_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The entity's ID or username.
	 * @return 	boolean
	 */
	public function restore($id)
	{
		// Restoring by ID?
		if (is_numeric($id))
		{
			return $this->restore_by('id', $id);
		}

		// Restoring by username?
		if (is_string($id))
		{
			return $this->restore_by('username', $id);
		}

		// Otherwise, let the restore by handle the WHERE clause.
		return $this->restore_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple entities previously soft deleted by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause and 
	 *         			we added optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Use the limit if provided.
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		// Let's prepare the WHERE clause.
		(is_array($field)) OR $field = array($field => $match);

		// We make sure to target only deleted entities.
		$field['deleted >'] = 0;

		// Let's now update entities.
		return $this->update_by($field, array(
			'deleted'    => 0,
			'deleted_at' => 0,
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of stored entities.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array
	 */
	public function get_ids($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Prepare an empty $ids array.
		$ids = array();

		// Let's retrieve entities from database.
		$entities = $this->select('id')->get_many($field, $match, $limit, $offset);

		// If we found any, we fill $ids array.
		if ($entities)
		{
			foreach ($entities as $e)
			{
				$ids[] = (int) $e->id;
			}
		}

		// We return the final result.
		return $ids;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of requested entities IDS.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for backward compatibility.
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array
	 */
	public function get_all_ids($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return $this->get_ids($field, $match, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Counts entities by arbitrary WHERE clause.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed	 $match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	public function count($field = null, $match = null, $limit = 0, $offset = 0)
	{
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities');

		return $query->num_rows();
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entities_ids'))
{
	/**
	 * Returns an array of all availables entities.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$param
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array
	 */
	function get_entities_ids($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->get_ids($field, $match, $limit, $offset);
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
		return get_instance()->kbcore->entities->create($data);
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
		return get_instance()->kbcore->entities->get($id);
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
		return get_instance()->kbcore->entities->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_entities'))
{
	/**
	 * Retrieve multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of object if found, else null.
	 */
	function get_entities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_entities'))
{
	/**
	 * This function is used in order to search entities.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of entities if found, else null.
	 */
	function find_entities($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->find($field, $match, $limit, $offset);
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
		return get_instance()->kbcore->entities->update($id, $data);
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
			array(get_instance()->kbcore->entities, 'update_by'),
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
			array(get_instance()->kbcore->entities, 'update_by'),
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
		return get_instance()->kbcore->entities->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_entity_by'))
{
	/**
	 * Soft delete a single or multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow methods structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function delete_entity_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_entities'))
{
	/**
	 * Soft delete a single or multiple entities by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow methods structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function delete_entities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->delete_by($field, $match, $limit, $offset);
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
		return get_instance()->kbcore->entities->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_entity_by'))
{
	/**
	 * Completely remove a single or multiple entities and all what's
	 * related to them by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function remove_entity_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->remove_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_entities'))
{
	/**
	 * Completely remove a single or multiple entities and all what's
	 * related to them by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function remove_entities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->remove_by($field, $match, $limit, $offset);
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
		return get_instance()->kbcore->entities->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_entity_by'))
{
	/**
	 * Restore a single or multiple entities previously soft deleted
	 * by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function restore_entity_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_entities'))
{
	/**
	 * Restore a single or multiple entities previously soft deleted
	 * by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to match method's structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	boolean
	 */
	function restore_entities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_entities'))
{
	/**
	 * Counts entities from database with arbitrary WHERE clause and optional
	 * limit and offset.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	function count_entities($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->entities->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Entity
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Entity
{
	/**
	 * Entity data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The entity's ID.
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
	 * Retrieves the entity data and passes it to KB_Entity::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Entity's ID, username, object or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Entity) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$entity = get_entity($id);
			if ($entity) {
				$this->init($entity->data);
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
	public function init($entity) {
		$this->data = $entity;
		$this->id   = (int) $entity->id;
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
	 * Method for checking the existence of an entity in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the entity exists, else false.
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
	 * Method for updating the entity in database.
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
		$status = update_entity($this->id, $data);

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
			$status = update_entity($this->id, $this->queue);

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
