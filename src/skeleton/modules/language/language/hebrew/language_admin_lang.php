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
 * Language Module - Admin Language (Hebrew)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

$lang['manage_languages'] = 'ניהול שפות';
$lang['manage_languages_tip'] = 'זמין, לא זמין, להתקין ולהגדיר אתר שפת ברירת המחדל. שפות זמינות זמינות למבקרים באתר.';

$lang['folder']       = 'תיקייה';
$lang['abbreviation'] = 'קיצור';
$lang['is_default']   = 'היא ברירת מחדל';
$lang['enabled']      = 'זמין';

$lang['make_default'] = 'להפוך את ברירת המחדל';

$lang['missing_language_folder'] = 'השפה התיקייה חסרה.';

$lang['english_required'] = 'נדרש טמא.';

// ------------------------------------------------------------------------
// Messages.
// ------------------------------------------------------------------------

// Enable language.
$lang['language_enable_missing'] = 'את השפה שאתה מנסה להפעיל אינה זמינה.';
$lang['language_enable_success'] = 'השפה לזמין בהצלחה.';
$lang['language_enable_error']   = 'לא מצליח להפעיל את השפה.';
$lang['language_enable_already']   = 'שפה זו היא כבר מופעלת.';

// Disable language.
$lang['language_disable_missing'] = 'את השפה שאתה מנסה להפוך ללא זמין לא זמין.';
$lang['language_disable_success'] = 'שפה בהצלחה השבת.';
$lang['language_disable_error']   = 'אין אפשרות לנטרל את השפה.';
$lang['language_disable_already'] = 'את השפה הוא כבר זמין.';

// Set default language.
$lang['language_default_missing'] = 'את השפה בה אתה מנסה לעשות. בתור ברירת המחדל אינו זמין.';
$lang['language_default_success'] = 'שפת ברירת המחדל בהצלחה השתנה.';
$lang['language_default_error']   = 'אין אפשרות לשנות את שפת ברירת המחדל.';
$lang['language_default_already'] = 'שפה זו כבר ברירת מחדל אחד.';
