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
 * Kbcore_menus Class
 *
 * Handles operations done on site navigations and menus.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.0
 */
class Kbcore_menus extends CI_Driver
{
	/**
	 * Holds the current front-end theme.
	 * @var string
	 */
	protected $_theme;

	/**
	 * Holds the current front-end theme language index.
	 * @var string
	 */
	protected $_theme_domain;

	/**
	 * Cache all current front-end menus locations to reduce DB access.
	 * @var array
	 */
	protected $_locations;

	/**
	 * Holds cached menus to reduce DB access.
	 * @var array
	 */
	protected $_menus;

	/**
	 * Array of relations between relations and menus.
	 * @var array
	 */
	protected $_locations_menus;

	/**
	 * Cached menus items to reduce DB access.
	 * @var array
	 */
	protected $_items;

	/**
	 * Cached relations between menus and items.
	 * @var array
	 */
	protected $_menus_items;

	/**
	 * Initialize class so that helpers would be available.
	 *
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function initialize()
	{
		// Make sure to load needed helpers.
		$this->ci->load->helper(array('url', 'html', 'inflector'));

		log_message('info', 'Kbcore_menus Class Initialized');
	}

	// ------------------------------------------------------------------------
	// Theme Methods.
	// ------------------------------------------------------------------------

	/**
	 * Return the currently active menu.
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function _theme()
	{
		/**
		 * We make sure to always cache things to reduce DB access;
		 * If the theme is not already cached, get it and cache it.
		 */
		if ( ! isset($this->_theme))
		{
			$this->_theme = $this->_parent->options->item('theme', 'default');
		}

		// Return the cached version.
		return $this->_theme;
	}
	// --------------------------------------------------------------------

	/**
	 * Returns the current theme's language index.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better performance.
	 * 
	 * @access 	private
	 * @return 	string 	The language index if found, else null.
	 */
	private function _theme_domain()
	{
		/**
		 * If the theme domain was not previously cached, we make sure to 
		 * cache it to avoid calling the Theme library next time.
		 */
		if ( ! isset($this->_theme_domain))
		{
			$this->_theme_domain = $this->ci->theme->theme_domain();
		}

		// Return the cached version.
		return $this->_theme_domain;
	}

	// ------------------------------------------------------------------------
	// Locations Methods.
	// ------------------------------------------------------------------------

	/**
	 * Add a single or multiple menus locations for the current theme.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better performance.
	 * 
	 * @access 	public
	 * @param 	string 	$slug 			the location slug.
	 * @param 	string 	$description 	The location's description or name.
	 * @return 	bool 	true if locations were updated, else false.
	 */
	public function add_location($slug, $description = null)
	{
		// Make it possible to add multiple locations.
		(is_array($slug)) OR $slug = array($slug => $description);

		// Array of locations to add.
		$locations = array();

		// We loop through all locations and add them.
		foreach ($slug as $key => $val)
		{
			// This line makes it possible to add location with only slug.
			if (is_int($key) && is_string($val))
			{
				$locations[$val] = htmlentities($description, ENT_QUOTES, 'UTF-8');
			}
			else
			{
				$locations[$key] = htmlentities($val, ENT_QUOTES, 'UTF-8');
			}
		}

		/**
		 * We now update locations only if provided ones are different
		 * from already stored locations.
		 */
		return ( ! empty($locations) && $locations <> $this->_get_locations())
			? $this->_set_locations($locations)
			: false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single location name.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	public
	 * @param 	string 	$slug 	The location's slug.
	 * @return 	string
	 */
	public function get_location($slug)
	{
		// Use "get_locations" method.
		$locations = $this->get_locations();
		return (isset($locations[$slug])) ? $locations[$slug] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the current theme's menus location.
	 * This method is called only of dashboard menus section so that locations
	 * names can be translated.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	public
	 * @return 	array
	 */
	public function get_locations()
	{
		// Get stored locations.
		$locations = $this->_get_locations();

		// Let's see if locations names need to be translated.
		foreach ($locations as $slug => &$name)
		{
			if (sscanf($name, 'lang:%s', $translated) === 1)
			{
				$name = $this->ci->lang->line($translated, $this->_theme_domain());
			}
		}

		// We return the final result.
		return $locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a menu location for the current theme.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	public
	 * @param 	string 	$slug 	The location's slug.
	 * @return 	bool 	true if the location was deleted, else false.
	 */
	public function delete_location($slug)
	{
		// Let's retrieve stored locations first.
		$locations = $this->_get_locations();

		// We remove the location only if found.
		if (isset($locations[$slug]))
		{
			// Unset it then update record.
			unset($locations[$slug]);
			return $this->_set_locations($locations);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve the menu assigned to the selected location.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Only one menu allowed per location.
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 *
	 * @access 	public
	 * @param 	string 	$slug 	The location's slug.
	 * @return 	object 	The menu's object if found, else null.
	 */
	public function get_location_menu($slug)
	{
		// We start with an empty $owner_id.
		$owner_id = 0;

		// Was the menu already cached? Use its ID.
		if (isset($this->_locations_menus[$slug]))
		{
			$owner_id = $this->_locations_menus[$slug];
		}
		// Otherwise, get it from database.
		else
		{
			$meta = $this->_parent->metadata->get_by(array(
				'name'  => 'menu_location',
				'value' => $slug,
			));

			// The meta is found? Use it.
			if ($meta)
			{
				$owner_id = $meta->guid;

				// Cache it to reduce DB access.
				$this->_locations_menus[$slug] = $owner_id;
			}
		}

		// Now we attempt to get the menu.
		return ($owner_id > 0) ? $this->get_menu($owner_id) : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Assign location to the selected menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 *
	 * @access 	public
	 * @param 	mixed 	$slug 			Location's slug or associative array.
	 * @param 	int 	$menu_it 	The menu's ID to which we assign the location.
	 * @return 	bool 	true if everything goes well, else false.
	 */
	public function set_location_menu($slug, $owner_id = 0)
	{
		// Turn everything into an array.
		(is_array($slug)) OR $slug = array($slug => $owner_id);

		// We get stored locations first.
		$db_locations = $this->_get_locations();

		// We loop through all elements and set them.
		foreach ($slug as $location => $menu_id)
		{
			// The location cannot be found? Ignore it.
			if ( ! isset($db_locations[$location]))
			{
				continue;
			}

			/**
			 * If $owner_id is set to 0, we make sure to remove the location
			 * from any existing menu.
			 */
			if ($menu_id == 0)
			{
				$this->_parent->metadata->update_by(
					array('name' => 'menu_location', 'value' => $location),
					array('value' => null)
				);
			}
			// Otherwise, we update/create the meta.
			else
			{
				$this->_parent->metadata->update_meta($menu_id, 'menu_location', $location);
			}
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve registered locations.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	private
	 * @return 	array
	 */
	private function _get_locations()
	{
		/**
		 * If locations are not already cached, we make sure to get them,
		 * cache them then return them.
		 */
		if ( ! isset($this->_locations))
		{
			$this->_locations = $this->_parent->options->item(
				'theme_menus_'.$this->_theme(),
				array() // Default value if not found.
			);
		}

		// Return the cached version.
		return $this->_locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update locations for the current theme.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	private
	 * @param 	array 	$locations
	 * @return 	object
	 */
	private function _set_locations($locations = array())
	{
		// We update cached locations.
		$this->_locations = $locations;

		// Prepare the option's name.
		$option_name = 'theme_menus_'.$this->_theme;

		// Get the options from database.
		$option = $this->_parent->options->get($option_name);

		// If the location option is found, we update it only.
		if ($option)
		{
			$option->value = $this->_locations;
			return $option->save();
		}

		// Otherwise, we create it.
		return $this->_parent->options->add_item($option_name, $this->_locations, 'menus', false);
	}

	// ------------------------------------------------------------------------
	// Menus Methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for creating a new menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code and to add the $slug option.
	 *
	 * @access 	public
	 * @param 	string 	$name 	The menu's name.
	 * @param 	string 	$description 	The menu's description.
	 * @param 	string 	$slug 	The menu's slug.
	 * @return 	mixed 	the menu ID if created, else false.
	 */
	public function add_menu($name, $description = null, $slug = null)
	{
		// We make sure the slug is provided.
		($slug === null) && $slug = $name;

		// We create the menu.
		return $this->_parent->groups->create(array(
			'subtype'     => 'menu',
			'username'    => url_title($slug, '-', true),
			'name'        => $name,
			'description' => $description,
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Update an existing menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten because Kbcore_groups was updated.
	 *
	 * @access 	public
	 * @param 	mixed 	$id 	The menu's ID or slug.
	 * @param 	string 	$name 	The menu's name.
	 * @param 	string 	$name 	The menu's description.
	 * @param 	string 	$name 	The menu's slug.
	 * @return 	bool 	true if the menu is updated, else false
	 */
	public function update_menu($id, $name, $description = null, $slug = null)
	{
		// We make sure the menu exists first.
		$menu = $this->get_menu($id);
		if ( ! $menu)
		{
			return false;
		}

		// We update the name.
		$menu->name = $name;

		/**
		 * If we provided a new slug for the menu, we make sure that
		 * it is different from the current one and also that it 
		 * is not used by another entity.
		 */
		if ($slug && $slug <> $menu->username && false === $this->get_menu($slug))
		{
			$menu->username = $slug;
		}

		// If we provided a description, use it.
		(null !== $description) && $menu->description = $description;

		// We update the menu.
		return $menu->save();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete the selected menu and all its data and items.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten because entities library was updated.
	 *
	 * @access 	public
	 * @param 	mixed 	$id 	The menu's ID, slug or array of WHERE clause.
	 * @return 	bool
	 */
	public function delete_menu($id)
	{
		// We make sure to remove only a menu.
		$where['type']    = 'group';
		$where['subtype'] = 'menu';

		// What column to use?
		$column = (is_numeric($id)) ? 'id' : 'username';
		$where[$column] = $id;

		/**
		 * Because we have rewritten the entities library to remove all
		 * entity's related data, all lines are unnecessary, so we only
		 * call the "remove_by" method.
		 */
		return $this->_parent->entities->remove_by($where);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single menu by its ID or slug.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	mixed 	$id 	The menu's ID or slug.
	 * @return 	mixed 	menu's object if found, else false.
	 */
	public function get_menu($id)
	{
		// We start with an empty $menu.
		$menu = false;

		// Do we have already cached menus? We look for it there.
		if (isset($this->_menus))
		{
			// Are we getting by ID?
			if (is_numeric($id) && isset($this->_menus[$id]))
			{
				$menu = $this->_menus[$id];
			}
			// Otherwise, we look for it by its slug.
			else
			{
				foreach ($this->_menus as $_id => $_menu)
				{
					if ($_menu->username == $id)
					{
						$menu = $_menu;
						break;
					}
				}
			}
		}

		// If we have no menus cached, or the menu was not found, we get it.
		if (false === $menu)
		{
			// We prepare our WHER clause.
			$where['subtype'] = 'menu';
			$column           = (is_numeric($id)) ? 'id' : 'username';
			$where[$column]   = $id;

			// We attempt to get the menu from database.
			$db_menu = $this->_parent->groups->get_by($where);

			// If the menu was found, we add the location's name.
			if ($db_menu)
			{
				// We assign $db_menu to $menu.
				$menu = $db_menu;

				// Get our available locations and their names.
				$locations = $this->get_locations();
				$menu->location_name = null;
				if ($menu->menu_location && isset($locations[$menu->menu_location]))
				{
					$menu->location_name = $locations[$menu->menu_location];
				}

				// We make sure to cache the menu to reduce DB access.
				$this->_menus[$menu->id] = $menu;
			}
		}

		// Return the final result.
		return $menu;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieves all menus stored in database.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function get_menus()
	{
		// We start with an empty $menus.
		$menus = array();

		// We count menus for comparison purpose.
		$menus_count = $this->_parent->entities->count(array(
			'type'    => 'group',
			'subtype' => 'menu',
		));

		/**
		 * If there were some menus cached, we make sure that the count
		 * is identical to $menus_count to return them, this means that 
		 * they were all cached. Otherwise, we get all menus from database
		 * then cache them form later use.
		 */
		if (isset($this->_menus) && count($this->_menus) === $menus_count)
		{
			$menus = $this->_menus;
		}
		else
		{
			// Get menus from database.
			$db_menus = $this->_parent->groups->get_many('subtype', 'menu');

			// Did we find any?
			if ($db_menus)
			{
				// Assign them to $menus.
				$menus = $db_menus;

				// Get our available locations and their names.
				$locations = $this->get_locations();

				// We add locations names.
				foreach ($menus as $id => &$menu)
				{
					$menu->location_name = null;
					if ($menu->menu_location && isset($locations[$menu->menu_location]))
					{
						$menu->location_name = $locations[$menu->menu_location];
					}

					// We make sure to cache the menu to reduce DB access.
					$this->_menus[$menu->id] = $menu;
				}
			}
		}

		// We return the final result.
		return $menus;
	}

	// ------------------------------------------------------------------------
	// Menus Items Methods.
	// ------------------------------------------------------------------------

	/**
	 * Add a new item to the selected menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	int 	$owner_id 		The menu's ID or username.
	 * @param 	string 	$name 			The item's name.
	 * @param 	string 	$href 			The item's URL.
	 * @param 	string 	$description 	The item's description.
	 * @param 	array 	$attrs 			Array of additional item attributes.
	 * @param 	array 	$parent_id 		The item's parent used to build multilevel menus.
	 * @return 	int 	The new item's id if created, else false.
	 */
	public function add_item($owner_id, $name, $href = '#', $description = null, $attrs = array(), $parent_id = 0)
	{
		// We make sure the menu exists and $name is provided.
		$menu = $this->get_menu($owner_id);
		if (false === $menu OR empty($name))
		{
			return false;
		}

		// We make sure $owner_id is numeric.
		(is_numeric($owner_id)) OR $owner_id = $menu->id;

		// We make sure to format attributes and order.
		return $this->_parent->objects->create(array(
			'parent_id'   => $parent_id,
			'owner_id'    => $owner_id,
			'subtype'     => 'menu_item',
			'name'        => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
			'description' => $description,
			'content'     => $href,
			'attributes'  => $attrs,
			'order'       => $this->count_menu_items($owner_id),
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single item details.
	 *
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	int 	$id 			The item's ID.
	 * @param 	string 	$name 			The item's name (title).
	 * @param 	string 	$href 			The item's URL (content).
	 * @param 	string 	$description 	The item's description.
	 * @param 	array 	$attrs 			The item's extra attributes.
	 * @return 	bool 	true if the item was updated, else false.
	 */
	public function update_item($id, $name, $href = '#', $description = null, $attrs = array())
	{
		// We get the item and make sure it exists.
		$item = $this->get_item($id);
		if ( ! $item)
		{
			return false;
		}

		// We update things only if changed.
		($name <> $item->name) && $item->name = $name;
		($description <> $item->description) && $item->description = $description;
		($href <> $item->content) && $item->content = $href;

		// We update attributes now.
		$item->attributes = $attrs;

		// We proceed.
		return $item->save();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete an existing menu item from database.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to avoid doing bad things if wrong ID is passed.
	 *
	 * @access 	public
	 * @param 	int 	$id 	The item's ID.
	 * @return 	bool 	true if the item was remove, else false.
	 */
	public function delete_item($id)
	{
		return $this->_parent->entities->remove_by(array(
			'id'      => $id,
			'type'    => 'object',
			'subtype' => 'menu_item',
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single menu item by its ID.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	int 	$id 	The item's ID.
	 * @return 	object 	the item's object if found, else false.
	 */
	public function get_item($id)
	{
		// We start with empty $item.
		$item = false;

		// Found in cached items?
		if (is_numeric($id) && isset($this->_items[$id]))
		{
			$item = $this->_items[$id];
		}
		// Not cached? Get it from database.
		else
		{
			$db_item = $this->_parent->objects->get_by(array(
				'id' => $id,
				'subtype' => 'menu_item',
			));

			// Found?
			if ($db_item)
			{
				// Assign it to $item.
				$item = $db_item;

				// Add item order.
				$item->order = $db_item->order;
				$item->attributes = $db_item->attributes;

				// We cache the item to reduce DB access.
				$this->_items[$db_item->id] = $item;
			}
		}

		// Return the final result.
		return $item;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for retrieving all menu items from database.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function get_items()
	{
		// We prepare the array of cached items and items to return.
		$cached_ids = array();
		$items      = array();

		// Do we have items cached? Get them first.
		if (isset($this->_items))
		{
			$cached_ids = array_keys($this->_items);
			$items      = array_value($this->_items);
		}

		// We prepare our WHERE clause.
		$where['subtype'] = 'menu_item';
		if ( ! empty($cached_ids))
		{
			$where['!id'] = $cached_ids;
		}
		
		// We now get the rest from database.
		$db_items = $this->_parent->objects->get_many($where);

		// Did we find any?
		if ($db_items)
		{
			foreach ($db_items as $item)
			{
				// Temporary item so we can add order an attributes.
				$_item             = $item;
				$_item->order      = $item->order;
				$_item->attributes = $item->attributes;

				// Add it to items array.
				$items[]           = $item;

				// We make sure to cache it to reduce DB access.
				$this->_items[$item->id] = $_item;
			}
		}

		// We we have any items, we make sure to sort them.
		if ( ! empty($items))
		{
			usort($items, array($this, '_sort_items'));
		}

		// We return the final result.
		return $items;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for retrieving items listed under the selected menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	mixed 	$id 	The menu's ID or slug.
	 * @return 	array
	 */
	public function get_menu_items($id)
	{
		// We start with empty $items array.
		$items = array();

		// We make sure the menu exists.
		$menu = $this->get_menu($id);
		if (false === $menu)
		{
			return $items;
		}

		// We make sure $id is numeric.
		(is_numeric($id)) OR $id = $menu->id;

		// Maybe some items are cached, so we check them.
		$cached_ids = array();
		if (isset($this->_items))
		{
			foreach ($this->_items as $cached_id => &$cached_item)
			{
				if ($cached_item->owner_id == $id)
				{
					$cached_ids[]        = $cached_id;
					$items[]             = $cached_item;
				}
			}
		}

		// We prepare our WHERE clause to retrieve the rest from database.
		$where['owner_id'] = $id;
		$where['subtype']  = 'menu_item';
		(empty($cached_ids)) OR $where['!id'] = $cached_ids;

		// Attempt to get items from database.
		$db_items = $this->_parent->objects->get_many($where);

		// Did we find any?
		if ($db_items)
		{
			foreach ($db_items as $db_item)
			{
				// Temporary so we can edit it.
				$item             = $db_item;
				$item->order      = $db_item->order;
				$item->attributes = $db_item->attributes;

				// Add the item to items array.
				$items[] = $item;

				// We make sure to cache it to reduce DB access.
				$this->_items[$db_item->id] = $item;
			}
		}

		// We make sure to order items if we found any.
		if ( ! empty($items))
		{
			usort($items, array($this, '_sort_items'));
		}

		// Return the final result.
		return $items;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for counting menus items.
	 *
	 * @since 	1.3.0
	 * 
	 * @access 	public
	 * @param 	int 	$id 	The menu's ID or username.
	 * @return 	int
	 */
	public function count_menu_items($id)
	{
		// Are we counting by the menu's username?
		if ( ! is_numeric($id) && false !== $menu = $this->get_menu($id))
		{
			$id = $menu->id;
		}

		// Return items count.
		return $this->_parent->objects->count(array(
			'owner_id' => $id,
			'subtype'  => 'menu_item',
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Update items order for the given menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Kept for backward compatibility.
	 * 
	 * @access 	public
	 * @param 	int 	$id 	the menu's 	id.
	 * @param 	array 	$items 	array of item's IDs.
	 * @return 	boolean
	 */
	public function items_order($id, array $items = array())
	{
		return $this->order_menu_items($id, $items);
	}

	// ------------------------------------------------------------------------

	/**
	 * Update items order for the selected menu.
	 *
	 * @since 	1.3.0 	Created for better function name.
	 *
	 * @access 	public
	 * @param 	mixed 	$id 	The menu's ID or username.
	 * @param 	array 	$items 	Array of items IDs.
	 * @return 	bool 	true if everything goes well, else false.
	 */
	public function order_menu_items($id, array $items = array())
	{
		// If the menu does not exists, or we provide no items, nothing to do.
		$menu = $this->get_menu($id);
		if (false === $menu OR empty($items))
		{
			return false;
		}

		// We make sure $id is numeric.
		(is_numeric($id)) OR $id = $menu->id;

		// We start ordering.
		$i = 0;
		foreach ($items['item'] as $item_id)
		{
			// If any of the items was not updated, we stop the script.
			if ( ! $this->_parent->metadata->update_meta($item_id, 'order', $i))
			{
				return false;
			}

			// Iterate $i.
			$i++;
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for sorting items by their order.
	 *
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	object 	$a
	 * @param 	object 	$b
	 * @return 	int
	 */
	private function _sort_items($a, $b)
	{
		return $a->order - $b->order;
	}

	// ------------------------------------------------------------------------
	// Utilities.
	// ------------------------------------------------------------------------

	/**
	 * Method for building a menu by its ID, slug or location.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	updated because of some code refactoring.
	 *
	 * @access 	public
	 * @param 	array 	$args 	Arguments used to build the menu.
	 * @return 	string 	The fully built menu if found, else null.
	 */

	public function build_menu(array $args = array())
	{
		// Prepare default array.
		$defaults = array(
			// Location.
			'location' => null,
			// Menu.
			'menu'      => null,
			'menu_tag'  => 'ul',
			'menu_attr' => array(),
			// Container.
			'container'      => 'div',
			'container_attr' => array(),
			// Text before and after the link markup.
			'before' => null,
			'after'  => null,
			// Anchor class and text before and after the link text.
			'link_before'      => null,
			'link_after'       => null,
			'link_attr'        => array(),
			'parent_link_attr' => array(),
		);

		// Merge everything.
		$args = array_replace_recursive($defaults, $args);

		// Fire any filters targeting arguments.
		$args = apply_filters('menu_args', $args);

		// Now we extract everything.
		extract($args);

		// Make sure at least the location or menu are set.
		if (empty($menu) && empty($location))
		{
			return null;
		}
		// Only location is provided?
		elseif (empty($menu))
		{
			$menu = $this->get_location_menu($location);
		}
		// Otherwise, get the menu.
		else
		{
			$menu = $this->get_menu($menu);
		}

		// No menu found? Nothing to do.
		if (false === $menu)
		{
			return null;
		}

		// Retrieve menus items.
		$items = $this->get_menu_items($menu->id);
		
		// If there are no items, nothing to do.
		if ( ! $items)
		{
			return null;
		}
		
		// Start generating our output.
		$output = '%s';
		
		// Add menu ID and class if not already added.
		(empty($menu_attr['id'])) && $menu_attr['id'] = 'menu-'.$menu->username;
		$menu_class = "menu-{$menu->id} menu-{$menu->username}";
		(isset($menu_attr['class'])) && $menu_class .= ' '.$menu_attr['class'];
		$menu_attr['class'] = $menu_class;
		
		// Container.
		$container_allowed_tags = apply_filters('menu_container_allowed_tags', array('div', 'nav'));
		
		if (isset($container) && in_array($container, $container_allowed_tags))
		{
			$container_attr['aria-label'] = $menu->name;
			$container_attr['class'] = (isset($container_attr['class']))
				? "menu-container menu-container-{$menu->id} menu-{$menu->username}-container ".$container_attr['class']
				: "menu-container menu-container-{$menu->id} menu-{$menu->username}-container";
			$output = html_tag($container, $container_attr, '%s');
		}
		else
		{
			$menu_attr['aria-label'] = $menu->name;
		}
		
		// Menu.
		$menu_allowed_tags = apply_filters('menu_allowed_tags', array('div', 'ul'));
		$menu_tag = ( ! empty($menu_tag) && in_array($menu_tag, $menu_allowed_tags))
			? $menu_tag
			: 'ul';

		$output = sprintf($output, html_tag($menu_tag, $menu_attr, '%s'));
		
		// Before anchor.
		if ($menu_tag === 'ul')
		{
			$before = ( ! isset($before)) ? '<li>' : $before;
			$after  = ( ! isset($after)) ? '</li>' : $after;
		}
		
		(is_array($link_attr)) OR $link_attr = (array) $link_attr;
		
		// Build menu items.
		$items_output = '';
		
		foreach ($items as $item)
		{
			// Add the link location to attributes.
			$item_attr['href'] = (filter_var($item->content, FILTER_VALIDATE_URL) === false)
				? site_url($item->content)
				: $item->content;
			
			// Generate item class to be targeted.
			$item_attr['class'] = 'menu-item menu-item-'.$item->id;
			
			// If there is any extra class, append it.
			if (isset($link_attr['class']))
			{
				$item_attr['class'] .= ' '.$link_attr['class'];
				unset($link_attr['class']);
			}
			
			// Make sure to add the item id as well so we can target
			// it on the front-end.
			$item_attr['id'] = 'menu-item-'.$item->id;
			
			// There are attributes stored in database? Add them.
			if ( ! empty($item->attributes))
			{
				// We append the class to avoid overriding generic ones.
				if (isset($item->attributes['class']))
				{
					$item_attr['class'] .= ' '.$item->attributes['class'];
				}
			
				// Merge all attributes together.
				$item_attr = array_merge($item_attr, $link_attr, $item->attributes);
			}
			
			// Add to output.
			$items_output .= $before.html_tag('a', $item_attr, $link_before.htmlspecialchars_decode($item->name).$link_after).$after;
		}
		
		// Prepare the final output then return it.
		$output = sprintf($output, $items_output);
		return $output;
	}
}

// ------------------------------------------------------------------------
// List of helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('register_menu'))
{
	/**
	 * Function for adding a single or multiple menus locations for the
	 * currently used theme.
	 *
	 * @since 	1.0.0
	 *
	 * @param 	mixed 	$slug 		Location slug or associative array.
	 * @param 	string 	$description 	The location's description.
	 * @return 	object
	 */
	function register_menu($slug, $description = null)
	{
		return get_instance()->kbcore->menus->add_location($slug, $description);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('unregister_menu'))
{
	/**
	 * Function for unregistering a previously added menu location.
	 *
	 * @since 	1.0.0
	 *
	 * @param 	string 	$slug 	The location's slug.
	 * @return 	object
	 */
	function unregister_menu($slug)
	{
		return get_instance()->kbcore->menus->delete_location($slug);
	}
}

// ------------------------------------------------------------------------
// 
if ( ! function_exists('has_menu'))
{
	/**
	 * Returns true if a menu is register on the selected location.
	 * @param 	string 	$location 	the location's slug.
	 * @return 	boolean
	 */
	function has_menu($location)
	{
		return ( ! empty(get_instance()->kbcore->menus->get_location_menu($location)));
	}
}
// --------------------------------------------------------------------
if ( ! function_exists('build_menu'))
{
	/**
	 * Build a menu.
	 * @param 	array 	$args
	 * @return 	string
	 */
	function build_menu(array $args = array())
	{
		return get_instance()->kbcore->menus->build_menu($args);
	}
}
