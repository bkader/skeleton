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
 * @link 		https://goo.gl/wGXHO9
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This configuration file holds all possible form inputs and is 
 * loaded every time you use the "prep_form" method in your 
 * controllers. This way, no need to declare array of form inputs, 
 * you simple need to use like so:
 *
 * @example
 *
 * $data['username'] = $this->config->item('username', 'inputs')
 *
 * Then pass the data to view load (or theme render method) and you 
 * can later our provided function "print_input" that accepts extra 
 * parameter, array of attributes. For instance, in your view:
 *
 * echo print_input($username, array('class' => 'form-control'))
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

// Username field.
$config['username'] = array(
	'name'        => 'username',
	'id'          => 'username',
	'placeholder' => 'lang:username',
);

// Identity field.
$config['identity'] = array(
	'name'        => 'identity',
	'id'          => 'identity',
	'placeholder' => 'lang:identity',
);

// ------------------------------------------------------------------------
// Passwords fields.
// ------------------------------------------------------------------------

// Password field.
$config['password'] = array(
	'type'        => 'password',
	'name'        => 'password',
	'id'          => 'password',
	'placeholder' => 'lang:password',
);

// Confirm field.
$config['cpassword'] = array(
	'type'        => 'password',
	'name'        => 'cpassword',
	'id'          => 'cpassword',
	'placeholder' => 'lang:confirm_password',
);

// New password field.
$config['npassword'] = array(
	'type'        => 'password',
	'name'        => 'npassword',
	'id'          => 'npassword',
	'placeholder' => 'lang:new_password',
);

// Current password field.
$config['opassword'] = array(
	'type'        => 'password',
	'name'        => 'opassword',
	'id'          => 'opassword',
	'placeholder' => 'lang:current_password',
);

// ------------------------------------------------------------------------
// Email addresses fields.
// ------------------------------------------------------------------------

// Email field.
$config['email'] = array(
	'type'        => 'email',
	'name'        => 'email',
	'id'          => 'email',
	'placeholder' => 'lang:email_address',
);

// New email field.
$config['nemail'] = array(
	'type'        => 'email',
	'name'        => 'nemail',
	'id'          => 'nemail',
	'placeholder' => 'lang:new_email_address',
);

// ------------------------------------------------------------------------
// User profile fields.
// ------------------------------------------------------------------------

// First name field.
$config['first_name'] = array(
	'name'        => 'first_name',
	'id'          => 'first_name',
	'placeholder' => 'lang:first_name',
);

// Last name field.
$config['last_name'] = array(
	'name'        => 'last_name',
	'id'          => 'last_name',
	'placeholder' => 'lang:last_name',
);

// Gender field.
$config['gender'] = array(
	'type' => 'dropdown',
	'name' => 'gender',
	'id' => 'gender',
	'options' => array(
		'unspecified' => 'lang:unspecified',
		'male'        => 'lang:male',
		'female'      => 'lang:female',
	),
);

// Company field.
$config['company'] = array(
	'name'        => 'company',
	'id'          => 'company',
	'placeholder' => 'lang:company',
);

// Phone field.
$config['phone'] = array(
	'name'        => 'phone',
	'id'          => 'phone',
	'placeholder' => 'lang:phone',
);

// Location field.
$config['location'] = array(
	'name'        => 'location',
	'id'          => 'location',
	'placeholder' => 'lang:location',
);

// ------------------------------------------------------------------------
// Fields used by groups and objects.
// ------------------------------------------------------------------------

// Name fields (form groups and objects).
$config['name'] = array(
	'name'        => 'name',
	'id'          => 'name',
	'placeholder' => 'lang:name',
);

// Title (same as name field).
$config['title'] = array(
	'name'        => 'name',
	'id'          => 'name',
	'placeholder' => 'lang:title',
);

// Elements slug.
$config['slug'] = array(
	'name'        => 'slug',
	'id'          => 'slug',
	'placeholder' => 'lang:slug',
);

// Description field.
$config['description'] = array(
	'type'        => 'textarea',
	'name'        => 'description',
	'id'          => 'description',
	'placeholder' => 'lang:description',
);

// Used by menu items.
$config['href'] = array(
	'name'        => 'href',
	'id'          => 'href',
	'placeholder' => 'lang:url',
);

// Menu order.
$config['order'] = array(
	'type'        => 'number',
	'name'        => 'order',
	'id'          => 'order',
	'placeholder' => 'lang:order',
);

// ------------------------------------------------------------------------
// SEO Fields.
// ------------------------------------------------------------------------

// Meta title.
$config['meta_title'] = array(
	'name'        => 'meta_title',
	'id'          => 'meta_title',
	'placeholder' => 'lang:meta_title',
	'maxlength'   => '70',
);

// Meta description
$config['meta_description'] = array(
	'name'        => 'meta_description',
	'id'          => 'meta_description',
	'placeholder' => 'lang:meta_description',
	'maxlength'   => '160',
);

// Meta keywords.
$config['meta_title'] = array(
	'name'        => 'meta_title',
	'id'          => 'meta_title',
	'placeholder' => 'lang:meta_title',
	'maxlength'   => '255',
);
