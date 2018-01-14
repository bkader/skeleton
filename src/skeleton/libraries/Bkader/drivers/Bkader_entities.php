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
		// Make sure to load entities model.
		$this->ci->load->model('bkader_entities_m');

		log_message('info', 'Bkader_entities Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use entities model methods too.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_entities_m, $method))
		{
			return call_user_func_array(
				array($this->ci->bkader_entities_m, $method),
				$params
			);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
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
	 * Once the entity is remove, we remove everything that is
	 * related to it: users, groups, objects, metadata, variables
	 * and relations.
	 * @access 	public
	 * @param 	int 	$id 	the entity's ID.
	 * @return 	bool
	 */
	public function remove($id)
	{
		// Get the entity first and make sure it exists.
		$ent = $this->ci->bkader_entities_m->with_deleted()->get($id);

		if ( ! $ent)
		{
			return false;
		}

		if ( ! $this->ci->bkader_entities_m->remove($id))
		{
			return false;
		}

		// Delete from the related table.
		switch ($ent->type)
		{
			case 'user':
				$this->_parent->users->delete($id);

				// Delete user's activities.
				$this->_parent->activities->delete_by('user_id', $id);
				break;
			case 'group':
				$this->_parent->groups->delete($id);
				break;
			case 'object':
				$this->_parent->objects->delete($id);
				break;
		}

		// Delete metadata.
		$this->_parent->metadata->delete_by('guid', $id);

		// Delete variables.
		$this->_parent->variables->delete_by('guid', $id);

		// Delete relations.
		$this->_parent->relations
			->where('guid_from', $id)
			->or_where('guid_to', $id)
			->delete();

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove multiple entities and everything that is related
	 * to each and everyone of them.
	 * @access 	public
	 * @param 	mixed
	 * @return 	bool
	 */
	public function remove_by()
	{
		$ents = call_user_func_array(
			array($this->ci->bkader_entities_m, 'get_many_by'),
			func_get_args()
		);

		if ( ! $ents)
		{
			return false;
		}

		foreach ($ents as $ent)
		{
			$this->remove($ent->id);
		}

		return true;
	}

}
