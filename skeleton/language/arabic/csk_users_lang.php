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
 * Users language file (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

$lang['CSK_USERS_MANAGE_USERS'] = 'إدارة المستخدمين';
$lang['CSK_USERS_MEMBER_LOGIN'] = 'دخول الأعضاء';

// Users actions.
$lang['CSK_USERS_ADD_USER']  = 'إضافة حساب';
$lang['CSK_USERS_ADD_GROUP'] = 'مجموعة جديدة';
$lang['CSK_USERS_ADD_LEVEL'] = 'مستوى وصول جديد';

$lang['CSK_USERS_EDIT_USER']  = 'تعديل الحساب';
$lang['CSK_USERS_EDIT_GROUP'] = 'تعديل المجموعة';
$lang['CSK_USERS_EDIT_LEVEL'] = 'تعديل مستوى الوصول';

$lang['CSK_USERS_DELETE_USER']  = 'حذف الحساب';
$lang['CSK_USERS_DELETE_GROUP'] = 'حذف المجموعة';
$lang['CSK_USERS_DELETE_LEVEL'] = 'حذف مستوى الوصول';

$lang['CSK_USERS_ACTIVATE_USER']   = 'تفعيل الحساب';
$lang['CSK_USERS_DEACTIVATE_USER'] = 'تعطيل الحساب';
$lang['CSK_USERS_RESTORE_USER']    = 'استعادة الحساب';
$lang['CSK_USERS_REMOVE_USER']     = 'إزالة الحساب';

// Actions with name.
$lang['CSK_USERS_EDIT_USER_NAME']       = 'تعديل الحساب: %s';
$lang['CSK_USERS_DELETE_USER_NAME']     = 'حذف الحساب: %s';
$lang['CSK_USERS_ACTIVATE_USER_NAME']   = 'تفعيل الحساب: %s';
$lang['CSK_USERS_DEACTIVATE_USER_NAME'] = 'تعطيل الحساب: %s';

// Users roles.
$lang['CSK_USERS_ROLE']  = 'الرتبة';
$lang['CSK_USERS_ROLES'] = 'المراتب';

$lang['CSK_USERS_ROLE_REGULAR']   = 'عادي';		// Level: 1
$lang['CSK_USERS_ROLE_PREMIUM']   = 'متميز';	// Level: 2
$lang['CSK_USERS_ROLE_AUTHOR']    = 'مؤلف';		// Level: 3
$lang['CSK_USERS_ROLE_EDITOR']    = 'محرر';		// Level: 4
$lang['CSK_USERS_ROLE_MANAGER']   = 'مدير'; 	// Level: 6
$lang['CSK_USERS_ROLE_ADMIN']     = 'مشرف';		// Level: 9
$lang['CSK_USERS_ROLE_OWNER']     = 'مالك';		// Level: 10

$lang['CSK_USERS_ROLE_ADMINISTRATOR'] = 'مشرف'; // Alias of Admin.

// Users statuses.
$lang['CSK_USERS_ACTIVE']   = 'مفعّل';
$lang['CSK_USERS_INACTIVE'] = 'معطّل';
$lang['CSK_USERS_DELETED']  = 'محذوف';

// Confirmation messages.
$lang['CSK_USERS_ADMIN_CONFIRM_ACTIVATE']   = 'هل أنت متأكد من أنك تريد تفعيل هذا الحساب؟';
$lang['CSK_USERS_ADMIN_CONFIRM_DEACTIVATE'] = 'هل أنت متأكد من أنك تريد إلغاء تفعيل هذا الحساب؟';
$lang['CSK_USERS_ADMIN_CONFIRM_DELETE']     = 'هل أنت متأكد من أنك تريد حذف هذا الحساب؟';
$lang['CSK_USERS_ADMIN_CONFIRM_RESTORE']    = 'هل أنت متأكد من أنك تريد استرجاع هذا الحساب؟';
$lang['CSK_USERS_ADMIN_CONFIRM_REMOVE']     = 'هل أنت متأكد من أنك تريد حذف هذا الحساب وكل بياناته نهائياً؟';

// Success messages.
$lang['CSK_USERS_ADMIN_SUCCESS_ADD']        = 'تم إنشاء الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_EDIT']       = 'تم تحديث الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_ACTIVATE']   = 'تم تفعيل الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_DEACTIVATE'] = 'تم تعطيل الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_DELETE']     = 'تم حذف الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_RESTORE']    = 'تمت استعادة الحساب بنجاح.';
$lang['CSK_USERS_ADMIN_SUCCESS_REMOVE']     = 'تمت إزالة الحساب وجميع بياناته بصفة نهائية.';

// Error messages.
$lang['CSK_USERS_ADMIN_ERROR_ADD']        = 'تعذر إنشاء الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_EDIT']       = 'تعذر تحديث الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE']   = 'تعذر تفعيل الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE'] = 'تعذر تعطيل الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE']     = 'تعذر حذف الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE']    = 'تعذرت استعادة الحساب.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE']     = 'تعذر إزالة الحساب وجميع بياناته.';

// Messages on own account.
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE_OWN']   = 'لا يمكنك تفعيل حسابك الخاص.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE_OWN'] = 'لا يمكنك تعطيل حسابك الخاص.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE_OWN']     = 'لا يمكنك حذف حسابك الخاص.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE_OWN']    = 'لا يمكنك استعادة حسابك الخاص.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE_OWN']     = 'لا يمكنك إزالة حسابك الخاص.';

// ------------------------------------------------------------------------
// Account creation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_CREATE']       = 'تم إنشاء الحساب بنجاح.';
$lang['CSK_USERS_SUCCESS_CREATE_LOGIN'] = 'تم إنشاء الحساب بنجاح. يمكنك الآن الدخول.';

// Info messages.
$lang['CSK_USERS_INFO_CREATE']        = 'تم إنشاء الحساب وإرسال رابط التفعيل إليك بنجاح.';
$lang['CSK_USERS_INFO_CREATE_MANUAL'] = 'جميع الحسابات تتطلب موافقة من مسؤول الموقع قبل أن تكون نشطة. سوف تتلقى رسالة بمجرد تفعيل حسابك.';

// Error messages.
$lang['CSK_USERS_ERROR_CREATE'] = 'تعذر إنشاء الحساب.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_ACTIVATE']       = 'تم تفعيل الحساب بنجاح.';
$lang['CSK_USERS_SUCCESS_ACTIVATE_LOGIN'] = 'تم تفعيل الحساب بنجاح. يمكنك الآن الدخول.';

// Error messages.
$lang['CSK_USERS_ERROR_ACTIVATE']         = 'تعذر تفعيل الحساب.';
$lang['CSK_USERS_ERROR_ACTIVATE_ALREADY'] = 'تم تمكين هذا الحساب من قبل.';
$lang['CSK_USERS_ERROR_ACTIVATE_CODE']    = 'لم يعد رابط تفعيل الحساب هذا صالحا.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RESEND_LINK'] = 'إعادة إرسال رابط التفعيل';
$lang['CSK_USERS_RESEND_TIP']  = 'أدخل اسم المستخدم أو عنوان البريد الإلكتروني، وسنرسل إليك رابطا لتفعيل حسابك.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESEND'] = 'تمت إعادة إرسال رابط تفعيل الحساب بنجاح. تحقق من البريد الوارد أو الرسائل غير المرغوب فيها.';

// Error message.
$lang['CSK_USERS_ERROR_RESEND'] = 'تعذر إعادة إرسال رابط تفعيل الحساب.';

// ------------------------------------------------------------------------
// Member login.
// ------------------------------------------------------------------------
$lang['CSK_USERS_REMEMBER_ME'] = 'تذكرني';

// Error messages.
$lang['CSK_USERS_ERROR_ACCOUNT_MISSING']       = 'هذا المستخدم غير موجود.';
$lang['CSK_USERS_ERROR_ACCOUNT_INACTIVE']      = 'حسابك ليس نشطًا بعد. استخدم الرابط الذي تم إرساله إليك أو %s لتلقي رابط جديد.';
$lang['CSK_USERS_ERROR_ACCOUNT_BANNED']        = 'هذا المستخدم ممنوع من الموقع.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED']       = 'تم حذف حسابك ولكن لم تتم إزالته بعد من قاعدة البيانات. %s إذا كنت ترغب في استعادته.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED_ADMIN'] = 'تم حذف حسابك من قبل مسؤول وبالتالي لا يمكنك استعادته. لا تتردد في الاتصال بنا للحصول على مزيد من التفاصيل.';

$lang['CSK_USERS_ERROR_LOGIN_CREDENTIALS'] = 'اسم المستخدم/عنوان البريد الإلكتروني و/أو كلمة المرور غير صالحة.';

// ------------------------------------------------------------------------
// Lost password section.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RECOVER_TIP'] = 'أدخل اسم المستخدم أو عنوان البريد الإلكتروني، وسنرسل إليك رابطا لإعادة تعيين كلمة المرور.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RECOVER'] = 'تم إرسال رابط إعادة تعيين كلمة المرور بنجاح.';

// Error messages.
$lang['CSK_USERS_ERROR_RECOVER']         = 'تعذر إرسال رابط إعادة تعيين كلمة المرور.';
$lang['CSK_USERS_ERROR_RECOVER_DELETED'] = 'تم حذف حسابك ولكن لم تتم إزالته بعد من قاعدة البيانات. الرجاء الاتصال بنا إذا أردت استعادة.';

// ------------------------------------------------------------------------
// Password reset section.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_RESET'] = 'تمت إعادة تعيين كلمة المرور بنجاح.';

// Error messages.
$lang['CSK_USERS_ERROR_RESET']      = 'تعذر إعادة تعيين كلمة المرور.';
$lang['CSK_USERS_ERROR_RESET_CODE'] = 'لم يعد رابط إعادة تعيين كلمة المرور صالحا.';

// ------------------------------------------------------------------------
// Restore account section.
// ------------------------------------------------------------------------

$lang['CSK_USERS_RESTORE_ACCOUNT'] = 'استعادة الحساب';
$lang['CSK_USERS_RESTORE_TIP'] = 'أدخل اسم المستخدم/عنوان البريد الإلكتروني وكلمة المرور لاستعادة حسابك.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESTORE'] = 'تمت استعادة الحساب بنجاح.';

// Error messages.
$lang['CSK_USERS_ERROR_RESTORE']         = 'تعذر استعادة الحساب.';
$lang['CSK_USERS_ERROR_RESTORE_DELETED'] = 'يمكن استعادة الحسابات المحذوفة فقط.';

// ------------------------------------------------------------------------
// Users emails subjects.
// ------------------------------------------------------------------------
$lang['CSK_USERS_EMAIL_ACTIVATED']         = 'تم تنشيط الحساب';
$lang['CSK_USERS_EMAIL_EMAIL']             = 'تم تغيير البريد الالكتروني';
$lang['CSK_USERS_EMAIL_EMAIL_PREP']        = 'طلب تغيير البريد الالكتروني';
$lang['CSK_USERS_EMAIL_MANUAL_ACTIVATION'] = 'تفعيل يدوي';
$lang['CSK_USERS_EMAIL_PASSWORD']          = 'تم تغيير كلمة السر';
$lang['CSK_USERS_EMAIL_RECOVER']           = 'إعادة تعيين كلمة المرور';
$lang['CSK_USERS_EMAIL_REGISTER']          = 'تنشيط الحساب';
$lang['CSK_USERS_EMAIL_RESEND']            = 'رابط تنشيط الجديد';
$lang['CSK_USERS_EMAIL_RESTORE']           = 'تم إستعادة الحساب';
$lang['CSK_USERS_EMAIL_WELCOME']           = 'مرحبًا بك في {site_name}';
