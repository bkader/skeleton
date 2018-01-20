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
class Route
{
	/**
	 * Array of stored routes.
	 * @var array
     */
    protected static $routes = array();

    /**
     * Currently used prefix.
     * @var string
     */
    protected static $prefix = null;

    /**
     * Array of named routes.
     * @var array
     */
    protected static $named_routes = array();
    
    /**
     * Default controller if none is provided.
     * @var string
     */
    protected static $default_controller = 'home';

    /**
     * Holds instances of Route_object before creating routes.
     * @var array
     */
    protected static $pre_route_objects = array();
    
    /**
     * Holds instances of Route_object.
     * @var array
     */
    protected static $route_objects = array();
    
    /**
     * Array of pre-defined patterns.
     * @var array
     */
    protected static $pattern_list = array();
    
    // ------------------------------------------------------------------------
    
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
    public static function map($routes = array())
    {
    	// See if there is a default controller set.
        $default_controller = (isset($routes['default_controller']))
        	? $routes['default_controller']
        	: self::$default_controller;

        // We now mount the route object array with all the form routes.
        foreach (self::$pre_route_objects as &$object)
        {
            self::$route_objects[$object->get_from()] =& $object;
        }
        
        // Prepare array of pre-made route objects.
        self::$pre_route_objects = array();
        
        foreach (self::$route_objects as $key => $route_object)
        {
			$add_route     = true;
			$from          = $route_object->get_from();
			$to            = $route_object->get_to();
			$routes[$from] = str_replace('{default_controller}', $default_controller, $to);
        }
        
        return $routes;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Returns the array of parameters for the selected $route in case we 
     * have defined any. This will be used by the URI class for naming
     * URIs purpose.
     * @access 	public
     * @param 	string 	$route 	The route to get parameters for.
     * @return 	array 	The parameters if any, else empty array.
     *
     * @example 	Route::get_parameters('welcome/index');
     */
    public static function get_parameters($route)
    {
    	return (array_key_exists($route, self::$route_objects))
    		? self::$route_objects[$route]->get_parameters()
    		: array();
    }
    
    // ------------------------------------------------------------------------
    
    
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
            return self::create_route($from, $to, $options, $nested);
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
     * Create a route using for PUST method.
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

    /**
     * Create a route using for MATCH method.
     * @access 	public
     * @param 	string 	$from 		The route to use.
     * @param 	string 	$to 		The original route.
     * @param 	mixed 	$options 	Array of options or closure used as $nested.
     * @param 	closure $nested 	A closure to generate nested routes.
     * @return 	void
     */
    public static function match(array $requests, $from, $to, $options = array(), $nested = false)
    {
        $return = null;
        
        foreach ($requests as $request)
        {
            if (method_exists('Route', $request))
            {
                $r = self::$request($from, $to, $options, $nested);
                
                if ( ! is_null($r))
                {
                    $return = $r;
                }
            }
        }

        return $return;
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
        self::get($name,                 $new_name.'/index'.$nest_offset,                     $options, $nested);
        self::get($name.'/new',          $new_name.'/create_new'.$nest_offset,                $options, $nested);
        self::get($name.'/'.$id.'/edit', $new_name.'/edit'.$nest_offset.'/$'.(1 + $offset),   $options, $nested);
        self::get($name.'/'.$id,         $new_name.'/show'.$nest_offset.'/$'.(1 + $offset),   $options, $nested);
        self::post($name,                $new_name.'/create'.$nest_offset,                    $options, $nested);
        self::put($name.'/'.$id,         $new_name.'/update'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
        self::delete($name.'/'.$id,      $new_name.'/delete'.$nest_offset.'/$'.(1 + $offset), $options, $nested);
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
			$controller = $name;
    	}

    	// Hold the controller in case it is still not set.
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
    // Pattern methods.
    // ------------------------------------------------------------------------

    /**
     * Adds a global pattern that will be used along all the routes.
     * @access 	public
     * @param 	string 	$pattern 	The pattern to use.
     * @param 	string 	$regex 		The pattern's regex.
     * @return 	void.
     * @example 	Route::pattern('id', '[0-9]+');
     */
    public static function pattern($pattern, $regex = null)
    {
    	if (is_array($pattern))
    	{
    		foreach ($pattern as $key => $val)
    		{
        		self::$pattern_list[$key] = $val;
    		}
    	}
    	else
    	{
        	self::$pattern_list[$pattern] = $regex;
    	}
    }
    
    // ------------------------------------------------------------------------

    /**
     * Return the selected pattern from patterns list.
     * @access 	public
     * @param 	string 	$pattern 	The pattern to retrieve.
     * @return 	The pattern if exists, else null.
     */
    public static function get_pattern($pattern)
    {
    	return (array_key_exists($pattern, self::$pattern_list))
    		? self::$pattern_list[$pattern]
    		: null;
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
    	// If an array is passed.
        (is_array($name)) && $name = $name['name'];
        
        self::_add_prefix($name);
        call_user_func($callback);
        self::_delete_prefix();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Temporary add the prefix in order to generate routes.
     * @access 	private
     * @param 	string 	$prefix
     * @return 	void
     */
    private static function _add_prefix($prefix)
    { 
        self::$prefix[] = $prefix;
    }

    // ------------------------------------------------------------------------

    /**
     * Remove the prefix that was temporary added by _add_prefix method.
     * @access 	private
     * @return 	void
     */
    private static function _delete_prefix()
    {
        array_pop(self::$prefix);
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
    	if ( ! isset(self::$named_routes[$name]))
    	{
    		return null;
    	}

    	// Hold the URL to return.
        $return = self::$named_routes[$name];
        
        // Are there parameters to pass?
        if ( ! empty($params))
        {
            foreach ($params as $key => $param)
            {
                $return = str_replace('$'.($key + 1), $param, $return);
            }
        }
        
        return $return;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Set a name for a pre-defined route.
     * @access 	public
     * @param 	string 	$name
     * @param 	string 	$route
     * @return 	void
     */
    public static function set_name($name, $route)
    {
        self::$named_routes[$name] = $route;
    }
    
    // ------------------------------------------------------------------------
    // Block routes.
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
    	// Collect arguments first and make sure there are some.
    	$args = func_get_args();
    	if (empty($args))
    	{
    		return;
    	}

    	// Get rid of nasty deep array.
    	(is_array($args[0])) && $args = $args[0];

    	foreach ($args as $arg)
    	{
    		self::create_route($arg, '+');
    	}
    }

    // ------------------------------------------------------------------------
    // Reseter.
    // ------------------------------------------------------------------------
    
    /**
     * Reset all the class to a first-load state. This is useful during testing
     * @access 	public
     * @return 	void
     */
    public static function reset()
    {
        self::$route_objects     = array();
        self::$named_routes      = array();
        self::$routes            = array();
        self::$prefix            = null;
        self::$pre_route_objects = array();
        self::$pattern_list      = array();
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
    public static function create_route($from, $to, $options = array(), $nested = false)
    {
        // Create a new route object.
        $new_route = new Route_object($from, $to, $options, $nested);
        
        self::$pre_route_objects[] = $new_route;
        
        // Make the route then return a new facade instance/
        $new_route->make();
        return new Route_facade($new_route);   
    }

}

// ------------------------------------------------------------------------

/**
 * Route_facade Class
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
class Route_facade
{
	/**
	 * Holds an instance of Route_object.
	 * @var object
	 */
    private $loaded_object;

    /**
     * Class constructor.
     * @return 	void
     */
    function __construct(Route_object &$object)
    {
        $this->loaded_object =& $object;
    }

    // ------------------------------------------------------------------------

    /**
     * Search into loaded object for patterns.
     * @access 	public
     * @param 	string 	$parameter 	The parameter.
     * @param 	string 	$pattern 	The pattern.
     * @return 	object
     */
    public function where($parameter, $pattern = null)
    {
        $this->loaded_object->where($parameter, $pattern);
        return $this;
    }

}

// ------------------------------------------------------------------------

/**
 * Route_object Class
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
class Route_object
{
    private $pre_from;
    private $from;
    private $to;
    private $options;
    private $nested;
    private $prefix;
    
    private $optional_parameters = array();
    private $parameters = array();
    private $optional_objects = array();
    
    /**
     * @param string $from
     * @param boolean $nested
     */
    function __construct($from, $to, $options, $nested)
    {
        $this->pre_from = $from;
        $this->to       = $to;

        if ($options instanceof Closure)
        {
			$this->nested  = $options;
			$this->options = array();
        }
        else
        {
	        $this->options  = $options;
	        $this->nested   = $nested;
        }
        
        $this->prefix = Route::get_prefix();
        
        $this->pre_from = $this->prefix.$this->pre_from;
        
        //check for route parameters
        $this->_check_parameters();
        
    }
    
    public function make()
    {
        // Due to bug stated in https://github.com/Patroklo/codeigniter-static-laravel-routes/issues/11
        // we will make a cleanup of the parameters not used in the optional cases
        $parameter_positions = array_flip(array_keys($this->parameters));
        
        //first of all, we check for optional parameters. If they exist, 
        //we will make another route without the optional parameter
        foreach ($this->optional_parameters as $parameter) {
            $from = $this->pre_from;
            $to   = $this->to;
            
            //we get rid of prefix in case it exists
            if (!empty($this->prefix) && strpos($from, $this->prefix) === 0) {
                $from = substr($from, strlen($this->prefix));
            }
            ;
            
            
            foreach ($parameter as $p) {
                
                // Create the new $from without some of the optional routes
                $from = str_replace('/{'.$p.'}', '', $from);
                
                // Create the new $to without some of the optional destiny routes
                if (array_key_exists($p, $parameter_positions)) {
                    $to = str_replace('/$'.($parameter_positions[$p] + 1), '', $to);
                }
            }
            
            // Save the optional routes in case we will need them for where callings
            $this->optional_objects[] = Route::create_route($from, $to, $this->options, $this->nested);
        }
        
        // Do we have a nested function?
        if ($this->nested && is_callable($this->nested))
        {
            $name = rtrim($this->pre_from, '/');
            Route::prefix($name, $this->nested);
        }
        
    }
    
    private function _check_parameters()
    {
        preg_match_all('/\{(.+?)\}/', $this->pre_from, $matches);
        
        if (array_key_exists(1, $matches) && !empty($matches[1])) {
            //we make the parameters that the route could have and, if 
            //it's an optional parameter, we add it into the optional parameters array
            //to make later the new route without it
            
            $uris = array();
            foreach ($matches[1] as $parameter) {
                if (substr($parameter, -1) == '?') {
                    $new_key = str_replace('?', '', $parameter);
                    
                    //$this->optional_parameters[$parameter] = $new_key;
                    $uris[] = $new_key;
                    
                    $this->pre_from = str_replace('{'.$parameter.'}', '{'.$new_key.'}', $this->pre_from);
                    
                    $parameter = $new_key;
                }
                
                $this->parameters[$parameter] = array(
                    'value' => null
                );
            }
            
            if (!empty($uris)) {
                $num = count($uris);
                
                //The total number of possible combinations 
                $total = pow(2, $num);
                
                //Loop through each possible combination  
                for ($i = 0; $i < $total; $i++) {
                    
                    $sub_list = array();
                    
                    for ($j = 0; $j < $num; $j++) {
                        //Is bit $j set in $i? 
                        if (pow(2, $j) & $i) {
                            $sub_list[] = $uris[$j];
                        }
                    }
                    
                    $this->optional_parameters[] = $sub_list;
                }
                
                if (!empty($this->optional_parameters)) {
                    array_shift($this->optional_parameters);
                }
            }
            
            
            $uri_list = explode('/', $this->pre_from);
            
            foreach ($uri_list as $key => $uri) {
                $new_uri = str_replace(array(
                    '{',
                    '}'
                ), '', $uri);
                
                if (array_key_exists($new_uri, $this->parameters)) {
                    $this->parameters[$new_uri]['uri'] = ($key + 1);
                }
                
            }
            
        }
    }
    
    public function get_from()
    {
        //check if parameters of the from have a regex pattern to put in their place
        //if not, they will be a (:any)
        
        if (is_null($this->from)) {
            $pattern_list                  = array();
            $substitution_list             = array();
            $named_route_substitution_list = array();
            
            $pattern_num = 1;
            
            foreach ($this->parameters as $parameter => $data) {
                $value = $data['value'];
                
                //if there is a question mark in the parameter
                //we will add a scape \ for the regex
                $pattern_list[] = '/\{'.$parameter.'\}/';
                
                //if parameter is null will check if there is a global parameter, if not, 
                //we will put an (:any)
                if (is_null($value)) {
                    $pattern_value = Route::get_pattern($parameter);
                    
                    if (!is_null($pattern_value)) {
                        if ($pattern_value[0] != '(' && $pattern_value[strlen($pattern_value) - 1] != ')') {
                            $pattern_value = '('.$pattern_value.')';
                        }
                        
                        $substitution_list[] = $pattern_value;
                    } else {
                        $substitution_list[] = '(:any)';
                    }
                } else {
                    if ($value[0] != '(' && $value[strlen($value) - 1] != ')') {
                        $value = '('.$value.')';
                    }
                    
                    $substitution_list[] = $value;
                }
                
                $named_route_substitution_list[] = '\$'.$pattern_num;
                $pattern_num += 1;
            }
            
            // make substitutions to make codeigniter comprensible routes
            $this->from = preg_replace($pattern_list, $substitution_list, $this->pre_from);
            
            // make substitutions in case there is a named route 
            // Are we saving the name for this one?
            if (isset($this->options['as']) && !empty($this->options['as'])) {
                $named_route = preg_replace($pattern_list, $named_route_substitution_list, $this->pre_from);
                
                Route::set_name($this->options['as'], $named_route);
            }
            
        }
        return $this->from;
    }
    
    public function get_to()
    {
        return $this->to;
    }
    
    public function where($parameter, $pattern = null)
    {
        if (is_array($parameter)) {
            foreach ($parameter as $key => $value) {
                $this->where($key, $value);
            }
        } else {
            //calling all the optional routes to send them the where
            foreach ($this->optional_objects as $ob) {
                $ob->where($parameter, $pattern);
            }
            
            $this->parameters[$parameter]['value'] = $pattern;
        }
        
        return $this;
    }
    
    public function get_parameters()
    {
        $return_parameters = array();
        
        foreach ($this->parameters as $key => $parameter) {
            if (array_key_exists('uri', $parameter)) {
                $return_parameters[$key] = $parameter['uri'];
            }
        }
        
        return $return_parameters;
    }
    
    public function get_options($option = null)
    {
        if ($option == null) {
            return $this->options;
        } else {
            if (array_key_exists($option, $this->options)) {
                return $this->options[$option];
            }
        }
        
        return false;
        
    }
    
}
