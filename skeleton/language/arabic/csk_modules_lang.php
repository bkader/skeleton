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
 * Modules language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

$lang['CSK_MODULES']         = 'موديولات';
$lang['CSK_MODULES_MODULE']  = 'موديول';
$lang['CSK_MODULES_MODULES'] = 'موديولات';

// Modules actions.
$lang['CSK_MODULES_ACTIVATE']   = 'تفعيل';
$lang['CSK_MODULES_ADD']        = 'موديول جديد';
$lang['CSK_MODULES_DEACTIVATE'] = 'تعطيل';
$lang['CSK_MODULES_DELETE']     = 'حذف';
$lang['CSK_MODULES_DETAILS']    = 'تفاصيل';
$lang['CSK_MODULES_INSTALL']    = 'تنصيب';
$lang['CSK_MODULES_SETTINGS']   = 'إعدادات';
$lang['CSK_MODULES_UPLOAD']     = 'رفع موديول';

// Upload tip.
$lang['CSK_MODULES_UPLOAD_TIP'] = 'إذا كان الموديول في ملف .zip مضغوط, يمكنك تنصيبه بواسطة رفعه هنا.';

// Confirmation messages.
$lang['CSK_MODULES_CONFIRM_ACTIVATE']   = 'هل أنت متأكد من أنك تريد تفعيل الموديول %s؟';
$lang['CSK_MODULES_CONFIRM_DEACTIVATE'] = 'هل أنت متأكد من أنك تريد تعطيل الموديول %s؟';
$lang['CSK_MODULES_CONFIRM_DELETE']     = 'هل أنت متأكد من أنك تريد حذف الموديول %s وكل بياناته؟';

// Success messages.
$lang['CSK_MODULES_SUCCESS_ACTIVATE']   = 'تم تفعيل الموديول %s بنجاح.';
$lang['CSK_MODULES_SUCCESS_DEACTIVATE'] = 'تم إلغاء تفعيل الموديول %s بنجاح.';
$lang['CSK_MODULES_SUCCESS_DELETE']     = 'تم حذف الموديول %s بنجاح.';
$lang['CSK_MODULES_SUCCESS_INSTALL']    = 'تم تنصيب الموديول بنجاح.';
$lang['CSK_MODULES_SUCCESS_UPLOAD']     = 'تم تحميل الموديول بنجاح.';

// Error messages.
$lang['CSK_MODULES_ERROR_ACTIVATE']      = 'تعذر تفعيل الموديول %s.';
$lang['CSK_MODULES_ERROR_DEACTIVATE']    = 'تعذر إلغاء تفعيل الموديول %s.';
$lang['CSK_MODULES_ERROR_DELETE']        = 'تعذر حذف الموديول %s.';
$lang['CSK_MODULES_ERROR_INSTALL']       = 'تعذر تنصيب الموديول %s.';
$lang['CSK_MODULES_ERROR_UPLOAD']        = 'تعذر تحميل الموديول.';
$lang['CSK_MODULES_ERROR_DELETE_ACTIVE'] = 'يجب عليك إلغاء تفعيل الموديول %s قبل حذفه.';

// Errors when performing actions.
$lang['CSK_MODULES_ERROR_MODULE_MISSING'] = 'هذه الموديول غير موجود.';

// Module upload location.
$lang['CSK_MODULES_LOCATION_SELECT']      = '&#151; اختر موقعا &#151;';
$lang['CSK_MODULES_LOCATION_PUBLIC']      = 'المجلد العام (public)';
$lang['CSK_MODULES_LOCATION_APPLICATION'] = 'مجلد التطبيق (application)';

// Module details.
$lang['CSK_MODULES_DETAILS']      = 'تفاصيل الموديول';
$lang['CSK_MODULES_NAME']         = 'الاسم';
$lang['CSK_MODULES_FOLDER']       = 'المجلد';
$lang['CSK_MODULES_URI']          = 'موقع الموديول';
$lang['CSK_MODULES_DESCRIPTION']  = 'الوصف';
$lang['CSK_MODULES_VERSION']      = 'النسخة';
$lang['CSK_MODULES_LICENSE']      = 'الرخصة';
$lang['CSK_MODULES_LICENSE_URI']  = 'موقع الرخصة';
$lang['CSK_MODULES_AUTHOR']       = 'المؤلف';
$lang['CSK_MODULES_AUTHOR_URI']   = 'موقع المؤلف';
$lang['CSK_MODULES_AUTHOR_EMAIL'] = 'بريد للمؤلف';
$lang['CSK_MODULES_TAGS']         = 'الوسوم';
$lang['CSK_MODULES_ZIP']          = 'أرشيف ZIP الموديول';

// With extra string after.
$lang['CSK_MODULES_DETAILS_NAME'] = 'تفاصيل الموديول: %s';
$lang['CSK_MODULES_VERSION_NUM']  = 'النسخة: %s';
$lang['CSK_MODULES_LICENSE_NAME'] = 'الرخصة: %s';
$lang['CSK_MODULES_AUTHOR_NAME']  = 'بواسطة %s';
$lang['CSK_MODULES_TAGS_LIST']    = 'الوسوم: %s';

// Module install filters.
$lang['CSK_MODULES_FILTER_FEATURED']    = 'البارز';
$lang['CSK_MODULES_FILTER_POPULAR']     = 'الأكثر شعبية';
$lang['CSK_MODULES_FILTER_RECOMMENDED'] = 'موصى به';
$lang['CSK_MODULES_FILTER_NEW']         = 'جديد';
$lang['CSK_MODULES_SEARCH']             = 'بحث في الموديولات...';

// Module details with links.
$lang['CSK_MODULES_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">الدعم</a>';
