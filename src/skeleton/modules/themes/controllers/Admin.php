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
class Admin extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent constructor, load language file, add head part extra
	 * string and load themes JS file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.0.0
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

		// Add language lines to head part.
		add_filter('admin_head', array($this, '_admin_head'));

		// Add our needed JS file.
		array_push($this->scripts, 'themes');
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
