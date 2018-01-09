<?php
defined('BASEPATH') OR exit('No direct script access allowed');

add_filter('theme_layouts_path', function($path) {
	return get_theme_path('templates/layouts/');
});

add_filter('theme_partials_path', function($path) {
	return get_theme_path('templates/partials/');
});

add_filter('theme_views_path', function($path) {
	return get_theme_path('templates/');
});

// add_filter('pagination', function($args) {
// 	$args['num_links'] = 5;
// 	return $args;
// });

/**
 * Use the following filter if you want to add
 * extra profile details or edit/delete exsting ones.
 */
// add_filter('user_profile_update_fields', function($post) {
// 	$post[] = 'address';
// 	return $post;
// });

// add_filter('user_profile_form_fields', function($fields) {
// 	$fields['address'] = array(
// 		'type'        => 'textarea',
// 		'name'        => 'address',
// 		'id'          => 'address',
// 		'placeholder' => __('address'),
// 		'value' => set_value(
// 			'address',
// 			$this->_ci->app->metadata->get_meta(
// 				$this->_ci->auth->user()->id,
// 				'address',
// 				true
// 			)),
// 	);
// 	return $fields;
// });

// ------------------------------------------------------------------------

add_action('after_theme_setup', function() {
	add_style('opensans', get_common_url('vendor/open-sans/css/open-sans.min'));
	add_style('fontawesome', get_common_url('css/font-awesome.min'));
	add_style('bootstrap', 'assets/css/bootstrap.min');
	// add_style(null, 'assets/css/bootstrap-theme.min');
	add_style('style', 'assets/css/style');
	add_script("bootstrap", 'assets/js/bootstrap.min');
	add_style('zoom', get_common_url('css/zoom.min'));
	add_script('zoom', get_common_url('js/zoom.min'));
});

// ------------------------------------------------------------------------

add_filter('theme_translation', function($path) {
	return get_theme_path('langs');
});

// add_filter('theme_translation_index', function($index) {
// 	return 'default';
// });

// ------------------------------------------------------------------------

add_action('theme_menus', function() {
	// Register theme's menus.
	register_menu(array(
		'header-menu'  => 'lang:main_menu',
		'footer-menu'  => 'lang:footer_menu',
		'sidebar-menu' => 'lang:sidebar_menu',
	));
});


// ------------------------------------------------------------------------

add_filter('extra_head', function($output) {
	add_ie9_support($output, false);
	return $output;
});

// ------------------------------------------------------------------------

// Print Google Analytics after all script tags.
add_filter('after_scripts', function($output) {
	$output .= get_the_analytics(get_option('google_analytics_id'));
	return $output;
});

// ------------------------------------------------------------------------

add_filter('theme_layout', function($layout) {

	// Change layout of Auth controller.
	if (is_module('users'))
	{
		return 'clean';
	}

	// In case of admin area.
	if (is_controller('admin'))
	{
		return 'admin';
	}

	return $layout;
});

// ------------------------------------------------------------------------

// Partials enqueue for caching purpose.
add_action('enqueue_partials', function() {
	if (is_controller('admin'))
	{
		add_partial('admin_navbar', null, 'navbar');
		add_partial('admin_sidebar', null, 'sidebar');
	}
	elseif ( ! is_module('users'))
	{
		add_partial('navbar');
	}

	add_partial('footer');
});

// ------------------------------------------------------------------------

if ( ! function_exists('fa_icon'))
{
	/**
	 * Useful to generate a fontawesome icon.
	 * @param  string $icon the icon to generate.
	 * @return string       the full FA tag.
	 */
	function fa_icon($icon = 'user')
	{
		return "<i class=\"fa fa-{$icon}\"></i>";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('bs_label'))
{
	function bs_label($content = '', $type = 'default')
	{
		return "<span class=\"label label-{$type}\">{$content}</span>";
	}
}
