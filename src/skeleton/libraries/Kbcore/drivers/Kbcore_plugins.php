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
 * Kbcore_plugins Class
 *
 * Handles site's plugins behavior.
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

class Kbcore_plugins extends CI_Driver
{
	/**
	 * Holds the path where plugins are located.
	 * @var string
	 */
	private $_plugins_dir;

	/**
	 * Array of all available plugins.
	 * @var array
	 */
	private $_plugins;

	/**
	 * Holds the array of active plugins.
	 * @var array
	 */
	private $_active_plugins;

	/**
	 * Array of plugin's headers to retrieve.
	 * @since 	1.3.4
	 * @var 	array
	 */
	private $_plugin_headers = array(
		'Plugin Name',
		'Plugin URI',
		'Description',
		'Version',
		'License',
		'License URI',
		'Author',
		'Author URI',
		'Author Email',
		'Tags',
		'Language Folder',
		'Language Index',
	);

	/**
	 * Array of plugins default headers.
	 * @since 	1.3.4
	 * @var 	array
	 */
	private $_default_headers = array(
		'name',
		'plugin_uri',
		'description',
		'version',
		'license',
		'license_uri',
		'author',
		'author_uri',
		'author_email',
		'tags',
		'language_folder',
		'language_index',
	);

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		// Always keep the path to plugins directory.
		$this->_plugins_dir = FCPATH.(config_item('plugins_dir') ?: 'content/plugins/');

		log_message('info', 'Kbcore_plugins Class Initialize');
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns a list of available plugins.
	 * @access 	public
	 * @param 	bool 	$details Whether to get details
	 * @return 	array
	 */
	public function get_plugins($details = true)
	{
		// Not cached? Cache them first.
		if ( ! isset($this->_plugins))
		{
			$this->_plugins = array_filter($this->_fetch_plugins_dir($details));
		}

		return $this->_plugins;
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
		$plugins = $this->get_plugins();
		return (isset($plugins[$name])) ? $plugins[$name] : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Reads details about the plugin from the manifest.json file.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added a property for whether to check existence.
	 * 
	 * @access 	public
	 * @param 	string 	$name 	the plugin's name.
	 * @param 	bool 	$check 	Whether to check existence or not.
	 * @return 	array if found, else false.
	 */
	public function get_plugin_info($name, $check = true)
	{
		// Do we need to check exists?
		if (true === $check && false === $this->_is_valid($name))
		{
			return false;
		}

		// We grab plugin's file to read its data.
		$plugin_path = $this->plugins_path($name);
		$plugin_file = $plugin_path.DS.$name.'.php';
		if (true !== is_file($plugin_file))
		{
			return false;
		}

		// Load our custom file helper if not loaded.
		(function_exists('get_file_data')) OR $this->ci->load->helper('file');

		// Second check function existence just in case.
		if ( ! function_exists('get_file_data'))
		{
			return false;
		}

		// Get plugin headers.
		$plugin_headers = get_file_data($plugin_file, $this->_plugin_headers);

		// Not header? Nothing to do.
		if (empty(array_filter($plugin_headers)))
		{
			return false;
		}

		// We now prepare our final output.
		$headers = array_fill_keys($this->_default_headers, false);
		foreach ($plugin_headers as $index => $value)
		{
			$headers[$this->_default_headers[$index]] = $value;
		}

		// We add extra details about the plugin.
		$headers['folder']       = $name;
		$headers['full_path']    = $plugin_path;
		$headers['enabled']      = $this->_is_enabled($name);
		$headers['has_settings'] = has_filter('plugin_settings_'.$name);

		// The language folder not provided? Use default one.
		(empty($headers['language_folder'])) && $headers['language_folder'] = 'language';

		// Set up plugin language index.
		(empty($headers['language_index'])) && $headers['language_index'] = $name;

		/**
		 * We translate plugin's name and description only if it is not activated,
		 * just to avoid loading language files again and again.
		 */
		if (true !== $this->_is_enabled($name))
		{
			// Path to languages files and make sure it's found.
			$lang_path = $this->plugins_path($name.'/'.$headers['language_folder']);
			if (false === $lang_path)
			{
				return $headers;
			}

			// We first load the English translation but check if first.
			$english = $lang_path.DS.'english.php';
			if (true !== is_file($english))
			{
				return $headers;
			}

			// Include the language file and make sure the $lang array is found.
			require_once($english);
			if ( ! isset($lang))
			{
				return $headers;
			}

			// Prepare default description and name if found.
			if (isset($lang['plugin_name']))
			{
				$headers['name'] = $lang['plugin_name'];
			}
			if (isset($lang['plugin_description']))
			{
				$headers['description'] = $lang['plugin_description'];
			}
			unset($lang);

			// Now we see if we are using a different language.
			$current = $this->ci->config->item('language');
			if ('english' !== $current && false !== is_file($lang_path.DS.$current.'.php'))
			{
				require_once($lang_path.DS.$current.'.php');

				// We translate both name and description if found in $lang array.
				if (isset($lang) && isset($lang['plugin_name']))
				{
					$headers['name'] = $lang['plugin_name'];
				}
				if (isset($lang) && isset($lang['plugin_description']))
				{
					$headers['description'] = $lang['plugin_description'];
				}
				unset($lang);
			}

			return $headers;
		}

		// We now return the final output.
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
		$plugins        = $this->get_plugins();
		$active_plugins = $this->get_active_plugins();

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
		$plugins        = $this->get_plugins();
		$active_plugins = $this->get_active_plugins();

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
		$plugins = $this->get_plugins();
		if ( ! isset($plugins[$name]))
		{
			return false;
		}

		// We cannot delete a plugin that does not exist or a plugin that is active.
		if (false === $this->plugins_path($name) 
			OR false !== $this->_is_enabled($name))
		{
			return false;
		}

		// Proceed to plugin deletion after deactivation.
		$this->deactivate($name);
		$this->ci->load->helper('directory');
		directory_delete($this->plugins_path($name));
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Load all plugins in order to do all their actions.
	 * @access 	public
	 * @return 	void
	 */
	public function load_plugins()
	{
		// Get the list of active plugins.
		$plugins = $this->get_active_plugins();

		// Lopp through all plugins.
		foreach ($plugins as $plugin)
		{
			if (false !== $file = $this->plugins_path("{$plugin}/{$plugin}.php"))
			{
				// Include their main file if found.
				include_once($file);
				
				// Get details so we can load their translations.
				$this->_load_plugin_language($plugin);

				// Do the action related to each plugin.
				do_action('plugin_install_'.$plugin);
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
	 * @param 	string 	$name 	The plugin's name (folder).
	 * @return 	void
	 */
	private function _load_plugin_language($name)
	{
		// Retrieve plugin's details.
		$details = $this->get_plugin_info($name);

		// Prepare path to languages fiels.
		$lang_path = $details['full_path'].DS.$details['language_folder'].DS;

		// See if we have the English version and skip if it's not found.
		$english   = $lang_path.'english.php';
		if (true !== is_file($english))
		{
			return;
		}

		// Include plugin english translation first.
		require_once($english);
		$full_lang = (isset($lang)) ? $lang : array();
		unset($lang);

		// Using a different language?
		$current = $this->ci->config->item('language');
		if ('english' !== $current && false !== is_file($lang_path.$current.'.php'))
		{
			require_once($lang_path.$current.'.php');
			if (isset($lang))
			{
				$full_lang = array_replace_recursive($full_lang, $lang);
			}
		}

		// We merge arrays.
		if ( ! empty($full_lang))
		{
			$this->ci->lang->language[$details['language_index']] = $full_lang;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * List all plugins found inside plugins folder.
	 * @access 	public
	 * @param 	bool 	$details 	whether to retrieve details or not.
	 * @return 	array
	 */
	public function _fetch_plugins_dir($details = true)
	{
		// Prepare empty array of plugins.
		$plugins = array();


		// Let's go through folders and check if there are any.
		if ($handle = opendir($this->_plugins_dir))
		{
			$_to_eliminate = array(
				'.',
				'..',
				'index.html',
				'.htaccess',
				'__MACOSX',
			);

			while (false !== ($file = readdir($handle)))
			{
				if ( ! in_array($file, $_to_eliminate))
				{
					$plugins[] = $file;
				}
			}
		}

		// No details needed?
		if ($details === false)
		{
			return $details;
		}

		// If there are folders, we get plug-ins details.
		if ( ! empty($plugins))
		{
			foreach ($plugins as $key => $plugin)
			{
				if ($this->_is_valid($plugin))
				{
					$plugins[$plugin] = $this->get_plugin_info($plugin, false);
				}
				unset($plugins[$key]);
			}
		}

		// Return the result.
		return $plugins;
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
	 * @access 	private
	 * @param 	string 	$name
	 * @return 	boolean
	 */
	private function _is_enabled($name)
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
