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
 * @since 		Version 1.0.0
 * @version 	1.3.2
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure to load language file.
		$this->load->language('themes/themes');
	}

	// ------------------------------------------------------------------------

	/**
	 * Theme settings.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Get themes from database.
		$themes = get_option('themes', null);
		// Make sure themes are stored in database
		if ($themes && $themes <> $this->theme->get_themes())
		{
			set_option('themes', $this->theme->get_themes());
		}
		elseif (empty($themes))
		{
			$themes = $this->theme->get_themes();
			$this->kbcore->options->insert(array(
				'name'  => 'themes',
				'value' => $themes,
				'tab'   => 'theme',
			));
		}

		// Add enabled element.
		foreach ($themes as &$theme)
		{
			$theme['enabled'] = false;
			if ($theme['folder'] == get_option('theme'))
			{
				$theme['enabled'] = true;
			}
		}

		$data['themes'] = $themes;

		$this->theme
			->set_title(lang('theme_settings'))
			->add('css', get_common_url('css/zoom.min.css'))
			->add('js', get_common_url('js/zoom.min.js'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Activate the selected theme.
	 * @access 	public
	 * @param 	string 	$theme 	the theme's folder.
	 * @return 	void
	 */
	public function activate($theme = null)
	{
		// We first check the safe URL.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/themes');
			exit;
		}

		/**
		 * Make sure the $theme is provided and is different
		 * from the currently used one.
		 */
		if (empty($theme) OR $theme == get_option('theme'))
		{
			set_alert(lang('theme_activate_error'), 'error');
			redirect('admin/themes');
			exit;
		}

		// XSS clean theme's folder and update option.
		$status = set_option('theme', xss_clean($theme));

		if ($status === true)
		{
			set_alert(lang('theme_activate_success'), 'success');

			// Log the activity.
			log_activity($this->c_user->id, 'enabled theme: '.$theme);
		}
		else
		{
			set_alert(lang('theme_activate_error'), 'error');
		}

		redirect('admin/themes');
		exit;
	}

}
