<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller Routes.
 *
 * @package 	CodeIgniter
 * @category 	Routes
 * @usersor 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

// Login page and sub-pages.
Route::any('login', 'users/login', function() {
	Route::any('recover', 'users/recover');
	Route::any('restore', 'users/restore');
	Route::any('reset(.*)', 'users/reset$1');
});

// Register page and sub-pages.
Route::any('register', 'users/register', function() {
	Route::any('resend', 'users/resend');
	Route::get('activate(.*)', 'users/activate$1');
});

// Logout page.
Route::get('logout', 'users/logout');

// Block direct access to users controllers and methods.
Route::block('users(.*)');
