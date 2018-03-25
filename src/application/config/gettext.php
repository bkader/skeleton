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
 * Gettext hook configuration.
 *
 * This file holds all needs configurations needed by the Gettext class.
 *
 * @package 	CodeIgniter
 * @subpackage 	Gettext
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

/**
 * Whether to use the class or not.
 * Setting this to FALSE will simply ignore the class
 */
$config['enabled'] = true;

// ------------------------------------------------------------------------

/**
 * The default language used on the website.
 * You can set your language here or you can leave it
 * empty and the class will use the language set in
 * config.php file.
 */
$config['language'] = 'english';

// ------------------------------------------------------------------------

/**
 * Here you can set the default application language
 * file name. Default: application.
 */
$config['default_file'] = null;

// ------------------------------------------------------------------------

// Here you can set the list of available languages.
$config['languages'] = array(
	'arabic',
	'english',
	'french',
	'german',
	'italian',
	'portuguese',
	'spanish',
);

// ------------------------------------------------------------------------

// Whether to detect client's language or not.
$config['detect'] = false;

// ------------------------------------------------------------------------

/**
 * If you want to store the language inside a cookie, you
 * can set the cookie name here.
 *
 * NOTE:
 * Your site will always be in the default language if you set "detect"
 * to FALSE and "cookie" to NULL.
 * If you don't wish to store the language in cookies, make sure to
 * turn "detect" to TRUE in order to use client's language if available.
 */
$config['cookie'] = 'ci_language';
