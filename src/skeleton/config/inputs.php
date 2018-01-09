<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stored Form Inputs
 *
 * @package 	CodeIgniter
 * @category 	Configuration
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

// Username field.
$config['username'] = array(
	'name'        => 'username',
	'id'          => 'username',
	'placeholder' => __('username'),
);

// Identity field.
$config['identity'] = array(
	'name'        => 'identity',
	'id'          => 'identity',
	'placeholder' => __('identity'),
);

// ------------------------------------------------------------------------

// Password field.
$config['password'] = array(
	'type'        => 'password',
	'name'        => 'password',
	'id'          => 'password',
	'placeholder' => __('password'),
);

// Confirm field.
$config['cpassword'] = array(
	'type'        => 'password',
	'name'        => 'cpassword',
	'id'          => 'cpassword',
	'placeholder' => __('confirm_password'),
);

// New password field.
$config['npassword'] = array(
	'type'        => 'password',
	'name'        => 'npassword',
	'id'          => 'npassword',
	'placeholder' => __('new_password'),
);

// Current password field.
$config['opassword'] = array(
	'type'        => 'password',
	'name'        => 'opassword',
	'id'          => 'opassword',
	'placeholder' => __('current_password'),
);

// ------------------------------------------------------------------------

// Email field.
$config['email'] = array(
	'type'        => 'email',
	'name'        => 'email',
	'id'          => 'email',
	'placeholder' => __('email_address'),
);

// New email field.
$config['nemail'] = array(
	'type'        => 'email',
	'name'        => 'nemail',
	'id'          => 'nemail',
	'placeholder' => __('new_email_address'),
);

// ------------------------------------------------------------------------

// First name field.
$config['first_name'] = array(
	'name'        => 'first_name',
	'id'          => 'first_name',
	'placeholder' => __('first_name'),
);

// Last name field.
$config['last_name'] = array(
	'name'        => 'last_name',
	'id'          => 'last_name',
	'placeholder' => __('last_name'),
);

// Gender field.
$config['gender'] = array(
	'type' => 'dropdown',
	'name' => 'gender',
	'id' => 'gender',
	'options' => array(
		'unspecified' => __('unspecified'),
		'male'        => __('male'),
		'female'      => __('female'),
	),
);

// Company field.
$config['company'] = array(
	'name'        => 'company',
	'id'          => 'company',
	'placeholder' => __('company'),
);

// Phone field.
$config['phone'] = array(
	'name'        => 'phone',
	'id'          => 'phone',
	'placeholder' => __('phone'),
);

// Location field.
$config['location'] = array(
	'name'        => 'location',
	'id'          => 'location',
	'placeholder' => __('location'),
);

// ------------------------------------------------------------------------

// Name fields (form groups and objects).
$config['name'] = array(
	'name'        => 'name',
	'id'          => 'name',
	'placeholder' => __('name'),
);

// Title (same as name field).
$config['title'] = array(
	'name'        => 'name',
	'id'          => 'name',
	'placeholder' => __('title'),
);

// Elements slug.
$config['slug'] = array(
	'name'        => 'slug',
	'id'          => 'slug',
	'placeholder' => __('slug'),
);

// Used by menu items.
$config['href'] = array(
	'name'        => 'href',
	'id'          => 'href',
	'placeholder' => __('url'),
);

// Order.
$config['order'] = array(
	'type'        => 'number',
	'name'        => 'order',
	'id'          => 'order',
	'placeholder' => __('order'),
);

// Description field.
$config['description'] = array(
	'type'        => 'textarea',
	'name'        => 'description',
	'id'          => 'description',
	'placeholder' => __('description'),
);

// ------------------------------------------------------------------------
// SEO Fields.
// ------------------------------------------------------------------------

// Meta title.
$config['meta_title'] = array(
	'name'        => 'meta_title',
	'id'          => 'meta_title',
	'placeholder' => __('meta_title'),
	'maxlength'   => '70',
);

// Meta description
$config['meta_description'] = array(
	'name'        => 'meta_description',
	'id'          => 'meta_description',
	'placeholder' => __('meta_description'),
	'maxlength'   => '160',
);

// Meta keywords.
$config['meta_title'] = array(
	'name'        => 'meta_title',
	'id'          => 'meta_title',
	'placeholder' => __('meta_title'),
	'maxlength'   => '255',
);
