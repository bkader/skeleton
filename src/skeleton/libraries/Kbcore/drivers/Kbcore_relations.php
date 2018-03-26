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
 * Kbcore_relations Class
 *
 * Handles all operations done on relationships between site entities.
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
	 * Create a single or multiple relations
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new row ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// Make sure we have data.
		if (empt($data))
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
		if (empt($data) OR ( ! isset($data['relation']) OR empty($data['relation'])))
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
			return false;
		}

		// Add the date of creation.
		(isset($data['created_at'])) OR $data['created_at'] = time();

		$this->ci->db->insert('relations', $dat);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single relation by its ID.
	 * @access 	public
	 * @param 	mixed 	$id 		The relation's ID.
	 * @param 	bool 	$single 	Whether to return the relation.
	 * @return 	object if found, else null
	 */
	public function get($id, $single = false)
	{
		return $this->get_by('id', $id, $single);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single relation by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	bool 	$single 	Whether to return the relation.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null, $single = false)
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

		$relation = $this->ci->db
			->order_by('id', 'DESC')
			->limit(1)
			->get('relations')
			->row();

		if ($relation)
		{
			return ($single === true) ? $relation->relation: $relation;
		}

		return null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple relations by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
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
		return $this->ci->db->get('relations')->result();
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
	 * Update a single relation by its primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		return $this->update_by(array('id' => $id), $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single, all or multiple relations by arbitrary WHERE clause.
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
		$this->ci->db->update('relations');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single relation by its primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->delete_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single, all or multiple relations by arbitrary WHER clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// Prepare our WHERE clause.
		if ( ! empty($field))
		{
			// Turn things into an array first.
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

		// Proceed to deletion.
		$this->ci->db->delete('relations');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Count relations.
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

		$rows = $this->ci->db->get('relations');

		return $rows->num_rows();
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
