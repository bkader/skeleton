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
 * Themes Module - Admin Controller
 *
 * This module allow admins to manage site themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		// Call parent constructor.
		parent::__construct();

		// Add our safe AJAX methods.
		array_push($this->safe_ajax_methods, 'activate', 'delete');

		// Make sure to load language file.
		$this->load->language('themes/themes');

		// Add our needed JS file.
		array_push($this->scripts, 'themes');

		// Add language lines to head part.
		add_filter('admin_head', array($this, '_admin_head'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Theme settings.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten for better code readability and performance.
	 * 
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Get themes stored in database and in folder.
		$db_themes = $this->kbcore->options->get('themes');
		$folder_themes = $this->theme->get_themes();

		// The options does not exist in database? Create it.
		if (false === $db_themes)
		{
			// We create the option.
			$this->kbcore->options->create(array(
				'name'  => 'themes',
				'value' => $folder_themes,
				'tab'   => 'theme',
			));

			// Then we get it.
			$db_themes = $this->kbcore->options->get('themes');
		}
		// Was themes folder update for some reason?
		elseif ($folder_themes <> $db_themes->value)
		{
			// we retrieve all themes and update the option.
			$db_themes->set('value', $folder_themes);
			$db_themes->save();
		}

		// Prepare our themes array.
		$themes = $db_themes->value;

		// Format some elements before final output.
		foreach ($themes as $folder => &$t)
		{
			// Is the theme enabled?
			$t['enabled'] = ($folder === get_option('theme', 'default'));

			// The theme has a URI?
			$t['name_uri'] = (empty($t['theme_uri']))
				? $t['name']
				: sprintf(lang('sth_theme_name'), $t['name'], $t['theme_uri']);

			// Does the license have a URI?
			$t['license'] = (empty($t['license_uri']))
				? $t['license']
				: sprintf(lang('sth_theme_license'), $t['license'], $t['license_uri']);

			// Does the author have a URI?
			$t['author'] = (empty($t['author_uri']))
				? $t['author']
				: sprintf(lang('sth_theme_author'), $t['author'], $t['author_uri']);

			// Did the user provide a support email address?
			$t['author_email'] = (empty($t['author_email']))
				? null
				: sprintf(lang('sth_theme_author_email'), $t['author_email']);
		}

		// Displaying a single theme details?
		$theme = $this->input->get('theme');
		if (null !== $theme)
		{
			$theme = (isset($themes[$theme])) ? $themes[$theme] : null;
		}

		// Pass all variables to view.
		$data['themes'] = $themes;
		$data['theme']  = $theme;

		// Set page title and render view.
		$this->theme
			->set_title(lang('sth_theme_settings'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// AJAX methods.
	// ------------------------------------------------------------------------

	/**
	 * Activate the selected theme.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten to be an AJAX method.
	 * 
	 * @access 	public
	 * @param 	string 	$folder 	the theme's folder.
	 * @return 	void
	 */
	public function activate($folder = null)
	{
		// Default header status code.
		$this->response->header = 406;

		// We grab themes stored in database.
		$db_themes = $this->kbcore->options->get('themes');
		$db_theme  = $this->kbcore->options->get('theme');

		/**
		 * We makes sure that:
		 * 1. The $folder is provided and valid.
		 * 2. The selected theme is different from the current one.
		 * 3. The selected theme available.
		 */
		if (null === $folder 
			OR $folder === $db_theme->value 
			OR ! isset($db_themes->value[$folder]))
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// Keep theme's details for later use.
		$theme = $db_themes->value[$folder];

		// Successfully updated?
		if (false !== $db_theme->update('value', $folder))
		{
			$this->response->header  = 200;
			$this->response->message = lang('sth_theme_activate_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_themes_activate::'.$theme['name']);
			return;
		}

		// Otherwise, the theme could not be activated.
		$this->response->message = lang('sth_theme_activate_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting the selected theme.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$folder 	The theme's folder name.
	 * @return 	void
	 */
	public function delete($folder = null)
	{
		// Default header status code.
		$this->response->header = 406;

		// We grab themes stored in database.
		$db_themes = $this->kbcore->options->get('themes');

		/**
		 * We make sure that:
		 * 1. The $folder is provided and valid.
		 * 2. We have themes stored in database.
		 * 3. The selected theme is available.
		 */
		if (null === $folder 
			OR false === $db_themes 
			OR ! isset($db_themes->value[$folder]))
		{
			$this->response->header  = 412;
			$this->response->message = lang('error_safe_url');
			return;
		}

		// There is no way we can deleted the currently active theme.
		if ($folder === $this->config->item('theme'))
		{
			$this->response->message = lang('sth_theme_delete_active');
			return;
		}

		// We no remove the selected theme from themes array.
		$themes = $db_themes->value;
		$theme  = $themes[$folder];
		unset($themes[$folder]);

		// We load the custom directory helper in order to delete the theme.
		$this->load->helper('directory');

		/**
		 * We make sure that:
		 * 1. The "directory_delete" function exists.
		 * 2. The directory is successfully deleted.
		 * 3. Themes stored in database were successfully updated.
		 */
		if (false !== directory_delete($this->theme->themes_path($folder)) 
			&& false !== $db_themes->update('value', $themes))
		{
			$this->response->header  = 200;
			$this->response->message = lang('sth_theme_delete_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_themes_delete::'.$theme['name']);
			return;
		}

		// Otherwise, the theme could not be deleted.
		$this->response->mesage = lang('sth_theme_delete_error');
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for adding some JS lines to the head part.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		// Add lines.
		$lines = array(
			'activate' => lang('sth_theme_activate_confirm'),
			'delete'   => lang('sth_theme_delete_confirm'),
			'install'  => lang('sth_theme_install_confirm'),
			'upload'   => lang('sth_theme_upload_confirm'),
		);

		// We add our lines and return the final output.
		$output .= '<script type="text/javascript">var i18n=i18n||{};i18n.themes='.json_encode($lines).';</script>';
		return $output;
	}

}
