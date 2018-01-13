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
class Bkader_metadata extends CI_Driver
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
	 * Create multiple metadata for a given entity.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function create($guid, $meta, $value = null)
	{
		// We make sure the entity exists and $meta is provided.
		if ( ! $this->_parent->entities->get($guid) OR empty($meta))
		{
			return false;
		}

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
			if( ! $this->get($guid, $key))
			{
				$data[] = array(
					'guid'  => $guid,
					'name'  => $key,
					'value' => to_bool_or_serialize($val),
				);
			}
		}

		// Proceed only if $data is not empty.
		return ( ! empty($data))
			? ($this->ci->db->insert_batch('metadata', $data) > 0)
			: false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadat.
	 * @access 	public
	 * @param 	int 	$guid 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function update($guid, $meta, $value = null)
	{
		// Make sure the entity exists and metadata are provided.
		if ( ! $this->_parent->entities->get($guid) OR empty($meta))
		{
			return false;
		}

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
			$md = $this->get($guid, $key);

			// Found by same value? Nothing to do.
			if ($md && $md->value == $val)
			{
				continue;
			}

			// Found by different value? Update it.
			if ($md)
			{
				$this->ci->db
					->where('guid', $guid)
					->where('name', $key)
					->set('value', to_bool_or_serialize($val))
					->update('metadata');
			}
			else
			{
				$this->create($guid, $key, $val);
			}
		}

		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single or multiple metadata.
	 * @access 	public
	 * @return 	boolean
	 */
	public function delete($guid, $name = null)
	{
		// Make sure the entity exists.
		if ( ! $this->_parent->entities->get($guid))
		{
			return false;
		}

		// Proceed to deleting.
		$this->ci->db->where('guid', $guid);
		($name !== null) && $this->ci->db->where('name', $name);
		$this->ci->db->delete('metadata');
		return ($this->ci->db->affected_rows() > 0);
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
	public function get($guid, $name = null, $single = false)
	{
		// We start the search by $guid.
		$this->ci->db->where('guid', $guid);

		// If the name is provided, we look for that metadata.
		if ($name !== null)
		{
			// Complete DB query and attempt to get it.
			$meta = $this->ci->db
				->where('name', $name)
				->get('metadata')
				->row();

			// Found?
			if ($meta)
			{
				/**
				 * Here we format the metadata value because it may
				 * be an array or a string representation of a boolean.
				 */
				$meta->value = from_bool_or_serialize($meta->value);
				
				// Return only the value?
				if ($single === true)
				{
					return $meta->value;
				}
			}

			// Return the $meta object as-is.
			return $meta;
		}

		// The $name is not provided, we look for all metadata.
		$meta = $this->ci->db->get('metadata')->result();

		// Found any?
		if ($meta)
		{
			// Walk through all element and format their values.
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
	function add_meta($guid, $meta, $value = null)
	{
		return get_instance()->app->metadata->create($guid, $meta, $value);
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
	function update_meta($guid, $meta, $value = null)
	{
		return get_instance()->app->metadata->update($guid, $meta, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_meta'))
{
	function delete_meta($guid, $name = null)
	{
		return get_instance()->app->metadata->delete($guid, $name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_meta'))
{
	function get_meta($guid, $name = null, $single = false)
	{
		return get_instance()->app->metadata->get($guid, $name, $single);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('clean_meta'))
{
	function clean_meta()
	{
		return get_instance()->app->metadata->purge();
	}
}
