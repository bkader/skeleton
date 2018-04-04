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
 * Plugins Class
 *
 * This class allows you to add filters and actions
 * not only to your themes but all your application.
 *
 * @package 	CodeIgniter
 * @category 	Libraries.
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class CI_Plugins
{
	/**
	 * Holds the list of registered hooks.
	 * @var array
	 */
	private $_filters = array();

	/**
	 * Holds a list of mergered filters.
	 * @var array
	 */
	private $_merged_filters = array();

	/**
	 * Holds a list of registered actions.
	 * @var array
	 */
	private $_actions = array();

	/**
	 * Holds the name of the current filter.
	 * @var array
	 */
	private $_current_filter = array();

	/**
	 * Instance of this class to call it statically.
	 * @var object
	 */
	private static $_instance;

	/**
	 * This method allow you to call this class methods 
	 * statically without loading it.
	 * @example 	CI_Plugins::instance()->add_filter().
	 * @access 	public
	 * @param 	none
	 * @return 	object
	 */
	public static function instance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	// ------------------------------------------------------------------------

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
	public function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		$uid = $this->_filter_build_unique_id($tag, $function_to_add, $priority);
		$this->_filters[$tag][$priority][$uid] = array(
			'function' => $function_to_add,
			'accepted_args' => $accepted_args
		);
		unset($this->_merged_filters[$tag]);
		return true;
	}

	// ------------------------------------------------------------------------

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
	public function has_filter($tag, $function_to_check = false)
	{
		$has = ( ! empty($this->_filters[$tag]));
		if ($function_to_check === false OR $has === false)
		{
			return $has;
		}

		if ( ! $uid = $this->_filter_build_unique_id($tag, $function_to_check, false))
		{
			return false;
		}

		foreach((array)array_keys($this->_filters[$tag]) as $priority)
		{
			if (isset($this->_filters[$tag][$priority][$uid]))
			{
				return $priority;
			}
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Call the functions added to a filter hook.
	 * @access 	public
	 * @param  string  $tag  The name of the filter hook.
	 * @param  mixed  $value  The value on which the filters hooked to $tag are applied on.
	 * @return  The filtered value after all hooked functions are applied to it.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/apply_filters/
	 */
	public function apply_filters($tag, $value)
	{
		$args = array();

		// Let's do all actions first.

		if (isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
			$args = func_get_args();
			$this->__call_all_filters($args);
		}

		if ( ! isset($this->_filters[$tag]))
		{
			if (isset($this->_filters['all']))
			{
				array_pop($this->_current_filter);
			}

			return $value;
		}

		if ( ! isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
		}

		// Let's sort things.

		if ( ! isset($this->_merged_filters[$tag]))
		{
			ksort($this->_filters[$tag]);
			$this->_merged_filters[$tag] = true;
		}

		reset($this->_filters[$tag]);
		if (empty($args))
		{
			$args = func_get_args();
		}

		do
		{
			foreach((array)current($this->_filters[$tag]) as $filter)
			{
				if ( ! is_null($filter['function']))
				{
					$args[1] = $value;
					$value = call_user_func_array($filter['function'], array_slice($args, 1, (int)$filter['accepted_args']));
				}
			}
		}

		while (next($this->_filters[$tag]) !== false);
		array_pop($this->_current_filter);
		return $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Execute functions hooked on a specific filter hook, specifying arguments in an array.
	 * @access 	public
	 * @param  string  $tag  The name of the filter hook.
	 * @param  array  $args  The arguments supplied to the functions hooked to $tag.
	 * @return 	The filtered value after all hooked functions are applied to it.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/apply_filters_ref_array/
	 */
	public function apply_filters_ref_array($tag, $args)
	{

		// Let's do all action first.

		if (isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
			$all_args = func_get_args();
			$this->__call_all_filters($all_args);
		}

		if ( ! isset($this->_filters[$tag]))
		{
			if (isset($this->_filters['all']))
			{
				array_pop($this->_current_filter);
			}

			return $args[0];
		}

		if ( ! isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
		}

		// Let's sort things.

		if ( ! isset($this->_merged_filters[$tag]))
		{
			ksort($this->_filters[$tag]);
			$this->_merged_filters[$tag] = true;
		}

		reset($this->_filters[$tag]);
		do
		{
			foreach((array)current($this->_filters[$tag]) as $filter)
			{
				if ( ! is_null($filter['function']))
				{
					$args[0] = call_user_func_array($filter['function'], array_slice($args, 0, (int)$filter['accepted_args']));
				}
			}
		}

		while (next($this->_filters[$tag]) !== false);
		array_pop($this->_current_filter);
		return $args[0];
	}

	// ------------------------------------------------------------------------

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
	public function remove_filter($tag, $function_to_remove, $priority = 10)
	{
		$function_to_remove = $this->_filter_build_unique_id($tag, $function_to_remove, $priority);
		$r = (isset($this->_filters[$tag][$priority][$function_to_remove]));
		if ($r === true)
		{
			unset($this->_filters[$tag][$priority][$function_to_remove]);
			if (empty($this->_filters[$tag][$priority]))
			{
				unset($this->_filters[$tag][$priority]);
			}

			unset($this->_merged_filters[$tag]);
		}

		return $r;
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove all of the hooks from a filter.
	 * @access public
	 * @param  string  $tag  The filter to remove hooks from.
	 * @param  int|bool  $priority  The priority number to remove.
	 * @return  True when finished.
	 *
	 * @see  https://developer.wordpress.org/reference/functions/remove_all_filters/
	 */
	public function remove_all_filters($tag, $priority = false)
	{
		if (isset($this->_filters[$tag]))
		{
			if ($priority !== false && isset($this->_filters[$tag][$priority]))
			{
				unset($this->_filters[$tag][$priority]);
			}
			else
			{
				unset($this->_filters[$tag]);
			}
		}

		if (isset($this->_merged_filters[$tag]))
		{
			unset($this->_merged_filters[$tag]);
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve the name of the current filter or action.
	 * @access 	public
	 * @param 	none
	 * @return 	string 	Hook name of the current filter or action.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/current_filter/
	 */
	public function current_filter()
	{
		return end($this->_current_filter);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve the name of the current action.
	 * @access 	public
	 * @param 	none
	 * @return 	string 	Hook name of the current action.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/current_action/
	 */
	public function current_action()
	{
		return $this->_current_filter();
	}

	// ------------------------------------------------------------------------

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
	public function doing_filter($filter = null)
	{
		if ($filter === null)
		{
			return ( ! empty($this->_current_filter));
		}

		return (in_array($filter, $this->_current_filter));
	}

	// ------------------------------------------------------------------------

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
	public function doing_action($action = null)
	{
		return $this->_doing_filter($action);
	}

	// ------------------------------------------------------------------------

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
	public function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		return $this->add_filter($tag, $function_to_add, $priority, $accepted_args);
	}

	// ------------------------------------------------------------------------

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
	public function do_action($tag, $arg = '')
	{

		// Make sure $actions is always an array.

		(isset($this->_actions)) OR $this->_actions = array();
		if ( ! isset($this->_actions[$tag]))
		{
			$this->_actions[$tag] = 1;
		}
		else
		{
			++$this->_actions[$tag];
		}

		// Let's execute all filters first.

		if (isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
			$all_args = func_get_args();
			$this->__call_all_filters($all_args);
		}

		if ( ! isset($this->_filters[$tag]))
		{
			if (isset($this->_filters['all']))
			{
				array_pop($this->_current_filter);
			}

			return;
		}

		if ( ! isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
		}

		$args = array();
		if (is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]))
		{
			$args[] = & $arg[0];
		}
		else
		{
			$args[] = $arg;
		}

		for ($a = 2; $a < func_num_args(); $a++)
		{
			$args[] = func_get_arg($a);
		}

		// Let's sort things.

		if ( ! isset($this->_merged_filters[$tag]))
		{
			ksort($this->_filters[$tag]);
			$this->_merged_filters[$tag] = true;
		}

		// Set the internal pointer of an array to its first element

		reset($this->_filters[$tag]);
		do
		{
			foreach((array)current($this->_filters[$tag]) as $filter)
			{
				// echo print_d($filter);
				// exit;
				if ( ! is_null($filter['function']))
				{
					call_user_func_array($filter['function'], array_slice($args, 0, (int)$filter['accepted_args']));
				}
			}
		}

		while (next($this->_filters[$tag]) !== false);
		array_pop($this->_current_filter);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve the number of times an action is fired.
	 * @access 	public
	 * @param 	string 	$tag 	The name of the action hook.
	 * @return 	int 	The number of times action hook $tag is fired.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/did_action/
	 */
	public function did_action($tag)
	{
		if ( ! isset($this->_actions) OR !isset($this->_actions[$tag]))
		{
			return 0;
		}

		return $this->_actions[$tag];
	}

	// ------------------------------------------------------------------------

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
	public function do_action_ref_array($tag, $args)
	{

		// Make sure $actions are always an array.

		(isset($this->_actions)) OR $this->_actions = array();
		if ( ! isset($this->_actions[$tag]))
		{
			$this->_actions[$tag] = 1;
		}
		else
		{
			++$this->_actions[$tag];
		}

		// We start by doing all actions first.

		if (isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
			$all_args = func_get_args();
			$this->__call_all_filters($all_args);
		}

		// If the $tag is not found, we check if there are other filters

		if ( ! isset($this->_filters[$tag]))
		{
			if (isset($this->_filters['all']))
			{
				array_pop($this->_current_filter);
			}

			return;
		}

		// Well, if no filters are left, the current one if the called one.

		if ( ! isset($this->_filters['all']))
		{
			$this->_current_filter[] = $tag;
		}

		// Let's do some sorting.

		if ( ! isset($merged_filters[$tag]))
		{
			ksort($this->_filters[$tag]);
			$merged_filters[$tag] = true;
		}

		// Set the internal pointer of an array to its first element

		reset($this->_filters[$tag]);
		do
		{
			foreach((array)current($this->_filters[$tag]) as $filter)
			{
				if ( ! is_null($filter['function']))
				{
					call_user_func_array($filter['function'], array_slice($args, 0, (int)$filter['accepted_args']));
				}
			}
		}

		while (next($this->_filters[$tag]) !== false);

		// Remove the last element.

		array_pop($this->_current_filter);
	}

	// ------------------------------------------------------------------------

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
	public function has_action($tag, $function_to_check = false)
	{
		return $this->has_filter($tag, $function_to_check);
	}

	// ------------------------------------------------------------------------

	/**
	 * Removes a function from a specified action hook.
	 * @access 	public
	 * @param  string  $tag  The action hook to which the function to be removed is hooked.
	 * @param  string  $function_to_remove  The name of the function which should be removed.
	 * @return  bool  Whether the function is removed.
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/remove_action/
	 */
	public function remove_action($tag, $function_to_remove, $priority = 10)
	{
		return $this->remove_filter($tag, $function_to_remove, $priority);
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove all of the hooks from an action.
	 * @access 	public
	 * @param 	string 		$tag 		The action to remove hooks from.
	 * @param 	int|bool 	$pririty 	The priority number to remove them from.
	 * @return 	bool 	true when finished.
	 */
	public function remove_all_actions($tag, $priority = false)
	{
		return $this->remove_all_filters($tag, $priority);
	}

	// ------------------------------------------------------------------------

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
	private function _filter_build_unique_id($tag, $function, $priority)
	{
		static $filter_id_count = 0;
		if (is_string($function))
		{
			return $function;
		}

		if (is_object($function))
		{

			// Closures are currently implemented as objects

			$function = array(
				$function,
				''
			);
		}
		else
		{
			$function = (array)$function;
		}

		if (is_object($function[0]))
		{

			// Object Class Calling

			if (function_exists('spl_object_hash'))
			{
				return spl_object_hash($function[0]) . $function[1];
			}
			else
			{
				$obj_uid = get_class($function[0]) . $function[1];
				if ( ! isset($function[0]->filter_id))
				{
					if ($priority === false)
					{
						return false;
					}

					$obj_uid.= isset($this->_filters[$tag][$priority]) ? count((array)$this->_filters[$tag][$priority]) : $filter_id_count;
					$function[0]->filter_id = $filter_id_count;
					++$filter_id_count;
				}
				else
				{
					$obj_uid.= $function[0]->filter_id;
				}

				return $obj_uid;
			}
		}
		elseif (is_string($function[0]))
		{

			// Static Calling

			return $function[0] . $function[1];
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Calls all available filters and actions.
	 * @access 	private
	 * @param 	array 	$args
	 * @return  array
	 */
	public function __call_all_filters($args)
	{

		// Set the internal pointer of an array to its first element

		reset($this->_filters['all']);
		do
		{
			foreach((array)current($this->_filters['all']) as $filter)
			{
				if ( ! is_null($filter['function']))
				{
					call_user_func_array($filter['function'], $args);
				}
			}
		}

		while (next($this->_filters['all']) !== false);
	}
}

if ( ! function_exists('add_filter'))
{
	/**
	 * Hook a function or method to a specific filter action.
	 */
	function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		return CI_Plugins::instance()->add_filter($tag, $function_to_add, $priority, $accepted_args);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_filter'))
{
	/**
	 * Removes a function from a specified filter hook.
	 */
	function remove_filter($tag, $function_to_remove, $priority = 10)
	{
		return CI_Plugins::instance()->remove_filter($tag, $function_to_remove, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_all_filters'))
{
	/**
	 * Remove all of the hooks from a filter.
	 */
	function remove_all_filters($tag, $priority = false)
	{
		return CI_Plugins::instance()->remove_all_filters($tag, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('has_filter'))
{
	/**
	 * Check if any filter has been registered for a hook.
	 */
	function has_filter($tag, $function_to_check = false)
	{
		return CI_Plugins::instance()->has_filter($tag, $function_to_check);
	}
}

if ( ! function_exists('apply_filters'))
{
	/**
	 * Call the functions added to a filter hook.
	 */
	function apply_filters($tag, $value)
	{
		return CI_Plugins::instance()->apply_filters($tag, $value);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('apply_filters_ref_array'))
{
	/**
	 * Execute functions hooked on a specific filter hook,
	 * specifying arguments in an array.
	 */
	function apply_filters_ref_array($tag, $args)
	{
		return CI_Plugins::instance()->apply_filters_ref_array($tag, $args);
	}
}

/*=========================================
=            ACTIONS FUNCTIONS            =
=========================================*/

if ( ! function_exists('add_action'))
{
	/**
	 * Hooks a function on to a specific action.
	 */
	function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		return CI_Plugins::instance()->add_action($tag, $function_to_add, $priority, $accepted_args);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('has_action'))
{
	/**
	 * Check if any action has been registered for a hook.
	 */
	function has_action($tag, $function_to_check = false)
	{
		return CI_Plugins::instance()->has_action($tag, $function_to_check);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_action'))
{
	/**
	 * Removes a function from a specified action hook.
	 */
	function remove_action($tag, $function_to_remove, $priority = 10)
	{
		return CI_Plugins::instance()->remove_action($tag, $function_to_remove, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_all_actions'))
{
	/**
	 * Remove all of the hooks from an action.
	 */
	function remove_all_actions($tag, $priority = false)
	{
		return CI_Plugins::instance()->remove_all_actions($tag, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('do_action'))
{
	/**
	 * Execute functions hooked on a specific action hook.
	 */
	function do_action($tag, $arg = '')
	{
		return CI_Plugins::instance()->do_action($tag, $arg);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('do_action_ref_array'))
{
	/**
	 * Execute functions hooked on a specific action hook,
	 * specifying arguments in an array.
	 */
	function do_action_ref_array($tag, $args)
	{
		return CI_Plugins::instance()->do_action_ref_array($tag, $args);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('did_action'))
{
	/**
	 * Retrieve the number of times an action is fired.
	 */
	function did_action($tag)
	{
		return CI_Plugins::instance()->did_action($tag);
	}
}
