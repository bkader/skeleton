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
 * Bkader_groups Class
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
class Bkader_groups extends CI_Driver
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
		// Make sure to load entities model.
		$this->ci->load->model('bkader_groups_m');

		log_message('debug', 'Bkader_groups Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use groups model methods too.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_groups_m, $method))
		{
			return call_user_func_array(
				array($this->ci->bkader_groups_m, $method),
				$params
			);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
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
		(isset($entity['type']) && $entity['type'] == 'group') OR $entity['type'] = 'group';

		// Let's insert the entity first and make sure it's created.
		$guid = $this->_parent->entities->insert($entity);
		if ( ! $guid)
		{
			return false;
		}

		// Add the id to group.
		$group['guid'] = $guid;

		// Insert the group.
		$this->ci->bkader_groups_m->insert($group);

		// If there are any metadata, insert them.
		if ( ! empty($meta))
		{
			$this->_parent->metadata->create_for($guid, $meta);
		}

		return $guid;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single group.
	 * @access 	public
	 * @param 	int 	$group_id
	 * @param 	array 	$data
	 * @return 	bool
	 */
	public function update($group_id, array $data = array())
	{
		// Empty $data? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $group, $meta) = $this->_split_data($data);

		// Update entity.
		if ( ! empty($entity) && ! $this->_parent->entities->update($group_id, $entity))
		{
			return false;
		}

		// Update group.
		if ( ! empty($group) && ! $this->ci->bkader_groups_m->update($group_id, $group))
		{
			return false;
		}

		// Some metadata.
		if ( ! empty($meta) && ! $this->_parent->metadata->update_for($group_id, $meta))
		{
			return false;
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all groups.
	 *
	 * @access 	public
	 * @return 	int
	 */
	public function count_all()
	{
		return $this->ci->bkader_groups_m->count_all();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all groups.
	 *
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of groups.
	 */
	public function get_all_groups($limit = 0, $offset = 0)
	{
		return $this->ci->bkader_groups_m->limit($limit, $offset)->get_all();
	}

	// ------------------------------------------------------------------------

	/**
	 * Split data upon creation or update into entities, groups and metadata.
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
			// Anything else is metadata.
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
