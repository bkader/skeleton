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
 * @version 	2.0.0
 */
class Themes extends Admin_Controller {

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
		$this->load->language('csk_themes');

		// Add language lines to head part.
		add_filter('admin_head', array($this, '_admin_head'));

		// We need handlebars.
		$this->_handlebars()->_zoom();

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
		$folder_themes = $this->theme->get_themes(true);

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
			$t['actions'] = array();

			// Activation button.
			if ($folder !== get_option('theme', 'default'))
			{
				$t['actions'][] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => nonce_ajax_url(
						"themes/activate/{$folder}",
						"activate-theme_{$folder}"
					),
					'class' => 'btn btn-default btn-sm theme-activate mr-2',
				), line('CSK_THEMES_ACTIVATE'));
			}

			// Details button.
			$t['actions'][] = html_tag('a', array(
				'href' => admin_url('themes?theme='.$folder),
				'data-endpoint' => nonce_ajax_url(
					"themes/details/{$folder}",
					"details-theme_{$folder}"
				),
				'class' => 'btn btn-primary btn-sm theme-details',
			), line('CSK_THEMES_DETAILS'));
		}

		// Displaying a single theme details?
		$theme = $this->input->get('theme', true);
		if (null !== $theme && isset($themes[$theme]))
		{
			$get   = $theme;
			$theme = $themes[$theme];

			// Is the theme enabled?
			$theme['enabled'] = ($get === get_option('theme', 'default'));

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
						"themes/activate/{$get}",
						"activate-theme_{$get}"
					),
					'data-theme' => $get,
					'class' => 'btn btn-primary btn-sm theme-activate',
				), line('CSK_THEMES_ACTIVATE'));

				$theme['action_delete'] = html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => nonce_ajax_url(
						"themes/delete/{$get}",
						"delete-theme_{$get}"
					),
					'data-theme' => $get,
					'class' => 'btn btn-danger btn-sm theme-delete pull-right',
				), line('CSK_THEMES_DELETE'));
			}
		}
		else
		{
			$theme = null;
		}

		// Pass all variables to view.
		$this->data['themes'] = $themes;
		$this->data['theme']  = $theme;

		// Set page title and render view.
		$this->theme
			->set_title(line('CSK_THEMES'))
			->render($this->data);
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
			->set_title(line('CSK_THEMES_INSTALL'))
			->render($this->data);
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
		if (true !== $this->check_nonce('upload-theme'))
		{
			set_alert(line('CSK_ERROR_CSRF'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Did the user provide a valid file?
		if (empty($_FILES['themezip']['name']))
		{
			set_alert(line('CSK_THEMES_ERROR_UPLOAD'), 'error');
			redirect('admin/themes/install');
			exit;
		}

		// Load our file helper and make sure the "unzip_file" function exists.
		$this->load->helper('file');
		if ( ! function_exists('unzip_file'))
		{
			set_alert(line('CSK_THEMES_ERROR_UPLOAD'), 'error');
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
			set_alert(line('CSK_THEMES_ERROR_UPLOAD'), 'error');
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
			set_alert(line('CSK_THEMES_SUCCESS_UPLOAD'), 'success');
			redirect('admin/themes');
			exit;
		}

		// Otherwise, the theme could not be installed.
		set_alert(line('CSK_THEMES_ERROR_UPLOAD'), 'error');
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
			'activate' => line('CSK_THEMES_CONFIRM_ACTIVATE'),
			'delete'   => line('CSK_THEMES_CONFIRM_DELETE'),
			'install'  => line('CSK_THEMES_CONFIRM_INSTALL'),
			'upload'   => line('CSK_THEMES_CONFIRM_UPLOAD'),
		);
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.themes = '.json_encode($lines).';';
		$output .= '</script>';
		return $output;
	}
	// ------------------------------------------------------------------------

	/**
	 * _subhead
	 *
	 * Add some buttons to dashboard subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		// Default page icon and title.
		$this->data['page_icon']  = 'paint-brush';
		$this->data['page_title'] = line('CSK_THEMES');
		$this->data['page_help'] = 'https://goo.gl/B1hPhc';

		// On the install section?
		if ('install' === $this->router->fetch_method())
		{
			$this->data['page_title'] = line('CSK_THEMES_ADD');

			// Subhead.
			add_action('admin_subhead', function() {

				// Upload theme button.
				echo html_tag('button', array(
					'role' => 'button',
					'class' => 'btn btn-success btn-sm btn-icon mr-2',
					'data-toggle' => 'collapse',
					'data-target' => '#theme-install'
				), fa_icon('upload').line('CSK_THEMES_UPLOAD'));

				// Back button.
				$this->_btn_back('themes');

			});
		}
		else
		{
			// Subhead.
			add_action('admin_subhead', function() {
				// Add theme button.
				echo html_tag('a', array(
					'href' => admin_url('themes/install'),
					'class' => 'btn btn-success btn-sm btn-icon'
				), fa_icon('plus-circle').line('CSK_THEMES_ADD'));

			});
		}
	}

}
