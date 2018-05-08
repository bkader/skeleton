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

// Get the default controller from database.
require_once(BASEPATH .'database/DB.php');
$db =& DB();
if (null !== $result = $db->where('name', 'base_controller')->get('options')->row())
{
	// if we were able to connect and got a result
	// we set it to that result.
	$route['default_controller'] = $result->value;
}
else
{
	// else something went wrong and we'll 
	// default to the blog controller.
	$route['default_controller'] = 'welcome';
}

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ------------------------------------------------------------------------
// PUT YOUR ROUTE RULES BELOW.
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// END OF YOUR ROUTES. Place to ours.
// ------------------------------------------------------------------------

/**
 * The application has a built-in administration panel. Each module can
 * have context controllers.
 *
 * @example 	Admin Controllers.
 * Each module can have a controller named "Admin.php". It will be then
 * have an administration section and will be automatically added to
 * dashboard's menu. admin controller must extends "Admin_Controller" class.
 * To access admin section of a module, simply go to:
 * <site_url>/admin/<module>. i.e: <site_url>/admin/users.
 * You can user the provided URL helper: admin_url('<module>').
 *
 * @example 	Ajax Controller.
 * Each module has the possibility to handle AJAX requests by creating an.
 * "Ajax.php" controller that should extend our "Ajax_Controller" class.
 *
 * @example 	Process Controllers.
 * Sometimes, we want to create temporary keys they you will use in order
 * to execute certain operation. i.e: When an account is created, an
 * activation code is temporary created and stored in variables table.
 * In order to activate the account, the user must go to:
 * <site_url>/process/users/activate/<code>.
 * Another example is when changing the email address. The code and email
 * are store in database and in order to proceed, the user must go to:
 * <site_url>/process/settings/email/<code>
 *
 * NOTE:
 * You can create as any site areas as you want. Simply add the context
 * you want to the routing below. Let's say I want to add an "Api"
 * controller, all I need to do is adding to like so:
 * (admin|ajax|process) => (admin|ajax|process|api).
 */
Route::prefix(KB_ADMIN, function() {
	// System information route first.
	Route::any('settings/sysinfo', 'admin/settings/sysinfo');

	// Different contexts.
	global $contexts;
	foreach ($contexts as $context) {
		Route::context($context, array('home' => KB_ADMIN.'/'.$context));
	}
});
Route::context('(ajax|process)', '$1', array(
	'home'   => '$1/index',
	'offset' => 1
));

/**
 * Load controller used to load assets on the dashboard.
 * @since 	1.4.0
 */
Route::get('load/(.*)', 'load/index/$1');

/**
 * Because we are using Static Routing like Laravel's,
 * it is IMPORTANT to keep the line below ALWYAS at the
 * bottom of this file.
 */
$route = Route::map($route);
