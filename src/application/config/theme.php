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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme library configuration.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */

/**
 * Set the path to where themes are located. They must be
 * somewhere next to FCPATH with you mush not include.
 */
$config['themes_folder']  = 'content/themes';
$config['uploads_folder'] = 'content/uploads';
$config['common_folder']  = 'content/common';
$config['cache_folder']   = 'content/cache';

// Site default theme
$config['theme'] = 'default';

// Site title separator
$config['title_sep'] = '&#8212;';

// Minify HTML Output
$config['compress'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');

// Cache life time
$config['cache_lifetime'] = 0;

// Enable CDN (to use 2nd argument of css() & js() functions)
$config['cdn_enabled'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');

// The CDN URL if you host your files there
$config['cdn_server'] = ''; // i.e: 'http://static.myhost.com/';

/**
 * Set this to true to detect browser details.
 * This is useful if you want to check if the
 * user is on mobile or not and it gives you access
 * to browser's name, version and the platform the
 * client is using.
 */
$config['detect_browser'] = false;

// ------------------------------------------------------------------------
// Backup plan :D for site name, desription & keywords
// ------------------------------------------------------------------------

// Default site name, description and keywords.
$config['site_name']        = 'CodeIgniter Skeleton';
$config['site_description'] = 'A ready-to-use CodeIgniter skeleton with tons of new features and a whole new concept.';
$config['site_keywords']    = 'codeigniter, skeleton, themes, libraries, bkader, ianhub';
