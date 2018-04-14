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
 * Plugins Module - Admin Language (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */

// Dashboard title.
$lang['spg_manage_plugins'] = 'إدارة الإضافات';

// Plugin' settings page.
$lang['spg_plugin_settings']      = 'إعدادات الإضافة';
$lang['spg_plugin_settings_name'] = 'إعدادات الإضافة: %s';

// Plugin: singular and plural forms.
$lang['spg_plugin']  = 'الإضافة';
$lang['spg_plugins'] = 'الإضافات';

// Success messages.
$lang['spg_plugin_activate_success']   = 'تم تفعيل الاضافة بنجاح.';
$lang['spg_plugin_deactivate_success'] = 'تم إلغاء تفعيل الاضافة بنجاح.';
$lang['spg_plugin_delete_success']    = 'تم حذف الاضافة بنجاح.';
$lang['spg_plugin_uploaded_success']   = 'تم تحميل الاضافة بنجاح.';
$lang['spg_plugin_settings_success']   = 'تم تحديث إعدادات الاضافة بنجاح.';

// Error messages.
$lang['spg_plugin_activate_error']   = 'تعذر تفعيل الاضافة.';
$lang['spg_plugin_deactivate_error'] = 'تعذر إلغاء تفعيل الاضافة.';
$lang['spg_plugin_delete_error']    = 'تعذر حذف الاضافة.';
$lang['spg_plugin_uploaded_error']   = 'تعذر تحميل الاضافة.';
$lang['spg_plugin_settings_error']   = 'تعذر تحديث إعدادات الاضافة.';

// Confirmation messages.
$lang['spg_plugin_delete_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذه الاضافة وبياناتها؟';

// Plugins actions.
$lang['spg_activate']   = 'تفعيل';
$lang['spg_deactivate'] = 'تعطيل';
$lang['spg_delete']     = 'حذف';
$lang['spg_settings']   = 'إعدادات';

// Plugins filters.
$lang['spg_all']     = 'الكل (%s)';
$lang['spg_active']  = 'مفعّلة (%s)';
$lang['spg_inactive'] = 'غير مفعّلة (%s)';

// Actions errors
$lang['spg_plugin_missing']           = 'هذه الاضافة غير موجود.';
$lang['spg_plugin_settings_disabled'] = 'يمكنك فقط تحديث إعدادات الإضافات المفعلة.';
$lang['spg_plugin_settings_missing']  = 'لا يحتوي هذه الاضافة على صفحة إعدادات.';

// Plugin details.
$lang['spg_name']         = 'الاسم';
$lang['spg_folder']       = 'المجلد';
$lang['spg_plugin_uri']   = 'موقع الاضافة';
$lang['spg_description']  = 'الوصف';
$lang['spg_version']      = 'الإصدار';
$lang['spg_license']      = 'الرخصة';
$lang['spg_license_uri']  = 'موقع ترخيص';
$lang['spg_author']       = 'المؤلف';
$lang['spg_author_uri']   = 'موقع المؤلف';
$lang['spg_author_email'] = 'البريد الإلكتروني للمؤلف';
$lang['spg_tags']         = 'الوسوم';
