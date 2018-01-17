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
 * Make sure to load our custom Route class right here.
 * This class allows us to use static routing like laravel.
 */
require_once(KBPATH.'libraries/Route.php');

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
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class KB_Router extends CI_Router
{
	/**
	 * Holds an array of modules locations.
	 * @var array.
	 */
	protected $_locations;

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
		// Make sure to load config class.
		$this->config =& load_class('Config', 'core');

		// Let's first format modules locations.
		$locations = $this->config->item('modules_locations');

		// If it's not set, we set it.
		($locations) OR $locations = array(APPPATH.'modules/', KBPATH.'modules/');
		
		// If set, make sure it's an array.
		(is_array($locations)) OR $locations = (array) $locations;

		// If our custom path is not found, add it!
		(in_array(KBPATH.'modules/', $locations)) OR $locations[] = KBPATH.'modules/';

		// Now we format paths.
		foreach ($locations as $key => &$location)
		{
			if (realpath($location) === FALSE)
			{
				unset($locations[$key]);
			}
			else
			{
				$location = rtrim(str_replace('\\', '/', realpath($location)), '/').'/';
			}
		}

		// Now we set back config iteM
		$this->config->set_item('modules_locations', $locations);

		log_message('info', 'KB_Router Class Initialized');

		// Call parent's constructor.
		parent::__construct();
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
    	// Let's loop through respective folders.
    	foreach (array(APPPATH, KBPATH) as $path)
    	{
    		if (is_dir($path.'routes'))
    		{
    			$file_list = scandir($path.'routes');
    			foreach ($file_list as $file)
    			{
    				if (is_file($path.'routes/'.$file) 
    					&& pathinfo($file, PATHINFO_EXTENSION) == 'php')
    				{
    					include($path.'routes/'.$file);
    				}
    			}
    		}
    	}

		// We now let the parent do the heavy work.
		parent::_set_routing();
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
	 * @access 	public
	 * @param 	string 	$module 	Module name.
	 * @return 	the full path if found, else FALSE.
	 */
	public function module_path($module = null)
	{
		if (empty($module))
		{
			return NULL;
		}

		// Loop through all locations and try to find the module.
		foreach ($this->modules_locations() as $location)
		{
			// If found, return the path.
			if (is_dir($location.$module))
			{
				return $location.$module.'/';
			}
		}

		return NULL;
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

		// Prepare the module's path first and make sure it's valid.
		$module_path = $this->module_path($module);
		if (false === $module_path)
		{
			return false;
		}

		// Let's see if the manifest.json is found.
		if ( ! is_file($module_path.'manifest.json'))
		{
			return false;
		}

		// Get the content of the file and make sure it's well formatted.
		$manifest = file_get_contents($module_path.'manifest.json');
		$manifest = json_decode($manifest, true);
		if ( ! is_array($manifest))
		{
			return false;
		}

		// Default headers.
		$defaults = array(
			'name'         => null,
			'folder'       => $module_path,
			'module_uri'   => null,
			'description'  => null,
			'version'      => null,
			'license'      => null,
			'license_uri'  => null,
			'author'       => null,
			'author_uri'   => null,
			'author_email' => null,
			'tags'         => null,
			'admin_menu'   => null,
			'admin_order'  => 0
		);

		// Replace all keys.
		$manifest = array_replace_recursive($defaults, $manifest);

		// Add dashboard menu label.
		if ($this->has_admin($module))
		{
			if (empty($manifest['admin_menu']))
			{
				$manifest['admin_menu'] = lang($module);
			}
			elseif (sscanf($manifest['admin_menu'], 'lang:%s', $line))
			{
				$manifest['admin_menu'] = lang($line);
			}
		}

		// Add URI to MIT license.
		if ($manifest['license'] == 'MIT' && empty($manifest['license_uri']))
		{
			$manifest['license_uri'] = 'http://opensource.org/licenses/MIT';
		}

		return $manifest;
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
		// Prepare an empty array of modules.
		$modules = array();
		
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
						$modules[] = $file;
					}
				}
			}
		}

		if ( ! empty($modules) && $details === true)
		{
			foreach ($modules as $key => $module)
			{
				$modules[$module] = $this->module_details($module);
				unset($modules[$key]);
			}
		}
		
		// Now we return the final result.
		return $modules;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns and array of modules locations.
	 * @access 	public
	 * @return 	array.
	 */
	public function modules_locations()
	{
		// Already cached? Return it.
		if (isset($this->_locations))
		{
			return $this->_locations;
		}

		// Get modules locations from config, cache it then return it.
		$this->_locations = $this->config->item('modules_locations');
		return $this->_locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns TRUE if an Admin controllers is found.
	 * @access 	public
	 * @param 	string 	$module 	The module's name.
	 * @return 	boolean
	 */
	public function has_admin($module)
	{
		return (is_file($this->module_path($module).'controllers/Admin.php'));
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
