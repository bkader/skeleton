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
 * Static Routing Like Laravel
 *
 * @package     CodeIgniter
 * @author  Kader Bouyakoub <bkader@mail.com>
 * @link    https://github.com/bkader
 */
class Route
{
	/**
	 * Array of routes.
	 * @var array
	 */
	protected static $routes = array();

	/**
	 * Route prefix
	 * @var string
	 */
	protected static $prefix = null;

	/**
	 * Array of named routes.
	 * @var array
	 */
	protected static $named_routes = array();

	/**
	 * Default controller.
	 * @var string
	 */
	protected static $default_home = 'home';

	protected static $nested_prefix = '';

	protected static $nested_depth = 0;

	/**
	 * Maps all routes and generate the $route array.
	 * @param   array   $routes
	 * @return  array
	 */
	public static function map($routes = array())
	{
		$controller = (isset($routes['default_controller']))
			? $routes['default_controller']
			: self::$default_home;

		foreach (self::$routes as $from => $to)
		{
			$routes[$from] = str_replace('{default_controller}', $controller, $to);
		}

		return $routes;
	}

	/**
	 * Register a route that responds to multiple HTTP verbs.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function any($from, $to, $options = array(), $nested = false)
	{
		return self::create_route($from, $to, $options, $nested);
	}

	/**
	 * Register a GET route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function get($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'GET')
		{
			self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register a POST route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function post($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register a PUT route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function put($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'PUT')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register a DELETE route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function delete($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'DELETE')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register a HEAD route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function head($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'HEAD')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register a PATH route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function patch($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'PATCH')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Register OPTIONS route.
	 * @access 	public
	 * @param 	string 	$from
	 * @param 	string 	$to
	 * @param 	array 	$options
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function options($from, $to, $options = array(), $nested = false)
	{
		if (isset($_SERVER['REQUEST_METHOD'])
			&& $_SERVER['REQUEST_METHOD'] == 'OPTIONS')
		{
			return self::create_route($from, $to, $options, $nested);
		}
	}

	/**
	 * Generate all needed requests for a given route.
	 * @param 	string 	$name    the route name.
	 * @param 	array   $options route options.
	 * @param 	closure $nested
	 * @return 	void
	 */
	public static function resources($name, $options = array(), $nested = false)
	{
		if (empty($name))
		{
			return;
		}

		$nest_offset = '';
		$new_name    = $name;

		if (isset($options['controller']))
		{
			$new_name = $options['controller'];
		}

		if (isset($options['module']))
		{
			$new_name = $options['module'] . '/' . $new_name;
		}

		$id = '([a-zA-Z0-9\-_]+)';

		if (isset($options['constraint']))
		{
			$id = $options['constraint'];
		}

		$offset = isset($options['offset']) ? (int) $options['offset'] : 0;

		if (self::$nested_depth)
		{
			$nest_offset = '/$1';
			$offset++;
		}

		self::get($name, $new_name . '/index' . $nest_offset, null, $nested);
		self::get($name . '/new', $new_name . '/create_new' . $nest_offset, null, $nested);
		self::get($name . '/' . $id . '/edit', $new_name . '/edit' . $nest_offset . '/$' . (1 + $offset), null, $nested);
		self::get($name . '/' . $id, $new_name . '/show' . $nest_offset . '/$' . (1 + $offset), null, $nested);
		self::post($name, $new_name . '/create' . $nest_offset, null, $nested);
		self::put($name . '/' . $id, $new_name . '/update' . $nest_offset . '/$' . (1 + $offset), null, $nested);
		self::delete($name . '/' . $id, $new_name . '/delete' . $nest_offset . '/$' . (1 + $offset), null, $nested);
	}

	/**
	 * Prefix routes in a group
	 * @param  string  $name
	 * @param  Closure $callback
	 * @return void
	 */
	public static function prefix($name, Closure $callback)
	{
		self::$prefix = $name;
		call_user_func($callback);
		self::$prefix = null;
	}

	/**
	 * Returns a named route.
	 * @param  string $name the name of the route to get
	 * @return string
	 */
	public static function named($name)
	{
		if (isset(self::$named_routes[$name]))
		{
			return self::$named_routes[$name];
		}

		return null;
	}

	/**
	 * Create a full context route.
	 * @param  striig $name       the context name
	 * @param  string $controller the controller
	 * @param  array  $options    context options
	 * @return void
	 */
	public static function context($name, $controller = null, $options = array())
	{
		if (is_array($controller))
		{
			$options    = $controller;
			$controller = null;
		}

		if (empty($controller))
		{
			$controller = $name;
		}

		$offset = isset($options['offset']) ? (int) $options['offset'] : 0;
		$first  = 1 + $offset;
		$second = 2 + $offset;
		$third  = 3 + $offset;
		$fourth = 4 + $offset;
		$fifth  = 5 + $offset;
		$sixth  = 6 + $offset;

		self::any($name . '/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', "\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}/\${$fifth}/\${$sixth}");
		self::any($name . '/(:any)/(:any)/(:any)/(:any)/(:any)', "\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}/\${$fifth}");
		self::any($name . '/(:any)/(:any)/(:any)/(:any)', "\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}");
		self::any($name . '/(:any)/(:any)/(:any)', "\${$first}/{$controller}/\${$second}/\${$third}");
		self::any($name . '/(:any)/(:any)', "\${$first}/{$controller}/\${$second}");
		self::any($name . '/(:any)', "\${$first}/{$controller}");
		unset($first, $second, $third, $fourth, $fifth, $sixth);

		if (isset($options['home']) && ! empty($options['home']))
		{
			self::any($name, "{$options['home']}");
		}
	}

	/**
	 * Block direct access to given routes.
	 * @return void
	 */
	public static function block()
	{
		$args = func_get_args();
		if ( empty($args))
		{
			return;
		}

		(is_array($args[0])) && $args = $args[0];

		foreach ($args as $arg)
		{
			self::create_route($arg, '+');
		}
	}

	/**
	 * Reset all parameters.
	 * @return void
	 */
	public static function reset()
	{
		self::$routes       = array();
		self::$named_routes = array();
		self::$nested_depth = 0;
	}

	/**
	 * Generate a route.
	 * @return 	void
	 */
	private static function create_route($from, $to, $options = array(), $nested = false)
	{
		$prefix = is_null(self::$prefix) ? '' : self::$prefix . '/';
		$from   = self::$nested_prefix . $prefix . $from;

		if ($options instanceof Closure)
		{
			$nested  = $options;
			$options = array();
		}

		if (isset($options['as']) && !empty($options['as']))
		{
			self::$named_routes[$options['as']] = $from;
		}

		self::$routes[$from] = $to;

		if ($nested && is_callable($nested) && self::$nested_depth === 0)
		{
			self::$nested_prefix .= rtrim($from, '/') . '/';
			self::$nested_depth += 1;
			call_user_func($nested);
			self::$nested_prefix = '';
		}

		self::$nested_depth = (self::$nested_depth === 0)
			? self::$nested_depth
			: self::$nested_depth - 1;
	}
}

/* End of file Route.php */
/* Location: ./application/third_party/Route.php */
