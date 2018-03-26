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
 * Kbcore_groups Class
 *
 * Handles operations done on any thing tagged as a group.
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
	 * @access 	public
	 * @param 	mixed 	$id 	The group's ID or username.
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
	 * Retrieve a single group by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// The WHERE clause depends on $field and $match.
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

		// Proceed to join and get.
		return $this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id')
			->get('entities')
			->row();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple groups by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
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

		// Proceed to join and get.
		return $this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id')
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
	 * Update a single group.
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
		if ( ! empty($group) && ! $this->ci->bkader_groups_m->update($id, $group))
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
	 * Delete a single group by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->_parent->entities->delete($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple groups by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// See if groups exist.
		$groups = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($groups)
		{
			$ids = array();
			foreach ($groups as $group)
			{
				$ids[] = $group->id;
			}

			return $this->_parent->entities->delete_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single group by ID or username.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function remove($id)
	{
		return $this->_parent->entities->remove($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove multiple groups by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field = null, $match = null)
	{
		// See if groups exist.
		$groups = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($groups)
		{
			$ids = array();
			foreach ($groups as $object)
			{
				$ids[] = $object->id;
			}

			return $this->_parent->entities->remove_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft-deleted group.
	 * @access 	public
	 * @param 	int 	$id 	The group's ID.
	 * @return 	boolean
	 */
	public function restore($id)
	{
		return $this->_parent->entities->restore($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted groups.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null)
	{
		// Collect groups.
		$groups = $this->get_many($field, $match);

		if ($groups)
		{
			$ids = array();
			foreach ($groups as $group)
			{
				if ($group->deleted > 0)
				{
					$ids[] = $group->id;
				}
			}

			// Restore groups in IDS.
			return ( ! empty($ids))
				? $this->_parent->entities->restore_by('id', $ids)
				: false;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all groups.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	public function count($field = null, $match = null)
	{
		// Prepare where clause.
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

		$rows = $this->ci->db
			->where('entities.type', 'group')
			->join('groups', 'groups.guid = entities.id')
			->get('entities');

		return $rows->num_rows();
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

if ( ! function_exists('update_group'))
{
	/**
	 * Update a single group by ID.
	 * @param 	int 	$id 	The group's ID.
	 * @param 	array 	$data 	Array of data to set.
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_groups($field = null, $match = null)
	{
		return get_instance()->kbcore->groups->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_group'))
{
	/**
	 * Completely remove a group from database.
	 * @param 	int 	$id 	The group's ID or username.
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @return 	boolean
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
	 * @param 	int 	$id 	The group's ID.
	 * @return 	boolean
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
	 * Restore multiple soft-deleted groups.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_group_by($field, $match = null)
	{
		return get_instance()->kbcore->groups->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_groups'))
{
	/**
	 * Restore multiple or all soft-deleted groups.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_groups($field, $match = null)
	{
		return get_instance()->kbcore->groups->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_groups'))
{
	/**
	 * Count all groups on database with arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	function count_groups($field = null, $match = null)
	{
		return get_instance()->kbcore->groups->count($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_group'))
{
	/**
	 * Retrieve a single group by ID, groupname, email or arbitrary
	 * WHERE clause if $id an array.
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
