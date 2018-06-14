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
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Loader Class
 *
 * This class extends CI_Router class in order to use HMVC structure.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class KB_Loader extends CI_Loader
{
	/**
	 * Holds an array of loaded modules.
	 * @var array
	 */
	protected $_ci_modules = array();

	/**
	 * Holds an array of loaded modules controllers.
	 * @var array
	 */
	protected $_ci_controllers = array();

	/**
	 * Holds an instance of Router class.
	 * @var object
	 */
	protected $_router;

	/**
	 * Holds the array of files to be autoloaded.
	 * @var array
	 */
	public $autoload = array();

	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		// Let's add our path.
		$this->_ci_ob_level      = ob_get_level();
		$this->_ci_library_paths = array(APPPATH, KBPATH, BASEPATH);
		$this->_ci_helper_paths  = array(APPPATH, KBPATH, BASEPATH);
		$this->_ci_model_paths   = array(APPPATH, KBPATH);
		$this->_ci_view_paths    = array(
            APPPATH.'views/' => TRUE,
            KBPATH.'views/'  => TRUE
        );
		log_message('debug', 'KB_Loader class Initialized');

		// Now we call parent's constructor.
		parent::__construct();

		// Get an instance of router class.
		$this->_router =& get_instance()->router;

		// Make sure to add the module as a package.
		($this->_router->module) && $this->add_module($this->_router->module);
	}

	// ------------------------------------------------------------------------

	/**
	 * Controller Loader.
	 *
	 * This method lets you load any module's controller.
	 *
	 * @access 	public
	 * @param 	string 	$uri 	The controller to load. i.e: module/controller.
	 * @param 	array 	$data 	Array of arguments to pass to controller.
	 * @param 	bool 	$return In case you want to return instead of output.
	 * @return 	depends on the loaded controller.
	 */
	public function controller($uri, $data = array(), $return = FALSE)
	{
		// Let's first detect the module.
		list($module, $class) = $this->_detect_module($uri);

		// Not found? Let KB_Router find it and proceed if found.
		if ( ! isset($module) && $this->_router->module)
		{
			// Found? Change the URI.
			$uri = $this->_router->module.'/'.$uri;
		}

		/**
		 * Now all we have to do is to add the module, catch what  is returns,
		 * remove it and finally return the caught result.
		 */
		return $this->_load_controller($uri, $data, $return);
		// $this->add_module($module);
		// $result = $this->_load_controller($uri, $data, $return);
		// $this->remove_module();
		// return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * Config Loader
	 *
	 * This method overrides CodeIgniter config loaded to allow HMVC support.
	 *
	 * @uses	CI_Config::load()
	 * @param	string	$file			Configuration file name
	 * @param	bool	$use_sections		Whether configuration values should be loaded into their own section
	 * @param	bool	$fail_gracefully	Whether to just return FALSE or display an error message
	 * @return	bool	TRUE if the file was loaded correctly or FALSE on failure
	 */
	public function config($file, $use_sections = FALSE, $fail_gracefully = FALSE)
	{
		// Let's first detect the module.
		list($module, $class) = $this->_detect_module($file);

		// Cache CodeIgniter instance.
		$CI =& get_instance();

		// Proceed now.
		$result = $CI->config->load($file, $use_sections, ($module !== NULL));

		// Let's see if we are loading form a module.
		if ($module !== null)
		{
			// Already loaded?
			if (in_array($module, $this->_ci_modules))
			{
				$result = $CI->config->load($class, $use_sections, $fail_gracefully);
			}
			// Not loaded? Load it and catch the result.
			else
			{
				$this->add_module($module);
				$result = $CI->config->load($class, $use_sections, $fail_gracefully);
				$this->remove_module();
			}
		}

		return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Package Path
	 *
	 * This method was added so we can load "bootstrap.php" files from added
	 * packages and do actions if found.
	 *
	 * @access 	public
	 * @param 	string 	$path 	The path to add.
	 * @param 	bool 	$view_cascade
	 * @return 	object
	 */
	public function add_package_path($path, $view_cascade = TRUE)
	{
		// Make the method remember already loaded packages.
		static $loaded = array();

		if ( ! isset($loaded[$path]))
		{
			// Normalize path and use folder name for action.
			$path = normalize_path($path);
			$basename = basename($path);
			
			parent::add_package_path($path, $view_cascade);

			// Possibility to add a bootstrap.php file.
			if (is_file($path.'/bootstrap.php'))
			{
				require_once($path.'/bootstrap.php');

				/**
				 * If your package bootstrap file contains a class named like
				 * "Folder_bootstrap" and having an "init" method, the class
				 * is automatically initialized and the method called.
				 */
				$class = ucfirst($basename).'_bootstrap';

				if (class_exists($class, false))
				{
					$class = new $class();
					is_callable(array($class, 'init')) && $class->init();
				}

				do_action('package_added_'.$basename);
			}

			$loaded[$path] = $basename;
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove Package Path
	 *
	 * Simply uses parent's method and fires the "package_removed_" action
	 * if it exists.
	 *
	 * @access 	public
	 * @param 	string 	$path 	The path to remove.
	 * @return 	object
	 */
	public function remove_package_path($path = '')
	{
		empty($path) OR do_action('package_removed_'.basename($path));
		return parent::remove_package_path($path);
	}

	// ------------------------------------------------------------------------

	/**
	 * Override CodeIgniter helper loader to allow passing arguments 
	 * as array or comma-separated arguments.
	 * @access 	public
	 * @param 	mixed 	$helpers 	string(s) or array.
	 * @return 	object
	 */
	public function helper($helpers = array())
	{
		// Catch method arguments first. None? Nothing to do.
		$args = func_get_args();
		if (empty($args))
		{
			return $this;
		}

		// Get rid of nasty array.
		(is_array($args[0])) && $args = $args[0];

		foreach ($args as &$helper)
		{
			$filename = basename($helper);
			$filepath = ($filename === $helper) ? '' : substr($helper, 0, strlen($helper) - strlen($filename));
			$filename = strtolower(preg_replace('#(_helper)?(\.php)?$#i', '', $filename)).'_helper';
			$helper   = $filepath.$filename;

			if (isset($this->_ci_helpers[$helper]))
			{
				continue;
			}

			// Is this a helper extension request?
			$ext_helper = config_item('subclass_prefix').$filename;
			$ext_loaded = FALSE;
			foreach ($this->_ci_helper_paths as $path)
			{
				if (is_file($path.'helpers/'.$ext_helper.'.php'))
				{
					include_once($path.'helpers/'.$ext_helper.'.php');
					$ext_loaded = TRUE;
				}
			}

            // Look for out custom helpers.
            if (is_file(KBPATH.'helpers/KB_'.$helper.'.php'))
            {
                include_once(KBPATH.'helpers/KB_'.$helper.'.php');
                $ext_loaded = TRUE;
            }

			// If we have loaded extensions - check if the base one is here
			if ($ext_loaded === TRUE)
			{
				$base_helper = BASEPATH.'helpers/'.$helper.'.php';
				if ( ! is_file($base_helper))
				{
					show_error('Unable to load the requested file: helpers/'.$helper.'.php');
				}

				include_once($base_helper);
				$this->_ci_helpers[$helper] = TRUE;
				log_message('info', 'Helper loaded: '.$helper);
				continue;
			}

			// No extensions found ... try loading regular helpers and/or overrides
			foreach ($this->_ci_helper_paths as $path)
			{
				if (is_file($path.'helpers/'.$helper.'.php'))
				{
					include_once($path.'helpers/'.$helper.'.php');

					$this->_ci_helpers[$helper] = TRUE;
					log_message('info', 'Helper loaded: '.$helper);
					break;
				}
			}

            // Not loaded? Try in module.
            if ( ! isset($this->_ci_helpers[$helper]) 
            	&& list($module, $class) = $this->_detect_module($helper))
            {
            	// Module already loaded?
            	if (in_array($module, $this->_ci_modules) 
            		&& is_file($this->_router->module_path($module).'helpers/'.$filename.'.php'))
            	{
            		include_once($this->_router->module_path($module).'helpers/'.$filename.'.php');
            		$this->_ci_helpers[$helper] = TRUE;
            	}
            	// Not loaded? Try to loaded and look for the file.
            	else
            	{
            		$this->add_module($module);
            		if (is_file($this->_router->module_path($module).'helpers/'.$filename.'.php'))
            		{
            			include_once($this->_router->module_path($module).'helpers/'.$filename.'.php');
            			$this->_ci_helpers[$helper] = TRUE;
            		}
            		$this->remove_module();
            	}
            }

			// unable to load the helper
			if ( ! isset($this->_ci_helpers[$helper]))
			{
				show_error('Unable to load the requested file: helpers/'.$helper.'.php');
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Load multiple helpers. This method was added only to override parent's.
	 * @access 	public
	 * @param 	mixed
	 * @return 	object.
	 */
	public function helpers($helpers = array())
	{
		return call_user_func_array(array($this, 'helper'), func_get_args());
	}

	// ------------------------------------------------------------------------

	/**
	 * Language loader.
	 * @access 	public
	 * @param 	string|array 	$files 	Files to load.
	 * @param 	string  		$lang 	Language name.
	 * @return 	object.
	 */
	public function language($files, $lang = '')
	{
		if (is_array($files))
		{
			foreach ($files as $file)
			{
				$this->language($file, $lang);
			}

			return TRUE;
		}

		// Detect the module first. Priority if to modules first.
		if (list($module, $class) = $this->_detect_module($files))
		{
			// Module already loaded?
			if (in_array($module, $this->_ci_modules))
			{
				$result = parent::language($class, $lang);
			}
			/// Here we add the module, catch the result, remove it and return.
			else
			{
				$this->add_module($module);
				$result = parent::language($class, $lang);
				$this->remove_module();
			}
		}
		// No module? Nothing to do.
		else
		{
			$result = parent::language($files, $lang);
		}

		return $result;
	}

    // ------------------------------------------------------------------------

	/**
	 * Library Loader.
	 * @access 	public
	 * @param 	mixed 	$class 			String or array.
	 * @param 	array 	$params 		Library configuration.
	 * @param 	string 	$object_name 	Whether to rename the library.
	 * @return 	void
	 */
    public function library($class, $params = NULL, $object_name = NULL)
    {
    	// In case of multiple libraries.
    	if (is_array($class))
    	{
    		foreach ($class as $key => $val)
    		{
    			if (is_int($key))
    			{
    				$this->library($val, $params);
    			}
    			else
    			{
    				$this->library($key, $params, $val);
    			}
    		}

    		return $this;
    	}

    	// Priority is to modules.
    	if (list($module, $_class) = $this->_detect_module($class))
    	{
    		// Already loaded?
    		if (in_array($module, $this->_ci_modules))
    		{
    			$result = parent::library($_class, $params, $object_name);
    		}
    		// Not loaded? Load it.
    		else
    		{
    			$this->add_module($module);
    			$result = parent::library($_class, $params, $object_name);
    			$this->remove_module();
    		}
    	}
    	// Not in module? Go the default way.
    	else
    	{
    		$result = parent::library($class, $params, $object_name);
    	}

    	// Return the final result.
    	return $result;
    }

	// ------------------------------------------------------------------------

	/**
	 * Models Loader.
	 * @access 	public
	 * @param 	mixed 	$model 		Single or multiple models
	 * @param 	string 	$$name 		Whether to rename the model.
	 * @param	bool	$db_conn	An optional database connection configuration to initialize
	 * @return 	object
	 */
	public function model($model, $name = '', $db_conn = FALSE)
	{
		if (empty($model))
		{
			return $this;
		}
		elseif (is_array($model))
		{
			foreach ($model as $key => $value)
			{
				is_int($key) ? $this->model($value, '', $db_conn) : $this->model($key, $value, $db_conn);
			}

			return $this;
		}

		$path = '';

		// Used by HMVC.
		$original_name = $model;

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, ++$last_slash);

			// And the model name behind it
			$model = substr($model, $last_slash);
		}

		if (empty($name))
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return $this;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			throw new RuntimeException('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		if ($db_conn !== FALSE && ! class_exists('CI_DB', FALSE))
		{
			if ($db_conn === TRUE)
			{
				$db_conn = '';
			}

			$this->database($db_conn, FALSE, TRUE);
		}

		// Note: All of the code under this condition used to be just:
		//
		//       load_class('Model', 'core');
		//
		//       However, load_class() instantiates classes
		//       to cache them for later use and that prevents
		//       MY_Model from being an abstract class and is
		//       sub-optimal otherwise anyway.
		if ( ! class_exists('CI_Model', FALSE))
		{
			$app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
			if (file_exists($app_path.'Model.php'))
			{
				require_once($app_path.'Model.php');
				if ( ! class_exists('CI_Model', FALSE))
				{
					throw new RuntimeException($app_path."Model.php exists, but doesn't declare class CI_Model");
				}
			}
			elseif ( ! class_exists('CI_Model', FALSE))
			{
				require_once(BASEPATH.'core'.DIRECTORY_SEPARATOR.'Model.php');
			}

			$class = config_item('subclass_prefix').'Model';
			if (file_exists($app_path.$class.'.php'))
			{
				require_once($app_path.$class.'.php');
				if ( ! class_exists($class, FALSE))
				{
					throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
				}
			}
		}

		$model = ucfirst($model);
		if ( ! class_exists($model, FALSE))
		{
			// Use by HMVC
			$model_exists = FALSE;

			foreach ($this->_ci_model_paths as $mod_path)
			{
				if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))
				{
					continue;
				}

				require_once($mod_path.'models/'.$path.$model.'.php');
				if ( ! class_exists($model, FALSE))
				{
					throw new RuntimeException($mod_path."models/".$path.$model.".php exists, but doesn't declare class ".$model);
				}

				$model_exists = TRUE;
				break;
			}

			// The model was not found? Try in modules.
			if ( ! $model_exists && list($module, $_class) = $this->_detect_module($original_name))
			{
				// Load the module if not loaded.
				(in_array($module, $this->_ci_modules)) OR $this->add_module($module);
				$mod_path = $this->_router->module_path($module);

				if (file_exists($mod_path.'models/'.$model.'.php'))
				{
					require_once($mod_path.'models/'.$model.'.php');
				}
				
			}

			if ( ! class_exists($model, FALSE))
			{
				throw new RuntimeException('Unable to locate the model you have specified: '.$model);
			}
		}
		elseif ( ! is_subclass_of($model, 'CI_Model'))
		{
			throw new RuntimeException("Class ".$model." already exists and doesn't extend CI_Model");
		}

		$this->_ci_models[] = $name;
		$CI->$name = new $model();
		return $this;
	}

    // ------------------------------------------------------------------------

    /**
     * This method adds a module exactly the same way we add packages.
     * @access 	public
     * @param 	string 	$module 	Module's name.
     * @param 	bool 	$view_cascade.
     * @return 	void
     */
    public function add_module($module, $view_cascade = TRUE)
    {
    	// Make sure the module exists first.
    	$module_path = $this->_router->module_path($module);

    	if (FALSE !== $module_path)
    	{
    		// Mark the module as loaded first.
    		array_unshift($this->_ci_modules, $module);

    		// Add the path to the module as a package path.
    		$this->add_package_path($module_path, $view_cascade);
    	}
    }

    // ------------------------------------------------------------------------

    /**
     * This method does what is says, it removes the module the same way 
     * we remove packages paths with CodeIgniter.
     * @access 	public
     * @param 	string 	$module 	Module's name.
     * @param 	bool 	$config 	Whether to remove config file.
     * @return 	void
     *
     */
    public function remove_module($module = null, $remove_config = TRUE)
    {
    	// Empty module's name?
        if (empty($module))
        {
            // Remove the first element of loaded modules array.
            array_shift($this->_ci_modules);

            // Now we remove the package.
            $this->remove_package_path('', $remove_config);
        }
        // Search the module and remove it if found.
        elseif (FALSE !== ($key = array_search($module, $this->_ci_modules)))
        {
        	$module_path = $this->_router->module_path($module);

        	// Found? Remove it.
        	if (FALSE !== $module_path)
        	{
        		// Make the module as not loaded.
        		unset($this->_ci_modules[$key]);

        		// Remove the module as we remove package.
        		$this->remove_package_path($module_path, $remove_config);
        	}
        }
    }

	// ------------------------------------------------------------------------

    /**
     * This method attempts to detect the module form the passed string.
     * @access 	protected
     * @param 	string 	$class 	The string used to detect the module.
     * @return 	mixed 	array of module and class if found, else false.
     */
    protected function _detect_module($class)
    {
    	// First, we remove the extension and trim slashes.
        $class = str_replace('.php', '', trim($class, '/'));

        // Catch the position of the first slash.
        $first_slash = strpos($class, '/');

        // If there is a slash, proceed.
        if (FALSE !== $first_slash)
        {
        	// Get the module and class from $class.
			$module = substr($class, 0, $first_slash);
			$class  = substr($class, $first_slash + 1);

            // Make sure the module exits before returning the result.
            if ($this->_router->module_path($module) !== FALSE)
            {
            	return array($module, $class);
            }
        }

        // Nothing found?
        return FALSE;
    }

	// ------------------------------------------------------------------------

	/**
	 * Handles controllers loading.
	 * @access 	public
	 * @param 	string 	$uri 	The controller to load. i.e: module/controller.
	 * @param 	array 	$data 	Array of arguments to pass to controller.
	 * @param 	bool 	$return In case you want to return instead of output.
	 * @return 	depends on the loaded controller.
	 */
	protected function _load_controller($uri = '', $data = array(), $return = FALSE)
	{
		// Make sure to backup router properties first.
		$backup = array();
		foreach (array('directory', 'class', 'method', 'module') as $prop)
		{
			$backup[$prop] = $this->_router->{$prop};
		}

		// Let's now try to locate the controller.
		$segments = $this->_router->locate(explode('/', $uri));
		$class    = (isset($segments[0])) ? $segments[0] : FALSE;
		$method   = (isset($segments[1])) ? $segments[1] : 'index';


		// Controller not found? Nothing to do.
		if ( ! $class)
		{
			return;
		}

		// In case the controller was not already loaded, load it.
        if ( ! array_key_exists(strtolower($class), $this->_ci_controllers))
        {
        	// Priority is to controller inside application/controllers directory.
        	$filepath = APPPATH.'controllers/'.ucfirst($class).'.php';

        	// Not found? Use module.
        	if ( ! is_file($filepath))
        	{
            	$filepath = APPPATH.'controllers/'.$this->_router->fetch_directory().$class.'.php';
        	}

            // If found, load it.
            if (is_file($filepath))
            {
                include_once($filepath);
            }

            // If the controller's class was not found, trigger 404 error.
            if ( ! class_exists($class))
            {
            	show_404("Controller class was not found: {$class}/{$method}");
            }

            // If found, add it to loaded controllers by instantiating its class.
            $this->_ci_controllers[strtolower($class)] = new $class();
        }

        // Get the controller's object from loaded controllers array.
        $controller = $this->_ci_controllers[strtolower($class)];

        // Make sure the called method exists first.
        if ( ! method_exists($controller, $method))
        {
        	show_error("Controllers method was not found: {$class}/{$method}");
        }

        // Now we restore router's properties.
        foreach ($backup as $prop => $value)
        {
            $this->_router->{$prop} = $value;
        }

        // Let's capture the output first and catch the result.
        ob_start();
        $result = call_user_func_array(array($controller, $method), $data);

        // Return instead of output?
        if ($return === TRUE)
        {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }

        // Finally, we flush output and return the result.
        ob_end_flush();
        return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * Internal CI Data Loader
	 * @access 	protected
	 * @param	array	$_ci_data	Data to load
	 * @return 	void
	 */
	protected function _ci_load($_ci_data)
	{
		/**
		 * Here we loop through available views paths and see if the 
		 * view exists. Priority here is for application/views/ and 
		 * skeleton/views/ folders first.
		 */
		foreach ($this->_ci_view_paths as $path => $cascade)
		{
			if (isset($_ci_data['_ci_view']) && is_file($path.$_ci_data['_ci_view'].'.php'))
			{
				return parent::_ci_load($_ci_data);
			}
		}

		// See if it's inside a module!
		if (isset($_ci_data['_ci_view']) && 
			list($module, $class) = $this->_detect_module($_ci_data['_ci_view']))
		{
			// Module already loaded?
			if ( ! in_array($module, $this->_ci_modules))
			{
				$this->add_module($module);
			}
			
			// $_ci_data['_ci_view'] = $class;
			$_ci_data['_ci_path'] = $this->_router->module_path($module).'views/'.$class.'.php';
			
			return parent::_ci_load($_ci_data);
		}

		return parent::_ci_load($_ci_data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Internal CI Stock Library Loader
	 *
	 * A little tweak so we can load our customized libraries.
	 * 
	 * @param	string	$library_name	Library name to load
	 * @param	string	$file_path	Path to the library filename, relative to libraries/
	 * @param	mixed	$params		Optional parameters to pass to the class constructor
	 * @param	string	$object_name	Optional object name to assign to
	 * @return	void
	 */
	protected function _ci_load_stock_library($library_name, $file_path, $params, $object_name)
	{
		// We load our custom libraries if found.
		if (is_file(BASEPATH.'libraries/'.$file_path.$library_name.'.php') 
			&& is_file(KBPATH.'libraries/KB_'.$library_name.'.php'))
		{
			// Load stock library first.
			include_once(BASEPATH.'libraries/'.$file_path.$library_name.'.php');

			// Now we load our custom library.
			include_once(KBPATH.'libraries/KB_'.$library_name.'.php');

			// Let the parent do the job!
			return parent::_ci_init_library($library_name, 'KB_', $params, $object_name);
		}

		return parent::_ci_load_stock_library($library_name, $file_path, $params, $object_name);
	}

	// ------------------------------------------------------------------------

	/**
	 * CI Autoloader
	 *
	 * Overrides CodeIgniter default method to use our custom file.
	 *
	 * Loads component listed in the config/autoload.php file.
	 *
	 * @used-by 	CI_Loader::initialize()
	 * @return 	void
	 */
	protected function _ci_autoloader()
	{
		// Skeleton "autoload.php".
		if (is_file(KBPATH.'config/autoload.php'))
		{
			require_once(KBPATH.'config/autoload.php');
			
			if (isset($autoload))
			{
				$this->autoload = array_replace_recursive($this->autoload, $autoload);
				unset($autoload);
			}
		}

		// Application "autoload.php".
		if (is_file(APPPATH.'config/autoload.php'))
		{
			require_once(APPPATH.'config/autoload.php');

			if (isset($autoload))
			{
				$this->autoload = array_replace_recursive($this->autoload, $autoload);
				unset($autoload);
			}
		}

		if (is_file(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
		{
			require_once(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');

			if (isset($autoload))
			{
				$this->autoload = array_replace_recursive($this->autoload, $autoload);
				unset($autoload);
			}
		}

		$this->autoload = array_filter($this->autoload);

		if (empty($this->autoload))
		{
			return;
		}

		// Autoload packages
		if (isset($this->autoload['packages']))
		{
			foreach ($this->autoload['packages'] as $package_path)
			{
				$this->add_package_path($package_path);
			}
		}

		// Load any custom config file
		if (isset($this->autoload['config']) && count($this->autoload['config']) > 0)
		{
			foreach ($this->autoload['config'] as $val)
			{
				$this->config($val);
			}
		}

		// Autoload helpers and languages
		foreach (array('helper', 'language') as $type)
		{
			if (isset($this->autoload[$type]) && count($this->autoload[$type]) > 0)
			{
				$this->$type($this->autoload[$type]);
			}
		}

		// Autoload drivers
		if (isset($this->autoload['drivers']))
		{
			$this->driver($this->autoload['drivers']);
		}

		// Load libraries
		if (isset($this->autoload['libraries']) && count($this->autoload['libraries']) > 0)
		{
			// Load the database driver.
			if (in_array('database', $this->autoload['libraries']))
			{
				$this->database();
				$this->autoload['libraries'] = array_diff($this->autoload['libraries'], array('database'));
			}

			// Load all other libraries
			$this->library($this->autoload['libraries']);
		}

		// Autoload models
		if (isset($this->autoload['model']))
		{
			$this->model($this->autoload['model']);
		}
	}

}
