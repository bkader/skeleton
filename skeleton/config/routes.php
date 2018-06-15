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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.1.4
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * We get the default controller from database.
 * If found, we set it, otherwise we use the default one stored
 * in the KB_BASE constant (application/config/constants.php).
 * @since 	1.3.0
 */
if (function_exists('_DB')) {
	$base_controller = config_item('base_controller');
} else {
	$base_controller = null;
	require_once(BASEPATH .'database/DB.php');
	$db =& DB();
	if (null !== ($result = $db->where('name', 'base_controller')->get('options')->row())) {
		$base_controller = $result->value;
	}
}
$route['default_controller'] = $base_controller ? $base_controller : KB_BASE;

/**
 * Authentication routes.
 * @since 	2.0.0
 */
Route::any(KB_LOGIN, 'users/login', array('as' => 'login'), function() {
	Route::any('recover', 'users/recover', array('as' => 'lost-password'));
	Route::any('reset', 'users/reset', array('as' => 'reset-password'));
	Route::any('restore', 'users/restore', array('as' => 'restore-account'));
});
Route::any(KB_LOGOUT, 'users/logout', array('as' => 'logout'));

/**
 * Account creation routes.
 * @since 	2.0.0
 */
Route::any(KB_REGISTER, 'users/register', array('as' => 'register'), function() {
	Route::any('resend', 'users/resend', array('as' => 'resend-link'));
	Route::any('activate', 'users/activate', array('as' => 'activate-account'));
});

// Prevent direct access to users controller.
Route::block('users(.*)');

/**
 * The application has a built-in administration panel. Each module can
 * have context controllers.
 * Default contexts are stored within the application/config/contexts.php
 * file. If you want to add a context, you may simply add it to the 
 * corresponding array ($back_contexts or front_contexts).
 * @since 	1.0.0
 */
Route::prefix(KB_ADMIN, function() {

	// Admin login section.
	Route::any('login', 'admin/login/index', array('as' => 'admin-login'));

	// System information route first.
	Route::any('settings/sysinfo', 'admin/settings/sysinfo');

	/**
	 * Load controller used to load assets on the dashboard.
	 * @since 	1.4.0
	 */
	Route::get('load/(.*)', 'admin/load/index/$1');

	/**
	 * Reserved dashboard sections.
	 * @since 	2.0.0
	 */
	$modules_routes = implode('|', _csk_modules());
	Route::any("({$modules_routes})/(:any)/(:any)", 'admin/$1/$2/$3');
	Route::any("({$modules_routes})/(:any)", 'admin/$1/$2');
	Route::any("({$modules_routes})", 'admin/$1/index');

	/**
	 * Reserved back-end contexts.
	 * @since 	1.5.0
	 */
	global $back_contexts;
	$contexts_routes = implode('|', $back_contexts);
	Route::context("({$contexts_routes})", '$1', array(
		'home'   => KB_ADMIN.'/$1/index',
		'offset' => 1,
	));
});

/**
 * Admin contexts.
 * This is kept for security, in case of errors.
 * @since 	2.0.0
 */
// Route::context(KB_ADMIN, 'admin', array('home' => 'admin/index'));

/**
 * Reserved back-end AJAX routes.
 * @since 	2.0.0
 */
Route::prefix('ajax', function () {
	$modules_routes = implode('|', _csk_modules());
	Route::any("({$modules_routes})/(:any)/(:any)", "ajax/index/$1/$2/$3");
	Route::any("({$modules_routes})/(:any)", "ajax/index/$1/$2");
	Route::any("({$modules_routes})", "ajax/index/$1");
});
Route::any(
	'process/set_language(.*)',
	'process/set_language$1',
	array('as' => 'change-language')
);

/**
 * Front-end context.
 * @since 	1.0.0
 */
global $front_contexts;
Route::context('('.implode('|', $front_contexts).')', '$1', array(
	'home'   => '$1/index',
	'offset' => 1,
));
