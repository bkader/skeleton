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
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This configuration file holds defaults site options that will 
 * be later overridden but options stores in database.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

// ------------------------------------------------------------------------
// General settings.
// ------------------------------------------------------------------------
$config['site_name']        = 'Skeleton';
$config['site_description'] = 'A skeleton application for building CodeIgniter application.';
$config['site_keywords']    = 'these, are, site, keywords';
$config['site_favicon']     = 'favicon.ico';
$config['site_author']      = 'Kader Bouyakoub';

// Elements per page.
$config['per_page'] = 10;

// Google analytics and verification.
$config['google_analytics_id']      = '';
$config['google_site_verification'] = '';

// Trace URL key.
$config['trace_url_key'] = 'trk';

// ------------------------------------------------------------------------
// Users settings.
// ------------------------------------------------------------------------
$config['allow_registration']  = true;
$config['email_activation']    = false;
$config['manual_activation']   = false;
$config['login_type']          = 'both';
$config['allow_multi_session'] = true;
$config['use_gravatar']        = false;

// ------------------------------------------------------------------------
// Email settings.
// ------------------------------------------------------------------------
$config['admin_email']   = 'admin@localhost';
$config['mail_protocol'] = 'mail';
$config['sendmail_path'] = '/usr/sbin/sendmail';
$config['server_email']  = '';
$config['smtp_host']     = '';
$config['smtp_port']     = '';
$config['smtp_crypto']   = 'none';
$config['smtp_user']     = '';
$config['smtp_pass']     = '';

// ------------------------------------------------------------------------
// Language settings.
// ------------------------------------------------------------------------
$config['language'] = 'french';
$config['languages'] = array('arabic', 'english', 'french');

// ------------------------------------------------------------------------
// Themes settings.
// ------------------------------------------------------------------------
$config['theme'] = 'default';

// ------------------------------------------------------------------------
// Upload settings.
// ------------------------------------------------------------------------
$config['upload_path']   = 'content/uploads';
$config['allowed_types'] = 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4';

// ------------------------------------------------------------------------
// Captcha settings.
// ------------------------------------------------------------------------
$config['use_captcha']           = false;
$config['use_recaptcha']         = false;
$config['recaptcha_site_key']    = '';
$config['recaptcha_private_key'] = '';

// ------------------------------------------------------------------------
// Roles and permissions.
// ------------------------------------------------------------------------
$config['default_role'] = 'regular';
$config['user_roles']   = array(

	// Administrator
	'administrator' => array(
		'name'        => 'lang:administrator',
		'permissions' => array(

			// Themes actions.
			'delete_themes' => true,
			'switch_themes' => true,
			'update_themes' => true,
			'upload_themes' => true,

			// Plugins.
			'activate_plugins' => true,
			'update_plugins'   => true,
			'install_plugins'  => true,
			'delete_plugins'   => true,

			// Users
			'edit_users'    => true,
			'delete_users'  => true,
			'create_users'  => true,
			'list_users'    => true,
			'remove_users'  => true,
			'promote_users' => true,

			// Site settings.
			'manage_options' => true,

		),
	),

	// Regular users
	'regular' => array(
		'name'        => 'lang:regular',
		'permissions' => array(),
	),
);
