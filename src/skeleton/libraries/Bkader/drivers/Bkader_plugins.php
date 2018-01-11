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
	 * Holds the path to plugins.
	 * @var string
	 */
	private $_plugins_path;

	/**
	 * Array of all available plugins.
	 * @var array
	 */
	private $_plugins;

	/**
	 * Array of plugins stored in database.
	 * @var array
	 */
	private $_db_plugins;

	/**
	 * Array of activated plugins.
	 * @var array
	 */
	private $_active_plugins;

	// ------------------------------------------------------------------------

	/**
	 * Method call catcher to always see if plugins system is on or not.
	 * @access 	public
	 * @param 	string 	$method 	The method to call.
	 * @param 	mixed 	$params 	methods arguments
	 * @return 	depends on the method.
	 */
	public function __call($method, $params = array())
	{
		// All our methods have a prepended underscore.
		$_method = '_' . $method;
		
		// We throw a BadMethodCallException if no method exists.
		if ( ! method_exists($this, $_method))
		{
			throw new BadMethodCallException("Call to a private method Bkader_plugins::{$method}()");
		}


		/**
		 * By using the ReflectionMethod class we make sure to
		 * call only public or protected method but never
		 * private one.
		 */
		$reflection = new ReflectionMethod($this, $_method);

		if ($reflection->isPrivate())
		{
			throw new BadMethodCallException("Call to a private method Bkader_plugins::{$method}()");
		}

		// We proceed only if plugins system is enabled.
		if ($this->use_plugins())
		{
			return call_user_func_array(array($this, $_method), $params);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		// Set the path to plugins folder.
		$this->_plugins_path = (function_exists('plugins_path'))
			? plugins_path()
			: realpath(FCPATH.'content/plugins');
		($this->_plugins_path) && $this->_plugins_path .= DIRECTORY_SEPARATOR;

		/**
		 * We proceed only if the plugins folder if found and
		 * the plugins system is enabled.
		 */
		if (false === $this->_plugins_path)
		{
			return;
		}

		// Make sure to load needed resources.
		$this->ci->load->helper(array('url', 'directory', 'file'));

		// List all available plugins.
		$this->_plugins = $this->_get_all_plugins();

		log_message('info', 'Bkader_plugins Class Initialize');
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks if the using plugins is enabled.
	 * @access 	public
	 * @return 	boolean
	 */
	public function use_plugins()
	{
		return ($this->ci->config->item('use_plugins') === true && false !== $this->_plugins_path);
	}

	// ------------------------------------------------------------------------

	/**
	 * Load active plugins.
	 * @access 	protected
	 * @return 	void
	 */
	protected function _load_plugins()
	{
		// Prepare the list or activated plugins.
		$this->_active_plugins = $this->__get_active_plugins();

		// Now we instantiate plugins.
		$this->__initialize_plugins();
	}

	// --------------------------------------------------------------------

	/**
	 * Activate the selected plugin.
	 * @access 	protected
	 * @param 	string 	$name 	the plugin's folder name.
	 * @return 	bool
	 */
	protected function _activate($name)
	{
		// Prepare the name.
		$name = strtolower(rtrim($name, DIRECTORY_SEPARATOR));

		// Prepare process status.
		$status = false;

		// Proceed only if the plugin exists and is not active.
		if (! isset($this->_active_plugins[$name]))
		{
			$plugins = $this->__get_db_plugins();

			// Plugins are store in database?
			if ($plugins)
			{
				// Make sure it's a valid array.
				(is_array($plugins->value)) OR $plugins->value = array();

				// Add the plugin.
				$plugins->value[$name] = array('folder' => $name);
				$status = $this->_parent->options->update('active_plugins', array(
					'value' => $plugins->value,
				));
			}
			// Store the plugins in database.
			else
			{
				// For security, delete it first.
				$this->_parent->options->delete_by('name', 'active_plugins');

				// Then we insert it.
				$this->_parent->options->insert(array(
					'name'  => 'active_plugins',
					'value' => array($name => array('folder' => $name)),
					'tab'   => 'plugins',
				));

				$status = true;
			}

		}

		// If the plugin is enabled, do the action.
		if ($status === true)
		{
			do_action('plugin_activate_'.$name);
		}

		// Return the process status.
		return $status;
	}

	// --------------------------------------------------------------------

	/**
	 * Deactivate the selected plugin.
	 * @access 	protected
	 * @param 	string 	$name 	Plugin name.
	 * @return 	bool
	 */
	protected function _deactivate($name)
	{
		// Prepare the name.
		$name = strtolower(rtrim($name, DIRECTORY_SEPARATOR));

		// Prepare process status.
		$status = false;

		if (isset($this->_active_plugins[$name]))
		{
			// Get all activated plugins and remove the selected one.
			$plugins = $this->__get_db_plugins();
			unset($plugins->value[$name]);

			// Update database.
			$status = $this->_parent->options->set_item('active_plugins', $plugins->value);

			// Unset the item and do action if success.
			if ($status === true)
			{
				unset($this->_active_plugins[$name]);
				do_action('plugin_deactivate_'.$name);
			}
		}

		return $status;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a plugin from plugins directory.
	 * @access 	protected
	 * @param 	string 	$plugin 	Plugin's slug.
	 * @return 	boolean
	 */
	protected function _delete($name)
	{
		// Prepare the name.
		$name = strtolower(rtrim($name, DIRECTORY_SEPARATOR));

		// Make sure the plugin exists.
		if ( ! isset($this->_plugins[$name]))
		{
			return false;
		}

		// Make sure the directory is found.
		$plugin_path = realpath(plugins_path().'/'.$name);
		if (false === $plugin_path)
		{
			return;
		}

		/**
		 * Two steps here: 1. delete all files within the plugin's folder,
		 * then 2. delete the folder.
		 */
		array_map('unlink', glob($plugin_path.'/*.*'));
		rmdir($plugin_path);
		return $this->_deactivate($name);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns all available plugins at the plugins directory.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _get_all_plugins()
	{
		// Get all plugins if not already set.
		$plugins = (isset($this->_plugins)) ? $this->_plugins : $this->__get_all_plugins();

		// Get all active plugins.
		$active_plugins = (isset($this->_active_plugins))
			? $this->_active_plugins
			: $this->__get_active_plugins();

		// Mark active plugins as enabled.
		if ( ! empty($plugins))
		{
			foreach ($plugins as $slug => &$plugin)
			{
				$plugin['enabled'] = (isset($active_plugins[$slug]));
			}
		}

		return $plugins;
	}

	// ------------------------------------------------------------------------

	/**
	 * List all available plugins in plugins directory.
	 * @access 	private
	 * @return 	array
	 */
	private function __get_all_plugins()
	{
		// Already cached? Return them.
		if (isset($this->_plugins))
		{
			return $this->_plugins;
		}

		// Prepare empty array of plugins.
		$plugins = array();

		// Let's go through folders and check if there are any.
		if ($handle = opendir($this->_plugins_path))
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

		// If there are folders, we get plug-ins details.
		if ( ! empty($plugins))
		{
			foreach ($plugins as $key => $plugin)
			{
				// A valid plugin comes with 'manifest.json' file.
				if (false !== realpath($this->_plugins_path.$plugin.DS.'manifest.json'))
				{
					// The manifest.json must contain a valid array.
					$details = $this->__get_plugin_details($plugin, false);

					// Cache plugins to avoid repeating.
					if ($details !== null)
					{
						$this->_plugins[$plugin] = $details;
					}
				}
				unset($plugins[$key]);
			}
		}

		// Return the result.
		return $this->_plugins;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieve a single plugins details from manifest.json
	 * @access 	private
	 * @param 	string 	$name 	plugin's name.
	 * @param 	bool 	$check 	whether to validate the manifest.
	 * @return 	array if valid, else false.
	 */
	private function __get_plugin_details($name, $check = true)
	{
		$manifest = file_get_contents($this->_plugins_path.$name.'/manifest.json');
		$manifest = json_decode($manifest, true);
		if ( ! is_array($manifest))
		{
			if ($check === true)
			{
				show_error("The 'manifest.json' file of '{$name}' plugin does not contain a valid array.");
			}

			return $manifest;
		}

		// Always add the folder.
		$manifest['folder'] = $name;

		// Prepare default details.
		$defaults = array(
			'name'         => null,
			'folder'       => null,
			'plugin_uri'    => null,
			'description'  => 'This plugin has no description',
			'version'      => null,
			'license'      => 'MIT',
			'license_uri'  => 'https://opensource.org/licenses/MIT',
			'author'       => 'Kader Bouyakoub',
			'author_uri'   => 'https://github.com/bkader',
			'author_email' => 'bkader@mail.com',
			'tags'         => null,
		);

		return array_replace($defaults, $manifest);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the list of activated plugins.
	 * @access 	private
	 * @return 	array if found, else null.
	 */
	private function __get_active_plugins()
	{
		// Start an empty array.
		$this->_active_plugins = array();

		// Get plugins from database.
		$plugins = $this->__get_db_plugins();

		// Found?
		if ($plugins && count($plugins) > 0)
		{
			foreach ($plugins as $plugin)
			{
				$details = $this->__get_plugin_details($plugin['folder']);

				// Cache the plugin.
				$this->_active_plugins[$plugin['folder']] = $details;
			}
		}

		return $this->_active_plugins;
	}

	// --------------------------------------------------------------------

	/**
	 * Get active plugins from database.
	 * @access 	private
	 * @return 	array if found, else null.
	 */
	protected function ___get_db_plugins()
	{
		// Already cached? Return them.
		if (isset($this->_db_plugins))
		{
			return $this->_db_plugins;
		}

		// Cache them to reduce BD access.
		$db_plugins = $this->_parent->options->item('active_plugins');
		$this->_db_plugins = ($db_plugins) ? $db_plugins : array();
		return $this->_db_plugins;
	}

	// --------------------------------------------------------------------

	/**
	 * Instantiate plugins actions.
	 * @access 	private
	 * @return 	void
	 */
	private function __initialize_plugins()
	{
		if (isset($this->_active_plugins))
		{
			// For comparison reason.
			$db_plugins = $this->__get_db_plugins();

			foreach ($this->_active_plugins as $folder => $details)
			{
				// Update plugin details only if incomplete.
				if ($db_plugins[$folder] <> $details)
				{
					$db_plugins[$folder] = $details;
					$this->_parent->options->set_item('active_plugins', $db_plugins);
				}
				// Include the plugin file.
				include_once $this->_plugins_path.$folder.'/'.$folder.'.php';

				// Do the install action.
				do_action('plugin_install_'.$folder);
			}
		}
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('plugins_path'))
{
	/**
	 * Return the real path to plugins folder.
	 * @return 	string if found, else false.
	 */
	function plugins_path()
	{
		return realpath(FCPATH.'content/plugins/');
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
		return base_url('content/plugins/'.$uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('activate_plugin'))
{
	/**
	 * Activate the selected plugin.
	 * @access 	protected
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
	 * @access 	protected
	 * @param 	string 	$name 	the plugin's folder name.
	 * @return 	bool
	 */
	function deactivate_plugin($plugin)
	{
		return get_instance()->app->plugins->deactivate($plugin);
	}
}
