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
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.4.0
 */
class Admin extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Simply call parent constructor, load language file, add head part extra
	 * string and load themes JS file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.0.0
	 * @since 	1.4.0 	Included Handlebars and removed array_push for better performance.
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

		// We need handlebars.
		$this->_handlebars();

		// Add our needed JS file.
		$this->scripts[] = 'themes';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Display available themes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.0.0
	 * @since 	1.3.3 	Rewritten for better code readability and performance.
	 *
	 * @access 	public
	 * @param 	none
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
		$theme = $this->input->get('theme', true);
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

	/**
	 * install
	 *
	 * Method for installing themes from future server or upload ZIP themes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.3.4
	 * @since 	1.4.0 	Updated to use newly created nonce system.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function install()
	{
		// We prepare form validation.
		$this->prep_form();

		// Set page title and load view.
		$this->theme
			->set_title(lang('sth_theme_add'))
			->render();
	}

	// ------------------------------------------------------------------------

	/**
	 * upload
	 *
	 * Method for uploading themes using ZIP archives.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.3.4
	 * @since 	1.4.0 	Updated to use newly created nonce system.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function upload()
	{
		if (true !== $this->check_nonce('theme_upload'))
		{
			set_alert(lang('CSK_ERROR_CSRF'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['themezip']['name']))
		{
			set_alert(lang('sth_theme_upload_error'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(lang('sth_theme_upload_error'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Load upload library.
		$this->load->library('upload', array(
			'upload_path'   => FCPATH.'content/uploads/temp/',
			'allowed_types' => 'zip',
		));

		// Error uploading?
		if (false === $this->upload->do_upload('themezip') OR ! class_exists('ZipArchive', false))
		{
			set_alert(lang('sth_theme_upload_error'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Prepare data for later use.
		$data = $this->upload->data();

		// Catch the upload status and delete the temporary file anyways.
		$status = unzip_file($data['full_path'], FCPATH.'content/themes/');
		@unlink($data['full_path']);
		
		// Successfully installed?
		if (true === $status)
		{
			set_alert(lang('sth_theme_upload_success'), 'success');
			redirect('admin/themes');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(lang('sth_theme_upload_error'), 'error');
		redirect('admin/themes/install');
		exit;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for adding some JS lines to the head part.
	 *
	 * @since 	1.3.3
	 * @since 	1.4.0 	Update because CSK object was updated.
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
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.themes = '.json_encode($lines).';';
		$output .= '</script>';
		return $output;
	}

}
