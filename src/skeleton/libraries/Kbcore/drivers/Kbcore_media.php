<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kbcore_media extends CI_Driver implements CRUD_interface
{
	/**
	 * Initialize class.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_media Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new media item.
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new media item ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// Make sure $data is provided.
		if (empty($data))
		{
			return false;
		}

		// Make sure the object subtype is always attachment.
		$data['subtype'] = 'attachment';

		// Proceed to creation.
		return $this->_parent->objects->create($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single media item by primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @return 	object if found, else null
	 */
	public function get($id)
	{
		return $this->get_by('id', $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single media item by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Make sure to add the "attachment subtype".
		$this->ci->db->where('entities.subtype', 'attachment');
		return $this->_parent->objects->get_by($field, $match);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple media items by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Make sure to add the "attachment subtype".
		$this->ci->db->where('entities.subtype', 'attachment');
		return $this->_parent->objects->get_many($field, $match, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all media items.
	 * @access 	public
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		// Make sure to add the "attachment subtype".
		$this->ci->db->where('entities.subtype', 'attachment');
		return $this->_parent->objects->get_all($limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single media item by its primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	boolean
	 */
	public function update($id, array $data = array())
	{
		return $this->_parent->update_by(array('id' => $id,'subtype' => 'attachment'), $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update all or multiple media items by arbitrary WHERE clause.
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

		// Prepare where clause.
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$args['subtype'] = 'attachment';
		}
		else
		{
			$args['subtype'] = 'attachment';
		}

		return $this->_parent->objects->update_by($args, $data);
	}

	/**
	 * Delete a single media item by its primary key.
	 * @access 	public
	 * @param 	mixed 	$id 	The primary key value.
	 * @return 	boolean
	 */
	public function delete($id)
	{
		return $this->_parent->objects->remove($id);
	}

	/**
	 * Delete multiple or all media items by arbitrary WHER clause.
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// See if items exist.
		$items = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($items)
		{
			$ids = array();
			foreach ($items as $item)
			{
				$ids[] = $item->id;
			}

			return $this->_parent->entities->remove('id', $ids);
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
		return $this->_parent->entities->restore($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted items.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null)
	{
		// Collect items.
		$items = $this->get_many($field, $match);

		if ($items)
		{
			$ids = array();
			foreach ($items as $item)
			{
				if ($item->deleted > 0)
				{
					$ids[] = $item->id;
				}
			}

			// Restore items in IDS.
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
			->where('entities.type', 'object')
			->where('entities.subtype', 'attachment')
			->join('objects', 'objects.guid = entities.id')
			->get('entities');

		return $rows->num_rows();
	}

	// ------------------------------------------------------------------------
	// Themes images sizes methods.
	// ------------------------------------------------------------------------

	public function add_image_size($name, $width = 0, $height = 0, $crop = false)
	{
		return $this->_set_theme_sizes(array(
			$name => array(
				'width'  => (int) $width,
				'height' => (int) $height,
				'crop'   => (bool) $crop,
			),
		));
	}

	private function _set_theme_sizes($sizes)
	{
		$option_name = 'theme_images_'.$this->_parent->options->item('theme');

		$option = $this->_parent->options->get($option_name);

		if ($option && $option->value == $sizes)
		{
			return true;
		}

		if ($option)
		{
			return $this->_parent->options->set_item($option_name, array_merge($option->value, $sizes));
		}

		return $this->_parent->options->create(array(
			'name'     => $option_name,
			'value'    => $sizes,
			'tab'      => 'theme',
			'required' => 0,
		));
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_image_size'))
{
	function add_image_size($name, $width = 0, $height = 0, $crop = false)
	{
		return get_instance()->kbcore->media->add_image_size($name, $width, $height, $crop);
	}
}
