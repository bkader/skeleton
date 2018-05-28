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
 * Dashboard main language file (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.1
 */
// ------------------------------------------------------------------------
// Navbar items.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_DASHBOARD']   = 'لوحة التحكم';
$lang['CSK_ADMIN_ADMIN_PANEL'] = 'لوحة التحكم';

// System menu.
$lang['CSK_ADMIN_SYSTEM']             = 'النظام';
$lang['CSK_ADMIN_GLOBAL_SETTINGS']    = 'الاعدادات العامة';
$lang['CSK_ADMIN_SYSTEM_INFORMATION'] = 'معلومات النظام';

// Users menu.
$lang['CSK_ADMIN_USERS']        = 'المستخدمون';
$lang['CSK_ADMIN_USERS_MANAGE'] = 'ادارة المستخدمين';
$lang['CSK_ADMIN_USERS_GROUPS'] = 'مجموعات المستخدمين';
$lang['CSK_ADMIN_USERS_LEVELS'] = 'مستويات الوصول';

// Content menu.
$lang['CSK_ADMIN_CONTENT'] = 'المحتويات';

// Components Menu.
$lang['CSK_ADMIN_COMPONENTS'] = 'التطبيقات';

// Extensions menu.
$lang['CSK_ADMIN_EXTENSIONS']        = 'الملحقات';
$lang['CSK_ADMIN_MODULES']           = 'الموديولات';
$lang['CSK_ADMIN_PLUGINS']           = 'الإضافات';
$lang['CSK_ADMIN_THEMES']            = 'القوالب';
$lang['CSK_ADMIN_LANGUAGES']         = 'اللغات';
$lang['CSK_ADMIN_LANGUAGES_DEFAULT'] = 'اللغة - افتراضية';

// Reports menu.
$lang['CSK_ADMIN_REPORTS'] = 'الأنشطة';

// Help menu.
$lang['CSK_ADMIN_DOCUMENTATION'] = 'دليل سكلتون';
$lang['CSK_ADMIN_TRANSLATIONS']  = 'ترجمات سكلتون';
$lang['CSK_ADMIN_SKELETON_SHOP'] = 'سوق سكلتون';

// ------------------------------------------------------------------------
// General confirmation messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_CONFIRM_ACTIVATE']         = 'هل أنت متأكد من أنك تريد تفعيل %s؟';
$lang['CSK_ADMIN_CONFIRM_DEACTIVATE']       = 'هل أنت متأكد من أنك تريد تعطيل %s؟';
$lang['CSK_ADMIN_CONFIRM_DELETE']           = 'هل أنت متأكد من أنك تريد حذف %s؟';
$lang['CSK_ADMIN_CONFIRM_DELETE_PERMANENT'] = 'هل أنت متأكد من أنك تريد حذف %s وكل بياناته؟';
$lang['CSK_ADMIN_CONFIRM_DELETE_SELECTED']  = 'هل أنت متأكد من أنك تريد حذف %s المحددة وكل بياناتها؟';
$lang['CSK_ADMIN_CONFIRM_DISABLE']          = 'هل أنت متأكد من أنك تريد تعطيل %s؟';
$lang['CSK_ADMIN_CONFIRM_ENABLE']           = 'هل أنت متأكد من أنك تريد تفعيل %s؟';
$lang['CSK_ADMIN_CONFIRM_INSTALL']          = 'هل أنت متأكد من أنك تريد تثبيت %s؟';
$lang['CSK_ADMIN_CONFIRM_RESTORE']          = 'هل أنت متأكد من أنك تريد استعادة %s؟';
$lang['CSK_ADMIN_CONFIRM_UPLOAD']           = 'هل أنت متأكد من أنك تريد رفع %s؟';

// ------------------------------------------------------------------------
// General success messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_SUCCESS_ACTIVATE']         = 'تم تفعيل %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_DEACTIVATE']       = 'تم تعطيل %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_DELETE']           = 'تم حذف %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_DELETE_PERMANENT'] = 'تم حذف %s وكل بياناته بنجاح.';
$lang['CSK_ADMIN_SUCCESS_DELETE_SELECTED']  = 'تم حذف %s المحددة وكل بياناتها بنجاح.';
$lang['CSK_ADMIN_SUCCESS_DISABLE']          = 'تم تعطيل %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_ENABLE']           = 'تم تفعيل %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_INSTALL']          = 'تم تثبيت %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_RESTORE']          = 'تم استعادة %s بنجاح.';
$lang['CSK_ADMIN_SUCCESS_UPLOAD']           = 'تم رفع %s بنجاح.';

// ------------------------------------------------------------------------
// General Error messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_ERROR_ACTIVATE']         = 'تعذر تفعيل %s.';
$lang['CSK_ADMIN_ERROR_DEACTIVATE']       = 'تعذر تعطيل %s.';
$lang['CSK_ADMIN_ERROR_DELETE']           = 'تعذر حذف %s.';
$lang['CSK_ADMIN_ERROR_DELETE_PERMANENT'] = 'تعذر حذف %s وكل بياناته.';
$lang['CSK_ADMIN_ERROR_DELETE_SELECTED']  = 'تعذر حذف %s المحددة وكل بياناتها.';
$lang['CSK_ADMIN_ERROR_DISABLE']          = 'تعذر تعطيل %s.';
$lang['CSK_ADMIN_ERROR_ENABLE']           = 'تعذر تفعيل %s.';
$lang['CSK_ADMIN_ERROR_INSTALL']          = 'تعذر تثبيت %s.';
$lang['CSK_ADMIN_ERROR_RESTORE']          = 'تعذر استعادة %s.';
$lang['CSK_ADMIN_ERROR_UPLOAD']           = 'تعذر رفع %s.';

// ------------------------------------------------------------------------
// Footer section.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_FOOTER_TEXT']  = 'شكرًا لك لاستخدامك <a href="%s" target="_blank">كوديجنتر سكلتون</a>.';
$lang['CSK_ADMIN_VERSION_TEXT'] = 'النسخة: <strong>%s</strong> &#124; {elapsed_time}';

// ------------------------------------------------------------------------
// Misc.
// ------------------------------------------------------------------------

// Table actions.
$lang['CSK_ADMIN_ACTION']  = 'الإجراء';
$lang['CSK_ADMIN_ACTIONS'] = 'الإجراءات';

// ------------------------------------------------------------------------
// Different statuses.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_STATUS']   = 'الوضع';
$lang['CSK_ADMIN_STATUSES'] = 'الأوضاع';

$lang['CSK_ADMIN_ACTIVATED']   = 'مفعّل';
$lang['CSK_ADMIN_ACTIVE']      = 'نشيط';
$lang['CSK_ADMIN_ADDED']       = 'أضيف';
$lang['CSK_ADMIN_CANCELED']    = 'ألغي';
$lang['CSK_ADMIN_CREATED']     = 'انشيء';
$lang['CSK_ADMIN_DEACTIVATED'] = 'معطل';
$lang['CSK_ADMIN_DELETED']     = 'محذوف';
$lang['CSK_ADMIN_DISABLED']    = 'معطل';
$lang['CSK_ADMIN_EDITED']      = 'معدل';
$lang['CSK_ADMIN_ENABLED']     = 'مفعّل';
$lang['CSK_ADMIN_INACTIVE']    = 'غير مفعّل';
$lang['CSK_ADMIN_REMOVED']     = 'تمت الإزالة';
$lang['CSK_ADMIN_SAVED']       = 'تم الحفظ';
$lang['CSK_ADMIN_UPDATED']     = 'تم التحديث';
