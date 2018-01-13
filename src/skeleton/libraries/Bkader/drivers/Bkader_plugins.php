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
 * Bkader_plugins Class
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

class Bkader_plugins extends CI_Driver
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

		log_message('info', 'Bkader_plugins Class Initialize');
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
			$this->_plugins = $this->_fetch_plugins_dir($details);
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
	 * @access 	public
	 * @param 	string 	$name 	the plugin's name.
	 * @return 	array if found, else false.
	 */
	public function get_plugin_info($name)
	{
		// The plugin's folder name is required.
		if (empty($name))
		{
			return false;
		}

		// Make sure the manifest exists.
		$manifest = $this->plugins_path($name.'/manifest.json');
		if ( ! $manifest)
		{
			return false;
		}

		//
		$manifest = json_decode(file_get_contents($manifest), true);
		if (empty($manifest) OR ! is_array($manifest))
		{
			return false;
		}

		// Adding the folder.
		$manifest['folder'] = $name;

		// Is it enabled?
		$manifest['enabled'] = $this->_is_enabled($name);

		// Does it have a settings page?
		$manifest['has_settings'] = has_filter('plugin_settings_'.$name);

		// Complete missing data.
		$defaults = array(
			'name'         => null,
			'folder'       => null,
			'plugin_uri'   => null,
			'description'  => 'This plugin has no description',
			'version'      => null,
			'license'      => 'MIT',
			'license_uri'  => 'https://opensource.org/licenses/MIT',
			'author'       => 'Kader Bouyakoub',
			'author_uri'   => 'https://github.com/bkader',
			'author_email' => 'bkader@mail.com',
			'tags'         => null,
			'enabled'      => false,
			'has_settings' => false,
		);

		return array_replace($defaults, $manifest);
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

		if (isset($plugins[$name]) && ! in_array($active_plugins))
		{
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
			unset($active_plugins[$key]);
			return $this->_set_plugins($active_plugins);
		}


		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete the selected plugin.
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

		// Make sure the directory is found.
		if (false === $this->plugins_path($name))
		{
			return false;
		}

		/**
		 * Two steps here: 
		 * 1. delete all files within the plugin's folder.
		 * 2. delete the folder.
		 */
		$this->deactivate($name);
		array_map('unlink', glob($this->plugins_path($name).'/*.*'));
		rmdir($this->plugins_path($name));
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
			// Include their main file.
			include_once($this->plugins_path("{$plugin}/{$plugin}.php"));

			// Do the action related to each plugin.
			do_action('plugin_install_'.$plugin);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * List all plugins found inside plugins folder.
	 * @access 	private
	 * @param 	bool 	$details 	whether to retrieve details or not.
	 * @return 	array
	 */
	private function _fetch_plugins_dir($details = true)
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
				'.htaccess'
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
					$plugins[$plugin] = $this->get_plugin_info($plugin);
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
		$found = $this->_parent->options->get_by('name', 'active_plugins');

		// If found and updated, return TRUE.
		if ($found && $this->_parent->options->set_item('active_plugins', $plugins))
		{
			return true;
		}

		// Create it because it was not found.
		$this->_parent->options->insert(array(
			'name'  => 'active_plugins',
			'value' => $plugins,
			'tab'   => 'plugins',
		));
		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns TRUE if the selected plugin is valid.
	 * @access 	private
	 * @param 	string 	$name
	 * @return 	boolean
	 */
	private function _is_valid($name)
	{
		return ($name 
			&& false !== $this->plugins_path("{$name}/{$name}.php")
			&& false !== $this->plugins_path("{$name}/manifest.json"));
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
		return get_instance()->app->plugins->plugins_path($uri);
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
		return get_instance()->app->plugins->plugins_url($uri);
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
		return get_instance()->app->plugins->activate($plugin);
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
		return get_instance()->app->plugins->deactivate($plugin);
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
		return get_instance()->app->plugins->delete($plugin);
	}
}
