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
 * Kbcore_plugins Class
 *
 * Handles site's plugins behavior.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.2
 */

class Kbcore_plugins extends CI_Driver
{
	/**
	 * Holds the path where plugins are located.
	 * @var string
	 */
	protected $_plugins_dir;

	/**
	 * Array of all available plugins.
	 * @var array
	 */
	protected $_plugins;

	/**
	 * Array of all plugins and their details.
	 * @since 	2.0.0
	 * @var 	array
	 */
	protected $_plugins_details = array();

	/**
	 * Holds the array of active plugins.
	 * @var array
	 */
	private $_active_plugins;

	/**
	 * Array of plugins default headers.
	 * @since 	1.3.4
	 * @since 	2.0.0 	Fall-back to manifest.json for better performance.
	 * @var 	array
	 */
	private $_headers = array(
		'name'            => null,
		'plugin_uri'      => null,
		'description'     => null,
		'version'         => null,
		'license'         => null,
		'license_uri'     => null,
		'author'          => null,
		'author_uri'      => null,
		'author_email'    => null,
		'donation_uri'    => null,
		'tags'            => null,
		'language_folder' => null,
		'language_index'  => null,
		'translations'    => array(),
	);

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Kbcore_plugins Class Initialize');

		// Register the action after controller constructor.
		add_action('post_controller_constructor', array($this, '_load_plugins'));
	}

	// ------------------------------------------------------------------------

	/**
	 * plugins_dir
	 *
	 * Method for returning the full path to modules directory.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$uri 	String to append to uri.
	 * @return 	string
	 */
	public function plugins_dir($uri = '')
	{
		if ( ! isset($this->_plugins_dir))
		{
			$plugins_dir = $this->ci->config->item('plugins_dir');
			$plugins_dir OR $plugins_dir = 'content/plugins/';
			$this->_plugins_dir = rtrim(str_replace('\\', '/', FCPATH.$plugins_dir), '/').'/';
		}

		// Provided a $uri? Format it first.
		empty($uri) OR $uri = ltrim(str_replace('\\', '/', $uri), '/');

		return $this->_plugins_dir.$uri;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns a list of available plugins.
	 * @access 	public
	 * @param 	bool 	$details Whether to get details
	 * @return 	array
	 */
	public function list_plugins($details = true)
	{
		// Not cached? Cache them first.
		if ( ! isset($this->_plugins))
		{
			$this->_plugins = array();

			$plugins_dir = $this->plugins_dir();

			if (false !== ($handle = opendir($plugins_dir)))
			{
				// Files and directories to ignore.
				$_to_eliminate = array(
					'.',
					'..',
					'.gitkeep',
					'index.html',
					'.htaccess',
					'__MACOSX',
				);

				while (false !== ($file = readdir($handle)))
				{
					if ( ! in_array($file, $_to_eliminate) // Ignore some files.
						&& is_dir($plugins_dir.$file) // Valid directory.
						&& is_file($plugins_dir.$file.'/'.$file.'.php') // Plugin main file
						&& is_file($plugins_dir.$file.'/manifest.json')) // manifest.json file.
					{
						$this->_plugins[$file] = rtrim(str_replace('\\', '/', $plugins_dir.$file), '/').'/';
					}
				}
			}
		}

		// Alphabetically order plugins.
		ksort($this->_plugins);

		$return = $this->_plugins;

		if (true === $details)
		{
			$_plugins_details = array();

			foreach ($this->_plugins as $folder => $path)
			{
				if (isset($this->_plugins_details[$folder]))
				{
					$_plugins_details[$folder] = $this->_plugins_details[$folder];
				}
				elseif (false !== ($details = $this->plugin_details($folder, $path)))
				{
					$_plugins_details[$folder] = $details;
				}
			}

			empty($_plugins_details) OR $return = $_plugins_details;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get the list of active plugins.
	 * @access 	public
	 * @return 	array
	 */
	public function get_active_plugins()
	{
		// Not cached? Cache them first.
		if ( ! isset($this->_active_plugins))
		{
			$this->_active_plugins = $this->_parent->options->item('active_plugins', array());
		}

		return $this->_active_plugins;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns details about the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	The plugin's name.
	 * @return 	array if found, else false.
	 */
	public function get_plugin($name)
	{
		$plugins = $this->list_plugins();
		return (isset($plugins[$name])) ? $plugins[$name] : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Reads details about the plugin from the manifest.json file.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added a property for whether to check existence.
	 * @since 	2.0.0 	Fall-back to "manifest.json" for better performance.
	 * 
	 * @access 	public
	 * @param 	string 	$folder 	the plugin's name.
	 * @param 	string 	$path 	Path to plugin's folder.
	 * @return 	array if found, else false.
	 */
	public function plugin_details($folder, $path = null)
	{
		if (empty($folder))
		{
			return false;
		}

		// Prepare path to plugin first.
		if (null === $path && isset($this->_plugins[$folder]))
		{
			$path = $this->_plugins[$folder];
		}
		elseif (null === $path && is_dir($dir = $this->plugins_dir($folder.'/')))
		{
			$path = $dir;
			unset($dir);
		}

		$plugin_path = $path;
		$manifest_file = $plugin_path.'manifest.json';

		// Second check.
		if (null === $plugin_path OR ! is_file($manifest_file))
		{
			return false;
		}

		$content = file_get_contents($manifest_file);
		$headers = json_decode($content, true);

		// Make sure a good array is provided.
		if ( ! is_array($headers))
		{
			return false;
		}

		/**
		 * Allow users to filter default plugins headers.
		 * @since 	2.1.2
		 */
		$default_headers = apply_filters('plugins_headers', $this->_headers);
		empty($default_headers) && $default_headers = $this->_headers;

		$headers = array_replace_recursive($default_headers, $headers);

		// Remove not listed headers.
		foreach ($headers as $key => $val)
		{
			if ( ! array_key_exists($key, $default_headers))
			{
				unset($headers[$key]);
			}
		}

		// Format license.
		if (false !== stripos($headers['license'], 'mit') && empty($heades['license_uri']))
		{
			$headers['license_uri'] = 'http://opensource.org/licenses/MIT';
		}

		// Add some useful stuff.
		$headers['enabled']      = $this->is_enabled($folder);
		$headers['has_settings'] = has_filter('plugin_settings_'.$folder);
		$headers['folder']       = $folder;
		$headers['full_path']    = $plugin_path;

		// Send default language folder and index.
		empty($headers['language_folder']) && $headers['language_folder'] = 'language';
		empty($headers['language_index']) && $headers['language_index'] = $folder;

		// Cache everything before returning.
		$this->_plugins_details[$folder] = $headers;
		return $headers;
	}

	// ------------------------------------------------------------------------

	/**
	 * Activate the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	boolean
	 */
	public function activate($name)
	{
		$plugins        = $this->list_plugins();
		$active_plugins = $this->get_active_plugins();

		if (is_array($name))
		{
			foreach ($name as $i => $p)
			{
				if ( ! isset($plugins[$p]) OR in_array($p, $active_plugins))
				{
					continue;
				}

				do_action('plugin_activate_'.$p);
				$active_plugins[] = $p;
			}

			return $this->_set_plugins($active_plugins);
		}

		if (isset($plugins[$name]) && ! in_array($name, $active_plugins))
		{
			do_action('plugin_activate_'.$name);
			$active_plugins[] = $name;
			return $this->_set_plugins($active_plugins);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Deactivate the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	boolean
	 */
	public function deactivate($name)
	{
		$plugins        = $this->list_plugins();
		$active_plugins = $this->get_active_plugins();

		if (is_array($name))
		{
			foreach ($name as $i => $p)
			{
				if ( ! isset($plugins[$p]) 
					OR ! in_array($p, $active_plugins) 
					OR false === ($key = array_search($p, $active_plugins)))
				{
					continue;
				}

				do_action('plugin_deactivate_'.$p);
				unset($active_plugins[$key]);
			}

			return $this->_set_plugins($active_plugins);
		}

		if (isset($plugins[$name]) 
			&& in_array($name, $active_plugins)
			 && false !== ($key = array_search($name, $active_plugins)))
		{
			do_action('plugin_deactivate_'.$name);
			unset($active_plugins[$key]);
			return $this->_set_plugins($active_plugins);
		}


		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete the selected plugin.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	A little check to delete only deactivated plugins.
	 * 
	 * @access 	public
	 * @param 	string 	$name 	The plugin's folder name.
	 * @return 	boolean
	 */
	public function delete($name)
	{
		// Make sure the plugins exists.
		$plugins = $this->list_plugins(false);
		$active_plugins = $this->get_active_plugins();

		if (is_array($name))
		{
			foreach ($name as $i => $p)
			{
				if (true !== $this->delete($p))
				{
					return false;
				}
			}

			return true;
		}
		
		if ( ! isset($plugins[$name]) OR in_array($name, $active_plugins))
		{
			return false;
		}

		// Proceed to plugin deletion after deactivation.
		$this->deactivate($name);

		if (false !== is_dir($plugins[$name]))
		{
			function_exists('directory_delete') OR $this->ci->load->helper('directory');
			directory_delete($plugins[$name]);
		}
		
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Load all plugins in order to do all their actions.
	 * @access 	public
	 * @return 	void
	 */
	public function _load_plugins()
	{
		// Get the list of active plugins.
		$plugins = $this->get_active_plugins();

		// Lopp through all plugins.
		if ( ! empty($plugins))
		{
			foreach ($plugins as $folder)
			{
				if (false !== ($file = $this->plugins_dir("{$folder}/{$folder}.php")))
				{
					// Include their main file if found.
					require_once($file);
					
					// Get details so we can load their translations.
					$this->_load_plugin_language($folder);

					// Do the action related to each plugin.
					do_action('plugin_install_'.$folder);
				}
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for loading translation for the selected plugin.
	 *
	 * @since 	1.3.4
	 * 
	 * @access 	private
	 * @param 	string 	$folder 	The plugin's name (folder).
	 * @return 	void
	 */
	private function _load_plugin_language($folder)
	{
		if ( ! isset($this->_plugins_details[$folder]))
		{
			$this->_plugins_details[$folder] = $this->plugin_details($folder);
		}

		// Get details make sure they are valid.
		if (false === ($details = $this->_plugins_details[$folder]))
		{
			return;
		}

		// Make sure the language folder exists.
		$lang_path = rtrim(str_replace('\\', '/', $details['full_path'].$details['language_folder']), '/').'/';
		if (true !== is_dir($lang_path))
		{
			return;
		}

		/**
		 * "English" is required as the first language. It will be used as a
		 * fall-back language if other languages cannot be found;
		 */
		if (false === is_file($english = $lang_path.'english.php'))
		{
			return;
		}

		// Include plugin "English" translation first.
		require_once($english);
		$lines = (isset($lang)) ? $lang : array();
		unset($lang);

		// Using a different language? Make sure it's found.
		$language = $this->ci->lang->lang('folder');
		if ('english' !== $language 
			&& false !== is_file($lang_path.$language.'.php'))
		{
			// Load the file and merge things if found.
			require_once($lang_path.$language.'.php');
			isset($lang) && $lines = array_replace_recursive($lines, $lang);
		}

		// We add plugin's language lines.
		if ( ! empty($lines))
		{
			$index = isset($details['language_index']) ? $details['language_index'] : $folder;
			$this->ci->lang->language[$index] = $lines;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the real path to plugins directory.
	 * @access 	public
	 * @param 	string 	$uri 	The URI to append.
	 * @return 	string if a real path, else false.
	 */
	public function plugins_path($uri = '')
	{
		return realpath($this->_plugins_dir.'/'.$uri);
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the URL to plugins folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @return 	string
	 */
	public function plugins_url($uri = '')
	{
		$path = config_item('plugins_dir') ?: 'content/plugins';
		return base_url("{$path}/{$uri}");
	}

	// ------------------------------------------------------------------------

	/**
	 * Updates or create active plugins options item.
	 * @access 	private
	 * @param 	array 	$plugins
	 * @return 	bool
	 */
	private function _set_plugins($plugins = array())
	{
		if ( ! empty($plugins))
		{
			asort($plugins);
			$plugins = array_values($plugins);
		}

		// Check if the option exists first.
		$found = $this->_parent->options->get('active_plugins');

		// If found and updated, return TRUE.
		if ($found && $this->_parent->options->set_item('active_plugins', $plugins))
		{
			return true;
		}

		// Create it because it was not found.
		$this->_parent->options->create(
			'active_plugins',
			$plugins,
			'plugins'
		);
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns TRUE if the selected plugin is valid.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	We no longer need to check for manifest.json file.
	 * 
	 * @access 	private
	 * @param 	string 	$name
	 * @return 	boolean
	 */
	private function _is_valid($name)
	{
		return ($name  && false !== $this->plugins_path("{$name}/{$name}.php"));
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns TRUE if the selected plugin is enabled.
	 * @access 	public
	 * @param 	string 	$name
	 * @return 	boolean
	 */
	public function is_enabled($name)
	{
		return (in_array($name, $this->get_active_plugins(false)));
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('plugins_path'))
{
	/**
	 * Return the real path to plugins folder.
	 * @return 	string if found, else false.
	 */
	function plugins_path($uri = '')
	{
		return get_instance()->kbcore->plugins->plugins_path($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('plugins_url'))
{
	/**
	 * Return the URL to plugins directory.
	 * @param 	string 	$uri
	 * @return 	string.
	 */
	function plugins_url($uri = '')
	{
		return get_instance()->kbcore->plugins->plugins_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('activate_plugin'))
{
	/**
	 * Activate the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	the plugin's folder name.
	 * @return 	bool
	 */
	function activate_plugin($plugin)
	{
		return get_instance()->kbcore->plugins->activate($plugin);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deactivate_plugin'))
{
	/**
	 * Deactivate the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	the plugin's folder name.
	 * @return 	bool
	 */
	function deactivate_plugin($plugin)
	{
		return get_instance()->kbcore->plugins->deactivate($plugin);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_plugin'))
{
	/**
	 * Delete the selected plugin.
	 * @access 	public
	 * @param 	string 	$name 	the plugin's folder name.
	 * @return 	bool
	 */
	function delete_plugin($plugin)
	{
		return get_instance()->kbcore->plugins->delete($plugin);
	}
}
