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
 * Admin_Controller Class
 *
 * Controllers extending this class requires a logged in user of rank "admin".
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Admin_Controller extends User_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure the user is an administrator.
		if ( ! $this->auth->is_admin())
		{
			set_alert(lang('error_permission'), 'error');
			redirect('');
			exit;
		}

		// We reset theme settings and add admin assets.
		$this->_switch_to_admin();

		// Load language file.
		$this->load->language('bkader_admin');

		// Now we add dashboard needed CSS and JS files.
		if (ENVIRONMENT === 'production')
		{
			$this->theme
				->add('css', 'https://fonts.googleapis.com/css?family=Fira+Sans:400,400i,700,700i|Oswald')
				->add('css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')
				->add('css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')
				->add('css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css')
				->add('css', get_common_url('css/admin.min'))
				->add('js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')
				->add('js', 'https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js')
				->add('js', get_common_url('js/admin.min'));
		}
		else
		{
			$this->theme
				->add('css', get_common_url('vendor/fira-sans/css/fira-sans.min'), 'fira-sans')
				->add('css', get_common_url('css/font-awesome.min'), 'font-awesome')
				->add('css', get_common_url('css/bootstrap.min'), 'bootstrap')
				//->add('css', get_common_url('css/bootstrap-rtl.min'), 'bootstrap-rtl')
				->add('css', get_common_url('css/bootstrap-theme.min'), 'bootstrap-theme')
				->add('css', get_common_url('css/admin'), 'admin')
				//->add('css', get_common_url('css/admin-rtl'), 'admin-rtl')
				->add('js', get_common_url('js/bootstrap.min'), 'bootstrap')
				->add('js', get_common_url('js/bootbox.min'), 'bootbox')
				->add('js', get_common_url('js/admin'), 'admin');
		}

		// Prepare dashboard sidebar.
		$this->theme->set('admin_menu', $this->_admin_menu(), true);
	}

	// ------------------------------------------------------------------------

	/**
	 * Removes theme filters, change view paths and load resources.
	 * @access 	private
	 * @return 	void
	 */
	private function _switch_to_admin()
	{
		/**
		 * Here we are resetting all applied filters and actions to
		 * force using default admin panel theme. Except these:
		 */
		$this->theme->reset(
			'after_metadata',
			'before_metadata',
			'after_scripts',
			'after_styles',
			'before_scripts',
			'before_styles',
			'enqueue_metadata',
			'the_title',
			'theme_menus',
			'theme_translation'
		);

		// Remove extra filters added by libraries.
		remove_all_filters('pagination');

		// Make sure to load theme's translation.
		$theme_lang = apply_filters('theme_translation', false);
		if (false !== $theme_lang)
		{
			$this->theme->load_translation($theme_lang);
		}

		// Let's set paths to layouts, partials and views.
		add_filter('theme_layouts_path', function($path) {
			return realpath(KBPATH.'views/admin/layouts/');
		});

		add_filter('theme_partials_path', function($path) {
			return realpath(KBPATH.'views/admin/partials/');
		});

		add_filter('theme_views_path', function($path) {
			return realpath(KBPATH.'views/admin/');
		});

		$module = $this->router->fetch_module();
		$module_path = $this->router->module_path($module);

		// We change the views path to modules.
		if ( ! empty($module) && FALSE !== $module_path)
		{
			add_action('theme_view', function($view) use ($module, $module_path) {
				return $module_path.'views/'.str_replace($module.'/', '', $view);
			});
		}

		// Add IE9 support.
		add_filter('extra_head', function($output) {
			add_ie9_support($output, (ENVIRONMENT === 'production'));
			return $output;
		});
	}

	// ------------------------------------------------------------------------

	/**
	 * Loads jQuery UI.
	 * @access 	protected
	 * @return 	void
	 */
	protected function load_jquery_ui()
	{
		$this->theme
			->add('css', get_common_url('css/jquery-ui.min'), 'jquery-ui')
			->add('js', get_common_url('js/jquery-ui.min'), 'jquery-ui');
	}

	// ------------------------------------------------------------------------

	/**
	 * Generates a JQuery content fot draggable items.
	 * @access 	protected
	 * @param 	string 	$button 	the button that handles saving.
	 * @param 	string 	$target 	The element id or class to target.
	 * @param 	string 	$url 		The URL used to send AJAX request.
	 * @param 	string 	$message 	The message to be displayed after success.
	 * @return 	void
	 */
	protected function add_sortable_list($button, $target, $url, $message = null)
	{
		// If these element are not provided, nothing to do.
		if (empty($button) OR empty($target) OR empty($url))
		{
			return;
		}

		// If the message is set, we add it.
		if ( ! empty($message))
		{
			$message = $this->theme->print_alert($message, 'success', true);
		}

		// Prepare the script to output.
		$script =<<<EOT
	<script>
	var data = data || [];
	\$('{$target}').sortable({
		axis: 'y',
		update: function (event, ui) {
			data = \$(this).sortable('serialize');
		}
	});
	\$(document).on('click', '{$button}', function(e) {
		e.preventDefault();
		console.log(data);
		if (data.length) {
			\$.ajax({
				data: data,
				type: 'POST',
				url: '{$url}',
				success: function(response) {
					response = \$.parseJSON(response);
					if (response.status == true) {
						\$({$message}).appendTo('body');
						\$('.alert-dismissable').fadeTo(2000, 500).slideUp(500, function() {
							\$(this).alert('close');
						});
					}
				}
			});
		}
	});
	</script>
EOT;

		// No we add it as an inline script.
		$this->theme->add_inline('js', $script);
	}

	// ------------------------------------------------------------------------

	/**
	 * Prepare dashboard sidebar menu.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	protected function _admin_menu()
	{
		$menu = array();
		$modules = $this->router->list_modules(true);

		// Sort modules.
		uasort($modules, function($a, $b) {
			return $a['admin_order'] - $b['admin_order'];
		});

		foreach ($modules as $folder => $details)
		{
			if ($this->router->has_admin($folder))
			{
				$menu[$folder] = $details['admin_menu'];
			}
		}

		return $menu;
	}

}
