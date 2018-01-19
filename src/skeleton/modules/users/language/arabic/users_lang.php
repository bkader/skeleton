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
 * Users Module - Users Language (Arabic)
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

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'تسجيل الدخول';
$lang['logout']          = 'خروج';
$lang['register']        = 'تسجيل';
$lang['create_account']  = 'إصنع حساب';
$lang['forgot_password'] = 'هل نسيت كلمة المرور؟';
$lang['lost_password']   = 'كلمة مرور مفقودة';
$lang['send_link']       = 'أرسل الرابط';
$lang['resend_link']     = 'إعادة إرسال الرابط';
$lang['restore_account'] = 'استعادة الحساب';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'اسم المستخدم';
$lang['identity']          = 'اسم المستخدم أو البريد الالكتروني';

$lang['email_address']     = 'عنوان البريد الإلكتروني';
$lang['new_email_address'] = 'عنوان البريد الإلكتروني الجديد';

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

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title']   = 'تسجيل';
$lang['us_register_heading'] = 'إصنع حساب';

$lang['us_register_success'] = 'تم إنشاء الحساب بنجاح. يمكنك الآن الدخول.';
$lang['us_register_info']    = 'تم إنشاء الحساب بنجاح. تم إرسال رابط التنشيط إليك.';
$lang['us_register_error']   = 'تعذر إنشاء حساب.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'لم يعد رابط تنشيط الحساب صالحا.';
$lang['us_activate_error']       = 'تعذر تنشيط الحساب.';
$lang['us_activate_success']     = 'تم تنشيط الحساب بنجاح. يمكنك الآن الدخول';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title'] = 'إعادة إرسال رابط التنشيط';
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
$lang['remember_me']      = 'تذكرنى';

$lang['us_wrong_credentials'] = 'Invalid username/email address and/or password.';
$lang['us_account_disabled']  = 'حسابك غير نشط حتى الآن. استخدم الرابط الذي تم إرساله إليك أو %s للحصول على رابط جديد.';
$lang['us_account_banned']    = 'هذا المستخدم محظور من الموقع.';
$lang['us_account_deleted']   = 'تم حذف حسابك من قبل لكن لم تتم إزالته بعد. %s إذا كنت ترغب في استعادته.';

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
