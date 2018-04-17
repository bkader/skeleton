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
 * Theme Module - Admin Language (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.4.0
 */

// Theme: singular and plural forms.
$lang['sth_theme']  = 'قوالب';
$lang['sth_themes'] = 'القوالب';

// Dashboard title.
$lang['sth_theme_settings'] = 'إعدادات القوالب';

// Theme actions and buttons.
$lang['sth_theme_activate'] = 'تفعيل';
$lang['sth_theme_add']      = 'أضف قوالب';
$lang['sth_theme_delete']   = 'حذف';
$lang['sth_theme_details']  = 'تفاصيل';
$lang['sth_theme_install']  = 'تثبيت';
$lang['sth_theme_upload']   = 'رفع قالب';

$lang['sth_theme_upload_tip'] = 'إذا كان لديك قالب بصيغة .zip، فيمكنك تنصيبه عن طريق رفعه من هنا.';

// Confirmation messages.
$lang['sth_theme_activate_confirm'] = 'هل أنت متأكد من أنك تريد تفعيل هذا القالب؟';
$lang['sth_theme_delete_confirm']   = 'هل أنت متأكد من أنك تريد حذف هذا القالب؟';
$lang['sth_theme_install_confirm']  = 'هل أنت متأكد من أنك تريد تثبيت هذا القوالب؟';
$lang['sth_theme_upload_confirm']   = 'هل أنت متأكد من أنك تريد تحميل هذا القالب؟';

// Success messages.
$lang['sth_theme_activate_success'] = 'تم تفعيل القالب بنجاح.';
$lang['sth_theme_delete_success']   = 'تم حذف القالب بنجاح.';
$lang['sth_theme_install_success']  = 'تم تثبت القالب بنجاح.';
$lang['sth_theme_upload_success']   = 'تم تحميل القالب بنجاح.';

// Error messages.
$lang['sth_theme_activate_error'] = 'تعذر تفعيل القالب.';
$lang['sth_theme_delete_error']   = 'تعذر حذف القالب.';
$lang['sth_theme_install_error']  = 'تعذر تثبيت القالب.';
$lang['sth_theme_upload_error']   = 'تعذر تحميل القالب.';
$lang['sth_theme_delete_active']  = 'لا يمكنك حذف القالب الممكن حاليًا.';

// Theme details.
$lang['sth_details']      = 'تفاصيل القالب';
$lang['sth_details_name'] = 'تفاصيل القالب: %s';
$lang['sth_name']         = 'الاسم';
$lang['sth_folder']       = 'المجلد';
$lang['sth_theme_uri']    = 'رابط القالب';
$lang['sth_description']  = 'الوصف';
$lang['sth_version']      = 'النسخة';
$lang['sth_license']      = 'الرخصة';
$lang['sth_license_uri']  = 'رابط الرخصة';
$lang['sth_author']       = 'المؤلف';
$lang['sth_author_uri']   = 'رابط المؤلف';
$lang['sth_author_email'] = 'بريد للمؤلف';
$lang['sth_tags']         = 'الوسوم';
$lang['sth_screenshot']   = 'الصورة';
$lang['sth_theme_zip']   = 'أرشيف ZIP القالب';

// Theme install filters.
$lang['sth_theme_featured'] = 'المميّزة';
$lang['sth_theme_popular']  = 'الأكثر شعبية';
$lang['sth_theme_new']      = 'الأحدث';
$lang['sth_theme_search']   = 'بحث عن قوالب...';

// Details with links:
$lang['sth_theme_name']         = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_license']      = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author']       = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author_email'] = '<a href="mailto:%1$s" target="_blank" rel="nofollow">الدعم</a>';
