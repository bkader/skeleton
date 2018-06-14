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
 * @since 		2.1.2
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Events Class
 *
 * A simple events system that can be used with CodeIgniter or anything else.
 * On CodeIgniter Skeleton, this can be used as an alternative to the Hooks system
 * where you can add/do actions and add/apply filters.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.2
 * @version 	2.1.2
 */
class Events {

	/**
	 * Holds an array of all registered events.
	 * @var array
	 */
	protected static $_events = array();

	// ------------------------------------------------------------------------

	/**
	 * register
	 *
	 * Method for registering a new Callback for the given event.
	 * @static
	 * @access 	public
	 * @param 	string 	$name 		The name of the event to register.
	 * @param 	mixed 	$callback 	The function name or array of Class::method.
	 * @return 	void
	 */
	public static function register($name, $callback)
	{
		$key = is_array($callback) ? $callback[0].'::'.$callback[1] : $callback;
		self::$_events[$name][$key] = $callback;
	}

	// ------------------------------------------------------------------------

	/**
	 * unregister
	 *
	 * Method for removing a previously registered event.
	 *
	 * @static
	 * @access 	public
	 * @param 	string 	$name 		The name of the event to unregister.
	 * @param 	muxed 	$callback 	The function or array of class::method to unregister.
	 * @return 	void
	 */
	public static function unregister($name, $callback = null)
	{
		// No registered event with given name? Nothing to do...
		if ( ! isset(self::$_events[$name]))
		{
			return;
		}

		// Unregister all event if no callback is provided.
		if (empty($callback))
		{
			unset(self::$_events[$name]);
			return;
		}

		$key = is_array($callback) ? $callback[0].'::'.$callback[1] : $callback;

		unset(self::$_events[$name][$key]);
		if (empty(self::$_events[$name]))
		{
			unset(self::$_events[$name]);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Trigger
	 *
	 * Triggers an event and returns the results.
	 *
	 * @static
	 * @param 	string 	$name 		The event name.
	 * @param 	mixed 	$data 		The data to pass to the event callback.
	 * @param 	string 	$format 	In what format the result is returned.
	 * @return 	mixes 	Depends on the return format.
	 */
	public static function trigger($name, $data = '', $format = 'string')
	{
		$results = array();

		if (isset(self::$_events[$name]))
		{
			foreach (self::$_events[$name] as $event)
			{
				// Not callable? Ignore it.
				if ( ! is_callable($event))
				{
					continue;
				}

				// Simple function? Use it as-it.
				if (is_string($event))
				{
					$results[] = call_user_func($event, $data);
					continue;
				}

				is_object($event[0]) OR $event[0] = new $event[0];

				$results[] = call_user_func($event, $data);
			}
		}

		return self::_return($results, $format);
	}

	// ------------------------------------------------------------------------

	/**
	 * has_events
	 *
	 * Checks if they are registered callbacks for the given event.
	 *
	 * @static
	 * @param 	string 	$name 	The event name.
	 * @return 	bool 	true if there are callbacks, else fales.
	 */
	public static function has_events($name)
	{
		return (isset(self::$_events[$name]) && count(self::$_events[$name]) > 0);
	}

	// ------------------------------------------------------------------------

	/**
	 * events
	 *
	 * Returns the array of all registered events and their callbacks.
	 *
	 * @static
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public static function all_events()
	{
		return self::$_events;
	}

	// ------------------------------------------------------------------------

	/**
	 * _return
	 *
	 * Formats the result in the given format.
	 *
	 * @static
	 * @access 	protected
	 * @param 	mixed 	$results 	The results to format.
	 * @param 	string 	$format 	The format to convert the result to.
	 * @return 	mixed 	Depends on the requested format.
	 */
	protected static function _return(array $results, $format = 'string')
	{
		switch ($format)
		{
			case 'json':
			case 'json_encode':
			case 'JSON':
				$results = json_encode($results);
				break;

			case 'serialize':
			case 'serialized':
				$results = serialize($results);
				break;

			case 'string':
				$string = '';
				foreach ($results as $result)
				{
					$string .= $result;
				}
				$results = $string;
				break;
		}

		return $results;
	}

}
