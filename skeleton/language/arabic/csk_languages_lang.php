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
 * Language Module - Admin Language (Arabic)
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

$lang['CSK_LANGUAGES']           = 'اللغات';
$lang['CSK_LANGUAGES_LANGUAGE']  = 'اللغة';
$lang['CSK_LANGUAGES_LANGUAGES'] = 'اللغات';

// Dashboard page title and tip.
$lang['CSK_LANGUAGES_TIP'] = 'تفعيل وتعطيل وتعيين اللغة الافتراضية للموقع. اللغات المفعلة متاحة لزوار الموقع.';

// Language details.
$lang['CSK_LANGUAGES_FOLDER']       = 'المجلد';
$lang['CSK_LANGUAGES_ABBREVIATION'] = 'الاختصار';
$lang['CSK_LANGUAGES_IS_DEFAULT']   = 'الافتراضي';
$lang['CSK_LANGUAGES_ENABLED']      = 'مفعل';

// Language actions.
$lang['CSK_LANGUAGES_DISABLE']      = 'تعطيل';
$lang['CSK_LANGUAGES_ENABLE']       = 'تفعيل';
$lang['CSK_LANGUAGES_MAKE_DEFAULT'] = 'الافتراضي';

// Confirmation messages.
$lang['CSK_LANGUAGES_CONFIRM_ENABLE']  = 'هل أنت متأكد أنك تريد تفعيل هذه اللغة؟';
$lang['CSK_LANGUAGES_CONFIRM_DISABLE'] = 'هل أنت متأكد من أنك تريد تعطيل هذه اللغة؟';
$lang['CSK_LANGUAGES_CONFIRM_DEFAULT'] = 'هل أنت متأكد من أنك تريد جعل هذه اللغة هي اللغة الافتراضية للموقع؟';

// Success messages.
$lang['CSK_LANGUAGES_SUCCESS_ENABLE']  = 'تم تفعيل اللغة بنجاح.';
$lang['CSK_LANGUAGES_SUCCESS_DISABLE'] = 'تم تعطيل اللغة بنجاح.';
$lang['CSK_LANGUAGES_SUCCESS_DEFAULT'] = 'تم تغيير اللغة الافتراضية للموقع بنجاح.';

// Error messages.
$lang['CSK_LANGUAGES_ERROR_ENABLE']           = 'تعذر تفعيل اللغة.';
$lang['CSK_LANGUAGES_ERROR_DISABLE']          = 'تعذر تعطيل اللغة.';
$lang['CSK_LANGUAGES_ERROR_DEFAULT']          = 'تعذر تغيير اللغة الافتراضية للموقع.';
$lang['CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED'] = 'اللغة الإنجليزية إجبارية، لذلك لا يمكن لمسها.';

// Missing language errors.
$lang['CSK_LANGUAGES_MISSING_FOLDER']  = 'مجلد اللغة مفقود. يستحيل الترجمة لهاته اللغة.';

// Already enabled/disable/default message.
$lang['CSK_LANGUAGES_ALREADY_ENABLE']  = 'هذه اللغة مفعلة أصلاً.';
$lang['CSK_LANGUAGES_ALREADY_DISABLE'] = 'هذه اللغة معطلة أصلاً..';
$lang['CSK_LANGUAGES_ALREADY_DEFAULT'] = 'هذه اللغة هي أصلاً اللغة الافتراضية للموقع.';
