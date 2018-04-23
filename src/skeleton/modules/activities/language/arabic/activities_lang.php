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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities language file (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.4.0
 */

$lang['sac_activity'] = 'النشاط';
$lang['sac_activities'] = 'الأنشطة';

// Dashboard title;
$lang['sac_activity_log'] = 'سجل النشاطات';

// Activities table headings.
$lang['sac_user']       = 'المستخدم';
$lang['sac_module']     = 'الوحدة';
$lang['sac_method']     = 'الطريقة';
$lang['sac_ip_address'] = 'عنوان IP';
$lang['sac_date']       = 'التاريخ';
$lang['sac_action']     = 'الفعل';

// Activities delete messages.
$lang['sac_activity_delete_confirm'] = 'هل أنت متأكد من أنك تريد حذف سجل النشاط هذا؟';
$lang['sac_activity_delete_success'] = 'تم حذف النشاط بنجاح.';
$lang['sac_activity_delete_error']   = 'غير قادر على حذف النشاط.';

// ------------------------------------------------------------------------
// Modules activities lines.
// ------------------------------------------------------------------------

// Language module.
$lang['act_language_enable'] = 'تفعيل اللغة: %s.';
$lang['act_language_disable'] = 'تعطيل اللغة: %s.';
$lang['act_language_default'] = 'تحديد اللغة الافتراضية: %s';

// Media module.
$lang['act_media_upload'] = 'تحميل العنصر: #%s';
$lang['act_media_update'] = 'تحديث العنصر: #%s';
$lang['act_media_delete'] = 'حذف العنصر: #%s';

// Users module.
$lang['act_user_register']  = 'انضم إلى الموقع.';
$lang['act_user_resend']    = 'طلب رمز التفعيل: <abbr title="%s">%s</abbr>';
$lang['act_user_restore']   = 'استعاد الحساب.';
$lang['act_user_activated'] = 'تفعيل البريد الالكتروني.';
$lang['act_user_recover']   = 'طلب رمز تعين كلمة المرور: <abbr title="%s">%s</abbr>';
$lang['act_user_reset']     = 'إعادة تعيين كلمة المرور.';
$lang['act_user_login']     = 'تسجيل الدخول.';

$lang['act_user_create']     = 'إنشاء المستخدم: #%s';
$lang['act_user_update']     = 'تحديث بيانات الحساب: #%s';
$lang['act_user_activate']   = 'تفعيل الحساب: #%s';
$lang['act_user_deactivate'] = 'تعطيل الحساب: #%s';
$lang['act_user_delete']     = 'حذف الحساب: #%s';
$lang['act_user_restore']    = 'إستعادة الحساب: #%s';
$lang['act_user_remove']     = 'إزالة الحساب: #%s';

// Menus module.
$lang['act_menus_add_menu']         = 'إضافة القائمة: #%s';
$lang['act_menus_edit_menu']        = 'تعديل القائمة: #%s';
$lang['act_menus_update_locations'] = 'تحديث موقع القوائم.';
$lang['act_menus_add_item']         = 'إضافة عنصر القائمة: #%s';
$lang['act_menus_update_items']     = 'تحديث عنصر القائمة: #%s';
$lang['act_menus_delete_menu']      = 'حذف القائمة: #%s';
$lang['act_menus_delete_item']      = 'حذف عنصر القائمة: #%s';

// Plugins Module.
$lang['act_plugin_activate']   = 'تفعيل الاضافة: %s';
$lang['act_plugin_deactivate'] = 'تعطيل الاضافة: %s';
$lang['act_plugin_delete']     = 'حذف الاضافة: %s';

// Themes plugin.
$lang['act_themes_activate'] = 'تفعيل القالب: %s';
$lang['act_themes_delete']   = 'حدف القالب: %s';
$lang['act_themes_install']  = 'تثبيت القالب: %s';
$lang['act_themes_upload']   = 'تحميل القالب: %s';

// Settings Module.
$lang['act_settings_admin'] = 'تحديث إعدادات الموقع: %s';
$lang['act_settings_user']  = 'تحديث إعدادات الحساب: %s';
