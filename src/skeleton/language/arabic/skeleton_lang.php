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
 * Main application language file (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */

// ------------------------------------------------------------------------
// General Buttons and Links.
// ------------------------------------------------------------------------
$lang['home']       = 'الرئيسية';
$lang['click_here'] = 'انقر هنا';
$lang['settings']   = 'إعدادات';

// ------------------------------------------------------------------------
// Forms Input.
// ------------------------------------------------------------------------

$lang['name']        = 'الاسم';
$lang['title']       = 'العنوان';
$lang['description'] = 'الوصف';
$lang['content']     = 'المحتوى';
$lang['unspecified'] = 'غير محدد';
$lang['slug']        = 'السبيكة';
$lang['order']       = 'الترتيب';
$lang['url']         = 'URL';

$lang['meta_title']       = 'عنوان ميتا';
$lang['meta_description'] = 'وصف ميتا';
$lang['meta_keywords']    = 'كلمات دلالية';

$lang['email']   = 'البريد الإلكتروني';
$lang['captcha'] = 'كلمة التحقق';
$lang['upload']  = 'تحميل';
$lang['uploads'] = 'تحميلات';

// Selection options.
$lang['none'] = 'لا شيء';
$lang['both'] = 'على حد سواء';
$lang['all']  = 'الكل';

// "More" links.
$lang['more']         = 'أكثر';
$lang['more_details'] = 'المزيد';
$lang['view_more']    = 'عرض المزيد';

// Yes and No.
$lang['no']  = 'لا';
$lang['yes'] = 'نعم';

// ------------------------------------------------------------------------
// Application buttons.
// ------------------------------------------------------------------------
$lang['action']  = 'الفعل';
$lang['actions'] = 'الأفعال';

$lang['add']    = 'إضافة';
$lang['new']    = 'جديد';
$lang['create'] = 'إنشاء';

$lang['edit']   = 'تعديل';
$lang['update'] = 'تحديث';
$lang['save']   = 'حفظ';

$lang['delete'] = 'حذف';
$lang['remove'] = 'إزالة';

$lang['activate']   = 'تفعيل';
$lang['deactivate'] = 'تعطيل';

$lang['enable']  = 'تفعيل';
$lang['disable'] = 'تعطيل';

$lang['back']   = 'الى الخلف';
$lang['cancel'] = 'إلغاء';

$lang['advanced'] = 'أكثر';

// Changes buttons.
$lang['discard_changed'] = 'تجاهل التغييرات';
$lang['save_changes']    = 'حفظ التغييرات';

// Different statuses.
$lang['status']   = 'الوضع';
$lang['statuses'] = 'الأوضاع';

$lang['added']   = 'أضيف';
$lang['created'] = 'انشء';

$lang['edited']  = 'معدل';
$lang['updated'] = 'محدث';
$lang['saved']   = 'حفظ';

$lang['deleted'] = 'حذف';
$lang['removed'] = 'أزيل';

$lang['activated']   = 'مفعّل';
$lang['deactivated'] = 'غير مفعّل';

$lang['active']   = 'مفعّل';
$lang['inactive'] = 'غير مفعّل';

$lang['enabled']  = 'مفعّل';
$lang['disabled'] = 'غير مفعّل';

$lang['canceled'] = 'ألغي';

// Actions performed by.
$lang['created_by']     = 'انشء بواسطة';
$lang['updated_by']     = 'عدل بواسطة';
$lang['deleted_by']     = 'حذف بواسطة';
$lang['removed_by']     = 'أزيل بواسطة';
$lang['activated_by']   = 'فعل بواسطة';
$lang['deactivated_by'] = 'معطل بواسطة';
$lang['enabled_by']     = 'مكن بواسطة';
$lang['disabled_by']    = 'عطل بواسطة';
$lang['canceled_by']    = 'ألغى بواسطة';

// ------------------------------------------------------------------------
// General notices and messages.
// ------------------------------------------------------------------------

// Error messages.
$lang['error_csrf']              = 'لم يمر هذا النموذج ضوابط الأمان.';
$lang['error_safe_url']          = 'هذا الإجراء لم يمر ضوابط الأمان.';
$lang['error_captcha']           = 'كود الكابتشا الذي أدخلته غير صحيح.';
$lang['error_fields_required']   = 'جميع الحقول مطلوبة.';
$lang['error_permission']        = 'ليس لديك الصلاحية لدخول هذه الصفحة.';
$lang['error_logged_in']         = 'انت داخل.';
$lang['error_logged_out']        = 'يجب عليك تسجيل الدخول للوصول إلى هذه الصفحة.';
$lang['error_account_missing']   = 'هذا المستخدم غير موجود.';
$lang['error_action_permission'] = 'ليس لديك الصلاحية لتنفيذ هذا الإجراء.';

// ------------------------------------------------------------------------
// Form validation lines.
// ------------------------------------------------------------------------

$lang['form_validation_alpha_extra']       = 'يحتوي الحقل {field} على أحرف أبجدية رقمية ومسافات ونقاط وشرطات سفلية وشرطات فقط.';
$lang['form_validation_check_credentials'] = 'اسم المستخدم/عنوان البريد الإلكتروني و/أو كلمة المرور غير صالحة.';
$lang['form_validation_current_password']  = 'كلمة المرور الحالية الخاصة بك غير صحيحة.';
$lang['form_validation_unique_email']      = 'هذا البريد الإلكتروني قيد الاستخدام.';
$lang['form_validation_unique_username']   = 'اسم المستخدم هذا غير متوفر.';
$lang['form_validation_user_exists']       = 'لم يتم العثور على مستخدم بهذا الاسم أو عنوان البريد الإلكتروني.';

// ========================================================================
// Dashboard Lines.
// ========================================================================

$lang['admin_panel'] = 'لوحة الادارة';
$lang['dashboard']   = 'لوحة القيادة';
$lang['view_site']   = 'زيارة الموقع';

// Confirmation before action.
$lang['are_you_sure'] = 'هل أنت متأكد أنك تريد %s?';

// Dashboard footer.
$lang['admin_footer_text'] = 'شكرًا لك لاستخدامك <a href="https://goo.gl/jb4nQC" target="_blank">كوديجنتر سكلتون</a>.';

// ------------------------------------------------------------------------
// Dashboard sections (singular and plural forms).
// ------------------------------------------------------------------------

// Users.
$lang['user']  = 'العضو';
$lang['users'] = 'الأعضاء';

// Media.
$lang['media']   = 'الوسائط';
$lang['library'] = 'مكتبة الوسائط';

// Themes.
$lang['theme']  = 'القالب';
$lang['themes'] = 'القوالب';

// Menus.
$lang['menu']  = 'القائمة';
$lang['menus'] = 'القوائم';

// Menus.
$lang['plugin']  = 'إضافة';
$lang['plugins'] = 'إضافات';

// Languages.
$lang['language']  = 'اللغة';
$lang['languages'] = 'اللغات';

// Activities.
$lang['activity']   = 'النشاط';
$lang['activities'] = 'الأنشطة';
