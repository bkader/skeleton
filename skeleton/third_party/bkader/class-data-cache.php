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
 * @since 		2.1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Data_Cache
 *
 * This class and its helpers can used to store anything in the global scope
 * in order to reduce DB access for example. The cache object stores all of
 * the cache data to memory and makes the cache contents available by using
 * a key, which is used to name and retrieve the cache contents.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.0
 * @version 	2.1.0
 */
class Data_Cache {

	/**
	 * Holds an array of the cached objects.
	 * @var array
	 */
	private $cache = array();

	/**
	 * Holds the amount of time a cache was requested, and found.
	 * in the cache.
	 * @var integer
	 */
	public $cache_hits = 0;

	/**
	 * Holds the amount of time a cache was requested, but did not exist.
	 * @var integer
	 */
	public $cache_misses = 0;

	/**
	 * Holds a list of global cache groups.
	 * @var array
	 */
	protected $groups = array();

	/**
	 * Reference of this object singleton.
	 * @static
	 * @var object
	 */
	protected static $instance;

	/**
	 * Reference to this class.
	 * @static
	 * @access 	public
	 * @param 	none
	 * @return 	object
	 */
	public static function instance()
	{
		isset(static::$instance) OR static::$instance = new self();
		return static::$instance;
	}

	// ------------------------------------------------------------------------
	// Magic methods.
	// ------------------------------------------------------------------------

	/**
	 * Nothing to do except registering shutdown function.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		register_shutdown_function(array($this, '__destruct'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for accessing object properties.
	 * @access 	public
	 * @param 	string 	$key 	The property to get.
	 * @return 	mixed 	Depends on the property.
	 */
	public function __get($key)
	{
		return $this->{$key};
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method for setting object properties.
	 * @access 	public
	 * @param 	string 	$key 	The property to set.
	 * @param 	mixed 	$value 	The property value.
	 * @return 	mixed 	THe newly set; property.
	 */
	public function __set($key, $value)
	{
		return $this->{$key} = $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic method used for checking existence of object property.
	 * @access 	public
	 * @param 	string 	$key 	The property to check.
	 * @return 	bool 	whether the property is set.
	 */
	public function __isset($key)
	{
		return isset($this->{$key});
	}

	// ------------------------------------------------------------------------

	/**
	 * Property used to unset object properties.
	 * @access 	public
	 * @param 	string 	$key 	The property to unset.
	 * @return 	void
	 */
	public function __unset($key)
	{
		unset($this->{$key});
	}

	// ------------------------------------------------------------------------

	/**
	 * Saves the object cache before object is completely destroyed.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	Aways returns true.
	 */
	public function __destruct()
	{
		return true;
	}

	// ------------------------------------------------------------------------
	// Class methods.
	// ------------------------------------------------------------------------

	/**
	 * Adds data to the cache if it does not already exist.
	 * @access 	public
	 * @param 	mixed 	$key 	What to cal the contents in the cache.
	 * @param 	mixed 	$data 	The contents to store in the cache.
	 * @param 	string 	$group 	Where to group the cache content. Default "defautl".
	 * @return 	bool 	true if data added, false on error or key existence.
	 */
	public function add($key, $data, $group = 'default')
	{
		// We don't proceed if cache is suspended.
		if (data_cache_suspend())
		{
			return false;
		}

		empty($group) && $group = 'default';

		if ($this->_exists($key, $group))
		{
			return false;
		}

		return $this->set($key, $data, $group);
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets the list of global cache groups.
	 * @access 	public
	 * @param 	mixed 	$groups 	Array, string or comma-separated string.
	 * @return 	void
	 */
	public function add_groups($groups)
	{
		is_array($groups) OR $groups = explode(',', $groups);

		asort($groups); // Alphabetically.
		$groups = array_fill_keys(array_clean($groups), true);

		$this->groups = array_merge($this->groups, $groups);
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets the data contents into the cache.
	 *
	 * The cache contents is grouped by the $group parameter followed by the
	 * $key. This allows for duplicate ids in unique groups. Therefore, naming of
	 * the group should be used with care and should follow normal function
	 * naming guidelines outside of core WordPress usage.
	 *
	 * @access 	public
	 * @param 	mixed  	$key 		What to call the contents in the cache.
	 * @param 	mixed  	$data 		The contents to store in the cache.
	 * @param 	string  $group 		Where to group the cache contents. Default 'default'.
	 * @return 	bool 	Always returns true.
	 */
	public function set($key, $data, $group = 'default')
	{
		empty($group) && $group = 'default';

		is_object($data) && $data = clone $data;

		$this->cache[$group][$key] = $data;
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieves the cache contents, if it exists.
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * key in the cache group. If the cache is hit (success) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @access 	public
	 * @param 	mixed 	$key 	What the contents in the cache are called.
	 * @param 	string 	$group 	Where the cache contents are grouped. Default 'default'.
	 * @param 	bool 	$found 	Whether the key was found in the cache (passed by reference).
	 * @return 	mixed 	false on failure to retrieve contents or the cache contents on success.
	 */
	public function get($key, $group = 'default', &$found = null)
	{
		empty($group) && $group = 'default';

		if ($this->_exists($key, $group))
		{
			$found = true;
			$this->cache_hits += 1;

			if (is_object($this->cache[$group][$key]))
			{
				return clone $this->cache[$group][$key];
			}

			return $this->cache[$group][$key];
		}

		$found = false;
		$this->cache_misses += 1;
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Replaces the contents in the cache, if contents already exist.
	 * @access 	public
	 * @param 	mixed 	$key 		What to call the contents in the cache.
	 * @param 	mixed 	$data 		The contents to store in the cache.
	 * @param 	string 	$group 		Where to group the cache contents. Default 'default'.
	 * @return bool False if not exists, true if contents were replaced.
	 */
	public function replace($key, $data, $group = 'default')
	{
		empty($group) && $group = 'default';

		if ( ! $this->_exists($key, $group))
		{
			return false;
		}

		return $this->set($key, $data, $group);
	}

	// ------------------------------------------------------------------------
	// Cleaners.
	// ------------------------------------------------------------------------

	/**
	 * Removes the contents of the cache key in the group if it exists.
	 * @access 	public
	 * @param 	mixed 	$key 	What the contents in the cache are called.
	 * @param 	string 	$group 	Optional. Where the cache contents are grouped. Default 'default'.
	 * @return 	bool 	true if the contents were deleted, else false.
	 */
	public function delete($key, $group = 'default')
	{
		empty($group) && $group = 'default';
		
		if ( ! $this->_exists($key, $group))
		{
			return false;
		}

		unset($this->cache[$group][$key]);
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Resets all cache keys.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function reset()
	{
		$groups = array_keys($this->cache);

		foreach ($groups as $group)
		{
			if (isset($this->groups[$group]))
			{
				unset($this->cache[$group]);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Clears the object cache of all data.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	Always returns true.
	 */
	public function flush()
	{
		$this->cache = array();
		return true;
	}

	// ------------------------------------------------------------------------
	// Increment/Decrement cache.
	// ------------------------------------------------------------------------

	/**
	 * Increments numeric cache item's value.
	 * @access 	public
	 * @param 	mixed 	$key 	The cache key to increment
	 * @param 	int 	$offset The amount by which to increment the item's value. Default 1.
	 * @param 	string 	$group 	The group the key is in. Default 'default'.
	 * @return 	mixed 	the item's new value if incremented, else false.
	 */
	public function increment($key, $offset = 1, $group = 'default')
	{
		empty($group) && $group = 'default';

		if ( ! $this->_exists($key, $group))
		{
			return false;
		}

		if ( ! is_numeric($this->cache[$group][$key]))
		{
			$this->cache[$group][$key] = 0;
		}

		$this->cache[$group][$key] += (int) $offset;

		if ($this->cache[$group][$key] < 0)
		{
			$this->cache[$group][$key] = 0;
		}

		return $this->cache[$group][$key];
	}

	// ------------------------------------------------------------------------

	/**
	 * Dcrements numeric cache item's value.
	 * @access 	public
	 * @param 	mixed 	$key 	The cache key to decrement
	 * @param 	int 	$offset The amount by which to decrement the item's value. Default 1.
	 * @param 	string 	$group 	The group the key is in. Default 'default'.
	 * @return 	mixed 	the item's new value if decremented, else false.
	 */
	public function decrement($key, $offset = 1, $group = 'default')
	{
		empty($group) && $group = 'default';

		if ( ! $this->_exists($key, $group))
		{
			return false;
		}

		if ( ! is_numeric($this->cache[$group][$key]))
		{
			$this->cache[$group][$key] = 0;
		}

		$this->cache[$group][$key] -= (int) $offset;

		if ($this->cache[$group][$key] < 0)
		{
			$this->cache[$group][$key] = 0;
		}

		return $this->cache[$group][$key];
	}

	// ------------------------------------------------------------------------
	// Stats.
	// ------------------------------------------------------------------------

	/**
	 * Echoes the stats of the caching.
	 *
	 * Gives the cache hits, and cache misses. Also prints every cached group,
	 * key and the data.
	 * 
	 * @access 	public
	 * @param 	bool 	$display 	Whether to return an array or HTML output.
	 * @return 	string
	 */
	public function stats($display = true)
	{
		if ($display === true)
		{
			$output = '<p>';
			$output .= "<strong>Cache Hits:</strong> {$this->cache_hits}<br />";
			$output .= "<strong>Cache Misses:</strong> {$this->cache_misses}<br />";
			$output .= '</p>';
			
			$output .= '<ul>';
			foreach ($this->cache as $group => $cache)
			{
				$output .= '<li><strong>Group</strong>: ';
				$output .= $group.' - (';
				$output .= number_format(strlen(serialize($cache)) / KB_IN_BYTES, 2);
				$output .= 'k)</li>';
			}
			$output .= '</ul>';

			return $output;
		}

		return array(
			'hits'   => $this->cache_hits,
			'misses' => $this->cache_misses,
			'cache'  => $this->cache,
		);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Checks whether a key exists in the cache.
	 * @param 	mixed 	$key 	Cache key to check for existence.
	 * @param 	string 	$group 	Cache group for the key existence check.
	 * @return 	bool 	Whether the key exists in the cache for the given group.
	 */
	private function _exists($key, $group)
	{
		$exists = isset($this->cache[$group]);
		$exists && $exists = (isset($this->cache[$group][$key]) OR array_key_exists($key, $this->cache[$group]));
		return $exists;
	}
}

// ------------------------------------------------------------------------
// Helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_suspend'))
{
	/**
	 * This method is used to temporary suspend cache. No more data can be
	 * added to the cache but already cache data can be retrieved.
	 * This is useful for actions, such us imports, when a lot of data
	 * would otherwise be almost useless added to the cache.
	 *
	 * Suspension lasts for a single page load at most. Remember to call this
	 * function again if you wish to re-enable cache adds earlier.
	 *
	 * @param 	bool 	$suspend 	Suspends the cache if true, enables it if false.
	 * @return 	bool 	The current suspension status.
	 */
	function data_cache_suspend($suspend = null)
	{
		static $suspended = false;
		
		is_bool($suspend) && $suspended = $suspend;
		
		return $suspended;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_instance'))
{
	/**
	 * Returns an instance of Data_Cache object.
	 * @param 	void
	 * @return 	object
	 */
	function data_cache_instance()
	{
		return Data_Cache::instance();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_init'))
{
	/**
	 * Sets up Object Cache Global and assigns it.
	 * @param 	none
	 * @return 	void
	 */
	function data_cache_init()
	{
		$GLOBALS['cs_cache'] = new Data_Cache();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_add'))
{
	/**
	 * Adds data to the cache if it does not already exist.
	 * @access 	public
	 * @param 	mixed 	$key 	What to cal the contents in the cache.
	 * @param 	mixed 	$data 	The contents to store in the cache.
	 * @param 	string 	$group 	Where to group the cache content. Default "defautl".
	 * @return 	bool 	true if data added, false on error or key existence.
	 */
	function data_cache_add($key, $data, $group = '')
	{
		return data_cache_instance()->add($key, $data, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_add_groups'))
{
	/**
	 * Sets the list of global cache groups.
	 * @access 	public
	 * @param 	mixed 	$groups 	Array, string or comma-separated string.
	 * @return 	void
	 */
	function data_cache_add_groups($groups)
	{
		return data_cache_instance()->add_groups($groups);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_set'))
{
	/**
	 * Sets the data contents into the cache.
	 *
	 * The cache contents is grouped by the $group parameter followed by the
	 * $key. This allows for duplicate ids in unique groups. Therefore, naming of
	 * the group should be used with care and should follow normal function
	 * naming guidelines outside of core WordPress usage.
	 *
	 * @access 	public
	 * @param 	mixed  	$key 		What to call the contents in the cache.
	 * @param 	mixed  	$data 		The contents to store in the cache.
	 * @param 	string  $group 		Where to group the cache contents. Default 'default'.
	 * @return 	bool 	Always returns true.
	 */
	function data_cache_set($key, $data, $group = '')
	{
		return data_cache_instance()->set($key, $data, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_get'))
{
	/**
	 * Retrieves the cache contents, if it exists.
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * key in the cache group. If the cache is hit (success) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @access 	public
	 * @param 	mixed 	$key 	What the contents in the cache are called.
	 * @param 	string 	$group 	Where the cache contents are grouped. Default 'default'.
	 * @param 	bool 	$found 	Whether the key was found in the cache (passed by reference).
	 * @return 	mixed 	false on failure to retrieve contents or the cache contents on success.
	 */
	function data_cache_get($key, $group = '', &$found = null)
	{
		return data_cache_instance()->get($key, $group, $found);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_replace'))
{
	/**
	 * Replaces the contents in the cache, if contents already exist.
	 * @access 	public
	 * @param 	mixed 	$key 		What to call the contents in the cache.
	 * @param 	mixed 	$data 		The contents to store in the cache.
	 * @param 	string 	$group 		Where to group the cache contents. Default 'default'.
	 * @return bool False if not exists, true if contents were replaced.
	 */
	function data_cache_replace($key, $data, $group = '')
	{
		return data_cache_instance()->replace($key, $data, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_delete'))
{
	/**
	 * Removes the contents of the cache key in the group if it exists.
	 * @access 	public
	 * @param 	mixed 	$key 	What the contents in the cache are called.
	 * @param 	string 	$group 	Optional. Where the cache contents are grouped. Default 'default'.
	 * @return 	bool 	true if the contents were deleted, else false.
	 */
	function data_cache_delete($key, $group = '')
	{
		return data_cache_instance()->delete($key, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_reset'))
{
	/**
	 * Resets all cache keys.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	function data_cache_reset()
	{
		return data_cache_instance()->reset();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_flush'))
{
	/**
	 * Clears the object cache of all data.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	Always returns true.
	 */
	function data_cache_flush()
	{
		return data_cache_instance()->flush();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_increment'))
{
	/**
	 * Increments numeric cache item's value.
	 * @access 	public
	 * @param 	mixed 	$key 	The cache key to increment
	 * @param 	int 	$offset The amount by which to increment the item's value. Default 1.
	 * @param 	string 	$group 	The group the key is in. Default 'default'.
	 * @return 	mixed 	the item's new value if incremented, else false.
	 */
	function data_cache_increment($key, $offset = 1, $group = '')
	{
		return data_cache_instance()->increment($key, $offset, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_decrement'))
{
	/**
	 * Dcrements numeric cache item's value.
	 * @access 	public
	 * @param 	mixed 	$key 	The cache key to decrement
	 * @param 	int 	$offset The amount by which to decrement the item's value. Default 1.
	 * @param 	string 	$group 	The group the key is in. Default 'default'.
	 * @return 	mixed 	the item's new value if decremented, else false.
	 */
	function data_cache_decrement($key, $offset = 1, $group = '')
	{
		return data_cache_instance()->decrement($key, $offset, $group);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('data_cache_stats'))
{
	/**
	 * Echoes the stats of the caching.
	 *
	 * Gives the cache hits, and cache misses. Also prints every cached group,
	 * key and the data.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	function data_cache_stats()
	{
		return data_cache_instance()->stats();
	}
}
