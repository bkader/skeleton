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
 * Bkader_metadata Class
 *
 * Handles all operation done on metadata.
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
class Bkader_metadata extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Bkader_metadata Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a single or multiple metadata.
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
	 * @access 	public
	 * @param 	int 	$id 	The meta ID.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		return $this->ci->db
			->where('id', $id)
			->get('metadata')
			->row();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single metadata by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else NULL
	 */
	public function get_by($field, $match = NULL)
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

		$meta = $this->ci->db->get('metadata')->row();

		// Found?
		if ($meta)
		{
			$meta->value = from_bool_or_serialize($meta->value);
		}

		return $meta;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple metadata by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else NULL
	 */
	public function get_many($field = NULL, $match = NULL, $limit = 0, $offset = 0)
	{
		// Argument provided?
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

		// Proceed to retrieving.
		$meta = $this->ci->db->get('metadata')->result();

		// Found? Format the value.
		if ($meta)
		{
			foreach ($meta as &$_meta)
			{
				$_meta->value = from_bool_or_serialize($_meta->value);
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
	 * Update a single row by its primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		// Make sure there are some data.
		if (empty($data))
		{
			return false;
		}

		// Prepare value.
		if (isset($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}

		// Proceed to update.
		$this->ci->db
			->where('id', $id)
			->set($data)
			->update('metadata');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadata.
	 * @access 	public
	 * @return 	boolean
	 *
	 * @example:
	 * $this->app->metadata->update_by(
	 * 		array('guid' => 1, 'name' => 'var_name'),
	 *   	array(
	 *   		'value'  => 'new_value',
	 *   		'params' => 'new_params'
	 *   	)
	 * );
	 */
	public function update_by()
	{
		// Let's first collect method arguments.
		$args = func_get_args();

		// If there are not, nothing to do.
		if (empty($args))
		{
			return FALSE;
		}

		/**
		 * Data to update is always the last argument
		 * and it must be an array.
		 */
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return FALSE;
		}

		// Prepare the value and params.
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

		// Proceed to update an return TRUE if all went good.
		$this->ci->db->update('metadata');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single metadata by its primary key.
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
	 * Delete multiple metadata by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
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
		$this->ci->db->delete('metadata');
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create multiple metadata for a given entity.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function add_meta($guid, $meta, $value = NULL)
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
		return ( ! empty($data))
			? $this->create($data)
			: FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single or multiple metadata of the selected entity.
	 * @access 	public
	 * @param 	int 	$guid 	The entiti'y id.
	 * @param 	string 	$name 	The metadata name
	 * @param 	bool 	$single Whether to return the metadata value.
	 * @return 	mixed
	 */
	public function get_meta($guid, $name = NULL, $single = FALSE)
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
			return ($meta && $single === TRUE) ? $meta->value : $meta;
		}

		// Multiple metadata.
		return $this->get_many('guid', $guid);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadata.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function update_meta($guid, $meta, $value = NULL)
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
			if ($md && from_bool_or_serialize($md->value) === $val)
			{
				continue;
			}

			// Found by different value? Update it.
			if ($md)
			{
				$this->update($md->id, array('value' => $val));
			}
			else
			{
				$this->add_meta($guid, $key, $val);
			}
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple metadata.
	 * @access 	public
	 * @return 	boolean
	 * 
	 * @example:
	 * To delete all metadata of an entity, just pass the ID.
	 * To delete a specific metadata, pass its name as the second parameter.
	 * To delete multiple one, pass their array as the second parameter or
	 * you can pass successive names.
	 */
	public function delete_meta()
	{
		$args = func_get_args();
		if (empty($args))
		{
			return FALSE;
		}

		// $guid is always the first element.
		$guid = array_shift($args);
		if ( ! is_numeric($guid))
		{
			return FALSE;
		}

		// Prepare WHERE clause.
		$where = array('guid' => $guid);

		// Are there arguments left?
		if ( ! empty($args))
		{
			// Get rid of deep nasty array.
			(is_array($args[0])) && $args = $args[0];
			$where['name'] = $args;
		}

		return $this->delete_by($where);
	}

	// ------------------------------------------------------------------------

	/**
	 * This method deletes all metadata that have to owners.
	 * @access 	public
	 * @return 	boolean
	 */
	public function purge()
	{
		$this->ci->db
			->where_not_in('guid', $this->_parent->entities->get_all_ids())
			->delete('metadata');

		return ($this->ci->db->affected_rows() > 0);
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
	 * @return 	boolean
	 */
	function add_meta($guid, $meta, $value = NULL)
	{
		return get_instance()->app->metadata->add_meta($guid, $meta, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_meta'))
{
	/**
	 * Retrieve a single or multiple metadata for the selected entity.
	 * @param 	int 	$guid 	The entity's ID.
	 * @param 	mixed 	$name 	The metadata name or array.
	 * @param 	bool 	$single Whether to retrieve the value instead of the object.
	 * @return 	mixed 	depends on the value of the metadata.
	 */
	function get_meta($guid, $name = NULL, $single = FALSE)
	{
		return get_instance()->app->metadata->get_meta($guid, $name, $single);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_meta_by'))
{
	/**
	 * Retrieve a single metadata by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else NULL
	 */
	function get_meta_by($field, $match = NULL)
	{
		return get_instance()->app->metadata->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_many_meta'))
{
	/**
	 * Retrieve multiple metadata by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	array of objects if found, else NULL
	 */
	function get_many_meta($field, $match = NULL)
	{
		return get_instance()->app->metadata->get_many($field, $match);
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
	 * @return 	boolean.
	 */
	function update_meta($guid, $meta, $value = NULL)
	{
		return get_instance()->app->metadata->update($guid, $meta, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_meta_by'))
{
	/**
	 * Update a single or multiple metadata.
	 * @return 	boolean
	 */
	function update_meta_by()
	{
		return call_user_func_array(
			array(get_instance()->app->metadata, 'update_by'),
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
	 * @param 	mixed 	$name 	The meta name or array.
	 * @return 	boolean
	 */
	function delete_meta($guid, $name = NULL)
	{
		return get_instance()->app->metadata->delete($guid, $name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_meta_by'))
{
	/**
	 * Delete multiple metadata by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_meta_by($field = null, $match = null)
	{
		return get_instance()->app->metadata->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('purge_meta'))
{
	/**
	 * Clean up metadata table from meta that have no existing entities.
	 * @return 	boolean
	 */
	function purge_meta()
	{
		return get_instance()->app->metadata->purge();
	}
}
