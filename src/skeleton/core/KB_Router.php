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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Make sure to load our custom Route class right here.
 * This class allows us to use static routing like laravel.
 */
require_once(KBPATH.'third_party/Route/Route.php');

/**
 * KB_Router Class
 *
 * This class extends CI_Router class in order to use HMVC structure.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.5.2
 */
class KB_Router extends CI_Router
{
	/**
	 * Holds an array of modules locations.
	 * @var array.
	 */
	protected $_locations;

	/**
	 * Caches the array of available modules.
	 * @var array
	 */
	protected $_modules;

	/**
	 * Cache the array of available modules paths.
	 * @since 1.4.0
	 * @var array
	 */
	protected $_modules_paths;

	/**
	 * Cache modules details in case they are called again.
	 * @since 	1.4.0
	 * @var 	array
	 */
	protected $_modules_details = array();

	/**
	 * To avoid creating the variable each time we get 
	 * a single module details, we create it here.
	 * @since 	1.4.0
	 * @var 	array
	 */
	protected $_headers = array(
		'name'         => null,
		'module_uri'   => null,
		'description'  => null,
		'version'      => null,
		'license'      => null,
		'license_uri'  => null,
		'author'       => null,
		'author_uri'   => null,
		'author_email' => null,
		'tags'         => null,
		'enabled'      => false,
		'routes'       => array(),
		'admin_menu'   => null,
		'admin_order'  => 0,
		'submenu'      => array(),
		'translations' => array(),
	);

	/**
	 * The current module's name.
	 * @var string
	 */
	public $module = null;

	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		$this->config =& load_class('Config', 'core');
		$this->_prep_locations();
		$this->config->set_item('modules_locations', $this->_locations);
		
		log_message('info', 'KB_Router Class Initialized');
		
		parent::__construct();

		// Register the action after controller constructor.
		add_action('post_controller_constructor', array($this, '_load_modules'));
	}

	// ------------------------------------------------------------------------

	/**
	 * _prep_locations
	 *
	 * Method for formatting paths to modules directories.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _prep_locations()
	{
		if ( ! isset($this->_locations))
		{
			$this->_locations = $this->config->item('modules_locations');

			if (null === $this->_locations)
			{
				$this->_locations = array(APPPATH.'modules/', KBPATH.'modules/');
			}
			elseif ( ! in_array(KBPATH.'modules/', $this->_locations))
			{
				$this->_locations[] = KBPATH.'modules/';
			}
			
			foreach ($this->_locations as $i => &$location)
			{
				if (false !== ($path = realpath($location)))
				{
					$location = rtrim(str_replace('\\', '/', $path), '/').'/';
					continue;
				}

				unset($this->_locations[$i]);
			}
		}
	}

    // ------------------------------------------------------------------------

    /**
     * The only reason we are add this method is to allow users to create
     * a "routes" folder inside their application folder in which they can 
     * store individual routes files which will be included and added to the 
     * global routes.php file.
     * @access 	protected
     * @return 	void
     */
    protected function _set_routing()
    {
    	$modules = $this->list_modules(true);
    	foreach ($modules as $folder => $details)
    	{
    		// Set module routing.
    		if ( ! empty($details['routes']))
    		{
    			$this->_set_module_routes($details['routes']);
    		}
    	}

		// We now let the parent do the heavy work.
		parent::_set_routing();
    }

    // ------------------------------------------------------------------------

    /**
     * _set_module_routes
     *
     * Method for automatically register module routes stored in manifest file.
     *
     * @author 	Kader Bouyakoub
     * @link 	https://github.com/bkader
     * @since 	1.4.0
     *
     * @access 	protected
     * @param 	array 	$routes 	Module routes stored in manifest.json file.
     * @return 	void
     */
    protected function _set_module_routes($routes = array())
    {
    	if (empty($routes))
    	{
    		return;
    	}

    	foreach ($routes as $route => $original)
    	{
    		if (sscanf($route, 'resources:%s', $new_route))
    		{
    			Route::resources($new_route, $original);
    		}
    		elseif (sscanf($route, 'context:%s', $new_route))
    		{
    			Route::context($new_route, $original);
    		}
    		elseif (empty($original))
    		{
    			Route::block($route);
    		}
    		elseif (sscanf($route, 'any:%s', $new_route))
			{
    			Route::any($new_route, $original);
			}
    		elseif (sscanf($route, 'get:%s', $new_route))
			{
    			Route::get($new_route, $original);
			}
    		elseif (sscanf($route, 'post:%s', $new_route))
			{
    			Route::post($new_route, $original);
			}
			elseif (sscanf($route, 'put:%s', $new_route))
			{
    			Route::put($new_route, $original);
			}
			elseif (sscanf($route, 'delete:%s', $new_route))
			{
    			Route::delete($new_route, $original);
			}
			elseif (sscanf($route, 'head:%s', $new_route))
			{
    			Route::head($new_route, $original);
			}
			elseif (sscanf($route, 'patch:%s', $new_route))
			{
    			Route::patch($new_route, $original);
			}
			elseif (sscanf($route, 'options:%s', $new_route))
			{
    			Route::options($new_route, $original);
			}
			else
			{
				Route::any($route, $original);
			}
    	}
    }

    // ------------------------------------------------------------------------

    /**
     * Priority for default controllers is for application/controllers, if 
     * none is found there, we see if a module exists or not.
     * @access 	protected
     * @return 	void
     */
    protected function _set_default_controller()
    {
    	// No default controller set? Nothing to do.
		if (empty($this->default_controller))
		{
			show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
		}

		// Is the method being specified?
		if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2)
		{
			$method = 'index';
		}

		// Hold the controller location status.
		$controller_exists = FALSE;
		$module_controller = FALSE;

		// Found in application? Set it to found.
		if (file_exists(APPPATH.'controllers/'.$this->directory.ucfirst($class).'.php'))
		{
			$controller_exists = TRUE;
		}
		// Find is skeleton? Set it to found.
		elseif (file_exists(KBPATH.'controllers/'.$this->directory.ucfirst($class).'.php'))
		{
			$controller_exists = TRUE;
		}

		// If the controller was not found, try with modules.
		if ( ! $controller_exists && $located = $this->locate(array($class, $class, $method)))
		{
			$controller_exists = TRUE;
			$module_controller = FALSE;
		}

        // This will trigger 404 error.
        if ( ! $controller_exists)
        {
        	return;
        }

        log_message('debug', ($module_controller ? 'No URI present. Default module controller set.' : 'No URI present. Default controller set.'));

		$this->set_class($class);
		$this->set_method($method);

		// Assign routed segments, index starting from 1
		$this->uri->rsegments = array(
			1 => $class,
			2 => $method
		);
    }

    // ------------------------------------------------------------------------

    /**
     * Overrides CodeIgniter router _validate_request behavior.
     * @access 	protected
     * @param 	array 	$segments
     * @return 	array
     */
    protected function _validate_request($segments)
    {
    	// If we have no segments, return as-is.
        if (count($segments) == 0)
        {
            return $segments;
        }

        // Let's now look for the controller with HMVC support.
        if ($located = $this->locate($segments))
        {
        	// If found, return the result.
            return $located;
        }

        // Did the user specify a 404 override?
        if ( ! empty($this->routes['404_override']))
        {
            $segments = explode('/', $this->routes['404_override']);

            // Again, look for the controller with HMVC support.
            if ($located = $this->locate($segments))
            {
                return $located;
            }
        }

        // Let the parent handle the rest!
        return parent::_validate_request($segments);
    }

    // ------------------------------------------------------------------------

	/**
	 * Parse Routes
	 *
	 * Matches any routes that may exist in the config/routes.php file
	 * against the URI to determine if the class/method need to be remapped.
	 *
	 * @return	void
	 */
    protected function _parse_routes()
    {
    	// Accessing a module?
        if ($module = $this->uri->segment(1))
        {
        	// Let's look for the module.
            foreach ($this->modules_locations() as $location)
            {
            	// If there are any routes, include theme.
                if (is_file($file = $location.$module.'/config/routes.php'))
                {
                    include($file);

                    // If $routes is set, merge thing.
                    if (isset($route) && is_array($route))
                    {
                    	$this->routes = array_merge($this->routes, $route);

                    	// Just in case!
                    	unset($route);	
                    }
                }
            }
        }

        // Let parent do the heavy routing
        return parent::_parse_routes();
    }

	// ------------------------------------------------------------------------

	/**
	 * Set module name.
	 * @access 	public
	 * @param 	string 	$module
	 * @return 	void
	 */
	public function set_module($module)
	{
		$this->module = $module;
	}

	// ------------------------------------------------------------------------

	/**
	 * Fetch the current module name.
	 * @access 	public
	 * @return 	string
	 */
	public function fetch_module()
	{
		return $this->module;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the real path to the selected module.
	 *
	 * @since 	1.0.0
	 * @since 	1.4.0 	Rewritten for better code.
	 * 
	 * @access 	public
	 * @param 	string 	$module 	Module name.
	 * @return 	the full path if found, else FALSE.
	 */
	public function module_path($module = null)
	{
		$paths = $this->modules_paths();
		return (isset($paths, $paths[$module])) ? $paths[$module] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Return an array of the selected module's details.
	 * @access 	public
	 * @param 	string 	$module 	The module's name (folder).
	 * @return 	array if found, else false.
	 */
	public function module_details($module)
	{
		if (empty($module))
		{
			return false;
		}

		if (isset($this->_modules_details[$module]))
		{
			return $this->_modules_details[$module];
		}

		$module_path    = $this->module_path($module);
		$manifest_file = $module_path.'manifest.json';

		if (null === $module_path OR false === is_file($manifest_file))
		{
			return false;
		}

		$content = file_get_contents($manifest_file);
		$headers = json_decode($content, true);

		if ( ! is_array($headers))
		{
			return false;
		}

		$headers = array_replace_recursive($this->_headers, $headers);

		// Added things:
		$headers['folder']    = $module;
		$headers['full_path'] = $module_path;


		if (false !== $this->has_admin($module) && empty($headers['admin_menu']))
		{
			$headers['admin_menu'] = ucwords($module);
		}

		if ($headers['license'] == 'MIT' && empty($headers['license_uri']))
		{
			$headers['license_uri'] = 'http://opensource.org/licenses/MIT';
		}

		$this->_modules_details[$module] = $headers;

		return $this->_modules_details[$module];
	}

	// ------------------------------------------------------------------------

	/**
	 * List all available modules.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function list_modules($details = false)
	{
		if ( ! $this->_modules)
		{
			// Prepare an empty array of modules.
			$this->_modules = array();
			
			// Let's go through folders and check if there are any.
			foreach ($this->modules_locations() as $location)
			{
				if ($handle = opendir($location))
				{
					$_to_eliminate = array(
						'.',
						'..',
						'.gitkeep',
						'index.html',
						'.htaccess'
					);
					
					while (false !== ($file = readdir($handle)))
					{
						if ( ! in_array($file, $_to_eliminate))
						{
							$this->_modules[] = $file;
						}
					}
				}
			}
		}

		$return = $this->_modules;

		if (true === $details)
		{
			$_modules_details = array();

			foreach ($this->_modules as $i => $module)
			{
				if (isset($this->_modules_details[$module]))
				{
					$_modules_details[$module] = $this->_modules_details[$module];
				}
				elseif (false !== ($details = $this->module_details($module)))
				{
					$_modules_details[$module] = $details;
				}
				unset($details);
			}

			empty($_modules_details) OR $return = $_modules_details;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * _load_modules
	 *
	 * Because modules are loaded ONLY when they are requested via HTTP and 
	 * there tons of ways to make them load. We created the "init.php" file
	 * method.
	 * You can put anything inside that file and it is loaded as long as it
	 * exists. This way, not only themes and plugins can affect the website, 
	 * but even modules. Cool isn't it?
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function _load_modules()
	{
		foreach ($this->modules_paths() as $i => $module)
		{
			if (false !== is_file($init = $module.'init.php'))
			{
				require_once($module.'init.php');
				/**
				 * Fetches right after the module's "init.php" file is loaded.
				 * @since 	1.4.0
				 */
				do_action('loaded_module_'.$module);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns and array of modules locations.
	 * @access 	public
	 * @return 	array.
	 */
	public function modules_locations()
	{
		if ( ! isset($this->_locations))
		{
			$this->_locations = $this->config->item('modules_locations');
		}

		return $this->_locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * modules_paths
	 *
	 * Method for retrieving an array of all modules and their paths.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function modules_paths()
	{
		if ( ! isset($this->_modules_paths))
		{
			$modules = $this->list_modules();
			foreach ($modules as $module)
			{
				foreach ($this->modules_locations() as $location)
				{
					if (false !== is_dir($location.$module))
					{
						$path = str_replace('\\', '/', $location.$module);
						$this->_modules_paths[$module] = rtrim($path, '/').'/';
						break;
					}
				}
			}
		}

		return $this->_modules_paths;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns TRUE if an Admin controllers is found.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Ignored admin module if there is one.
	 * 
	 * @access 	public
	 * @param 	string 	$module 	The module's name.
	 * @return 	boolean
	 */
	public function has_admin($module)
	{
		return ('admin' !== $module 
			&& false !== is_file($this->module_path($module).'controllers/Admin.php'));
	}

	// ------------------------------------------------------------------------

    /**
     * This method attempts to locate the controller of a module if 
     * detected in the URI.
     * @access 	public
     * @param 	array 	$segments
     * @return 	array 	$segments.
     */
    public function locate($segments)
    {
    	// Let's detect module's parts first.
        list($module, $directory, $controller) = array_pad($segments, 3, NULL);

        // Let's loop through modules locations.
        foreach ($this->modules_locations() as $location)
        {
        	// Path relative to default application/controllers folder.
			$relative = $location;
			$start    = rtrim(realpath(APPPATH), '/');
			$parts    = explode('/', str_replace('\\', '/', $start));

            // Iterate all parts and replace absolute part with relative part
            for ($i = 1; $i <= count($parts); $i++)
            {
                $relative = str_replace(
                	implode('/', $parts).'/', str_repeat('../', $i),
                	$relative,
                	$count
                );

                // Remove the last element.
                array_pop($parts);

                // Stop iteration if found
                if ($count)
                {
                    break;
                }
            }

            // Does the module exist?
            if (is_dir($source = $location.$module.'/controllers/'))
            {
				$this->module    = $module;
				$this->directory = $relative.$module.'/controllers/';

                // Controller found in module?
                if ($directory && is_file($source.ucfirst($directory).'.php'))
                {
                	// Set the class first.
                    $this->class = $directory;
                    return array_slice($segments, 1);
                }

                // Module sub-directory?
                if ($directory && is_dir($source.$directory.'/'))
                {
                    $source = $source.$directory.'/';
                    $this->directory .= $directory.'/';

                    // Module sub-directory controller?
                    if (is_file($source.ucfirst($directory).'.php'))
                    {
                        return array_slice($segments, 1);
                    }

                    // Module sub-directory  default controller?
                    if (is_file($source.ucfirst($this->default_controller).'.php'))
                    {
                        $segments[1] = $this->default_controller;
                        return array_slice($segments, 1);
                    }

                    // Module sub-directory sub-controller?
                    if ($controller && is_file($source.ucfirst($controller).'.php'))
                    {
                        return array_slice($segments, 2);
                    }
                }

                // Module controller?
                if (is_file($source.ucfirst($module).'.php'))
                {
                    return $segments;
                }

                // Module default controller?
                if (is_file($source.ucfirst($this->default_controller).'.php'))
                {
                    $segments[0] = $this->default_controller;
                    return $segments;
                }
            }
        }

        // Root folder controller?
        if (is_file(APPPATH.'controllers/'.ucfirst($module).'.php'))
        {
            return $segments;
        }

        // Sub-directory controller?
        if ($directory && is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).'.php'))
        {
            $this->directory = $module.'/';
            return array_slice($segments, 1);
        }

        // Default controller?
        if (is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($this->default_controller).'.php'))
        {
            $segments[0] = $this->default_controller;
            return $segments;
        }
    }

}
