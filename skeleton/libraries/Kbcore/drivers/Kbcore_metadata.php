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
 * Kbcore_metadata Class
 *
 * Handles all operation done on metadata.
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
class Kbcore_metadata extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_metadata Class Initialized');
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
	 * Return an array of metadata table fields.
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

		$this->fields = $this->ci->db->list_fields('metadata');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a single or multiple metadata.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @access 	public
	 * @param 	array 	$data
	 * @return 	mixed 	int for a single meta, array of ids for multiple.
	 */
	public function create(array $data = array())
	{
		// Make sure there are some meta.
		if (empty($data))
		{
			return false;
		}

		// In case of multiple.
		if (isset($data[0]) && is_array($data[0]))
		{
			$ids = array();
			foreach ($data as $_data)
			{
				$ids[] = $this->create($_data);
			}

			return $ids;
		}

		// Check the integrity of of $data.
		if ( ! isset($data['guid'])
			OR ( ! isset($data['name']) OR empty($data['name'])))
		{
			return false;
		}

		// Make sure to prepare value.
		if (isset($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}

		$this->ci->db->insert('metadata', $data);
		return $this->ci->db->insert_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single metadata by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use the "get_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The meta ID or array of WHERE clause.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// Getting by ID?
		if (is_numeric($id))
		{
			return $this->get_by('id', $id);
		}

		// Otherwise, let the "get_by" method handle the rest.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single metadata by arbitrary WHERE clause.
	 * @access 	public
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause and 
	 *         			create the KB_Meta object.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null
	 */
	public function get_by($field, $match = null)
	{
		// We start with an empty meta.
		$meta = false;

		// Attempt to get the meta from database.
		$_meta = $this->_parent
			->where($field, $match, 1, 0)
			->order_by('id', 'DESC')
			->get('metadata')
			->row();

		// If the meta was found, we create the object.
		if ($_meta)
		{
			$meta = new KB_Meta($_meta);
		}

		// Return the final result.
		return $meta;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple metadata by arbitrary WHERE clause.
	 * @access 	public
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause
	 *         			and create KB_Meta objects.
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// We start with empty $meta.
		$meta = false;

		// Attempt to get metadata form database.
		$_meta = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('metadata')
			->result();

		// If we found any, create their objects.
		if ($_meta)
		{
			foreach ($_meta as $m)
			{
				$meta[] = new KB_Meta($m);
			}
		}

		// Return the final result.
		return $meta;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all metadata.
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
	 * This method is used in order to search metadata table.
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
		// We start with empty metadata
		$metadata = false;

		// Attempt to find metadata.
		$db_metadata = $this->_parent
			->find($field, $match, $limit, $offset)
			->get('metadata')
			->result();

		// If we found any, we create their objects.
		if ($db_metadata)
		{
			foreach ($db_metadata as $db_meta)
			{
				$metadata[] = new KB_Meta($db_meta);
			}
		}

		// Return the final result.
		return $metadata;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single row by its primary key.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "update_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	bool
	 */
	public function update($id, array $data = array())
	{
		// Are we updating by ID?
		if (is_numeric($id))
		{
			return $this->update_by(array('id' => $id), $data);
		}

		// Otherwise, let "update_by" handle the rest.
		return $this->update_by($id, $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadata.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * 
	 * @access 	public
	 * @return 	bool 	true if anything updated, else false.
	 */
	public function update_by()
	{
		// Let's first collect method arguments.
		$args = func_get_args();

		// If there are not, nothing to do.
		if (empty($args))
		{
			return false;
		}

		// Data to update is always the last argument and it must be an array.
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// We make sure to format "value" if provided.
		if (isset($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}

		// Prepare our query.
		$this->ci->db->set($data);

		// If there are any arguments left, they will use as WHERE clause.
		if ( ! empty($args))
		{
			// Get rid of nasty deep array.
			(is_array($args[0])) && $args = $args[0];

			// Let the parent handle the WHERE clause.
			$this->_parent->where($args);
		}

		// Proceed to update an return true if all went good.
		return $this->ci->db->update('metadata');
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single metadata by its primary key.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to use "delete_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$id 	The meta's ID or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete($id)
	{
		// Are we deleting by ID?
		if (is_numeric($id))
		{
			return $this->delete_by('id', $id, 1, 0);
		}

		// Otherwise, let "delete_by" handle the rest.
		return $this->delete_by($id, null, 1, 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple metadata by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0	Rewritten for better code readability, better performance
	 *         			and to add optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool 	true if any meta deleted, else false.
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Let's attempt to delete metadata.
		$this->_parent
			->where($field, $match, $limit, $offset)
			->delete('metadata');

		// Were there any rows deleted?
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create multiple metadata for a given entity.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function add_meta($guid, $meta, $value = null)
	{
		// Turn things into an array.
		(is_array($meta)) OR $meta = array($meta => $value);


		// Prepare out array of metadata.
		$data = array();

		// Loop through elements and fill $data.
		foreach ($meta as $key => $val)
		{
			/**
			 * The reason we are doing this check is to allow
			 * the user use the following structure:
			 * @example:
			 *
			 * update_meta(1, array(
			 *     'phone' => '0123456789',
			 *     'address', // <-- See this!
			 *     'company' => 'Company Name',
			 * ));
			 *
			 * Both "phone" and "company" will use their respective
			 * value while "address" and all other metadata using
			 * the same structure will use $value.
			 */
			if (is_int($key))
			{
				$key = $val;
				$val = $value;
			}

			// We make sure it does not exists first.
			if( ! $this->get_meta($guid, $key))
			{
				$data[] = array(
					'guid'  => $guid,
					'name'  => $key,
					'value' => $val,
				);
			}
		}

		// Proceed only if $data is not empty.
		return ( ! empty($data)) ? $this->create($data) : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single or multiple metadata of the selected entity.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @access 	public
	 * @param 	int 	$guid 	The entity's id.
	 * @param 	string 	$name 	The metadata name.
	 * @param 	bool 	$single Whether to return the metadata value.
	 * @return 	mixed
	 */
	public function get_meta($guid, $name = null, $single = false)
	{
		// A single metadata to retrieve?
		if ( ! empty($name))
		{
			// Multiple metadata?
			if (is_array($name))
			{
				return $ths->get_many(array(
					'guid' => $guid,
					'name' => $name,
				));
			}

			$meta = $this->get_by(array(
				'guid' => $guid,
				'name' => $name,
			));

			// Return the value or the whole object if found.
			return ($meta && $single === true) ? $meta->value : $meta;
		}

		// Multiple metadata.
		return $this->get_many('guid', $guid);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadata.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to remove merging meta with arrays as value.
	 * 
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function update_meta($guid, $meta, $value = null)
	{
		// Turn things into an array.
		(is_array($meta)) OR $meta = array($meta => $value);

		// Loop through all, update if found, create if not.
		foreach ($meta as $key => $val)
		{
			/**
			 * The reason we are doing this check is to allow
			 * the user use the following structure:
			 * @example:
			 *
			 * update_meta(1, array(
			 *     'phone' => '0123456789',
			 *     'address', // <-- See this!
			 *     'company' => 'Company Name',
			 * ));
			 *
			 * Both "phone" and "company" will use their respective
			 * value while "address" and all other metadata using
			 * the same structure will use $value.
			 */
			if (is_int($key))
			{
				$key = $val;
				$val = $value;
			}

			// Check if the metadata exists first.
			$md = $this->get_meta($guid, $key);

			// Found by same value? Nothing to do.
			if ($md && $md->value === $val)
			{
				continue;
			}

			// Found by different value? Update it.
			if ($md)
			{
				// Proceed to update.
				$this->update($md->id, array('value' => $val));
			}
			else
			{
				$this->add_meta($guid, $key, $val);
			}
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple metadata.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @access 	public
	 * @return 	bool
	 *
	 * @example:
	 * To delete all metadata of an entity, just pass the ID.
	 * To delete a specific metadata, pass its name as the second parameter.
	 * To delete multiple one, pass their array as the second parameter or
	 * you can pass successive names.
	 */
	public function delete_meta($guid, $name = null)
	{
		// Let's prepare the WHERE clause.
		$where['guid'] = $guid;

		// If we passed name(s), add them to where clause.
		if ($name !== null)
		{
			$where['name'] = $name;
		}

		return $this->delete_by($where);
	}

	// ------------------------------------------------------------------------

	/**
	 * Count metadata by arbitrary WHERE clause.
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
			->get('metadata');

		// We return the count.
		return $query->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * This method deletes all metadata that have no owners.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause and
	 *         			add optional limit and offset.
	 * 
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	public function purge($limit = 0, $offset = 0)
	{
		// Let's first retrieve entities IDs.
		$ids = $this->_parent->entities->get_ids();

		// We now use the "delete_by" method.
		return $this->delete_by('!guid', $ids, $limit, $offset);
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_meta'))
{
	/**
	 * Helper function to create a new meta data for the selected entity.
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	mixed 	$meta 	The metadata name or an associative array.
	 * @param 	mixed 	$value 	The metadata value.
	 * @return 	bool
	 */
	function add_meta($guid, $meta, $value = null)
	{
		return get_instance()->kbcore->metadata->add_meta($guid, $meta, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_meta'))
{
	/**
	 * Retrieve a single or multiple metadata for the selected entity.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	mixed 	$name 	The metadata name or array.
	 * @param 	bool 	$single Whether to retrieve the value instead of the object.
	 * @return 	mixed 	depends on the value of the metadata.
	 */
	function get_meta($guid, $name = null, $single = false)
	{
		return get_instance()->kbcore->metadata->get_meta($guid, $name, $single);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_meta_by'))
{
	/**
	 * Retrieve a single metadata by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null
	 */
	function get_meta_by($field, $match = null)
	{
		return get_instance()->kbcore->metadata->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_many_meta'))
{
	/**
	 * Retrieve multiple metadata by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null
	 */
	function get_many_meta($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->metadata->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_metadata'))
{
	/**
	 * This function is used in order to search metadata.
	 *
	 * @since 	1.3.2
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of metadata if found, else null.
	 */
	function find_metadata($field, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->metadata->find($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('metadata_exists'))
{
	/**
	 * Checks the existence of a metadata.
	 *
	 * @since 	1.3.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 *
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	string 	$name 	The meta name.
	 * @return 	bool 	true if the meta exists, else false.
	 */
	function metadata_exists($guid, $name)
	{
		return (get_meta($guid, $name) !== null);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_meta'))
{
	/**
	 * Update a single or multiple metadata for the selected entity.
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	mixed 	$meta 	The metadata name or associative array.
	 * @param 	mixed 	$value 	The metadata value.
	 * @return 	bool.
	 */
	function update_meta($guid, $meta, $value = null)
	{
		return get_instance()->kbcore->metadata->update($guid, $meta, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_meta_by'))
{
	/**
	 * Update a single or multiple metadata.
	 * @return 	bool
	 */
	function update_meta_by()
	{
		return call_user_func_array(
			array(get_instance()->kbcore->metadata, 'update_by'),
			func_get_args()
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_meta'))
{
	/**
	 * Delete a single or multiple metadata for the selected entity.
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	mixed 	$key 	The meta name or array.
	 * @return 	bool
	 */
	function delete_meta($guid, $key = null)
	{
		return get_instance()->kbcore->metadata->delete($guid, $key);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_meta_by'))
{
	/**
	 * Delete multiple metadata by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_meta_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->metadata->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_metadata'))
{
	/**
	 * Count metadata by arbitrary WHERE clause.
	 *
	 * @since 	1.3.0
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	int
	 */
	function count_metadata($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->metadata->count($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_metadata'))
{
	/**
	 * Clean up metadata table from meta that have no existing entities.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure
	 *
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function purge_metadata($limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->metadata->purge($limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Meta
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Meta
{
	/**
	 * Meta data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The meta's ID.
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
	 * Retrieves the meta data and passes it to KB_Meta::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $id 	Meta's ID or WHERE clause.
	 * @return 	void
	 */
	public function __construct($id = 0) {
		// In case we passed an instance of this object.
		if ($id instanceof KB_Meta) {
			$this->init($id->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($id)) {
			$this->init($id);
			return;
		}

		if ($id) {
			$meta = get_meta($id);
			if ($meta) {
				$this->init($meta->data);
			} else {
				$this->data = new stdClass();
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets up object properties.
	 *
	 * @since 	1.3.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * 
	 * @access 	public
	 * @param 	object
	 */
	public function init($meta) {
		$this->data = $meta;
		$this->id   = (int) $meta->id;

		// Format value.
		if ( ! empty($meta->value)) {
			$meta->value = from_bool_or_serialize($meta->value);
		}

		// Apply a filter so that plugins/themes can use it.
		$this->data->value = apply_filters("pre_meta_{$meta->name}", $meta->value);
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
	 * Method for checking the existence of an meta in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the meta exists, else false.
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
	 * Method for updating the meta in database.
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
		$status = update_meta_by(array('id' => $this->id), $data);

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
		// We start if false status.
		$status = false;

		// If there are enqueued changes, apply them.
		if ( ! empty($this->queue)) {
			$status = update_meta_by(array('id' => $this->id), $this->queue);

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
