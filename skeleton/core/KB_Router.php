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
 * KB_Router Class
 *
 * This class extends CI_Router class in order to use HMVC structure.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.2.0
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
	 * Cache modules details in case they are called again.
	 * @since 	1.4.0
	 * @var 	array
	 */
	protected $_modules_details = array();

	/**
	 * Array of active modules.
	 * @since 	2.0.0
	 * @var 	array
	 */
	protected $_active_modules = array();

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
		'textdomain'   => null,
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
	 * Returns and array of modules locations.
	 * @access 	public
	 * @return 	array.
	 */
	public function modules_locations()
	{
		isset($this->_locations) OR $this->_prep_locations();
		return $this->_locations;
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
	 * @since 	2.0.0 	Added a little check for module.
	 * 
	 * @access 	public
	 * @param 	string 	$name 	Module name.
	 * @return 	the full path if found, else FALSE.
	 */
	public function module_path($name = null)
	{
		if (empty($name))
		{
			$name = $this->module;

			if (empty($name))
			{
				return false;
			}
		}

		if ( ! isset($this->_modules[$name]))
		{
			$path = false;

			foreach ($this->modules_locations() as $location)
			{
				if (is_dir($location.$name))
				{
					$path = $location.$name;
					break;
				}
			}

			if (false === $path)
			{
				return false;
			}

			$this->_modules[$name] = normalize_path($path.'/');
		}

		return $this->_modules[$name];
	}

	// ------------------------------------------------------------------------

	/**
	 * Return an array of the selected module's details.
	 * @access 	public
	 * @param 	string 	$name 	The module's name (folder).
	 * @return 	array if found, else false.
	 */
	public function module_details($name = null, $path = null)
	{
		if (empty($name))
		{
			$name = $this->module;

			if (empty($name))
			{
				return false;
			}
		}

		if ( ! isset($this->_modules_details[$name]))
		{
			$module_path = $path ? $path : $this->module_path($name);
			$manifest_file = $module_path.'manifest.json';
			$manifest_dist = $manifest_file.'.dist';

			if ( ! $module_path 
				OR ( ! is_file($manifest_file) && ! is_file($manifest_dist)))
			{
				return false;
			}

			/**
			 * In case the manifest.json is not found but we have a backup 
			 * file, we make sure to create the file first.
			 */
			if (( ! is_file($manifest_file) && is_file($manifest_dist)) 
				&& false === copy($manifest_dist, $manifest_file))
			{
				return false;
			}

			$headers = function_exists('json_read_file')
				? json_read_file($manifest_file)
				: json_decode(file_get_contents($manifest_file), true, JSON_PRETTY_PRINT);

			if ( ! $headers OR ! is_array($headers))
			{
				return false;
			}

			/**
			 * Create a back-up for the manifest.json file if it does not exist.
			 * @since 2.0.0
			 */
			if (true !== is_file($manifest_dist) 
				&& true !== copy($manifest_file, $manifest_dist))
			{
				return fales;
			}

			/**
			 * Allow users to filter default modules headers.
			 * @since 	2.1.2
			 */
			$default_headers = apply_filters('modules_headers', $this->_headers);
			empty($default_headers) && $default_headers = $this->_headers;

			// Grab module's headers.
			$headers = array_replace_recursive($default_headers, $headers);

			// Remove not listed headers.
			foreach ($headers as $key => $val)
			{
				if ( ! array_key_exists($key, $default_headers))
				{
					unset($headers[$key]);
				}
			}

			// Added things:
			empty($headers['admin_menu']) && $headers['admin_menu'] = $name;

			// Is module enabled?
			$headers['enabled'] = $this->is_active($name);

			// Add all internal details.
			$headers['contexts'] = $this->module_contexts($name, $module_path);
			if ( ! empty($headers['contexts']))
			{
				foreach ($headers['contexts'] as $key => $val)
				{
					$headers['has_'.$key] = (false !== $val);
				}
			}

			$headers['folder'] = $name;
			$headers['full_path'] = $module_path;

			/**
			 * If the module comes without a "help" controller, we see if
			 * the developer provided a module URI so we can use it as
			 * a URL later.
			 */
			if (false === $headers['has_help'] && ! empty($headers['module_uri']))
			{
				$headers['contexts']['help'] = $headers['module_uri'];
				$headers['has_help'] = true;
			}

			if ($headers['license'] == 'MIT' && empty($headers['license_uri']))
			{
				$headers['license_uri'] = 'http://opensource.org/licenses/MIT';
			}
			
			$this->_modules_details[$name] = $headers;
		}

		return $this->_modules_details[$name];
	}

	// ------------------------------------------------------------------------

	/**
	 * module_contexts
	 *
	 * Method for list all module's available contexts.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$module 	The module's name.
	 * @param 	string 	$path 		The module's directory path.
	 * @return 	array
	 */
	public function module_contexts($module, $path = null)
	{
		// Nothing provided? Nothing to do...
		if (empty($module))
		{
			return false;
		}

		// We start with an empty array.
		$module_contexts = array();

		// Make sure the module directory path if found.
		(null === $path) && $path = $this->module_path($module);
		if (false === $path)
		{
			return $module_contexts;
		}

		// Let's first see if the module has an admin controller.
		$module_contexts['admin']  = is_file($path.'/controllers/Admin.php');

		// Loop through contexts and see if we find a controller.
		global $back_contexts;
		foreach ($back_contexts as $context)
		{
			$module_contexts[$context] = is_file($path.'/controllers/'.ucfirst($context).EXT);
		}

		// Return the final result.
		return $module_contexts;
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

			/**
			 * Moved out of the foreach loop for better performance.
			 * @since 	2.0.0
			 * @var 	array
			 */
			$_to_eliminate = array(
				'.',
				'..',
				'.gitkeep',
				'index.html',
				'.htaccess',
				'__MACOSX',
			);

			// Let's go through folders and check if there are any.
			foreach ($this->modules_locations() as $location)
			{
				if ($handle = opendir($location))
				{		
					while (false !== ($file = readdir($handle))) {
						// Must be a directory and has "manifest.json".
						if ( ! in_array($file, $_to_eliminate) 
							&& is_dir($location.$file)
							&& (is_file($location.$file."/manifest.json") OR is_file($location.$file."/manifest.json.dist"))
							&& ! _csk_reserved_module($file))
						{
							$this->_modules[$file] = rtrim(str_replace('\\', '/', $location.$file), '/').'/';
						}
					}
				}
			}

			// Alphabetically order modules.
			ksort($this->_modules);
		}

		$return = $this->_modules;

		if (true === $details)
		{
			$_modules_details = array();

			foreach ($this->_modules as $module => $path)
			{
				if (false !== ($details = $this->module_details($module, $path)))
				{
					$_modules_details[$module] = $details;
				}
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
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 * @since 	2.0.0 	Fixed loading ini.php files for only enabled modules.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function _load_modules()
	{
		// Make sure we have some enabled modules first.
		$active = $this->active_modules(true);
		if (empty($active))
		{
			return;
		}

		// Prepare our list of modules.
		$modules = $this->list_modules();

		foreach ($active as $folder => $m)
		{
			// Module enabled but folder missing? Nothing to do.
			if ( ! is_dir($m['full_path']))
			{
				continue;
			}

			// "init.php" not found? Nothing to do.
			if ( ! is_file($m['full_path'].'init.php'))
			{
				continue;
			}

			// Import "init.php" file.
			require_once($m['full_path'].'init.php');

			/**
			 * If a "module_activate_" action was registered, we fire
			 * it and make sure to add the "enabled" file. This way we
			 * avoid firing it again.
			 */
			if (has_action('module_activate_'.$folder) 
				&& ! is_file($m['full_path'].'enabled'))
			{
				do_action('module_activate_'.$folder);
				@touch($m['full_path'].'enabled');
			}

			// We always fire this action.
			do_action('module_loaded_'.$folder);

			/**
			 * As of version 2.1.0, it is possible to use PHP Gettext.
			 * If the required function is available, we bind modules
			 * domain to global domains.
			 * @since 	2.1.0
			 */
			if  (function_exists('gettext_instance') 
				&& is_dir($m['full_path'].'language'))
			{
				gettext_instance()->bindtextdomain(
					is_string($m['textdomain']) ? $m['textdomain'] : $folder,
					$m['full_path'].'language'
				);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks whether the given $folder is a valid module.
	 * @access 	public
	 * @param 	string 	$folder
	 * @return 	bool
	 */
	public function valid_module($folder = null)
	{
		if ( ! empty($folder))
		{
			$modules = $this->list_modules();
			return isset($modules[$folder]);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * active_modules
	 *
	 * List all active modules previously stored in database.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @since 	2.1.0 	Added details about modules.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function active_modules($details = false)
	{
		// Active modules not previously cached?
		if (empty($this->_active_modules))
		{
			/**
			 * Because we are automatically assigning options from database
			 * to $assign_to_config array, we see if we have the item
			 */
			global $assign_to_config;
			if (isset($assign_to_config['active_modules']))
			{
				$modules = $assign_to_config['active_modules'];
			}
			// Otherwise, see on database.
			else
			{
				$modules = _DB()
					->where('name', 'active_modules')
					->get('options')
					->row();

				// Not found? We make sure to create the option.
				if (null === $modules)
				{
					$modules = array();
					_DB()->insert('options', array(
						'name'  => 'active_modules',
						'value' => to_bool_or_serialize($modules),
						'tab'   => 'modules',
					));
				}

			}

			// We make sure it's an array before finally caching it.
			is_array($modules) OR $modules = array();
			$this->_active_modules = $modules;
		}

		$return = $this->_active_modules;

		if (true !== $details)
		{
			return $return;
		}

		if ( ! empty($return))
		{
			$details = array();

			foreach ($return as $name)
			{
				if (false !== ($d = $this->module_details($name)))
				{
					$details[$name] = $d;
				}
			}

			empty($details) OR $return = $details;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * is_active
	 *
	 * Method for checking whether the selected module is available AND active.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The module's folder name.
	 * @return 	bool 	true if the module is active and found, else false.
	 */
	public function is_active($name)
	{
		$modules = $this->list_modules();
		$active = $this->active_modules();
		return (isset($modules[$name]) && in_array($name, $active));
	}

	// ------------------------------------------------------------------------

	/**
	 * module_activate
	 *
	 * Method for activating the selected module.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The module's folder name.
	 * @return 	bool 	true if the module is enabled, else false.
	 */
	public function module_activate($name)
	{
		$modules = $this->list_modules();
		$active = $this->active_modules();

		// Module don't exists or already enabled? Nothing to do...
		if ( ! isset($modules[$name]) OR in_array($name, $active))
		{
			return false;
		}

		// Add it to active modules and update database.
		$active[] = $name;
		return $this->_set_active_modules($active);
	}

	// For backward compatibility.
	public function module_enable($name)
	{
		return $this->module_activate($name);
	}

	// ------------------------------------------------------------------------

	/**
	 * module_deactivate
	 *
	 * Method for disabling the selected module.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$name 	The module folder name.
	 * @return 	bool 	true if the module was disable, else false.
	 */
	public function module_deactivate($name)
	{
		$modules = $this->list_modules();
		$active = $this->active_modules();

		// The module must exists and must be enabled to proceed.
		if ( ! isset($modules[$name]) 
			OR false === ($i = array_search($name, $active)))
		{
			return false;
		}

		// we use the $i (index) to remove the module.
		unset($active[$i]);

		// Fire the "module_deactivate_{folder}" action.
		do_action('module_deactivate_'.$name);

		// Successfully deactivated?
		if (false !== $this->_set_active_modules($active))
		{
			/**
			 * We make sure to remove our "enabled" flag file so the module
			 *  can use its "module_activate_{foler}" action if enabled again.
			 */
			if (is_file($modules[$name].'enabled'))
			{
				unlink($modules[$name].'enabled');
			}

			return true;
		}

		return false;
	}

	// For backward compatibility.
	public function module_disable($name)
	{
		return $this->module_deactivate($name);
	}

	// ------------------------------------------------------------------------

	/**
	 * _prep_locations
	 *
	 * Method for formatting paths to modules directories.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
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
				$this->_locations = array(APPPATH.'modules/');
			}
			elseif ( ! in_array(APPPATH.'modules/', $this->_locations))
			{
				$this->_locations[] = APPPATH.'modules/';
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
		if (file_exists(APPPATH.'controllers/'.$this->directory.ucfirst($class).EXT))
		{
			$controller_exists = TRUE;
		}
		// Find is skeleton? Set it to found.
		elseif (file_exists(KBPATH.'controllers/'.$this->directory.ucfirst($class).EXT))
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
     * The only reason we are add this method is to allow users to create
     * a "routes.php" file inside the config folder.
     * They can either use the "$route" array of our static Routing using
     * Route class.
     * @access 	protected
     * @return 	void
     */
    protected function _set_routing()
    {
		$routes  = array();

		// Modules routes.
    	if ( ! empty($modules = $this->list_modules()))
    	{
    		foreach ($modules as $folder => $path)
    		{
    			if (is_file($path.'config/routes.php'))
    			{
    				include_once($path.'config/routes.php');

    				if (isset($route) && is_array($route))
    				{
    					$routes = array_merge($routes, $route);
    					unset($route);
    				}

    				continue;
    			}

    			$details = $this->module_details($folder, $path);
    			if (isset($details['routes']) && ! empty($details['routes']))
    			{
    				$this->_set_module_routes($details['routes']);
    				continue;
    			}
    		}
    	}

    	// Skeleton routes.
    	if (is_file(KBPATH.'config/routes.php'))
    	{
    		include_once(KBPATH.'config/routes.php');

    		if (isset($route) && is_array($route))
    		{
    			$routes = array_merge($routes, $route);
    			unset($route);
    		}
    	}

    	// Application routes.
    	if (is_file(APPPATH.'config/routes.php'))
    	{
    		include_once(APPPATH.'config/routes.php');
    	}

    	if (is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
    	{
    		include_once(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
    	}

    	if (isset($route) && is_array($route))
    	{
    		$routes = array_merge($routes, $route);
    		unset($route);
    	}

		if (isset($routes) && is_array($routes))
		{
			isset($routes['default_controller']) && $this->default_controller = $routes['default_controller'];
			isset($routes['translate_uri_dashes']) && $this->translate_uri_dashes = $routes['translate_uri_dashes'];
			unset($routes['default_controller'], $routes['translate_uri_dashes']);
			$this->routes = Route::map($routes);
		}

		// Are query strings enabled in the config file? Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		if ($this->enable_query_strings)
		{
			// If the directory is set at this time, it means an override exists, so skip the checks
			if ( ! isset($this->directory))
			{
				$_d = $this->config->item('directory_trigger');
				$_d = isset($_GET[$_d]) ? trim($_GET[$_d], " \t\n\r\0\x0B/") : '';

				if ($_d !== '')
				{
					$this->uri->filter_uri($_d);
					$this->set_directory($_d);
				}
			}

			$_c = trim($this->config->item('controller_trigger'));
			if ( ! empty($_GET[$_c]))
			{
				$this->uri->filter_uri($_GET[$_c]);
				$this->set_class($_GET[$_c]);

				$_f = trim($this->config->item('function_trigger'));
				if ( ! empty($_GET[$_f]))
				{
					$this->uri->filter_uri($_GET[$_f]);
					$this->set_method($_GET[$_f]);
				}

				$this->uri->rsegments = array(
					1 => $this->class,
					2 => $this->method
				);
			}
			else
			{
				$this->_set_default_controller();
			}

			// Routing rules don't apply to query strings and we don't need to detect
			// directories, so we're done here
			return;
		}

		// Is there anything to parse?
		if ($this->uri->uri_string !== '')
		{
			$this->_parse_routes();
		}
		else
		{
			$this->_set_default_controller();
		}
    }

    // ------------------------------------------------------------------------

    /**
     * Set Module Routes
     *
     * Sets modules routes automatically.
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
    		if (1 === sscanf($route, 'resources:%s', $new_route))
    		{
    			Route::resources($new_route, $original);
    		}
    		elseif (1 === sscanf($route, 'context:%s', $new_route))
    		{
    			Route::context($new_route, $original);
    		}
    		elseif (empty($original))
    		{
    			Route::block($route);
    		}
    		elseif (1 === sscanf($route, 'any:%s', $new_route))
			{
    			Route::any($new_route, $original);
			}
    		elseif (1 === sscanf($route, 'get:%s', $new_route))
			{
    			Route::get($new_route, $original);
			}
    		elseif (1 === sscanf($route, 'post:%s', $new_route))
			{
    			Route::post($new_route, $original);
			}
			elseif (1 === sscanf($route, 'put:%s', $new_route))
			{
    			Route::put($new_route, $original);
			}
			elseif (1 === sscanf($route, 'delete:%s', $new_route))
			{
    			Route::delete($new_route, $original);
			}
			elseif (1 === sscanf($route, 'head:%s', $new_route))
			{
    			Route::head($new_route, $original);
			}
			elseif (1 === sscanf($route, 'patch:%s', $new_route))
			{
    			Route::patch($new_route, $original);
			}
			elseif (1 === sscanf($route, 'options:%s', $new_route))
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
	 * _set_active_modules
	 *
	 * Method updating active modules stored in database, "options" table.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	array 	$modules 	Array of modules to activate.
	 * @return 	bool 	true if successfully updated, else false.
	 */
	protected function _set_active_modules($modules)
	{
		if ( ! empty($modules))
		{
			// We make sure to reset array indexes.
			asort($modules);
			$modules = array_values($modules);
		}

		// We make sure $modules is always an array.
		$modules OR $modules = array();

		// Update the database
		return _DB()->update('options', array(
			'value' => to_bool_or_serialize($modules)
		), array(
			'name' => 'active_modules'
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * is_admin
	 *
	 * Method for checking if we are on the dashboard section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	bool
	 */
	public function is_admin()
	{
		global $back_contexts;

		$is_admin = false;

		if (in_array($this->class, $back_contexts)
			OR _csk_reserved_module($this->class)
			OR KB_ADMIN === $this->class
			OR KB_ADMIN === $this->uri->segment(1))
		{
			$is_admin = true;
		}

		// Last check for front-end Users controller.
		if (KB_ADMIN !== $this->uri->segment(1) 
			&& 'users' === $this->class)
		{
			$is_admin = false;
		}

		return $is_admin;
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

        // Flag to see if we are in a module.
        $is_module = false;

        if (isset($this->_modules[$module]))
        {
			$is_module = true;
			$location  = $this->_modules[$module];
        }
        // Because of revered routes ;)
        elseif (isset($this->_modules[$directory]))
        {
			$is_module = true;
			$location  = $this->_modules[$directory];
			$_module   = $module;
			$module    = $directory;
			$directory = $_module;
        }

        if (true === $is_module)
        {
			$relative    = rtrim(str_replace($module.'/', '', $location), '/');
			$start       = rtrim(realpath(APPPATH), '/');
			$parts       = explode('/', str_replace('\\', '/', $start));
			$parts_count = count($parts);

			for ($i = 1; $i <= $parts_count; $i++)
			{
				$relative = str_replace(
					implode('/', $parts).'/',
					str_repeat('../', $i),
					$relative,
					$count
				);

				array_pop($parts);

				if ($count)
				{
					break;
				}
			}

			if (true === is_dir($source = $location.'controllers/'))
			{
				$this->module = $module;
				$this->directory = "{$relative}/{$module}/controllers/";

				// Found the controller?
				if ($directory && is_file($source.ucfirst($directory).EXT))
				{
					$this->class = $directory;
					$segments[0] = $module;
					$segments[1] = $directory;
					return array_slice($segments, 1);
				}

				// Controller in a sub-directory?
				if ($directory && is_dir($source.$directory.'/'))
				{
					$source = $source.$directory.'/';
					$this->directory .= $directory.'/';

					if (is_file($source.ucfirst($directory).EXT))
					{
						return array_slice($segments, 1);
					}

					// Different controller's name?
					if ($controller && is_file($source.ucfirst($controller).EXT))
					{
						return array_slice($segments, 2);
					}

					// Module sub-directory with default controller?
					if (is_file($source.ucfirst($this->default_controller).EXT))
					{
						$segments[1] = $this->default_controller;
						return array_slice($segments, 1);
					}
				}

				// Module controller?
				if (is_file($source.ucfirst($module).EXT))
				{
					return $segments;
				}

				// Module with default controller?
				if (is_file($source.ucfirst($this->default_controller).EXT))
				{
					$segments[0] = $this->default_controller;
					return $segments;
				}
			}
        }

        // Paths where controllers may be located.
        $paths = array(APPPATH, KBPATH);
        foreach ($paths as $path)
        {
        	// Priority to sub-folders.
        	if ($directory 
        	    && is_file($path.'controllers/'.$module.'/'.ucfirst($directory).EXT))
        	{
	            $this->directory = $module.'/';
	            return array_slice($segments, 1);
        	}

	        // Root folder controller?
	        if (is_file($path.'controllers/'.ucfirst($module).EXT))
	        {
	            return $segments;
	        }

	        // Sub-directory controller?
	        if ($directory && is_file($path.'controllers/'.$module.'/'.ucfirst($directory).EXT))
	        {
	            $this->directory = $module.'/';
	            return array_slice($segments, 1);
	        }

	        // Default controller?
	        if (is_file($path.'controllers/'.$module.'/'.ucfirst($this->default_controller).EXT))
	        {
	            $segments[0] = $this->default_controller;
	            return $segments;
	        }	
        }
    }

}

// ------------------------------------------------------------------------
// Helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('module_path'))
{
	/**
	 * Returns the full path to the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @return 	the module's path if found, else false.
	 */
	function module_path($name = null)
	{
		return get_instance()->router->module_path($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('module_details'))
{
	/**
	 * Returns details about the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @param 	string 	$path 	The module path.
	 * @return 	array of module details if found, else false.
	 */
	function module_details($name = null, $path = null)
	{
		return get_instance()->router->module_details($name, $path);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('module_contexts'))
{
	/**
	 * Returns an array of the given module's contexts.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @return 	array of module contexts if found, empty array if not found.
	 */
	function module_contexts($name = null)
	{
		return get_instance()->router->module_contexts($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('list_modules'))
{
	/**
	 * Lists all modules available on the application.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	bool 	$details 	Whether to list details or not.
	 * @return 	array of all available modules.
	 */
	function list_modules($details = false)
	{
		return get_instance()->router->list_modules($details);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('active_modules'))
{
	/**
	 * Returns an array of enabled modules.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	bool 	$details Whether to collect details.
	 * @return 	array of modules.
	 */
	function active_modules($details = false)
	{
		return get_instance()->router->active_modules($details);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('module_is_active'))
{
	/**
	 * Checks whether the given module is enabled.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @return 	bool 	true if the module is enabled, else false.
	 */
	function module_is_active($name = null)
	{
		return get_instance()->router->is_active($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('activate_module'))
{
	/**
	 * Enables the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @return 	bool 	true if the module was enabled, else false.
	 */
	function activate_module($name)
	{
		return get_instance()->router->module_activate($name);
	}

	// Alias for backward compatibility.
	function enable_module($name)
	{
		return get_instance()->router->module_activate($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deactivate_module'))
{
	/**
	 * Disables the given module.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$name 	The module's name.
	 * @return 	bool 	true if the module was disabled, else false.
	 */
	function deactivate_module($name)
	{
		return get_instance()->router->module_deactivate($name);
	}

	// Alias for backward compatibility.
	function disable_module($name)
	{
		return get_instance()->router->module_deactivate($name);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_admin'))
{
	function is_admin()
	{
		return get_instance()->router->is_admin();
	}
}

// ------------------------------------------------------------------------
// Module's helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('get_the_module'))
{
	/**
	 * Returns the current module folder's name.
	 * @param 	none
	 * @return 	string 	Folder name if found, else null.
	 */
	function get_the_module()
	{
		return get_instance()->router->fetch_module();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('the_module'))
{
	/**
	 * Displays the current module folder's name.
	 * @param 	none
	 * @return 	void
	 */
	function the_module()
	{
		echo get_instance()->router->fetch_module();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_module'))
{
	/**
	 * Checks if the page belongs to a given module. If no argument is passed,
	 * it checks if we areusing a module.
	 * You may pass a single string, multiple comma- separated modules or an array.
	 * @param   string|array.
	 * @return 	bool 	true if passed check, else false.
	 */
	function is_module($modules = null)
	{
		$module = get_instance()->router->fetch_module();

		if (null === $modules)
		{
			return ($module !== null);
		}

		if ( ! is_array($modules))
		{
			$modules = explode(',', $modules);
		}

		$modules = array_clean($modules);

		return in_array($module, $modules);
	}
}

// ------------------------------------------------------------------------
// Controller's helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('get_the_controller'))
{
	/**
	 * Returns the current controller folder's name.
	 * @param 	none
	 * @return 	string 	Class name if found, else null.
	 */
	function get_the_controller()
	{
		return get_instance()->router->fetch_class();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('the_controller'))
{
	/**
	 * Displays the current controller folder's name.
	 * @param 	none
	 * @return 	void
	 */
	function the_controller()
	{
		echo get_instance()->router->fetch_class();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_controller'))
{
	/**
	 * Checks if the page belongs to a given controller.
	 * @param 	mixed 	$controllers
	 * @return 	bool
	 */
	function is_controller($controllers = null)
	{
		$controller = get_instance()->router->fetch_class();

		if (null === $controllers)
		{
			return ($controller !== null);
		}

		if ( ! is_array($controllers))
		{
			$controllers = explode(',', $controllers);
		}

		$controllers = array_clean($controllers);

		return in_array($controller, $controllers);
	}
}

// ------------------------------------------------------------------------
// Method's helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('get_the_method'))
{
	/**
	 * Returns the current method's name.
	 * @return 	string
	 */
	function get_the_method()
	{
		return get_instance()->router->fetch_method();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_method'))
{
	/**
	 * Returns the current method's name.
	 * @return 	void
	 */
	function the_method()
	{
		echo get_instance()->router->fetch_method();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_method'))
{
	/**
	 * Checks if the page belongs to a given method.
	 * @return 	bool
	 */
	function is_method($methods = null)
	{
		$method = get_instance()->router->fetch_method();

		// This is silly but, let's just put it.
		if (null === $methods)
		{
			return ($method !== null);
		}

		if ( ! is_array($methods))
		{
			$methods = explode(',', $methods);
		}

		$methods = array_clean($methods);

		return (in_array($method, $methods));
	}
}
