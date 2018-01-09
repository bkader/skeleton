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
$route['default_controller'] = 'welcome';
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
 * have an "Admin.php" controller which will be used as its admin area.
 * Note that this controller MUST extend our Admin_Controller unless you 
 * have added your own admin handler.
 * 
 * Modules admin area URI will be like so: admin/module/..
 */
Route::context('admin', array('home' => 'admin/index'));

/**
 * If you want to let modules accepts AJAX controllers, uncomment the 
 * line below and simply create an "Ajax.php" controller which will 
 * handle all of your AJAX requests.
 *
 * Modules ajax controller will be accessible like so: ajax/module/..
 */
Route::context('ajax', array('home' => 'ajax/index'));

/**
 * Just like admin and ajax, each module may have an "Api.php" 
 * controller that you can use as REST handles for the module.
 *
 * Modules API controllers will be accessible like so: api/module/..
 */
Route::context('api', array('home' => 'api/index'));

/**
 * Because we are using Static Routing like Laravel's,
 * it is IMPORTANT to keep the line below ALWYAS at the 
 * bottom of this file.
 */
$route = Route::map($route);
