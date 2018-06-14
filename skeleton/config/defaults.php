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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This configuration file holds defaults site options that will 
 * be later overridden but options stores in database.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.0
 */

// ------------------------------------------------------------------------
// General settings.
// ------------------------------------------------------------------------
$config['site_name']        = 'Skeleton';
$config['site_description'] = 'A skeleton application for building CodeIgniter application.';
$config['site_keywords']    = 'these, are, site, keywords';
$config['site_favicon']     = '';
$config['site_author']      = 'CodeIgniter Skeleton';

// Site base controller.
$config['bae_controller'] = 'welcome';

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
$config['language'] = 'english';
$config['languages'] = array('english');

// ------------------------------------------------------------------------
// Themes settings.
// ------------------------------------------------------------------------
$config['theme']  = 'default';
$config['themes'] = array();

// ------------------------------------------------------------------------
// Upload settings.
// ------------------------------------------------------------------------
$config['upload_path']   = 'content/uploads';
$config['allowed_types'] = 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4';
$config['max_height']    = 0;
$config['max_size']      = 0;
$config['max_width']     = 0;
$config['min_height']    = 0;
$config['min_width']     = 0;

// ------------------------------------------------------------------------
// Captcha settings.
// ------------------------------------------------------------------------
$config['use_captcha']           = false;
$config['use_recaptcha']         = false;
$config['recaptcha_site_key']    = '';
$config['recaptcha_private_key'] = '';

// ------------------------------------------------------------------------
// Active plugins.
// ------------------------------------------------------------------------
$config['active_plugins'] = array();

// ------------------------------------------------------------------------
// Date and time format.
// ------------------------------------------------------------------------
$config['date_format'] = 'd/m/Y'; 			// 21/03/1988
$config['time_format'] = 'G:i'; 			// 23:15
$config['datetime_format'] = 'Y-m-d G:i:s';	// 1988-03-21 23:15:30

// ------------------------------------------------------------------------
// Social network links sharers.
// ------------------------------------------------------------------------
$config['share_urls'] = array(
	'email'      => 'mailto:?subject={title}&amp;body={description}:%0A{url}',
	'facebook'   => 'https://www.facebook.com/sharer.php?u={url}&amp;t={title}&amp;d={description}',
	'googleplus' => 'https://plus.google.com/share?url={url}',
	'linkedin'   => 'http://www.linkedin.com/shareArticle?mini=true&amp;url={url}&amp;title={title}&amp;summary={description}&amp;source={site_name}',
	'twitter'    => 'http://twitter.com/share?url={url}&amp;text={title}&amp;via={site_name}',
);
