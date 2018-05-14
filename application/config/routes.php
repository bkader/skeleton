<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// ------------------------------------------------------------------------
// DON'T CHANGE LINES BELOW.
// ------------------------------------------------------------------------

/**
 * We get the default controller from database.
 * If found, we set it, otherwise we use the default one stored
 * in the KB_BASE constant (application/config/constants.php).
 * @since 	1.3.0
 */
require_once(BASEPATH .'database/DB.php');
$db =& DB();
$route['default_controller'] = (null !== ($result = $db->where('name', 'base_controller')->get('options')->row())) ? $result->value : KB_BASE;

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
Route::any(KB_ADMIN, 'admin/index');
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
	global $csk_modules;
	$modules_routes = implode('|', $csk_modules);
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
 * Reserved back-end AJAX routes.
 * @since 	2.0.0
 */
Route::prefix('ajax', function () {
	global $csk_modules;
	$modules_routes = implode('|', $csk_modules);
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

// ------------------------------------------------------------------------
// PUT YOUR ROUTE RULES BELOW.
// ------------------------------------------------------------------------

/*
| -------------------------------------------------------------------------
| CodeIgniter URI routing
| -------------------------------------------------------------------------
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
*/
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;


// ------------------------------------------------------------------------
// END OF YOUR ROUTES.
// ------------------------------------------------------------------------

/**
 * Because we are using Static Routing like Laravel's,
 * it is IMPORTANT to keep the line below ALWYAS at the
 * bottom of this file.
 */
$route = Route::map($route);
