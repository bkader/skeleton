<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_Controller Class
 *
 * Controllers extending this class require a logged user of rank 'admin'.
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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
			set_alert(__('error_permission'), 'error');
			redirect('');
			exit;
		}

		$this->_switch_to_admin();

		// Load admin language file.
		$this->load->language('bkader_admin');
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
		 * force using default admin panel theme. Except for 'theme_menus'
		 * and 'theme_translation'
		 */
		$this->theme->reset('theme_menus', 'theme_translation');

		// Remove extra filters added by libraries.
		remove_all_filters('pagination');

		// Make sure to load theme's translation.
		$theme_lang = apply_filters('theme_translation', false);
		if (false !== $theme_lang) {
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

		if ( ! empty($module) && FALSE !== $module_path)
		{
			add_action('theme_view', function($view) use ($module, $module_path) {
				return $module_path.'views/'.str_replace($module.'/', '', $view);
			});
		}
		else
		{
			// add_action('theme_view', function($view) use ($module_path) {
			// 	$view = $module_path;
			// 	die($views);
			// 	return $module_path.'views/'.str_replace(basename($module_path), '', $view);
			// });
		}
		// echo print_d($module);
		// echo print_d($module_path);
		// exit;

		// Add IE9 support.
		add_filter('extra_head', function($output) {
			add_ie9_support($output, false);
			return $output;
		});

		// Now we add dashboard needed CSS and JS files.
		$this->theme
			->add('css', get_common_url('css/font-awesome.min'), 'fontawesome')
			->add('css', get_common_url('css/bootstrap.min'), 'bootstrap')
			->add('css', get_common_url('css/admin'), 'admin.min')
			->add('js', get_common_url('js/bootstrap.min'), 'bootstrap')
			->add('js', get_common_url('js/admin'), 'admin.min');
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

	protected function add_sortable_list($button, $target, $url, $message = null)
	{
		if (empty($button) OR empty($target) OR empty($url))
		{
			return;
		}

		($message) && $message = $this->theme->print_alert(lang('menu_structure_success'), 'success', true);


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

		$this->theme->add_inline('js', $script);
	}

}
