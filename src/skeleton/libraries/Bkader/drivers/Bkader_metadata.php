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
		// Make sure to load entities model.
		$this->ci->load->model('bkader_metadata_m');

		log_message('debug', 'Bkader_metadata Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use metadata model methods as well.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	array or method arguments.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_metadata_m, $method))
		{
			return call_user_func_array(array($this->ci->bkader_metadata_m, $method), $params);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
	}

	// ------------------------------------------------------------------------

	/**
	 * Create multiple metadata for a given entity.
	 * @access 	public
	 * @param 	int 	$id 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function create_for($id, $meta, $value = null)
	{
		// Make sure the entity exists and metadata are provided.
		if ( ! $this->_parent->entities->get($id) OR empty($meta))
		{
			return false;
		}

		// Turn things into an array.
		(is_array($meta)) OR $meta = array($meta => $value);

		// Prepare out array of metadata.
		$data = array();

		foreach ($meta as $key => $val)
		{
			$data[] = array(
				'guid'  => $id,
				'name'  => $key,
				'value' => $val,
			);
		}

		return $this->ci->bkader_metadata_m->insert_many($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single or multiple metadat.
	 * @access 	public
	 * @param 	int 	$id 	the entity's ID.
	 * @param 	mixed 	$meta 	string or array of name => value.
	 * @param 	mixed 	$value
	 * @return 	bool
	 */
	public function update_for($id, $meta, $value = null)
	{
		// Make sure the entity exists and metadata are provided.
		if ( ! $this->_parent->entities->get($id) OR empty($meta))
		{
			return false;
		}

		// Turn things into an array.
		(is_array($meta)) OR $meta = array($meta => $value);

		// Loop through all, update if found, create if not.
		foreach ($meta as $key => $val)
		{
			$md = $this->ci->bkader_metadata_m->get_by(array(
				'guid' => $id,
				'name' => $key,
			));

			// Found by same value? Nothing to do.
			if ($md && $md->value == $val)
			{
				continue;
			}

			// Found by different value? Update it.
			if ($md)
			{
				$this->ci->bkader_metadata_m->update($md->id, array(
					'value' => $val,
				));
			}
			else
			{
				$this->ci->bkader_metadata_m->insert(array(
					'guid'  => $id,
					'name'  => $key,
					'value' => $val,
				));
			}
		}

		return true;
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
	public function get_meta($guid, $name, $single = false)
	{
		$meta = $this->ci->bkader_metadata_m->get_by(array(
			'guid' => $guid,
			'name' => $name,
		));

		// Returning a single ?
		if ($meta && $single === true)
		{
			$meta = $meta->value;
		}

		return $meta;
	}

}
