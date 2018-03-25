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
 * @version 	1.0.0
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

			// Add IE8 support.
			add_filter( 'extra_head', array( $this, 'extra_head' ) );

			// We add Google Analytics Code.
			add_filter( 'after_scripts', array( $this, 'google_analytics' ) );

			// Partials enqueue for caching purpose.
			add_action('enqueue_partials', array( $this, 'enqueue_partials' ) );
		}

		// Theme layout manager.
		add_filter( 'theme_layout', array( $this, 'theme_layout' ) );
	}

	// ------------------------------------------------------------------------
	// Views paths methods.
	// ------------------------------------------------------------------------

	public function set_views_paths() {
		// Layouts files.
		add_filter( 'theme_layouts_path', array( $this, 'theme_layouts_path' ) );

		// Partials files.
		add_filter( 'theme_partials_path', array( $this, 'theme_partials_path' ) );

		// Views files.
		add_filter( 'theme_views_path', array( $this, 'theme_views_path' ) );
	}

	public function theme_layouts_path() {
		return get_theme_path( 'templates/layouts/' );
	}

	public function theme_partials_path() {
		return get_theme_path( 'templates/partials/' );
	}

	public function theme_views_path() {
		return get_theme_path( 'templates/' );
	}

	// ------------------------------------------------------------------------
	// Theme translation.
	// ------------------------------------------------------------------------

	public function theme_translation( $path ) {
		return get_theme_path( 'language' );
	}

	// ------------------------------------------------------------------------
	// Theme menus.
	// ------------------------------------------------------------------------

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

	public function theme_images() {
		// These sizes are dummy ones.
		// Use yours depending on your theme.
		add_image_size( 'post', 220, 180, true );
		add_image_size( 'avatar', 100, 100, true );
	}

	// ------------------------------------------------------------------------
	// Assets methods.
	// ------------------------------------------------------------------------

	public function after_theme_setup() {
		// Load Open Sans fonts.
		add_style( 'opensans', get_common_url( 'vendor/open-sans/css/open-sans.min' ) );

		// Load Font Awesome.
		add_style( 'fontawesome', get_common_url( 'css/font-awesome.min' ) );

		// Load Bootstrap files.
		add_style( 'bootstrap', 'assets/css/bootstrap.min' );

		// Load main theme style.
		add_style( 'style', 'assets/css/style' );

		// Right to left language?
		if (langinfo('direction' ) === 'rtl' )
		{
			add_style( 'bootstrap-rtl', 'assets/css/bootstrap-rtl.min' );
			add_style( 'style-rtl', 'assets/css/style-rtl' );
		}

		// Load bootstrap JS file.
		add_script('bootstrap', 'assets/js/bootstrap.min' );

		// Load Zoom CSS and JS files.
		add_style( 'zoom', get_common_url( 'css/zoom.min' ) );
		add_script( 'zoom', get_common_url( 'js/zoom.min' ));
	}

	public function extra_head( $output ) {
		add_ie9_support($output, false);
		return $output;
	}

	public function google_analytics( $output ) {
		$output .= get_the_analytics( get_option( 'google_analytics_id' ) );
		return $output;
	}

	public function enqueue_partials() {
		add_partial( 'navbar' );
		add_partial( 'footer' );
	}

	public function theme_layout( $layout ) {
		// Change layout of Auth controller.
		if ( is_module( 'users' ) ) {
			$layout = 'clean';
		}
		// In case of admin area.
		elseif ( is_controller( 'admin' ) ) {
			return 'admin';
		}

		return $layout;
	}

}
// ------------------------------------------------------------------------
endif; // End of class Default_theme.
// ------------------------------------------------------------------------

// Initialize class.
$default_theme = new Default_theme();

// ------------------------------------------------------------------------



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

/* End of file functions.php */
/* Location: ./content/themes/default/functions.php */
