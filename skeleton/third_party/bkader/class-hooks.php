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
 * CS_Hooks class
 *
 * This is the class behind the hooks system used on WordPress, imported to
 * CodeIgniter Skeleton to bring whole new features and concept to the Framework.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Add-ons
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */
final class CS_Hooks implements Iterator, ArrayAccess
{
	/**
	 * Holds an array of registered callbacks.
	 * @var array
	 */
	public $callbacks = array();

	/**
	 * Holds the priority keys of actively running iterations of a hook.
	 * @var array
	 */
	private $iterations = array();

	/**
	 * Holds the current priority of actively running iterations of a hook.
	 * @var array
	 */
	private $current_priority = array();

	/**
	 * Number of levels this hooks can be recursively called.
	 * @var integer
	 */
	private $nesting_level = 0;

	/**
	 * Flag to doing an action rather than a filter.
	 * @var boolean
	 */
	private $doing_action = false;


	/**
	 * Hooks a function or method to a specific filter action.
	 *
	 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
	 * @param callable $function_to_add The callback to be run when the filter is applied.
	 * @param int      $priority        The order in which the functions associated with a
	 *                                  particular action are executed. Lower numbers correspond with
	 *                                  earlier execution, and functions with the same priority are executed
	 *                                  in the order in which they were added to the action.
	 * @param int      $accepted_args   The number of arguments the function accepts.
	 */
	public function add_filter($tag, $function_to_add, $priority, $accepted_args)
	{
		$idx = _filter_build_unique_id($tag, $function_to_add, $priority);
		$priority_existed = isset($this->callbacks[$priority]);
		
		$this->callbacks[$priority][$idx] = array(
			'function' => $function_to_add,
			'accepted_args' => $accepted_args
		);
		
		/**
		 * if we're adding a new priority to the list,
		 * put them back in sorted order
		 */
		if ( ! $priority_existed && count($this->callbacks) > 1)
		{
			ksort($this->callbacks, SORT_NUMERIC);
		}
		
		if ($this->nesting_level > 0)
		{
			$this->resort_active_iterations($priority, $priority_existed);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Handles reseting callback priority keys mid-iteration.
	 *
	 * @param bool|int $new_priority     Optional. The priority of the new filter being added. Default false,
	 *                                   for no priority being added.
	 * @param bool     $priority_existed Optional. Flag for whether the priority already existed before the new
	 *                                   filter was added. Default false.
	 */
	private function resort_active_iterations($new_priority = false, $priority_existed = false)
	{
		$new_priorities = array_keys($this->callbacks);
		
		// If there are no remaining hooks, clear out all running iterations.
		if ( ! $new_priorities)
		{
			foreach ($this->iterations as $index => $iteration)
			{
				$this->iterations[$index] = $new_priorities;
			}
			return;
		}
		
		$min = min($new_priorities);
		foreach ($this->iterations as $index => &$iteration)
		{
			$current = current($iteration);

			/**
			 * If we're already at the end of this iteration,
			 * just leave the array pointer where it is.
			 */
			if (false === $current)
			{
				continue;
			}
			
			$iteration = $new_priorities;
			
			if ($current < $min)
			{
				array_unshift($iteration, $current);
				continue;
			}
			
			while (current($iteration) < $current)
			{
				if (false === next($iteration))
				{
					break;
				}
			}

			/**
			 * If we have a new priority that didn't exist, but ::apply_filters()
			 * or ::do_action() thinks it's the current priority, and the new 
			 * priority is the same as what $this->iterations thinks is the previous
			 * priority, we need to move back to it.
			 */
			if ($new_priority === $this->current_priority[$index] && !$priority_existed)
			{
				// If we've already moved off the end of the array, go back to the last element.
				if (false === current($iteration))
				{
					$prev = end($iteration);
				}
				// Otherwise, just go back to the previous element.
				else
				{
					$prev = prev($iteration);
				}

				// Start of the array. Reset, and go about our day.
				if (false === $prev)
				{
					reset($iteration);
				}
				// Previous wasn't the same. Move forward again.
				elseif ($new_priority !== $prev)
				{
					next($iteration);
				}
			}
		}

		unset($iteration);
	}

	// ------------------------------------------------------------------------

	/**
	 * Unhooks a function or method from a specific filter action.
	 *
	 * @param string   $tag                The filter hook to which the function to be removed is hooked. Used
	 *                                     for building the callback ID when SPL is not available.
	 * @param callable $function_to_remove The callback to be removed from running when the filter is applied.
	 * @param int      $priority           The exact priority used when adding the original filter callback.
	 * @return bool Whether the callback existed before it was removed.
	 */
	public function remove_filter($tag, $function_to_remove, $priority)
	{
		$idx    = _filter_build_unique_id($tag, $function_to_remove, $priority);
		$exists = isset($this->callbacks[$priority][$idx]);

		if ($exists)
		{
			unset($this->callbacks[$priority][$idx]);

			if ( ! $this->callbacks[$priority])
			{
				unset($this->callbacks[$priority]);

				if ($this->nesting_level > 0)
				{
					$this->resort_active_iterations();
				}
			}
		}

		return $exists;
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks if a specific action has been registered for this hook.
	 *
	 * @param string        $tag               Optional. The name of the filter hook. Used for building
	 *                                         the callback ID when SPL is not available. Default empty.
	 * @param callable|bool $function_to_check Optional. The callback to check for. Default false.
	 * @return bool|int The priority of that hook is returned, or false if the function is not attached.
	 */
	public function has_filter($tag = '', $function_to_check = false)
	{
		if (false === $function_to_check)
		{
			return $this->has_filters();
		}
		
		$idx = _filter_build_unique_id($tag, $function_to_check, false);
		if ( ! $idx)
		{
			return false;
		}
		
		foreach ($this->callbacks as $priority => $callbacks)
		{
			if (isset($callbacks[$idx]))
			{
				return $priority;
			}
		}
		
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks if any callbacks have been registered for this hook.
	 * @return bool True if callbacks have been registered for the current hook, otherwise false.
	 */
	public function has_filters()
	{
		foreach ($this->callbacks as $callbacks)
		{
			if ($callbacks)
			{
				return true;
			}
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Removes all callbacks from the current filter.
	 * @param int|bool $priority Optional. The priority number to remove. Default false.
	 */
	public function remove_all_filters($priority = false)
	{
		if ( ! $this->callbacks)
		{
			return;
		}
		
		if (false === $priority)
		{
			$this->callbacks = array();
		}
		else if (isset($this->callbacks[$priority]))
		{
			unset($this->callbacks[$priority]);
		}
		
		if ($this->nesting_level > 0)
		{
			$this->resort_active_iterations();
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Calls the callback functions added to a filter hook.
	 *
	 * @param mixed $value The value to filter.
	 * @param array $args  Arguments to pass to callbacks.
	 * @return mixed The filtered value after all hooked functions are applied to it.
	 */
	public function apply_filters($value, $args)
	{
		if ( ! $this->callbacks)
		{
			return $value;
		}
		
		$nesting_level = $this->nesting_level++;
		
		$this->iterations[$nesting_level] = array_keys($this->callbacks);
		$num_args = count($args);
		
		do
		{
			$this->current_priority[$nesting_level] = $priority = current($this->iterations[$nesting_level]);
			
			foreach ($this->callbacks[$priority] as $the_)
			{
				if ( ! $this->doing_action)
				{
					$args[0] = $value;
				}
				
				if ($the_['accepted_args'] == 0)
				{
					$value = call_user_func_array($the_['function'], array());
				}
				elseif ($the_['accepted_args'] >= $num_args)
				{
					$value = call_user_func_array($the_['function'], $args);
				}
				else
				{
					$value = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
				}
			}
		} while (false !== next($this->iterations[$nesting_level]));
		
		unset(
			$this->iterations[$nesting_level],
			$this->current_priority[$nesting_level]
		);
		
		$this->nesting_level--;
		
		return $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Executes the callback functions hooked on a specific action hook.
	 *
	 * @param mixed $args Arguments to pass to the hook callbacks.
	 */	
	public function do_action($args)
	{
		$this->doing_action = true;
		$this->apply_filters('', $args);
		
		if ( ! $this->nesting_level)
		{
			$this->doing_action = false;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Processes the functions hooked into the 'all' hook.
	 *
	 * @param array $args Arguments to pass to the hook callbacks. Passed by reference.
	 */
	public function do_all_hook(&$args)
	{
		$nesting_level = $this->nesting_level++;
		$this->iterations[$nesting_level] = array_keys($this->callbacks);
		
		do
		{
			$priority = current($this->iterations[$nesting_level]);
			foreach ($this->callbacks[$priority] as $the_)
			{
				call_user_func_array($the_['function'], $args);
			}
		} while (false !== next($this->iterations[$nesting_level]));
		
		unset($this->iterations[$nesting_level]);
		$this->nesting_level--;
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the current priority level of the currently running iteration of the hook.
	 *
	 * @return int|false If the hook is running, return the current priority level. If it isn't running, return false.
	 */
	public function current_priority()
	{
		if (false === current($this->iterations))
		{
			return false;
		}
		
		return current(current($this->iterations));
	}

	// ------------------------------------------------------------------------

	/**
	 * Normalizes filters set up before Skeleton has initialized to CS_Hooks objects.
	 * 
	 * @static
	 *
	 * @param array $filters Filters to normalize.
	 * @return CS_Hooks[] Array of normalized filters.
	 */
	public static function build_prior_hooks($filters)
	{
		$normalized = array();
		
		foreach ($filters as $tag => $callback_groups)
		{
			if (is_object($callback_groups) && $callback_groups instanceof CS_Hooks)
			{
				$normalized[$tag] = $callback_groups;
				continue;
			}
			$hook = new CS_Hooks();
			
			foreach ($callback_groups as $priority => $callbacks)
			{
				
				foreach ($callbacks as $cb)
				{
					$hook->add_filter($tag, $cb['function'], $priority, $cb['accepted_args']);
				}
			}
			$normalized[$tag] = $hook;
		}
		return $normalized;
	}

	// ------------------------------------------------------------------------
	// ArrayAccess Methods.
	// ------------------------------------------------------------------------

	/**
	 * Determines whether an offset value exists.
	 *
	 * @see https://secure.php.net/manual/en/arrayaccess.offsetexists.php
	 *
	 * @param mixed $offset An offset to check for.
	 * @return bool True if the offset exists, false otherwise.
	 */
	public function offsetExists($offset)
	{
		return isset($this->callbacks[$offset]);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieves a value at a specified offset.
	 *
	 * @see https://secure.php.net/manual/en/arrayaccess.offsetget.php
	 *
	 * @param mixed $offset The offset to retrieve.
	 * @return mixed If set, the value at the specified offset, null otherwise.
	 */
	public function offsetGet($offset)
	{
		return isset($this->callbacks[$offset]) ? $this->callbacks[$offset] : null;
	}

	/**
	 * Sets a value at a specified offset.
	 *
	 * @see https://secure.php.net/manual/en/arrayaccess.offsetset.php
	 *
	 * @param mixed $offset The offset to assign the value to.
	 * @param mixed $value The value to set.
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->callbacks[] = $value;
		}
		else
		{
			$this->callbacks[$offset] = $value;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Unsets a specified offset.
	 *
	 * @see https://secure.php.net/manual/en/arrayaccess.offsetunset.php
	 *
	 * @param mixed $offset The offset to unset.
	 */
	public function offsetUnset($offset)
	{
		unset($this->callbacks[$offset]);
	}

	// ------------------------------------------------------------------------
	// Iterator Methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns the current element.
	 *
	 * @see https://secure.php.net/manual/en/iterator.current.php
	 *
	 * @return array Of callbacks at current priority.
	 */
	public function current()
	{
		return current($this->callbacks);
	}

	// ------------------------------------------------------------------------

	/**
	 * Moves forward to the next element.
	 *
	 * @see https://secure.php.net/manual/en/iterator.next.php
	 *
	 * @return array Of callbacks at next priority.
	 */
	public function next()
	{
		return next($this->callbacks);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the key of the current element.
	 *
	 * @see https://secure.php.net/manual/en/iterator.key.php
	 *
	 * @return mixed Returns current priority on success, or NULL on failure
	 */
	public function key()
	{
		return key($this->callbacks);
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks if current position is valid.
	 *
	 * @see https://secure.php.net/manual/en/iterator.valid.php
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return key($this->callbacks) !== null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Rewinds the Iterator to the first element.
	 *
	 * @see https://secure.php.net/manual/en/iterator.rewind.php
	 */
	public function rewind()
	{
		reset($this->callbacks);
	}
	
}

// ------------------------------------------------------------------------

// Defines filters and actions global variables.
global $cs_filter, $cs_actions, $cs_current_filter;

/**
 * If was have filters that were defined earlier, we make sure to 
 * build them so we can use them.
 */
$cs_filter = ($cs_filter)
	? CS_Hooks::build_prior_hooks($cs_filter)
	: array();

// We make sure actions and current filter are always array.
isset($cs_actions) OR $cs_actions = array();
isset($cs_current_filter) OR $cs_current_filter = array();

// ------------------------------------------------------------------------
// Filters functions.
// ------------------------------------------------------------------------

if ( ! function_exists('add_filter'))
{
	/**
	 * Hook a function or method to a specific filter action.
	 * @access 	public
	 * @param  string  $tag  The name of the filter to hook the $function_to_add callback to.
	 * @param  string $function_to_add  The callback to be run when the filter is applied.
	 * @param  int $priority  Used to specify the order in which the functions associated
	 * with a particular action are executed. Lower numbers correspond with earlier
	 * execution, and functions with the same priority are executed in the order in which
	 * they were added to the action.
	 * @param  int  $accepted_args  The number of arguments the function accepts.
	 * @return true
	 *
	 * @see  https://developer.wordpress.org/reference/functions/add_filter/
	 */
	function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		global $cs_filter;

		isset($cs_filter[$tag]) OR $cs_filter[$tag] = new CS_Hooks();

		$cs_filter[$tag]->add_filter($tag, $function_to_add, $priority, $accepted_args);
		return true;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('has_filter'))
{
	/**
	 * Check if any filter has been registered for a hook.
	 * @access 	public
	 * @param  string  $tag  The name of the filter hook.
	 * @param  string $function_to_check  The callback to check for.
	 * @return  false|int  If $function_to_check is omitted, returns boolean for
	 * whether the hook has anything registered. When checking a specific function,
	 * the priority of that hook is returned, or false if the function is not
	 * attached. When using the $function_to_check argument, this function may
	 * return a non-boolean value that evaluates to false (e.g.) 0, so use the === operator
	 * for testing the return value.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/has_filter/
	 */
	function has_filter($tag, $function_to_check = false)
	{
		global $cs_filter;
		return isset($cs_filter[$tag])
			? $cs_filter[$tag]->has_filter($tag, $function_to_check)
			: false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('apply_filters'))
{
	/**
	 * Call the functions added to a filter hook.
	 * @access 	public
	 * @param  string  $tag  The name of the filter hook.
	 * @param  mixed  $value  The value on which the filters hooked to $tag are applied on.
	 * @return  The filtered value after all hooked functions are applied to it.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/apply_filters/
	 */
	function apply_filters($tag, $value)
	{
		global $cs_filter, $cs_current_filter;
		
		$args = array();
		
		if (isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
			$args = func_get_args();
			_cs_call_all_hook($args);
		}
		
		if ( ! isset($cs_filter[$tag]))
		{
			if (isset($cs_filter['all']))
			{
				array_pop($cs_current_filter);
			}
			
			return $value;
		}
		
		if ( ! isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
		}
		
		empty($args) && $args = func_get_args();
		
		$filtered = $cs_filter[$tag]->apply_filters($value, $args);
		array_pop($cs_current_filter);
		return $filtered;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('apply_filters_ref_array'))
{
	/**
	 * Execute functions hooked on a specific filter hook, specifying arguments in an array.
	 * @access 	public
	 * @param  string  $tag  The name of the filter hook.
	 * @param  array  $args  The arguments supplied to the functions hooked to $tag.
	 * @return 	The filtered value after all hooked functions are applied to it.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/apply_filters_ref_array/
	 */
	function apply_filters_ref_array($tag, $args)
	{
		global $cs_filter, $cs_current_filter;
		
		if (isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
			$all_args = func_get_args();
			_cs_call_all_hook($all_args);
		}
		
		if ( ! isset($cs_filter[$tag]))
		{
			if (isset($cs_filter['all']))
			{
				array_pop($cs_current_filter);
			}

			return $args[0];
		}
		
		if ( ! isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
		}
		
		$filtered = $cs_filter[$tag]->apply_filters($args[0], $args);
		
		array_pop($cs_current_filter);
		
		return $filtered;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_filter'))
{
	/**
	 * Removes a function from a specified filter hook.
	 * @access  public
	 * @param  string  $tag  The filter hook to which the function to be removed is hooked.
	 * @param  string  $function_to_remove  The name of the function which should be removed.
	 * @param  int  $priority  The priority of the function.
	 * @return  bool  Whether the function existed before it was removed.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/remove_filter/
	 */
	function remove_filter($tag, $function_to_remove, $priority = 10)
	{
		global $cs_filter;
		
		$r = false;

		if (isset($cs_filter[$tag]))
		{
			$r = $cs_filter[$tag]->remove_filter($tag, $function_to_remove, $priority);
			
			if ( ! $cs_filter[$tag]->callbacks)
			{
				unset($cs_filter[$tag]);
			}
		}
		
		return $r;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_all_filters'))
{
	/**
	 * Remove all of the hooks from a filter.
	 * @access public
	 * @param  string  $tag  The filter to remove hooks from.
	 * @param  int|bool  $priority  The priority number to remove.
	 * @return  True when finished.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/remove_all_filters/
	 */
	function remove_all_filters($tag = null, $priority = false)
	{
		global $cs_filter;
		
		if (null !== $tag)
		{
			
			if (isset($cs_filter[$tag]))
			{
				$cs_filter[$tag]->remove_all_filters($priority);

				if ( ! $cs_filter[$tag]->has_filters())
				{
					unset($cs_filter[$tag]);
				}
			}
		}
		else
		{
			$cs_filter = array();
		}
		
		return true;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('current_filter'))
{
	/**
	 * Retrieve the name of the current filter or action.
	 * @access 	public
	 * @param 	none
	 * @return 	string 	Hook name of the current filter or action.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/current_filter/
	 */
	function current_filter()
	{
		global $cs_current_filter;
		return end($cs_current_filter);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('doing_filter'))
{
	/**
	 * Retrieve the name of a filter currently being processed.
	 * @access 	public
	 * @param 	string|null 	$filter 	Filter to check.
	 * @return 	bool
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/doing_filter/
	 *
	 * $filter. Defaults to null, which checks if any filter is currently being run.
	 */
	function doing_filter($filter = null)
	{
		global $cs_current_filter;

		return (null === $filter)
			? ( ! empty($cs_current_filter))
			: in_array($filter, $cs_current_filter);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('add_action'))
{
	/**
	 * Hooks a function on to a specific action.
	 * @access  public
	 * @param  string  $tag  The name of the action to which the $function_to_add is hooked.
	 * @param  string  $function_to_add  The name of the function you wish to be called.
	 * @param  int  $priority  Used to specify the order in which the functions associated
	 * with a particular action are executed. Lower numbers correspond with earlier execution,
	 * and functions with the same priority are executed in the order in which they were added
	 * to the action.
	 * @param  int  $accepted_args  The number of arguments the function accepts.
	 * @return  true  Will always return true.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/add_action/
	 */
	function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		return add_filter($tag, $function_to_add, $priority, $accepted_args);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('has_action'))
{
	/**
	 * Check if any action has been registered for a hook.
	 * @access 	public
	 * @param  string  $tag  The name of the action hook.
	 * @param  string  $function_to_check  The callback to check for.
	 * @return  bool|int  If $function_to_check is omitted, returns boolean
	 * for whether the hook has anything registered. When checking a specific
	 * function, the priority of that hook is returned, or false if the function
	 * is not attached. When using the $function_to_check argument, this function
	 * may return a non-boolean value that evaluates to false (e.g.) 0, so use
	 * the === operator for testing the return value.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/has_action/
	 */
	function has_action($tag, $function_to_check = false)
	{
		return has_filter($tag, $function_to_check);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('do_action'))
{
	/**
	 * Execute functions hooked on a specific action hook.
	 * @access 	public
	 * @param 	string 	$tag 	The name of the action to be executed.
	 * @param 	mixed 	$args 	Additional arguments which are passed on
	 * to the functions hooked to the action. Default empty.
	 * @return   void
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/do_action/
	 */
	function do_action($tag, $arg = '')
	{
		global $cs_filter, $cs_actions, $cs_current_filter;
		
		if ( ! isset($cs_actions[$tag]))
		{
			$cs_actions[$tag] = 1;
		}
		else
		{
			++$cs_actions[$tag];
		}
		
		if (isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
			$all_args            = func_get_args();
			_cs_call_all_hook($all_args);
		}
		
		if ( ! isset($cs_filter[$tag]))
		{
			if (isset($cs_filter['all']))
			{
				array_pop($cs_current_filter);
			}
			
			return;
		}
		
		if ( ! isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
		}
		
		$args = array();
		
		if (is_array($arg) 
			&& 1 == count($arg) 
			&& isset($arg[0]) 
			&& is_object($arg[0]))
		{
			$args[] =& $arg[0];
		}
		else
		{
			$args[] = $arg;
		}

		for ($a = 2, $num = func_num_args(); $a < $num; $a++)
		{
			$args[] = func_get_arg($a);
		}
		
		$cs_filter[$tag]->do_action($args);
		
		array_pop($cs_current_filter);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('do_action_ref_array'))
{
	/**
	 * Execute functions hooked on a specific action hook,
	 * specifying arguments in an array.
	 * @access 	public
	 * @param 	string 	$tag 	the name of the action to be executed.
	 * @param 	array 	$args 	the arguments supplied to the functions
	 * hooked to $tag.
	 *
	 * @see 	https://codex.wordpress.org/Function_Reference/do_action_ref_array
	 */
	function do_action_ref_array($tag, $args)
	{
		global $cs_filter, $cs_actions, $cs_current_filter;
		
		if ( ! isset($cs_actions[$tag]))
		{
			$cs_actions[$tag] = 1;
		}
		else
		{
			++$cs_actions[$tag];
		}
		
		if (isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
			$all_args = func_get_args();
			_cs_call_all_hook($all_args);
		}
		
		if ( ! isset($cs_filter[$tag]))
		{
			if (isset($cs_filter['all']))
			{
				array_pop($cs_current_filter);
			}

			return;
		}
		
		if ( ! isset($cs_filter['all']))
		{
			$cs_current_filter[] = $tag;
		}
		
		$cs_filter[$tag]->do_action($args);
		
		array_pop($cs_current_filter);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_action'))
{
	/**
	 * Removes a function from a specified action hook.
	 * @access 	public
	 * @param  string  $tag  The action hook to which the function to be removed is hooked.
	 * @param  string  $function_to_remove  The name of the function which should be removed.
	 * @return  bool  Whether the function is removed.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/remove_action/
	 */
	function remove_action($tag, $function_to_remove, $priority = 10)
	{
		return remove_filter($tag, $function_to_remove, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_all_actions'))
{
	/**
	 * Remove all of the hooks from an action.
	 * @access 	public
	 * @param 	string 		$tag 		The action to remove hooks from.
	 * @param 	int|bool 	$pririty 	The priority number to remove them from.
	 * @return 	bool 	true when finished.
	 */
	function remove_all_actions($tag = null, $priority = false)
	{
		return remove_all_filters($tag, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('current_action'))
{
	/**
	 * Retrieve the name of the current action.
	 * @access 	public
	 * @param 	none
	 * @return 	string 	Hook name of the current action.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/current_action/
	 */
	function current_action()
	{
		return current_filter();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('doing_action'))
{
	/**
	 * Retrieve the name of an action currently being processed.
	 * being processed.
	 * @access 	public
	 * @param 	string|null 	$action 	Action to check.
	 * @return 	bool
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/doing_action/
	 *
	 * $action Defaults to null, which checks if any action is currently being run.
	 */
	function doing_action($action = null)
	{
		return doing_filter($action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('did_action'))
{
	/**
	 * Retrieve the number of times an action is fired.
	 * @access 	public
	 * @param 	string 	$tag 	The name of the action hook.
	 * @return 	int 	The number of times action hook $tag is fired.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/did_action/
	 */
	function did_action($tag)
	{
		global $cs_actions;
		return isset($cs_actions[$tag]) ? $cs_actions[$tag] : 0;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_filter_build_unique_id'))
{
	/**
	 * Build Unique ID for storage and retrieval.
	 * @access 	private
	 * @param 	string 		$tag 		Used in counting how many hooks were applied.
	 * @param 	callback 	$function 	Used for creating unique id.
	 * @param 	int|bool 	$priority 	Used in counting how many hooks were applied.
	 * @return 	string|bool Unique ID or false in $callback === false.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/_wp_filter_build_unique_id/
	 *
	 * If $priority === false and $function is an object reference, we return the
	 * unique id only if it already has one, false otherwise.
	 */
	function _filter_build_unique_id($tag, $function, $priority)
	{
		global $cs_filters;
		static $filter_id_count = 0;
		
		if (is_string($function))
		{
			return $function;
		}
		
		$function = is_object($function) ? array($function, '') : (array) $function;
		
		if (is_object($function[0]))
		{
			if (function_exists('spl_object_hash'))
			{
				return spl_object_hash($function[0]).$function[1];
			}
			
			$obj_idx = get_class($function[0]).$function[1];
			
			if ( ! isset($funtion[0]->filter_id))
			{
				if (false === $priority)
				{
					return false;
				}
				
				$obj_idx .= isset($cs_filters[$tag][$priority]) 
					? count((array) $cs_filters[$tag][$priority])
					: $filter_id_count;
				
				++$filter_id_count;
			}
			else
			{
				$obj_idx .= $function[0]->filter_id;
			}
			
			return $obj_idx;
		}

		if (is_string($function[0]))
		{
			return $function[0].'::'.$function[1];
		}
	}
}
