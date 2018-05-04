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
 * Route Class
 *
 * Provides enhanced routing capabilities to CodeIgniter.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 *
 * Original author:
 * @author 		Patroklo
 * @link 		https://github.com/Patroklo/codeigniter-static-laravel-routes
 */
class Route {

    /**
     * Our built routes.
     * @var array
     */
	protected static $routes = array();

    /**
     * Routes prefix stored for later use.
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
	protected static $default_controller = 'welcome';

	/**
	 * Prefix used for nested routes.
	 * @var string
	 */
	protected static $nested_prefix = '';

	/**
	 * Nested routes depth.
	 * @var integer
	 */
    protected static $nested_depth  = 0;

    //--------------------------------------------------------------------

    /**
     * Combine all defined routes. This is intended to be used after all 
     * routes have been defined in order to merge CodeIgniter $route array 
     * with routes defined using this class.
     * @access 	public
     * @param 	array 	$route 	The array to merge.
     * @return 	array 	The final merged routes array.
     *
     * @example
     *     $route['default_controller'] = 'home';
     *     Route::resource('posts');
     *     $route = Route::map($route);
     */
    public static function map($routes=array())
    {
        $controller = (isset($routes['default_controller']))
        	? $routes['default_controller']
        	: self::$default_controller;

        foreach (self::$routes as $from => $to)
        {
            $routes[$from] = str_replace('{default_controller}', $controller, $to);
        }

        return $routes;
    }

    //--------------------------------------------------------------------

    /**
     * Accepts any kind of requests.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
     * @return 	void
     */
    public static function any($from, $to, $options = array(), $nested = false)
    {
        return self::create_route($from, $to, $options, $nested);
    }

    // ------------------------------------------------------------------------
    // HTTP verb-base routing.
    // ------------------------------------------------------------------------

    /**
     * Create a route using for GET method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------
    
    /**
     * Create a route using for POST method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------
    
    /**
     * Create a route using for PUT method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------
    
    /**
     * Create a route using for DELETE method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------

    /**
     * Create a route using for HEAD method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------

    /**
     * Create a route using for PATCH method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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
    
    // ------------------------------------------------------------------------

    /**
     * Create a route using for OPTIONS method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
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

    // ------------------------------------------------------------------------
    // Auto-routing generators
    // ------------------------------------------------------------------------
    
    /**
     * Generate HTTP verb-based routing for a given controller.
     * @access 	public
     * @param 	string 	$name 		The route to use.
     * @param 	mixed 	$options 	Array of options or closure.
     * @param 	closure $nested 	Use for building nested routing.
     * @return 	void
     *
     * @example
     * Let's assume we have a controller named "users".
     * Using: Route::resources('users') with output later:
     *
     *      Verb    Path            Action      used for
     *      ------------------------------------------------------------------
     *      GET     /users         index       displaying a list of users
     *      GET     /users/new     create_new  return an HTML form for creating a user
     *      POST    /users         create      create a new user
     *      GET     /users/{id}    show        display a specific user
     *      GET     /users/{id}/edit   edit    return the HTML form for editing a single user
     *      PUT     /users/{id}    update      update a specific user
     *      DELETE  /users/{id}    delete      delete a specific user
     */
    public static function resources($name, $options = array(), $nested = false)
    {
    	// The name is important.
        if (empty($name))
        {
            return;
        }
        
        // Prepare the nested offset.
        $nest_offset = '';

        /**
         * In order to allow customization of the route the resources 
         * are sent to, we need to have a new name to store values in.
         */
        $new_name = $name;

		/**
		 * If a new controller is specified, we replace the given 
		 * $name value with the name of its name.
		 */
        if (isset($options['controller']))
        {
            $new_name = $options['controller'];
            unset($options['controller']);
        }

        /**
         * If a module's name is specified, we make sure to put 
         * it in front of the controller.
         */
        if (isset($options['module']))
        {
            $new_name = $options['module'].'/'.$new_name;
            unset($options['module']);
        }

        /**
         * In order to allow customization of allowed ID values, 
         * we need to store them.
         */
        $id = '([a-zA-Z0-9\-_]+)';	// Default one.
        if (isset($options['constraint']))
        {
            $id = $options['constraint'];
            unset($options['constraint']);
        }

        /**
         * If the offset is provided in options, we make sure to offset 
         * all parameters placeholders in the $to by that amount.
         * This is useful if we are using an API with versioning
         * in the URL.
         */
        $offset = 0;
        if (isset($options['offset'])) 
        {
            $offset = (int) $options['offset'];
            unset($options['offset']);
        }

        // If the prefix was defined, use it.
        if ( ! empty(self::$prefix) && is_array(self::$prefix))
		{
            foreach (self::$prefix as $key => $val)
            {
                $nest_offset .= '/$'.($key + 1);
                $offset++;
            }
        }

        // No we proceed to generating routes.
        self::get($name, $new_name.'/index'.$nest_offset, $options, $nested);
        self::get($name.'/new', $new_name.'/add'.$nest_offset, $options, $nested);
        self::get($name.'/'.$id.'/edit', $new_name.'/edit'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
        self::get($name.'/'.$id, $new_name.'/view'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
        self::post($name, $new_name.'/create'.$nest_offset, $options, $nested);
        self::put($name.'/'.$id, $new_name.'/update'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
        self::delete($name.'/'.$id, $new_name.'/delete'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
    }

    // ------------------------------------------------------------------------

    /**
     * Contexts provide a way for modules to assign controllers to an area of the
     * site based on the name of the controller. This can be used for making a
     * '/admin' area of the site that all modules can create functionality into.
     * @access 	public
     * @param 	string 	$name 			The name of the URL segment
     * @param 	string 	$controller 	The name of the controller
     * @param 	array 	$options 		Options to use.
     * @return void
     */
    public static function context($name, $controller = null, $options = array())
    {
    	/**
    	 * In case $controller is passed as an array, we make sure to 
    	 * use is as options and set $name as the $controller.
    	 */
    	if (is_array($controller))
    	{
			$options    = $controller;
			$controller = null;
    	}

    	// Hold the controller in case it is still not set.
    	if (isset($options['controller']))
    	{
    		$controller = $options['controller'];
    		unset($options['controller']);
    	}

    	(empty($controller)) && $controller = $name;

        // Was an offset provided?
        $offset = (isset($options['offset'])) ? (int) $options['offset'] : 0;
        
        // Some helping hands
        $first  = 1 + $offset;
        $second = 2 + $offset;
        $third  = 3 + $offset;
        $fourth = 4 + $offset;
        $fifth  = 5 + $offset;
        $sixth  = 6 + $offset;
        
        // Now we generate our routes.
        self::any(
        	$name.'/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)',
        	"\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}/\${$fifth}/\${$sixth}"
        );
        
        self::any(
        	$name.'/(:any)/(:any)/(:any)/(:any)/(:any)', 
        	"\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}/\${$fifth}"
        );
        
        self::any(
        	$name.'/(:any)/(:any)/(:any)/(:any)', 
        	"\${$first}/{$controller}/\${$second}/\${$third}/\${$fourth}"
        );
        
        self::any(
        	$name.'/(:any)/(:any)/(:any)', 
        	"\${$first}/{$controller}/\${$second}/\${$third}"
        );
        
        self::any(
        	$name.'/(:any)/(:any)', 
        	"\${$first}/{$controller}/\${$second}"
        );
        
        self::any(
        	$name.'/(:any)', 
        	"\${$first}/{$controller}"
        );
        
        // Unset our helper because we no longer need them.
        unset($first, $second, $third, $fourth, $fifth, $sixth);
        
        // Is the home controller provided?
        if (isset($options['home']) && ! empty($options['home']))
        {
            self::any($name, $options['home']);
        }
    }

    // ------------------------------------------------------------------------
    // Prefix methods.
    // ------------------------------------------------------------------------
    
    /**
     * Add a prefix to the $from portion of the route.
     * @access 	public
     * @param 	string 	$prefix 	The prefix to add.
     * @param 	closure $callback 	Nested routes.
     * @return 	void
     *
     * @example
     *
     *      Route::prefix('admin', function()
     *      {
     *          Route::resources('users');
     *      });
     */
    public static function prefix($name, Closure $callback)
    {
    	// We first set the prefix.
        self::$prefix = $name;

        // We build our routes.
        call_user_func($callback);

        // Remove the prefix.
        self::$prefix = null;
    }

    // ------------------------------------------------------------------------

    /**
     * Return the current prefix of routes.
     * @access 	public
     * @return 	string 	if found, else null.
     */
    public static function get_prefix()
    {
    	return ( ! empty(self::$prefix))
    		? implode('/', self::$prefix).'/'
    		: '';
    }
    
    // ------------------------------------------------------------------------
    // Routes naming.
    // ------------------------------------------------------------------------
    
    /**
     * Return a route from routes array using the name is was defined with.
     * @access 	public
     * @param 	string 	$name 		The route's name.
     * @param 	array 	$params 	Parameters to pass to route.
     * @return 	string
     *
     * @example
     * Let's assume I registered the following route:
     *      Route::get('login', 'users/login', array('as' => 'login'));
     * If I want to show the URL to login page, I only need to do:
     * 		site_url(Route::named('login'));
     * This will generate a URL like <site_url>/login
     */
    public static function named($name, $params = array())
    {
        return (isset(self::$named_routes[$name])) ? self::$named_routes[$name] : null;
    }

    // ------------------------------------------------------------------------

    /**
     * Block access to any number ot routes by setting that route to a '+' path.
     * @access 	public
     * @return 	void
     *
     * @example
     *     Route::block('posts', 'photos/(:num)');
     *     // Like doing:
     *     $route['posts']          = '+';
     *     $route['photos/(:num)']  = '+';
     */
    public static function block()
    {
    	// Collect method arguments.
    	$args = func_get_args();
    	if (empty($args))
    	{
    		return;
    	}

    	// Get rid of deep nasty array.
    	(is_array($args[0])) && $args = $args[0];

    	foreach ($args as $arg)
    	{
    		self::create_route($arg, '+');
    	}
    }

    // ------------------------------------------------------------------------

    /**
     * Reset all the class to a first-load state. This is useful during testing
     * @access 	public
     * @return 	void
     */
    public static function reset()
    {
		self::$routes       = array();
		self::$named_routes = array();
		self::$nested_depth = 0;
    }

    // ------------------------------------------------------------------------
    // Create Route Methods
    // ------------------------------------------------------------------------

    /**
     * This is the main method that generate all routes.
     * @access 	public
     * @param 	string 	$from
     * @param 	string 	$to
     * @param 	array 	$options
     * @param 	closure $nested
     * @return 	array if all went well, else false.
     */
    private static function create_route($from, $to, $options = array(), $nested = false)
    {
    	$prefix = (empty(self::$prefix)) ? '' : self::$prefix.'/';

    	// Closure instead of array of options?
        if ($options instanceof Closure)
        {
        	$nested = $options;
        	$options = array();
        }

        // Prepare the route's "from" parameter.
        $from = self::$nested_prefix . $prefix . $from;

        // Are we setting a name for the route?
        if (isset($options['as']) && ! empty($options['as']))
        {
            self::$named_routes[$options['as']] = $from;
            unset($options['as']);
        }

        // Prepare the route's "to" parameter.
        self::$routes[$from] = $to;

        // Nested route?
        if ($nested && is_callable($nested) && self::$nested_depth === 0)
        {
			self::$nested_prefix .= rtrim($from, '/') .'/';
			self::$nested_depth  += 1;
            call_user_func($nested);

            self::$nested_prefix = '';
        }

        self::$nested_depth = (self::$nested_depth === 0)
        	? self::$nested_depth 
        	: self::$nested_depth - 1;
    }

}
