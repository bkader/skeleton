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
 * Kbcore_groups Class
 *
 * Handles operations done on any thing tagged as a group.
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
class Kbcore_groups extends CI_Driver implements CRUD_interface
{
	/**
	 * Holds groups table fields.
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
		log_message('info', 'Kbcore_groups Class Initialized');
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
	 * Return an array of groups table fields.
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

		$this->fields = $this->ci->db->list_fields('groups');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new group.
	 * @access 	public
	 * @param 	array 	$data
	 * @return 	int 	the group's ID if created, else false.
	 */
	public function create(array $data = array())
	{
		// Nothing provided? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $group, $meta) = $this->_split_data($data);

		// Make sure to alwayas add the entity's type.
		$entity['type'] = 'group';

		// Let's insert the entity first and make sure it's created.
		$guid = $this->_parent->entities->create($entity);
		if ( ! $guid)
		{
			return false;
		}

		// Add the id to group.
		$group['guid'] = $guid;

		// Insert the group.
		$this->ci->db->insert('groups', $group);

		// If the are any metadata, create them.
		if ( ! empty($meta))
		{
			$this->_parent->metadata->add_meta($guid, $meta);
		}

		return $guid;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single group by ID or username.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The group's ID username or array of WHERE clause.
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
	 * Retrieve a single group by arbitrary WHERE clause.
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
		// We start with an empty group.
		$group = false;

		// We make sure to join "groups" table first.
		$this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id');

		// Attempt to get the group from database.
		$db_group = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('entities.id', 'DESC')
			->get('entities')
			->row();

		// If found, we create its object.
		if ($db_group)
		{
			$group = new KB_Group($db_group);
		}

		// Return the final result.
		return $group;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple groups by arbitrary WHERE clause.
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
		// We start with empty groups.
		$groups = false;

		// We make sure to select groups and join their table.
		$this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id');

		// Attempt to retrieve groups from database.
		$db_groups = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities')
			->result();

		// If found any, create their objects.
		if ($db_groups)
		{
			foreach ($db_groups as $db_group)
			{
				$groups[] = new KB_Group($db_group);
			}
		}

		// Return the final result.
		return $groups;
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
	 * This method is used in order to search groups.
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
		// We start with a empty $groups.
		$groups = false;

		// Attempt to find groups.
		$db_groups = $this->_parent
			->find($field, $match, $limit, $offset, 'groups')
			->get('entities')
			->result();

		// If we find any, we create their objects.
		if ($db_groups)
		{
			foreach ($db_groups as $db_group)
			{
				$groups[] = new KB_Group($db_group);
			}
		}

		return $groups;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single group.
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
		list($entity, $group, $meta) = $this->_split_data($data);

		// Update entity.
		if ( ! empty($entity) && ! $this->_parent->entities->update($id, $entity))
		{
			return false;
		}

		// Update groups table.
		if ( ! empty($group) 
			&& ! $this->ci->db->update('groups', $group, array('guid' => $id)))
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
	 * Update all or multiple groups by arbitrary WHERE clause.
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

		// Get groups
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$groups = $this->get_many($args);
		}
		else
		{
			$groups = $this->get_all();
		}

		// If there are any groups, proceed to update.
		if ($groups)
		{
			foreach ($groups as $group)
			{
				$this->update($group->id, $data);
			}

			return true;
		}

		// Nothing happened, return false.
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single group by ID, username or arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	Group's ID, username or array of WHERE clause.
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
	 * Delete multiple groups by arbitrary WHERE clause.
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
		$groups = $this->get_many($field, $match, $limit, $offset);

		// If no group found, nothing to do.
		if ( ! $groups)
		{
			return false;
		}

		// Let's prepare groups IDS.
		$ids = array();
		foreach ($groups as $group)
		{
			$ids[] = $group->id;
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
	 * Completely remove a single group by ID, username or arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "remove_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	Group's ID, username or array of WHERE clause
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
	 * Completely remove multiple groups by arbitrary WHERE clause.
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
		// See if groups exist.
		$groups = $this->get_many($field, $match, $limit, $offset);

		// If not groups found, nothing to do.
		if ( ! $groups)
		{
			return false;
		}

		// Collect groups IDs.
		$ids = array();
		foreach ($groups as $group)
		{
			$ids[] = $group->id;
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
	 * Restore a previously soft-deleted group.
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
		return $this->restore_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted groups.
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
		// Collect groups.
		$groups = $this->get_many($field, $match, $limit, $offset);

		// If not groups found, nothing to do.
		if (empty($groups))
		{
			return false;
		}

		// Collect groups IDs.
		$ids = array();
		foreach ($groups as $group)
		{
			$ids[] = $group->id;
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
	 * Count all groups.
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
		// We make sure to select only groups and join their table.
		$this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id');

		// We run the query now.
		$query = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('entities');

		// We return the count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Deletes groups that have no existing records in "entities".
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
		// We get existing groups IDs.
		$entities_ids = $this->_parent->entities->get_ids('type', 'group');

		// Let's see if there are groups.
		$groups = $this->ci->db
			->where_not_in('guid', $entities_ids)
			->get('groups')
			->result();

		// No groups found? Nothing to do.
		if ( ! $groups)
		{
			return false;
		}

		// Collect groups ids.
		$ids = array();
		foreach ($groups as $group)
		{
			$ids[] = $group->id;
		}

		// Double check $ids array.
		if (empty($ids))
		{
			return false;
		}

		// We delete groups.
		$this->ci->db
			->where_in('guid', $ids)
			->delete('groups');

		// Hold the status for later use.
		$status = ($this->ci->db->affected_rows() > 0);

		// Deleted? Remove everything related to them.
		if ($status === true)
		{
			// Remove any groups or objects owned by groups.
			$this->_parent->entities->remove_by('parent_id', $ids);
			$this->_parent->entities->remove_by('owner_id', $ids);

			// Delete all groups metadata and variables.
			$this->_parent->metadata->delete_by('guid', $ids);
			$this->_parent->variables->delete_by('guid', $ids);

			// Delete all groups relations.
			$this->_parent->relations->delete_by('guid_from', $ids);
			$this->_parent->relations->delete_by('guid_to', $ids);
		}

		// Return the process status.
		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Split data upon creation or update into entity and group.
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
			// Groups table.
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

if ( ! function_exists('add_group'))
{
	/**
	 * Create a single group.
	 * @param 	array 	$data 	array of data to insert.
	 * @return 	int 	The group's id if created, else false.
	 */
	function add_group(array $data = array())
	{
		return get_instance()->kbcore->groups->create($data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_group'))
{
	/**
	 * Retrieve a single group by ID, username or arbitrary WHERE clause.
	 * @param 	mixed 	$id
	 * @return 	object if found, else null.
	 */
	function get_group($id)
	{
		return get_instance()->kbcore->groups->get($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_group_by'))
{
	/**
	 * Retrieve a single group by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	function get_group_by($field, $match = null)
	{
		return get_instance()->kbcore->groups->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_groups'))
{
	/**
	 * Retrieve multiple groups by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function get_groups($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_all_groups'))
{
	/**
	 * Retrieve all groups with optional limit and offset.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	function get_all_groups($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->get_all($limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_groups'))
{
	/**
	 * This function is used in order to search groups.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function find_groups($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_group'))
{
	/**
	 * Update a single group by ID.
	 * @param 	int 	$id 	The group's ID.
	 * @param 	array 	$data 	Array of data to set.
	 * @return 	bool
	 */
	function update_group($id, array $data = array())
	{
		return get_instance()->kbcore->groups->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_group_by'))
{
	/**
	 * Update a single, all or multiple groups by arbitrary WHERE clause.
	 * @return 	bool
	 */
	function update_group_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->groups, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_groups'))
{
	/**
	 * Update a single, all or multiple groups by arbitrary WHERE clause.
	 * @return 	bool
	 */
	function update_groups()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->groups, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_group'))
{
	/**
	 * Delete a single group by ID or username.
	 * @param 	mixed 	$id 	ID or username.
	 * @return 	bool
	 */
	function delete_group($id)
	{
		return get_instance()->kbcore->groups->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_group_by'))
{
	/**
	 * Soft delete multiple groups by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function delete_group_by($field, $match = null)
	{
		return get_instance()->kbcore->groups->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_groups'))
{
	/**
	 * Soft delete multiple or all groups by arbitrary WHERE clause.
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
	function delete_groups($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_group'))
{
	/**
	 * Completely remove a group from database.
	 * @param 	mixed 	$id 	The group's ID, username or WhERE clause.
	 * @return 	bool
	 */
	function remove_group($id)
	{
		return get_instance()->kbcore->groups->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_group_by'))
{
	/**
	 * Completely remove multiple groups from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function remove_group_by($field, $match = null)
	{
		return get_instance()->kbcore->groups->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_groups'))
{
	/**
	 * Completely remove multiple or all groups from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	bool
	 */
	function remove_groups($field = null, $match = null)
	{
		return get_instance()->kbcore->groups->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_group'))
{
	/**
	 * Restore a previously soft-deleted group.
	 * @access 	public
	 * @param 	mixed 	$id 	The group's ID, username or WHERE clause.
	 * @return 	bool
	 */
	function restore_group($id)
	{
		return get_instance()->kbcore->groups->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_group_by'))
{
	/**
	 * Restore multiple or all soft-deleted groups.
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
	function restore_group_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_groups'))
{
	/**
	 * Restore multiple or all soft-deleted groups.
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
	function restore_groups($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->restore_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_groups'))
{
	/**
	 * Count all groups on database with arbitrary WHERE clause.
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
	function count_groups($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_groups'))
{
	/**
	 * Delete groups that has no records in "entities" table.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_groups($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->groups->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Group
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Group
{
	/**
	 * Group data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The group's ID.
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
	 * Retrieves the group data and passes it to KB_Group::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Group's ID, username, object or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Group) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$group = get_group($id);
			if ($group) {
				$this->init($group->data);
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
	public function init($group) {
		$this->data = $group;
		$this->id   = (int) $group->id;
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
	 * Method for checking the existence of an group in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the group exists, else false.
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
	 * Method for updating the group in database.
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
		$status = update_group($this->id, $data);

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
			$status = update_group($this->id, $this->queue);

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
