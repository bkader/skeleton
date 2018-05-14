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
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main AJAX controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Ajax extends AJAX_Controller {

	/**
	 * Array of available contexts.
	 * @var array
	 */
	private $_targets = array(
		'languages',
		'modules',
		'plugins',
		'reports',
		'themes',
		'users',
	);

	/**
	 * __constructr
	 *
	 * Added safe methods.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	AJAX_Controller::response()
	 */
	public function __construct()
	{
		parent::__construct();

		// Add safe reports.
		$this->safe_admin_methods[] = '_languages';
		$this->safe_admin_methods[] = '_modules';
		$this->safe_admin_methods[] = '_plugins';
		$this->safe_admin_methods[] = '_reports';
		$this->safe_admin_methods[] = '_themes';
		$this->safe_admin_methods[] = '_users';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * This method handles all operation done on the reserved sections of the
	 * dashboard.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$target 	The target to perform action on.
	 * @param 	string 	$action 	The action to perform on the target.
	 * @param 	mixed 	$id 		The target name/id.
	 * @return 	AJAX_Controller:response()
	 */
	public function index($target, $action = null, $id = 0)
	{
		// We proceed only if both target and method are available.
		if ((empty($target) OR ! in_array($target, $this->_targets)) 
			OR ! method_exists($this, '_'.$target))
		{
			return;
		}

		return call_user_func_array(array($this, '_'.$target), array($action, $id));
	}

	// ------------------------------------------------------------------------

	/**
	 * _languages
	 *
	 * Method for interacting with languages.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The plugin's folder name;
	 * @return 	AJAX_Controller::response()
	 */
	public function _languages($action = null, $name = null)
	{
		$this->load->language('csk_languages');
		$actions = array('enable', 'disable', 'make_default');

		/**
		 * Here are conditions in order to proceed:
		 * 1. The action is provided and available.
		 * 2. The language name is provided and available.
		 * 3. The action passes nonce check.
		 */
		if ((null === $action OR ! in_array($action, $actions))
			OR (null === $name OR ! array_key_exists($name, $this->lang->languages()))
			OR true !== $this->check_nonce())
		{
			$this->response->header = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		// Make sure to lower the name.
		ctype_lower($name) OR $name = strtolower($name);

		// We cannot touch "English" language.
		if ('english' === $name && 'make_default' !== $action)
		{
			$this->response->header = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED');
			return;
		}

		// Get database languages for later use.
		$languages = $this->config->item('languages');
		$languages OR $languages = array();

		switch ($action)
		{
			// Enabling a language.
			case 'enable':

				// Already enabled? Nothing to do..
				if (in_array($name, $languages))
				{
					$this->response->header = self::HTTP_NOT_MODIFIED;
					$this->response->message = line('CSK_LANGUAGES_ALREADY_ENABLE');
					return;
				}

				// Add language to languages array.
				$languages[] = $name;
				asort($languages);
				$languages = array_values($languages);

				// Successfully updated?
				if (false !== $this->kbcore->options->set_item('languages', $languages))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_LANGUAGES_SUCCESS_ENABLE');
					return;
				}
				
				$this->response->message = line('CSK_LANGUAGES_ERROR_ENABLE');

				break;

			// Disabling a language.
			case 'disable':

				// Already disabled? Nothing to do..
				if ( ! in_array($name, $languages))
				{
					$this->response->header = self::HTTP_NOT_MODIFIED;
					$this->response->message = line('CSK_LANGUAGES_ALREADY_DISABLE');
					return;
				}

				// Remove language from languages array.
				$languages[] = $name;
				foreach ($languages as $i => $lang)
				{
					if ($lang === $name)
					{
						unset($languages[$i]);
					}
				}
				asort($languages);
				$languages = array_values($languages);

				// Successfully updated?
				if (false !== $this->kbcore->options->set_item('languages', $languages))
				{
					/**
					 * If the language is the site's default language, we make
					 * sure to set English as the default one.
					 */
					if ($name === $this->kbcore->options->item('language'))
					{
						$this->kbcore->options->set_item('language', 'english');
					}

					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_LANGUAGES_SUCCESS_DISABLE');
					return;
				}
				
				$this->response->message = line('CSK_LANGUAGES_ERROR_DISABLE');

				break;
			
			// Making language default.
			case 'make_default':

				// If the language is not enabled, we make sure to enable it first.
				if ( ! in_array($name, $languages))
				{
					$languages[] = $name;
					asort($languages);
					if (false === $this->kbcore->options->set_item('languages', $languages))
					{
						$this->response->header = self::HTTP_CONFLICT;
						$this->response->message = line('CSK_LANGUAGES_ERROR_DEFAULT');
						return;
					}
				}

				// Successfully changed?
				if (false !== $this->kbcore->options->set_item('language', $name))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_LANGUAGES_SUCCESS_DEFAULT');
					return;
				}

				$this->response->message = line('CSK_LANGUAGES_ERROR_DEFAULT');

				break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _modules
	 *
	 * Method for interacting with modules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The module's folder name;
	 * @return 	AJAX_Controller::response()
	 */
	public function _modules($action = null, $name = null)
	{
		// Load modules language file.
		$this->load->language('csk_modules');

		// Array of available actions.
		$actions = array('activate', 'deactivate', 'delete');

		if ((null === $action OR ! in_array($action, $actions))
			OR (null === $name OR ! is_string($name))
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		// Grab details for later use and to make sure the module exists.
		$details = $this->router->module_details($name);
		if (false === $details)
		{
			$this->response->header  = self::HTTP_NOT_FOUND;
			$this->response->message = line('CSK_MODULES_ERROR_MODULE_MISSING');
			return;
		}

		// Load file helper for other actions.
		if ('delete' !== $action)
		{
			function_exists('write_file') OR $this->load->helper('file');
			
			if ('deactivate' === $action)
			{
				unset($details['contexts']);
			}
		}
		// Load directory helper for delete action.
		elseif ( ! function_exists('directory_delete'))
		{
			$this->load->helper('directory');
		}

		$module = $details['name'];
		if ('english' !== ($lang = $this->config->item('language')))
		{
			if (isset($details['translations'][$lang]['name']))
			{
				$module = $details['translations'][$lang]['name'];
			}
		}

		switch ($action) {
			
			// In case of activating a module.
			case 'activate':
				// Already enabled? Nothing to do...
				if (true === $details['enabled'])
				{
					$this->response->header = self::HTTP_CONFLICT;
					$this->response->message = sprintf(line('CSK_MODULES_ERROR_ACTIVATE'), $module);
					return;
				}

				// Successfully enabled?
				$details['enabled'] = true;
				$manifest = $details['full_path'].'manifest.json';
				if (true === write_file($manifest, json_encode($details, JSON_PRETTY_PRINT)))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_MODULES_SUCCESS_ACTIVATE'), $module);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_MODULES_ERROR_ACTIVATE'), $module);
				break;
			
			// In case of deactivating a module.
			case 'deactivate':
				// Already enabled? Nothing to do...
				if (true !== $details['enabled'])
				{
					$this->response->header = self::HTTP_CONFLICT;
					$this->response->message = sprintf(line('CSK_MODULES_ERROR_DEACTIVATE'), $module);
					return;
				}

				// Process status and some needed variables.
				$status   = false;
				$manifest = $details['full_path'].'manifest.json';
				$backup   = $manifest.'.bak';

				// See if the back up file is found.
				if (is_file($backup))
				{
					is_file($manifest) && unlink($manifest);
					$status = (false !== copy($backup, $manifest));
				}

				if (true !== $status)
				{
					$status = (false !== write_file($manifest, json_encode($details, JSON_PRETTY_PRINT)));
				}

				if (false !== $status)
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_MODULES_SUCCESS_DEACTIVATE'), $module);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_MODULES_ERROR_DEACTIVATE'), $module);
				break;

			// In case of deleting a module.
			case 'delete':
				
				// Enabled? We cannot delete it.
				if (false !== $details['enabled'])
				{
					$this->response->header = self::HTTP_NOT_ACCEPTABLE;
					$this->response->message = sprintf(line('CSK_MODULES_ERROR_DELETE_ACTIVE'), $module);
					return;
				}

				// Passed?
				if (false !== directory_delete($details['full_path']))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_MODULES_SUCCESS_DELETE'), $module);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_MODULES_ERROR_DELETE'), $module);
				break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _plugins
	 *
	 * Method for interacting with plugins.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The plugin's folder name;
	 * @return 	AJAX_Controller::response()
	 */
	public function _plugins($action = null, $name = null)
	{
		// Load plugins language file.
		$this->load->language('csk_plugins');

		// Array of available actions.
		$actions = array('activate', 'deactivate', 'delete');

		if ((null === $action OR ! in_array($action, $actions))
			OR (null === $name OR ! is_string($name))
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		$details = $this->kbcore->plugins->plugin_details($name);
		$plugin = $details['name'];
		if ('english' !== ($lang = $this->config->item('language')))
		{
			if (isset($details['translations'][$lang]['name']))
			{
				$plugin = $details['translations'][$lang]['name'];
			}
		}


		switch ($action) {
			
			// In case of activating a plugin.
			case 'activate':

				// Successfully activated?
				if (false !== $this->kbcore->plugins->activate($name))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_PLUGINS_SUCCESS_ACTIVATE'), $plugin);
					return;
				}

				// An error occurred somewhere?
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_PLUGINS_ERROR_ACTIVATE'), $plugin);
				return;

				break;
			
			// In case of deactivating a plugin.
			case 'deactivate':
				// Successfully deactivated?
				if (false !== $this->kbcore->plugins->deactivate($name))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_PLUGINS_SUCCESS_DEACTIVATE'), $plugin);
					return;
				}

				// An error occurred somewhere?
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_PLUGINS_ERROR_DEACTIVATE'), $plugin);
				return;
				break;

			// In case of deleting a plugin.
			case 'delete':

				// Successfully deleted?
				if (false !== $this->kbcore->plugins->delete($name))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(line('CSK_PLUGINS_SUCCESS_DELETE'), $plugin);
					return;
				}

				// An error occurred somewhere?
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = sprintf(line('CSK_PLUGINS_ERROR_DELETE'), $plugin);
				return;

				break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _reports
	 *
	 * Method for interacting with reports.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	int  	$id 		The report ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function _reports($action = null, $id = 0)
	{
		// We make sure to load Reports language file.
		$this->load->language('csk_reports');

		// Array of available reports action.
		$actions = array('delete');

		/**
		 * In order to proceed, the following conditions are required:
		 * 1. The action is provided and is available.
		 * 2. The is is provided and is numeric.
		 * 3. The action passes nonce check.
		 */
		if ((null === $action OR ! in_array($action, $actions)) 
			OR ( ! is_numeric($id) OR $id < 0)
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		switch ($action) {
			
			// Delete report.
			case 'delete':
				
				// Successfully deleted?
				if (false !== $this->kbcore->activities->delete($id))
				{
					$this->response->header  = self::HTTP_OK;
					$this->response->message = line('CSK_REPORTS_SUCCESS_DELETE');
					return;
				}

				// Otherwise, the activity could not be deleted.
				$this->response->message = line('CSK_REPORTS_ERROR_DELETE');
				return;

				break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _themes
	 *
	 * Method for interacting with themes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The theme's folder name.
	 * @return 	AJAX_Controller::response()
	 */
	public function _themes($action = null, $name = null)
	{
		$this->load->language('csk_admin');
		$this->load->language('csk_themes');

		// Prepare stored themes and current theme for later use.
		$db_themes = $this->kbcore->options->get('themes');
		$db_theme  = $this->kbcore->options->get('theme');

		// Array of available actions and process status.
		$actions = array('activate', 'delete', 'details');

		/**
		 * Here are conditions in order to proceed:
		 * 1. The action is provided and available.
		 * 2. The name is provided and the theme exists.
		 * 3. The action passes nonce check.
		 */
		if ((empty($action) OR ! in_array($action, $actions))
			OR (empty($name) OR ! isset($db_themes->value[$name]))
			OR true !== $this->check_nonce())
		{
			$this->response->header = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		// Activate action.
		if ('activate' === $action)
		{
			$theme = $db_themes->value[$name];

			// Successfully updated?
			if (false !== $db_theme->update('value', $name))
			{
				// Delete other themes stored options.
				foreach (array_keys($db_themes->value) as $_name)
				{
					if ($name !== $_name)
					{
						delete_option('theme_images_'.$_name);
						delete_option('theme_menus_'.$_name);
					}
				}

				$this->response->header = self::HTTP_OK;
				$this->response->message = line('CSK_THEMES_SUCCESS_ACTIVATE');
				return;
			}

			// Otherwise, the theme could not be activated.
			$this->response->header = self::HTTP_NOT_MODIFIED;
			$this->response->message = line('CSK_THEMES_ERROR_ACTIVATE');
			return;
		}

		// Delete action.
		if ('delete' === $action)
		{
			// We cannot delete the current theme.
			if ($name === $db_theme->value)
			{
				$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
				$this->response->message = line('CSK_THEMES_ERROR_DELETE_ACTIVE');
				return;
			}

			$themes = $db_themes->value;
			$theme = $themes[$name];
			unset($themes[$name]);

			function_exists('directory_delete') OR $this->load->helper('directory');

			if (false !== directory_delete($this->theme->themes_path($name)) 
				&& false !== $db_themes->update('value', $themes))
			{
				delete_option('theme_images_'.$name);
				delete_option('theme_menus_'.$name);

				$this->response->header = self::HTTP_OK;
				$this->response->message = line('CSK_THEMES_SUCCESS_DELETE');
				return;
			}

			// Otherwise, the theme could not be delete.
			$this->response->header = self::HTTP_NOT_MODIFIED;
			$this->response->message = line('CSK_THEMES_ERROR_DELETE');
			return;
		}

		// Theme details.
		if ('details' === $action)
		{
			// Prepare the theme and add some details.
			$theme = $db_themes->value[$name];

			// Is the theme enabled?
			$theme['enabled'] = ($name === get_option('theme', 'default'));
			$theme['status'] = null;
			if (true === $theme['enabled']) {
				$theme['status'] = html_tag('span', array(
					'class' => 'badge badge-success',
				), line('CSK_ADMIN_ACTIVE'));
			}

			// The theme has a URI?
			$theme['name_uri'] = $theme['name'];
			if ( ! empty($theme['theme_uri'])) {
				$theme['name_uri'] = html_tag('a', array(
					'href'   => $theme['theme_uri'],
					'target' => '_blank',
					'rel'    => 'nofollow',
				), $theme['name']);
			}

			// Does the license have a URI?
			if ( ! empty($theme['license_uri'])) {
				$theme['license'] = html_tag('a', array(
					'href'   => $theme['license_uri'],
					'target' => '_blank',
					'rel'    => 'nofollow',
				), $theme['license']);
			}

			// Does the author have a URI?
			if ( ! empty($theme['author_uri'])) {
				$theme['author'] = html_tag('a', array(
					'href'   => $theme['author_uri'],
					'target' => '_blank',
					'rel'    => 'nofollow',
				), $theme['author']);
			}

			// Did the user provide a support email address?
			if ( ! empty($theme['author_email'])) {
				$theme['author_email'] = html_tag('a', array(
					'href'   => "mailto:{$theme['author_email']}?subject=".rawurlencode("Support: {$theme['name']}"),
					'target' => '_blank',
					'rel'    => 'nofollow',
				), $theme['author_email']);
			}

			// Actions buttons.
			$theme['action_activate'] = null;
			$theme['action_delete'] = null;
			if (true !== $theme['enabled'])
			{
				$theme['action_activate'] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => nonce_ajax_url(
						"themes/activate/{$name}",
						"activate-theme_{$name}"
					),
					'data-theme' => $name,
					'class' => 'btn btn-primary btn-sm theme-activate',
				), line('CSK_THEMES_ACTIVATE'));

				$theme['action_delete'] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => nonce_ajax_url(
						"themes/delete/{$name}",
						"delete-theme_{$name}"
					),
					'data-theme' => $name,
					'class' => 'btn btn-danger btn-sm theme-delete pull-right',
				), line('CSK_THEMES_DELETE'));
			}

			$this->response->header  = self::HTTP_OK;
			$this->response->results = $theme;
			return;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _users
	 *
	 * Method for interacting with users.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	int  	$id 		The user's ID.
	 * @return 	AJAX_Controller::response()
	 */
	public function _users($action = null, $id = 0)
	{
		$this->load->language('csk_users');
		$actions = array('activate', 'deactivate', 'delete', 'restore', 'remove');

		if ((null === $action OR ! in_array($action, $actions)) 
			OR ( ! is_numeric($id) OR $id < 0)
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		if ($id == $this->c_user->id)
		{
			$this->response->header  = self::HTTP_UNAUTHORIZED;
			$this->response->message = line('CSK_USERS_ADMIN_ERROR_'.strtoupper($action).'_OWN');
			return;
		}

		if (false === ($user = $this->kbcore->users->get($id)))
		{
			$this->response->header  = self::HTTP_NOT_FOUND;
			$this->response->message = line('CSK_USERS_ERROR_ACCOUNT_MISSING');
			return;
		}

		switch ($action)
		{
			// Activate a user.
			case 'activate':
				if (0 == $user->enabled && false !== $user->update('enabled', 1))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_USERS_ADMIN_SUCCESS_ACTIVATE');
					return;
				}

				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_USERS_ADMIN_ERROR_ACTIVATE');
				break;

			// Deactivate a user.
			case 'deactivate':
				if (1 == $user->enabled && false !== $user->update('enabled', 0))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_USERS_ADMIN_SUCCESS_DEACTIVATE');
					return;
				}

				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_USERS_ADMIN_ERROR_DEACTIVATE');
				break;

			// Delete a user.
			case 'delete':
				if (0 == $user->deleted && false !== $this->kbcore->users->delete($id))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_USERS_ADMIN_SUCCESS_DELETE');
					return;
				}

				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_USERS_ADMIN_ERROR_DELETE');
				break;

			// Restore a user.
			case 'restore':
				if (1 == $user->deleted && false !== $this->kbcore->users->restore($id))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_USERS_ADMIN_SUCCESS_RESTORE');
					return;
				}

				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_USERS_ADMIN_ERROR_RESTORE');
				break;
			
			// Remove a user.
			case 'remove':
				if (false !== $this->kbcore->users->remove($id))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = line('CSK_USERS_ADMIN_SUCCESS_REMOVE');
					return;
				}

				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_USERS_ADMIN_ERROR_REMOVE');
				break;
		}
	}

}
