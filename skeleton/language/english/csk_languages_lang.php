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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Module - Admin Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

$lang['CSK_LANGUAGES']           = 'Languages';
$lang['CSK_LANGUAGES_LANGUAGE']  = 'Language';
$lang['CSK_LANGUAGES_LANGUAGES'] = 'Languages';

// Dashboard page title and tip.
$lang['CSK_LANGUAGES_TIP'] = 'Enabled, disable and set site\'s default language. Enabled languages are available to site visitors.';

// Language details.
$lang['CSK_LANGUAGES_FOLDER']       = 'Folder';
$lang['CSK_LANGUAGES_ABBREVIATION'] = 'Abbreviation';
$lang['CSK_LANGUAGES_IS_DEFAULT']   = 'Is Default';
$lang['CSK_LANGUAGES_ENABLED']      = 'Enabled';

// Language actions.
$lang['CSK_LANGUAGES_DISABLE']      = 'Disable';
$lang['CSK_LANGUAGES_ENABLE']       = 'Enable';
$lang['CSK_LANGUAGES_MAKE_DEFAULT'] = 'Make Default';

// Confirmation messages.
$lang['CSK_LANGUAGES_CONFIRM_ENABLE']  = 'Are you sure you want to enable this language?';
$lang['CSK_LANGUAGES_CONFIRM_DISABLE'] = 'Are you sure you want to disable this language?';
$lang['CSK_LANGUAGES_CONFIRM_DEFAULT'] = 'Are you sure you want to make this language as site\'s default language?';

// Success messages.
$lang['CSK_LANGUAGES_SUCCESS_ENABLE']  = 'Language successfully enabled.';
$lang['CSK_LANGUAGES_SUCCESS_DISABLE'] = 'Language successfully disabled.';
$lang['CSK_LANGUAGES_SUCCESS_DEFAULT'] = 'Default language successfully changed.';

// Error messages.
$lang['CSK_LANGUAGES_ERROR_ENABLE']           = 'Unable to enable language.';
$lang['CSK_LANGUAGES_ERROR_DISABLE']          = 'Unable to disable language.';
$lang['CSK_LANGUAGES_ERROR_DEFAULT']          = 'Unable to change default language.';
$lang['CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED'] = 'The English language is required, thus it cannot be touched.';

// Missing language errors.
$lang['CSK_LANGUAGES_MISSING_FOLDER']  = 'The language folder is missing. Lines may not be translated.';

// Already enabled/disable/default message.
$lang['CSK_LANGUAGES_ALREADY_ENABLE']  = 'This language is already enabled.';
$lang['CSK_LANGUAGES_ALREADY_DISABLE'] = 'This language is already disabled.';
$lang['CSK_LANGUAGES_ALREADY_DEFAULT'] = 'This language is already the default one.';
