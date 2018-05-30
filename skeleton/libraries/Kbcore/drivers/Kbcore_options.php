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
 * Kbcore_options Class
 *
 * Handles all operations done on options stored in database.
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
class Kbcore_options extends CI_Driver implements CRUD_interface
{
	/**
	 * Array of cached options to reduce DB access.
	 * @var array
	 */
	private $cached;

	// ------------------------------------------------------------------------

	/**
	 * Get all autoloaded options from database and assign
	 * them to CodeIgniter config array.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_options Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new options.
	 * @access 	public
	 * @param 	array 	$data 	Array of data to insert.
	 * @return 	the new row ID if found, else false.
	 */
	public function create(array $data = array())
	{
		// If $data is empty, nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Make sure the name is set and unique.
		if ( ! isset($data['name']) OR $this->get_by('name', $data['name']))
		{
			return false;
		}

		/**
		 * Here we make sure to prepare "value" and "options" if they
		 * are set and not empty.
		 */
		if (isset($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}
		if (isset($data['options']))
		{
			$data['options'] = to_bool_or_serialize($data['options']);
		}

		// Insert the option into database.
		$this->ci->db->insert('options', $data);
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single row by it's primary ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Remove $single argument and use "get_by" method.
	 * 
	 * @access 	public
	 * @param 	mixed 	$name 		The primary key value.
	 * @return 	object if found, else null
	 */
	public function get($name)
	{
		// Getting by ID?
		if (is_string($name))
		{
			return $this->get_by('name', $name);
		}

		// Otherwise, let the "get_by" method handle the rest.
		return $this->get_by($name);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single option by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Remove $single argument and let parent handle WHERE clause.
	 * 
	 * @access 	public
	 * @param 	mixed 	$field 		Column name or associative array.
	 * @param 	mixed 	$match 		Comparison value.
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// We start with an empty $option.
		$option = false;

		// Attempt to get the option from database.
		$db_option = $this->_parent
			->where($field, $match, 1, 0)
			->get('options')
			->row();

		// If found, we create its object.
		if ($db_option)
		{
			$option = new KB_Option($db_option);
		}

		// Return the final result.
		return $option;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple options by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let parent handle WHERE clause and create
	 *         			objects for each found option.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Start with empty $options.
		$options = false;

		// Attempt to get options from database.
		$db_options = $this->_parent
			->where($field, $match, $limit, $offset)
			->get('options')
			->result();

		// If found any, create their objects.
		if ($db_options)
		{
			foreach ($db_options as $db_option)
			{
				$options[] = new KB_Option($db_option);
			}
		}

		// Return the final result.
		return $options;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all options.
	 * @access 	public
	 * @param 	int 	$limit 	Limit to use for getting records.
	 * @param 	int 	$offset Database offset.
	 * @return 	array o objects if found, else null.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single options by its name.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * 
	 * @access 	public
	 * @param 	mixed 	$name 	The option's name or array of WHERE clause.
	 * @param 	array 	$data 	Array of data to update.
	 * @return 	bool
	 */
	public function update($name, array $data = array())
	{
		// updating by name?
		if (is_string($name))
		{
			return $this->update_by(array('name' => $name), $data);
		}

		// Otherwise, let the "update_by" handle the rest.
		return $this->update_by($name, $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single, all or multiple options by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle WHERE clause.
	 * @access 	public
	 * @return 	bool
	 */
	public function update_by()
	{
		// Collect function arguments and make sure there are some.
		$args = func_get_args();
		if (empty($args))
		{
			return false;
		}

		// The data is always the last array.
		$data = array_pop($args);
		if ( ! is_array($data) OR empty($data))
		{
			return false;
		}

		// Format "value" and "options".
		if (isset($data['value']))
		{
			$data['value'] = to_bool_or_serialize($data['value']);
		}
		if (isset($data['options']))
		{
			$data['options'] = to_bool_or_serialize($data['options']);
		}

		// Prepare the update query.
		$this->ci->db->set($data);

		// All remaining arguments will be used as WHERE clause.
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$this->_parent->where($args);
		}

		// Proceed to update and return the status.
		return $this->ci->db->update('options');
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single option by its name.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better usage.
	 * @access 	public
	 * @param 	mixed 	$name 	The option's name or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete($name)
	{
		// Deleting by name?
		if (is_string($name))
		{
			return $this->delete_by('name', $name);
		}

		// Otherwise, let the "dlete_by" handle the rest.
		return $this->delete_by($name);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single, all or multiple options by arbitrary WHERE clause.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to let the parent handle the WHERE clause, and
	 *         			add optional limit and offset.
	 *
	 * @access 	public
	 * @param 	mixed 	$field 	Column name or associative array.
	 * @param 	mixed 	$match 	Comparison value.
	 * @return 	bool
	 */
	public function delete_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Delete them.
		$this->_parent
			->where($field, $match, $limit, $offset)
			->delete('options');

		// Return true if some rows were deleted.
		return ($this->ci->db->affected_rows() > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new option item.
	 * @access 	public
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$value 		the option's value.
	 * @param 	string 	$tab 		Where the option should be listed.
	 * @param 	string 	$field_type What type of filed input to display
	 * @param 	mixed 	$options 	Options to display on settings page.
	 * @param 	bool 	$required 	Whether to make the field required.
	 * @return 	bool
	 */
	public function add_item(
		$name,
		$value = null,
		$tab = '',
		$field_type = 'text',
		$options = '',
		$required = true)
	{
		return $this->create(array(
			'name'       => strtolower($name),
			'value'      => $value,
			'tab'        => $tab,
			'field_type' => $field_type,
			'options'    => $options,
			'required'   => ($required === true) ? 1 : 0,
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Update an option item if it exists or create it if it does not.
	 * @access 	public
	 * @param 	string 	$name 		the item name.
	 * @param 	mixed 	$new_value 	the new value.
	 * @return 	bool
	 */
	public function set_item($name, $new_value = null)
	{
		// Not found? Create it.
		if ( ! $this->get($name))
		{
			return $this->add_item($name, $new_value);
		}

		// Found? update it.
		return $this->update($name, array('value' => $new_value));
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single option item from cached array if found,
	 * then database then config array.
	 * @access 	public
	 * @param 	string 	$name
	 * @param 	mixed 	$default 	the default value to use if not found.
	 * @return 	mixed 	depends on the item's value
	 */
	public function item($name, $default = false)
	{
		// Cached? Get it.
		if (isset($this->cached[$name]))
		{
			return $this->cached[$name];
		}

		// Found in CodeIgniter config?
		if (null !== ($item = $this->ci->config->item($name)))
		{
			// Cached it first.
			$this->cached[$name] = $item;
			return $item;
		}

		// Try to get it.
		if (false !== ($item = $this->get_by('name', $name)))
		{
			// Cached it first.
			$this->cached[$name] = $item->value;
			return $item->value;
		}

		// Return the fall-back value.
		return $default;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all options by tab.
	 * @access 	public
	 * @param 	string 	$tab 	default: general
	 */
	public function get_by_tab($tab = 'general')
	{
		return $this->get_many('tab', $tab);
	}

}

// --------------------------------------------------------------------

if ( ! function_exists('get_option'))
{
	/**
	 * Retrieve a single option item.
	 * @param 	string 	$name 	 	the option's name.
	 * @param 	mixed 	$default 	the default value to use.
	 * @return 	mixed 	depends on the option.
	 */
	function get_option($name, $default = false)
	{
		return get_instance()->kbcore->options->item($name, $default);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_options'))
{
	/**
	 * Retrieve multiple options by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	array of objects if found, else null.
	 */
	function get_options($field = null, $match = null)
	{
		return get_instance()->kbcore->options->get_many($field, $match);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_option'))
{
	/**
	 * Create a new option item.
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$value 		the option's value.
	 * @param 	string 	$tab 		Where the option should be listed.
	 * @param 	string 	$field_type What type of filed input to display
	 * @param 	mixed 	$options 	Options to display on settings page.
	 * @param 	bool 	$required 	Whether to make the field required.
	 * @return 	bool
	 */
	function add_option(
		$name,
		$value = null,
		$tab = '',
		$field_type = 'text',
		$options = '',
		$required = true)
	{
		return get_instance()->kbcore->options->add_item($name, $value, $tab, $field_type, $options, $required);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_option'))
{
	/**
	 * Update a single option item if found, else creates it.
	 * @param 	string 	$name 		the option's name.
	 * @param 	mixed 	$new_value 	the new option value.
	 * @return 	bool
	 */
	function set_option($name, $new_value = null)
	{
		return get_instance()->kbcore->options->set_item($name, $new_value);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('delete_option'))
{
	/**
	 * Delete a single option item from database.
	 * @param 	string 	$name 	the option name.
	 * @return 	bool
	 */
	function delete_option($name)
	{
		return get_instance()->kbcore->options->delete($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_option_by'))
{
	/**
	 * Delete a single or multiple options by arbitrary WHERE clause.
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
	function delete_option_by($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->options->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_options'))
{
	/**
	 * Delete a single or multiple options by arbitrary WHERE clause.
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to follow method structure.
	 * 
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	bool
	 */
	function delete_options($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->kbcore->options->delete_by($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

/**
 * KB_Option
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.0
 */
class KB_Option
{
	/**
	 * Option data container.
	 * @var 	object
	 */
	public $data;

	/**
	 * The option's name.
	 * @var 	integer
	 */
	public $name = false;

	/**
	 * Array of data awaiting to be updated.
	 * @var 	array
	 */
	protected $queue = array();
	
	/**
	 * Constructor.
	 *
	 * Retrieves the option data and passes it to KB_Option::init().
	 *
	 * @access 	public
	 * @param 	mixed	 $name 	Option's name or WHERE clause.
	 * @return 	void
	 */
	public function __construct($name = 0) {
		// In case we passed an instance of this object.
		if ($name instanceof KB_Option) {
			$this->init($name->data);
			return;
		}

		// In case we passed the entity's object.
		elseif (is_object($name)) {
			$this->init($name);
			return;
		}

		if ($name) {
			$option = get_instance()->kbcore->options->get($name);
			if ($option) {
				$this->init($option->data);
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
	public function init($option) {
		$this->data = $option;
		$this->name = $option->name;

		// Format value and options.
		if ( ! empty($option->value)) {
			$option->value = from_bool_or_serialize($option->value);
		}
		if ( ! empty($option->options)) {
			$option->options = from_bool_or_serialize($option->options);
		}

		// Apply filters to value and options.
		$this->data->value   = apply_filters("option_value_{$this->name}", $option->value);
		$this->data->options = apply_filters("option_options_{$this->name}", $option->options);
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
		if ('ID' == $key OR 'id' == $key) {
			$key = 'name';
		}

		// Found in $data container or as this object property?
		return (isset($this->data->{$key}) OR isset($this->{$key}));
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for getting a property value.
	 * @access 	public
	 * @param 	string 	$key 	The property key to retrieve.
	 * @return 	mixed 	Depends on the property value.
	 */
	public function __get($key) {
		// Format the key.
		if ('ID' == $key OR 'id' == $key) {
			$key = 'name';
		}

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
		if ('ID' == $key OR 'id' == $key) {
			$key = 'name';
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
	 * Method for checking the existence of an option in database.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if the option exists, else false.
	 */
	public function exists() {
		return ( ! empty($this->name));
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
	 * Method for updating the option in database.
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
		$status = get_instance()->kbcore->options->update($this->name, $data);

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
			$status = get_instance()->kbcore->options->update($this->name, $this->queue);

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
