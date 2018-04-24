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
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Default theme functions.php file.
 *
 * This file is an example of how to use functions.php for your themes.
 * You can use a class or simply a list of functions to add your hooks.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Themes
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.3
 */
// ------------------------------------------------------------------------
if ( ! class_exists('Default_theme', false)):
// ------------------------------------------------------------------------
class Default_theme {
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct() {
		// Let's first change paths to layouts, partials and views.
		$this->set_views_paths();

		// Make sure to load theme translation.
		add_filter( 'theme_translation', array( $this, 'theme_translation' ) );

		// Register theme menus.
		add_action( 'theme_menus', array( $this, 'theme_menus' ) );

		// Register theme thumbnails sizes and names.
		add_action( 'theme_images', array( $this, 'theme_images' ) );

		// Things to do on the front-end.
		if ( ! is_admin() ) {
			// Enqueue our assets.
			add_action( 'after_theme_setup', array( $this, 'after_theme_setup' ) );

			// Add some meta tags.
			add_action( 'enqueue_meta', array( $this, 'enqueue_meta' ) );

			// Add IE8 support.
			add_filter( 'extra_head', array( $this, 'extra_head' ) );

			// We add Google Analytics Code.
			add_filter( 'after_scripts', array( $this, 'google_analytics' ) );

			// Partials enqueue for caching purpose.
			add_action('enqueue_partials', array( $this, 'enqueue_partials' ) );
		}

		// Theme layout manager.
		add_filter( 'theme_layout', array( $this, 'theme_layout' ) );

		add_filter( 'pagination', array( $this, 'pagination' ) );
	}

	// ------------------------------------------------------------------------
	// Views paths methods.
	// ------------------------------------------------------------------------

	/**
	 * Change paths to views, partials and layouts.
	 * @access 	public
	 */
	public function set_views_paths() {
		// Layouts files.
		add_filter( 'theme_layouts_path', array( $this, 'theme_layouts_path' ) );

		// Partials files.
		add_filter( 'theme_partials_path', array( $this, 'theme_partials_path' ) );

		// Views files.
		add_filter( 'theme_views_path', array( $this, 'theme_views_path' ) );
	}

	/**
	 * Change paths to layouts files.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_layouts_path() {
		return get_theme_path( 'templates/layouts/' );
	}

	/**
	 * Change paths to partials files.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_partials_path() {
		return get_theme_path( 'templates/partials/' );
	}

	/**
	 * Change paths to views files.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_views_path() {
		return get_theme_path( 'templates/' );
	}

	// ------------------------------------------------------------------------
	// Theme translation.
	// ------------------------------------------------------------------------

	/**
	 * Set the path to theme translation files.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_translation( $path ) {
		return get_theme_path( 'language' );
	}

	// ------------------------------------------------------------------------
	// Theme menus.
	// ------------------------------------------------------------------------

	/**
	 * Register themes available menus.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_menus() {
		register_menu( array(
			'header-menu'  => 'lang:main_menu',		// Main menu (translated)
			'footer-menu'  => 'lang:footer_menu',	// Footer menu (translated)
			'sidebar-menu' => 'lang:sidebar_menu',	// Sidebar menu (translated)
		) );
	}

	// ------------------------------------------------------------------------
	// Theme images sizes.
	// ------------------------------------------------------------------------

	/**
	 * Register themes images sizes.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_images() {
		// These sizes are dummy ones. Use yours depending on your theme.
		add_image_size( 'thumb', 260, 180, true );
		add_image_size( 'avatar', 100, 100, true );
	}

	// ------------------------------------------------------------------------
	// Assets methods.
	// ------------------------------------------------------------------------

	/**
	 * This method is triggered after theme was installed.
	 * @access 	public
	 */
	public function after_theme_setup() {
		// Load Open Sans fonts.

		// Load Font Awesome.
		if ( ENVIRONMENT === 'development') {
			add_style( 'opensans', 'assets/css/open-sans.min', null, true);
			add_style( 'fontawesome', get_common_url( 'css/font-awesome.min' ), null, true);
			add_style( 'bootstrap', 'assets/css/bootstrap.min', null, true);
			add_script( 'bootstrap', 'assets/js/bootstrap.min');
		} else {
			add_style( 'opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i', null, true);
			add_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, true);
			add_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', null, true);
			add_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
		}

		// Load main theme style.
		add_style( 'style', 'style', null, true);

		// Right to left language?
		if (langinfo('direction' ) === 'rtl' )
		{
			add_style( 'bootstrap-rtl', 'assets/css/bootstrap-rtl.min', null, true);
			add_style( 'style-rtl', 'style-rtl', null, true);
		}
	}

	/**
	 * Enqueue extra meta tags.
	 * @access 	public
	 */
	public function enqueue_meta() {
		// We are only adding favicon.
		add_meta_tag('icon', base_url('favicon.ico'), 'rel', 'type="image/x-icon"');
	}

	/**
	 * Add output before closing </head>
	 * @access 	public
	 */
	public function extra_head( $output ) {
		// We add support for old browsers.
		add_ie9_support($output, (ENVIRONMENT !== 'development'));
		return $output;
	}

	/**
	 * We add stuff to Google Analytics script position.
	 * @access 	public
	 */
	public function google_analytics( $output ) {
		// We simply add the analytics script.
		$output .= get_the_analytics( get_option( 'google_analytics_id' ) );
		return $output;
	}

	/**
	 * We enqueue our partial views so they get cached.
	 * @access 	public
	 */
	public function enqueue_partials() {
		add_partial( 'navbar' );
		add_partial( 'sidebar' );
		add_partial( 'footer' );
	}

	/**
	 * Handle our theme layouts.
	 * @access 	public
	 * @param 	string 	$layout 	The layout to use.
	 * @return 	string 	The layout to be used.
	 */

	public function theme_layout( $layout ) {
		// Change layout of Auth controller.
		if ( is_module( 'users' ) ) {
			$layout = 'clean';
		}
		// In case of admin area.
		elseif ( is_controller( 'admin' ) ) {
			return 'admin';
		}

		// Always return the layout.
		return $layout;
	}

	// ------------------------------------------------------------------------

	/**
	 * Uses Bootstrap for pagination.
	 * @access 	public
	 * @param 	array
	 * @return 	array
	 */
	public function pagination($args)
	{
		$args['full_tag_open']   = '<div class="text-center"><ul class="pagination pagination-centered">';
		$args['full_tag_close']  = '</ul></div>';
		$args['num_links']       = 5;
		$args['num_tag_open']    = '<li>';
		$args['num_tag_close']   = '</li>';
		$args['prev_tag_open']   = '<li>';
		$args['prev_tag_close']  = '</li>';
		$args['next_tag_open']   = '<li>';
		$args['next_tag_close']  = '</li>';
		$args['first_tag_open']  = '<li>';
		$args['first_tag_close'] = '</li>';
		$args['last_tag_open']   = '<li>';
		$args['last_tag_close']  = '</li>';
		$args['cur_tag_open']    = '<li class="active"><span>';
		$args['cur_tag_close']   = '<span class="sr-only">(current)</span></span></li>';

		return $args;
	}

}
// ------------------------------------------------------------------------
endif; // End of class Default_theme.
// ------------------------------------------------------------------------

// Initialize class.
$default_theme = new Default_theme();

/**
 * The CodeIgniter Skeleton comes with a copyright added to your final
 * HTML output. We really appreciate the fact that you keep it, it is a
 * way to say "Oh yeah, another person using my project.".
 * If you want to remove it, and you have the right to do it, the filter
 * below show you how to do it.
 */

// To remove the copyright added between DOCTYPE and <html>:
if ( ! function_exists('remove_skeleton_copyright'))
{
	/**
	 * Remove the Skeleton copyright.
	 * @param 	string 	$copyright
	 * @return 	string
	 */
	function remove_skeleton_copyright($content)
	{
		// Change it or return an empty string
		// return null or $content = null;
		return $content;
	}

	// Now you add the filer.
	add_filter('skeleton_copyright', 'remove_skeleton_copyright');
}

// To remove the generator meta tag:
if ( ! function_exists('remove_generator'))
{
	/**
	 * Remove the Skeleton generator meta tag.
	 * @param 	string 	$content
	 * @return 	string
	 */
	function remove_generator($content)
	{
		// Change it or return an empty string
		// return null or $content = null;
		return $content;
	}

	// Now you add the filer.
	add_filter('skeleton_generator', 'remove_generator');
}

// ------------------------------------------------------------------------

if ( ! function_exists( 'fa_icon' ) ) {
	/**
	 * Useful to generate a fontawesome icon.
	 * @param  string $icon the icon to generate.
	 * @return string       the full FA tag.
	 */
	function fa_icon( $icon = 'user' ) {
		return "<i class=\"fa fa-{$icon}\"></i>";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists( 'bs_label' )) {
	function bs_label( $content = '', $type = 'default' ) {
		return "<span class=\"label label-{$type}\">{$content}</span>";
	}
}
