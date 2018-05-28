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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins language file (Arabic)
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

// Main lines.
$lang['CSK_PLUGINS']         = 'الإضافات';
$lang['CSK_PLUGINS_PLUGIN']  = 'الإضافة';
$lang['CSK_PLUGINS_PLUGINS'] = 'الإضافات';

// Settings lines.
$lang['CSK_PLUGINS_SETTINGS']      = 'إعدادات الإضافة';
$lang['CSK_PLUGINS_SETTINGS_NAME'] = 'إعدادات الإضافة: %s';

// Plugins actions.
$lang['CSK_PLUGINS_ACTIVATE']   = 'تفعيل';
$lang['CSK_PLUGINS_ADD']        = 'إضافة جديدة';
$lang['CSK_PLUGINS_DEACTIVATE'] = 'تعطيل';
$lang['CSK_PLUGINS_DELETE']     = 'حذف';
$lang['CSK_PLUGINS_DETAILS']    = 'تفاصيل';
$lang['CSK_PLUGINS_INSTALL']    = 'تنصيب الاضافة';
$lang['CSK_PLUGINS_SETTINGS']   = 'إعدادات';
$lang['CSK_PLUGINS_UPLOAD']     = 'رفع إضافة';

// Upload tip.
$lang['CSK_PLUGINS_UPLOAD_TIP'] = 'إذا كانت الإضافة في ملف .zip مضغوط, يمكنك تنصيبها بواسطة رفعها هنا.';

// Confirmation messages.
$lang['CSK_PLUGINS_CONFIRM_ACTIVATE']   = 'هل أنت متأكد من أنك تريد تفعيل %s؟';
$lang['CSK_PLUGINS_CONFIRM_DEACTIVATE'] = 'هل أنت متأكد من أنك تريد تعطيل %s؟';
$lang['CSK_PLUGINS_CONFIRM_DELETE']     = 'هل أنت متأكد من أنك تريد حذف %s وبياناتها؟';

// Success messages.
$lang['CSK_PLUGINS_SUCCESS_ACTIVATE']        = 'تم تفعيل الاضافة %s بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_DEACTIVATE']      = 'تم تعطيل الاضافة %s بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_DELETE']          = 'تم حذف الاضافة %s بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_INSTALL']         = 'تم تنصيب الاضافة بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_SETTINGS']        = 'تم تحديث إعدادات الاضافة بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_UPLOAD']          = 'تم تحميل الاضافة بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_BULK_ACTIVATE']   = 'تم تفعيل الإضافات المحددة بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DEACTIVATE'] = 'تم تعطيل الإضافات المحددة بنجاح.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DELETE']     = 'تم حذف الإضافات المحددة بنجاح.';

// Error messages.
$lang['CSK_PLUGINS_ERROR_ACTIVATE']        = 'تعذر تفعيل الاضافة %s.';
$lang['CSK_PLUGINS_ERROR_DEACTIVATE']      = 'تعذر تعطيل الاضافة %s.';
$lang['CSK_PLUGINS_ERROR_DELETE']          = 'تعذر حذف الاضافة %s.';
$lang['CSK_PLUGINS_ERROR_INSTALL']         = 'تعذر تنصيب الاضافة.';
$lang['CSK_PLUGINS_ERROR_SETTINGS']        = 'تعذر تحديث إعدادات الاضافة.';
$lang['CSK_PLUGINS_ERROR_UPLOAD']          = 'تعذر تحميل الاضافة.';
$lang['CSK_PLUGINS_ERROR_BULK_ACTIVATE']   = 'تعذر تفعيل الإضافات المحددة.';
$lang['CSK_PLUGINS_ERROR_BULK_DEACTIVATE'] = 'تعذر تعطيل الإضافات المحددة.';
$lang['CSK_PLUGINS_ERROR_BULK_DELETE']     = 'تعذر حذف الإضافات المحددة.';

// Errors when performing actions.
$lang['CSK_PLUGINS_ERROR_PLUGIN_MISSING']    = 'هذه الاضافة غير موجودة.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_DISABLED'] = 'يمكنك فقط تحديث إعدادات الإضافات المفعّلة.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_MISSING']  = 'لا تحتوي هذه الاضافة على صفحة إعدادات.';

// Plugin details.
$lang['CSK_PLUGINS_DETAILS']      = 'تفاصيل الاضافة';
$lang['CSK_PLUGINS_NAME']         = 'الاسم';
$lang['CSK_PLUGINS_FOLDER']       = 'المجلد';
$lang['CSK_PLUGINS_URI']          = 'موقع الاضافة';
$lang['CSK_PLUGINS_DESCRIPTION']  = 'الوصف';
$lang['CSK_PLUGINS_VERSION']      = 'النسخة';
$lang['CSK_PLUGINS_LICENSE']      = 'الرخصة';
$lang['CSK_PLUGINS_LICENSE_URI']  = 'موقع الرخصة';
$lang['CSK_PLUGINS_AUTHOR']       = 'المؤلف';
$lang['CSK_PLUGINS_AUTHOR_URI']   = 'موقع المؤلف';
$lang['CSK_PLUGINS_AUTHOR_EMAIL'] = 'بريد للمؤلف';
$lang['CSK_PLUGINS_TAGS']         = 'الوسوم';
$lang['CSK_PLUGINS_ZIP']          = 'أرشيف ZIP الاضافة';

// With extra string after.
$lang['CSK_PLUGINS_DETAILS_NAME'] = 'تفاصيل الاضافة: %s';
$lang['CSK_PLUGINS_VERSION_NUM']  = 'النسخة: %s';
$lang['CSK_PLUGINS_LICENSE_NAME'] = 'الرخصة: %s';
$lang['CSK_PLUGINS_AUTHOR_NAME']  = 'بواسطة %s';
$lang['CSK_PLUGINS_TAGS_LIST']    = 'الوسوم: %s';

// Plugins filters.
$lang['CSK_PLUGINS_FILTER_ALL']      = 'الكل (%s)';
$lang['CSK_PLUGINS_FILTER_ACTIVE']   = 'مفعّلة (%s)';
$lang['CSK_PLUGINS_FILTER_INACTIVE'] = 'غير مفعّلة (%s)';

// Plugin install filters.
$lang['CSK_PLUGINS_FILTER_FEATURED']    = 'البارزة';
$lang['CSK_PLUGINS_FILTER_POPULAR']     = 'الأكثر شعبية';
$lang['CSK_PLUGINS_FILTER_RECOMMENDED'] = 'موصى بها';
$lang['CSK_PLUGINS_FILTER_NEW']         = 'جديدة';
$lang['CSK_PLUGINS_SEARCH']             = 'بحث في الإضافات...';

// Plugin details with links.
$lang['CSK_PLUGINS_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">الدعم</a>';
