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
 * Language Module - Admin Language (Arabic)
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

$lang['manage_languages']     = 'إدارة اللغات';
$lang['manage_languages_tip'] = 'تمكين وتعطيل وتعيين اللغة الافتراضية للموقع. اللغات الممكنة متاحة لزوار الموقع.';

$lang['folder']       = 'المجلد';
$lang['abbreviation'] = 'الاختصار';
$lang['is_default']   = 'افتراضي';
$lang['enabled']      = 'ممكن';

$lang['make_default'] = 'جعل الافتراضي';

$lang['missing_language_folder'] = 'مجلد اللغة مفقود.';

$lang['english_required'] = 'مطلوب وغير قابل للتحرير.';

// ------------------------------------------------------------------------
// Messages.
// ------------------------------------------------------------------------

// Enable language.
$lang['language_enable_missing'] = 'اللغة التي تحاول تمكينها غير متوفرة.';
$lang['language_enable_success'] = 'تم تمكين اللغة بنجاح.';
$lang['language_enable_error']   = 'تعذر تمكين اللغة.';
$lang['language_enable_already']   = 'هذه اللغة قيد الاستخدام.';

// Disable language.
$lang['language_disable_missing'] = 'اللغة التي تحاول تعطيلها غير متوفرة.';
$lang['language_disable_success'] = 'تم تعطيل اللغة بنجاح.';
$lang['language_disable_error']   = 'تعذر تعطيل اللغة.';
$lang['language_disable_already'] = 'هذه اللغة معطلة.';

// Set default language.
$lang['language_default_missing'] = 'اللغة التي تحاول جعلها افتراضية غير متوفرة.';
$lang['language_default_success'] = 'تم تغيير اللغة الافتراضية بنجاح.';
$lang['language_default_error']   = 'تعذر تغيير اللغة الافتراضية.';
$lang['language_default_already'] = 'هذه اللغة هي اللغة الافتراضية.';
