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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Themes Module - Ajax Controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controller
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.4.0
 */
class Ajax extends AJAX_Controller {

	/**
	 * __construct
	 *
	 * Simply calling parent constructor and make sure to load themes language 
	 * file in case it was not loaded.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure to load language file.
		$this->load->language('themes/themes');
		
		// Add our safe AJAX methods.
		array_push($this->safe_admin_methods, 'activate', 'delete');
	}

	// ------------------------------------------------------------------------

	/**
	 * activate
	 *
	 * Method for activating the selected theme.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$name 	The theme folder name.
	 * @return 	AJAX_Controller::response()
	 */
	public function activate($name = null)
	{
		// We grab themes stored in database.
		$db_themes = $this->kbcore->options->get('themes');
		$db_theme  = $this->kbcore->options->get('theme');

		/**
		 * We makes sure that:
		 * 1. The $name is provided and valid.
		 * 2. The selected theme is different from the current one.
		 * 3. The selected theme available.
		 */
		if (null === $name 
			OR $name === $db_theme->value 
			OR ! isset($db_themes->value[$name]))
		{
			$this->response->header  = self::HTTP_FORBIDDEN;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Keep theme's details for later use.
		$theme = $db_themes->value[$name];

		// Successfully updated?
		if (false !== $db_theme->update('value', $name))
		{
			$this->response->header  = self::HTTP_OK;
			$this->response->message = lang('sth_theme_activate_success');

			// Delete other themes menus and images sizes.
			foreach ($db_themes->value as $_name => $details)
			{
				// Only for others, not the one we are activating.
				if ($_name <> $name)
				{
					delete_option('theme_images_'.$_name);
					delete_option('theme_menus_'.$_name);
				}
			}

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_themes_activate::'.$theme['name']);
			return;
		}

		// Otherwise, the theme could not be activated.
		$this->response->message = lang('sth_theme_activate_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * delete
	 *
	 * Method for deleting the selected theme.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$name 	The theme folder name.
	 * @return 	AJAX_Controller::response()
	 */
	public function delete($name = null)
	{
		// We grab themes stored in database.
		$db_themes = $this->kbcore->options->get('themes');

		/**
		 * We make sure that:
		 * 1. The $name is provided and valid.
		 * 2. We have themes stored in database.
		 * 3. The selected theme is available.
		 */
		if (null === $name 
			OR false === $db_themes 
			OR ! isset($db_themes->value[$name]))
		{
			$this->response->header  = self::HTTP_FORBIDDEN;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// There is no way we can deleted the currently active theme.
		if ($name === $this->config->item('theme'))
		{
			$this->response->message = lang('sth_theme_delete_active');
			return;
		}

		// We no remove the selected theme from themes array.
		$themes = $db_themes->value;
		$theme  = $themes[$name];
		unset($themes[$name]);

		// We load the custom directory helper in order to delete the theme.
		$this->load->helper('directory');

		/**
		 * We make sure that:
		 * 1. The "directory_delete" function exists.
		 * 2. The directory is successfully deleted.
		 * 3. Themes stored in database were successfully updated.
		 */
		if (false !== directory_delete($this->theme->themes_path($name)) 
			&& false !== $db_themes->update('value', $themes))
		{
			$this->response->header  = self::HTTP_OK;
			$this->response->message = lang('sth_theme_delete_success');

			// we delete theme options.
			delete_option('theme_images_'.$name);
			delete_option('theme_menus_'.$name);

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_themes_delete::'.$theme['name']);
			return;
		}

		// Otherwise, the theme could not be deleted.
		$this->response->mesage = lang('sth_theme_delete_error');
	}

	// ------------------------------------------------------------------------

	public function details($name = null)
	{
		// We grab themes stored in database.
		$db_themes = $this->kbcore->options->get('themes');

		/**
		 * We make sure that:
		 * 1. The $name is provided and valid.
		 * 2. We have themes stored in database.
		 * 3. The selected theme is available.
		 */
		if (null === $name 
			OR false === $db_themes 
			OR ! isset($db_themes->value[$name]))
		{
			$this->response->header  = self::HTTP_FORBIDDEN;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Prepare the theme and add some details.
		$theme = $db_themes->value[$name];

		// Is the theme enabled?
		$theme['enabled'] = ($name === get_option('theme', 'default'));

		// The theme has a URI?
		$theme['name_uri'] = (empty($theme['theme_uri']))
			? $theme['name']
			: sprintf(lang('sth_theme_name'), $theme['name'], $theme['theme_uri']);

		// Does the license have a URI?
		$theme['license'] = (empty($theme['license_uri']))
			? $theme['license']
			: sprintf(lang('sth_theme_license'), $theme['license'], $theme['license_uri']);

		// Does the author have a URI?
		$theme['author'] = (empty($theme['author_uri']))
			? $theme['author']
			: sprintf(lang('sth_theme_author'), $theme['author'], $theme['author_uri']);

		// Did the user provide a support email address?
		$theme['author_email'] = (empty($theme['author_email']))
			? null
			: sprintf(lang('sth_theme_author_email'), $theme['author_email']);

		// Actions buttons.
		$theme['action_activate'] = null;
		$theme['action_delete'] = null;
		if (true !== $theme['enabled'])
		{
			$theme['action_activate'] = safe_ajax_anchor(
				'themes/activate/'.$name,
				'activate_theme_'.$name,
				line('sth_theme_activate'),
				array(
					'class'      => 'theme-activate btn btn-primary btn-sm',
					'data-theme' => $name,
				)
			);
			$theme['action_delete'] = safe_ajax_anchor(
				'themes/delete/'.$name,
				'delete_theme_'.$name,
				line('sth_theme_delete'),
				array(
					'class'      => 'theme-delete btn btn-danger btn-sm pull-right',
					'data-theme' => $name,
				)
			);
		}

		$this->response->header  = self::HTTP_OK;
		$this->response->results = $theme;
	}

}
