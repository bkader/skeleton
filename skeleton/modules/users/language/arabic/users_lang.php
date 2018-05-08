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
 * Users Module - Users Language (Arabic)
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

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'تسجيل الدخول';
$lang['logout']          = 'خروج';
$lang['register']        = 'تسجيل';
$lang['create_account']  = 'إنشاء حساب';
$lang['forgot_password'] = 'هل نسيت كلمة المرور؟';
$lang['lost_password']   = 'كلمة مرور مفقودة';
$lang['send_link']       = 'أرسل الرابط';
$lang['resend_link']     = 'إعادة إرسال الرابط';
$lang['restore_account'] = 'استعادة الحساب';

$lang['profile']      = 'الملف الشخصي';
$lang['view_profile'] = 'عرض الملف الشخصية';
$lang['edit_profile'] = 'تعديل الملف الشخصي';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'اسم المستخدم';
$lang['identity']          = 'اسم المستخدم أو البريد الالكتروني';

$lang['email_address']     = 'البريد الإلكتروني';
$lang['new_email_address'] = 'البريد الإلكتروني الجديد';

$lang['password']          = 'كلمه السر';
$lang['new_password']      = 'كلمة السر الجديدة';
$lang['confirm_password']  = 'تأكيد كلمة المرور';
$lang['current_password']  = 'كلمة السر الحالية';

$lang['first_name']        = 'الاسم الاول';
$lang['last_name']         = 'الكنية';
$lang['full_name']         = 'الاسم الكامل';

$lang['gender']            = 'الجنس';
$lang['male']              = 'ذكر';
$lang['female']            = 'أنثى';

$lang['company']  = 'الشركة';
$lang['phone']    = 'الهاتف';
$lang['address']  = 'العنوان';
$lang['location'] = 'الموقع';
$lang['avatar']   = 'الصورة';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title']   = 'تسجيل';
$lang['us_register_heading'] = 'إنشاء حساب';

$lang['us_register_success']     = 'تم إنشاء الحساب بنجاح. يمكنك الآن الدخول.';
$lang['us_register_info']        = 'تم إنشاء الحساب بنجاح. تم إرسال رابط التنشيط إليك.';
$lang['us_register_info_manual'] = 'جميع الحسابات تتطلب موافقة من مسؤول الموقع قبل أن تكون نشطة. سوف تتلقى رسالة بمجرد تفعيل حسابك.';
$lang['us_register_error']       = 'تعذر إنشاء الحساب.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'لم يعد رابط تنشيط الحساب هذا صالحا.';
$lang['us_activate_error']       = 'تعذر تنشيط الحساب.';
$lang['us_activate_success']     = 'تم تنشيط الحساب بنجاح. يمكنك الآن الدخول.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title']   = 'إعادة إرسال رابط التنشيط';
$lang['us_resend_heading'] = 'إعادة إرسال الرابط';

$lang['us_resend_notice']  = 'أدخل اسم المستخدم أو عنوان البريد الإلكتروني، وسنرسل إليك رابطا لتنشيط حسابك.';
$lang['us_resend_error']   = 'تعذر إعادة إرسال رابط تنشيط الحساب.';
$lang['us_resend_enabled'] = 'تم تمكين هذا الحساب من قبل.';
$lang['us_resend_success'] = 'تمت إعادة إرسال رابط تنشيط الحساب بنجاح. تحقق من البريد الوارد أو الرسائل غير المرغوب فيها.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'تسجيل الدخول';
$lang['us_login_heading'] = 'دخول الأعضاء';
$lang['remember_me']      = 'تذكرني';

$lang['us_wrong_credentials'] = 'اسم المستخدم/عنوان البريد الإلكتروني و/أو كلمة المرور غير صالحة.';
$lang['us_account_missing']  = 'هذا المستخدم غير موجود.';
$lang['us_account_disabled']  = 'حسابك ليس نشطًا بعد. استخدم الرابط الذي تم إرساله إليك أو %s لتلقي رابط جديد.';
$lang['us_account_banned']    = 'هذا المستخدم ممنوع من الموقع.';
$lang['us_account_deleted']   = 'تم حذف حسابك ولكن لم تتم إزالته بعد من قاعدة البيانات. %s إذا كنت ترغب في استعادته.';
$lang['us_account_deleted_admin']   = 'تم حذف حسابك من قبل مسؤول وبالتالي لا يمكنك استعادته. لا تتردد في الاتصال بنا للحصول على مزيد من التفاصيل.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'كلمة مرور مفقودة';
$lang['us_recover_heading'] = 'كلمة مرور مفقودة';

$lang['us_recover_notice']  = 'أدخل اسم المستخدم أو عنوان البريد الإلكتروني، وسنرسل إليك رابطا لإعادة تعيين كلمة المرور.';
$lang['us_recover_success'] = 'تم إرسال رابط إعادة تعيين كلمة المرور بنجاح.';
$lang['us_recover_error']   = 'تعذر إرسال رابط إعادة تعيين كلمة المرور.';

// ------------------------------------------------------------------------
// Reset password page.
// ------------------------------------------------------------------------
$lang['us_reset_title']   = 'إعادة تعيين كلمة المرور';
$lang['us_reset_heading'] = 'إعادة تعيين كلمة المرور';

$lang['us_reset_invalid_key'] = 'لم يعد رابط إعادة تعيين كلمة المرور صالحا.';
$lang['us_reset_error']       = 'تعذر إعادة تعيين كلمة المرور.';
$lang['us_reset_success']     = 'تمت إعادة تعيين كلمة المرور بنجاح.';

// ------------------------------------------------------------------------
// Restore account page.
// ------------------------------------------------------------------------
$lang['us_restore_title']   = 'استعادة الحساب';
$lang['us_restore_heading'] = 'استعادة الحساب';

$lang['us_restore_notice']  = 'أدخل اسم المستخدم/عنوان البريد الإلكتروني وكلمة المرور لاستعادة حسابك.';
$lang['us_restore_deleted'] = 'يمكن استعادة الحسابات المحذوفة فقط.';
$lang['us_restore_error']   = 'تعذر استعادة الحساب.';
$lang['us_restore_success'] = 'تمت استعادة الحساب بنجاح. مرحبا بعودتك!';

// ========================================================================
// Dashboard lines.
// ========================================================================

$lang['user']  = 'العضو';
$lang['users'] = 'الأعضاء';

// Main dashboard heading.
$lang['us_manage_users'] = 'إدارة الأعضاء';

// Users actions.
$lang['add_user']        = 'إضافة الحساب';
$lang['edit_user']       = 'تعديل الحساب';
$lang['activate_user']   = 'تفعيل الحساب';
$lang['deactivate_user'] = 'تعطيل الحساب';
$lang['delete_user']     = 'حذف الحساب';
$lang['restore_user']    = 'إستعادة الحساب';
$lang['remove_user']     = 'إزالة الحساب';

// Users roles.
$lang['role']  = 'الرتبة';
$lang['roles'] = 'المراتب';

$lang['regular']       = 'عادي';
$lang['premium']       = 'متميز';
$lang['author']        = 'كاتب';
$lang['editor']        = 'محرر';
$lang['admin']         = 'مدير';
$lang['administrator'] = 'مدير';

// Users statuses.
$lang['active']   = 'مفعّل';
$lang['inactive'] = 'غير مفعّل';

// Confirmation messages.
$lang['us_admin_activate_confirm']   = 'هل أنت متأكد من أنك تريد تفعيل هذا الحساب؟';
$lang['us_admin_deactivate_confirm'] = 'هل أنت متأكد من أنك تريد إلغاء تفعيل هذا الحساب؟';
$lang['us_admin_delete_confirm']     = 'هل أنت متأكد من أنك تريد حذف هذا الحساب؟';
$lang['us_admin_restore_confirm']    = 'هل أنت متأكد من أنك تريد استعادة هذا الحساب؟';
$lang['us_admin_remove_confirm']     = 'هل أنت متأكد من أنك تريد إزالة هذا الحساب وجميع بياناته؟';

// Success messages.
$lang['us_admin_add_success']        = 'تم إنشاء الحساب بنجاح.';
$lang['us_admin_edit_success']       = 'تم تحديث الحساب بنجاح.';
$lang['us_admin_activate_success']   = 'تم تفعيل الحساب بنجاح.';
$lang['us_admin_deactivate_success'] = 'تم إلغاء تفعيل الحساب بنجاح.';
$lang['us_admin_delete_success']     = 'تم حذف الحساب بنجاح.';
$lang['us_admin_restore_success']    = 'تمت استعادة الحساب بنجاح.';
$lang['us_admin_remove_success']     = 'تمت إزالة الحساب وجميع بياناته.';

// Error messages.
$lang['us_admin_add_error']        = 'تعذر إنشاء الحساب.';
$lang['us_admin_edit_error']       = 'تعذر تحديث الحساب.';
$lang['us_admin_activate_error']   = 'تعذر تفعيل الحساب.';
$lang['us_admin_deactivate_error'] = 'تعذر إلغاء تفعيل الحساب.';
$lang['us_admin_delete_error']     = 'تعذر حذف الحساب.';
$lang['us_admin_restore_error']    = 'تعذر استعادة الحساب.';
$lang['us_admin_remove_error']     = 'تعذر إزالة الحساب وجميع بياناته.';

// Messages on own account.
$lang['us_admin_activate_error_own']   = 'لا يمكنك تفعيل حسابك الخاص.';
$lang['us_admin_deactivate_error_own'] = 'لا يمكنك إلغاء تفعيل حسابك الخاص.';
$lang['us_admin_delete_error_own']     = 'لا يمكنك حذف حسابك الخاص.';
$lang['us_admin_restore_error_own']    = 'لا يمكنك استعادة حسابك الخاص.';
$lang['us_admin_remove_error_own']     = 'لا يمكنك إزالة حسابك الخاص.';

// ========================================================================
// Users settings lines.
// ========================================================================

// Pages titles.
$lang['set_profile_title']  = 'تحديث الملف الشخصي';
$lang['set_avatar_title']   = 'تحديث الصورة';
$lang['set_password_title'] = 'تغيير كلمة السر';
$lang['set_email_title']    = 'تغيير البريد الإلكتروني';

// Pages headings.
$lang['set_profile_heading']  = $lang['set_profile_title'];
$lang['set_avatar_heading']   = $lang['set_avatar_title'];
$lang['set_password_heading'] = $lang['set_password_title'];
$lang['set_email_heading']    = $lang['set_email_title'];

// Success messages.
$lang['set_profile_success']  = 'تم تحديث الملف الشخصي بنجاح.';
$lang['set_avatar_success']   = 'Avatar successfully updated.';
$lang['set_password_success'] = 'تم تغير كلمة السر بنجاح.';
$lang['set_email_success']    = 'تم تغيير عنوان البريد الإلكتروني بنجاح.';

// Error messages.
$lang['set_profile_error']   = 'تعذر تحديث الملف الشخصي.';
$lang['set_avatar_error']      = 'Unable to update avatar.';
$lang['set_password_error']   = 'تعذر تغير كلمة السر.';
$lang['set_email_error']       = 'تعذر تغيير عنوان البريد الإلكتروني.';
$lang['set_email_invalid_key'] = 'This new email link is no longer valid.';

// Info messages.
$lang['set_email_info'] = 'تم إرسال رابط لتغيير عنوان بريدك الإلكتروني إلى عنوانك الجديد.';

// Avatar extra lines.
$lang['update_avatar']       = 'Update Avatar';
$lang['add_image']           = 'Add Image';
$lang['use_gravatar']        = 'Use Gravatar';
$lang['use_gravatar_notice'] = 'If you check this option, your uploaded profile picture will be deleted and your <a href="%s" target="_blank">Gravatar</a> image will be used instead.';
