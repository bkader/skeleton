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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Module - Admin Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.3.3
 */

// Dashboard page title and tip.
$lang['sln_manage_languages']     = 'إدارة اللغات';
$lang['sln_manage_languages_tip'] = 'تفعيل وتعطيل وتثبيت وتعيين اللغة الافتراضية للموقع. اللغات المفعلة متوفرة لزوار الموقع.';

// Language details.
$lang['sln_folder']       = 'المجلد';
$lang['sln_abbreviation'] = 'الاختصار';
$lang['sln_is_default']   = 'الافتراضي';
$lang['sln_enabled']      = 'مفعل';

// Language actions.
$lang['sln_make_default'] = 'افتراضي';

// Success messages.
$lang['sln_language_enable_success']  = 'تم تفعيل اللغة بنجاح.';
$lang['sln_language_disable_success'] = 'تم تعطيل اللغة بنجاح.';
$lang['sln_language_default_success'] = 'تم تغيير اللغة الافتراضية بنجاح.';

// Error messages.
$lang['sln_english_required']       = 'مطلوب ولا يمكن تغييره.';
$lang['sln_language_enable_error']  = 'تعذر تفعيل اللغة.';
$lang['sln_language_disable_error'] = 'تعذر تعطيل اللغة.';
$lang['sln_language_default_error'] = 'تعذر تغيير اللغة الافتراضية.';

// Missing language errors.
$lang['sln_language_missing_folder']  = 'مجلد اللغة مفقود. لا يمكن ترجمة الموقع.';
$lang['sln_language_missing_line']    = 'لم يمكن العثور على سطر اللغة المطلوب.';
$lang['sln_language_enable_missing']  = 'اللغة التي تحاول تفعيلها غير متوفرة.';
$lang['sln_language_disable_missing'] = 'اللغة التي تحاول تعطيلها غير متوفرة.';
$lang['sln_language_default_missing'] = 'اللغة التي تحاول جعلها افتراضية غير متوفرة.';

// Already enabled/disable/default message.
$lang['sln_language_enable_already']  = 'هذه اللغة مفعلة.';
$lang['sln_language_disable_already'] = 'هذه اللغة معطلة.';
$lang['sln_language_default_already'] = 'هذه اللغة هي اللغة الافتراضية.';
