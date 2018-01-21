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
 * Users Module - Users Language (Hebrew)
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
$lang['login']           = 'סימן ב';
$lang['logout']          = 'השלט';
$lang['register']        = 'הרשמה';
$lang['create_account']  = 'צור חשבון';
$lang['forgot_password'] = 'שכחת את הסיסמה?';
$lang['lost_password']   = 'איבדתי את הסיסמה';
$lang['send_link']       = 'שלח קישור';
$lang['resend_link']     = 'לשלוח קישור';
$lang['restore_account'] = 'שחזור החשבון';

$lang['profile']      = 'פרופיל';
$lang['view_profile'] = 'צפה בפרופיל';
$lang['edit_profile'] = 'עריכת פרופיל';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'שם משתמש';
$lang['identity']          = 'שם משתמש או כתובת דוא " ל';

$lang['email_address']     = 'כתובת דוא " ל';
$lang['new_email_address'] = 'כתובת הדוא " ל החדשה';

$lang['password']          = 'הסיסמה';
$lang['new_password']      = 'הסיסמה החדשה';
$lang['confirm_password']  = 'אישור סיסמה';
$lang['current_password']  = 'הסיסמה הנוכחית';

$lang['first_name']        = 'שם פרטי';
$lang['last_name']         = 'שם משפחה';
$lang['full_name']         = 'שם מלא';

$lang['gender']            = 'מין';
$lang['male']              = 'זכר';
$lang['female']            = 'נקבה';

$lang['company']  = 'החברה';
$lang['phone']    = 'טלפון';
$lang['address']  = 'כתובת';
$lang['location'] = 'מיקום';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title'] = 'הרשמה';
$lang['us_register_heading'] = 'צור חשבון';

$lang['us_register_success'] = 'החשבון נוצר בהצלחה. כעת אתה יכול להתחבר.';
$lang['us_register_info']    = 'החשבון נוצר בהצלחה. קישור ההפעלה נשלח אליך.';
$lang['us_register_error']   = 'אין אפשרות ליצור חשבון.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'זה קישור להפעלת החשבון הוא כבר לא תקף.';
$lang['us_activate_error']       = 'לא ניתן להפעיל את החשבון.';
$lang['us_activate_success']     = 'החשבון הופעל בהצלחה. כעת אתה יכול להתחבר';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title'] = 'לשלוח קישור הפעלה';
$lang['us_resend_heading'] = 'לשלוח קישור';

$lang['us_resend_notice']  = 'הזן את שם המשתמש שלך או כתובת הדוא " ל ואנו נשלח לך קישור כדי להפעיל את החשבון שלך.';
$lang['us_resend_error']   = 'אין אפשרות לשלוח קישור להפעלת החשבון.';
$lang['us_resend_enabled'] = 'חשבון זה כבר זמין.';
$lang['us_resend_success'] = 'קישור להפעלת החשבון בהצלחה מוחה. בדוק את תיבת הדואר הנכנס שלך או דואר זבל.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'סימן ב';
$lang['us_login_heading'] = 'כניסת חבר';
$lang['remember_me']      = 'זוכר אותי';

$lang['us_wrong_credentials'] = 'שם משתמש שגוי/כתובת דוא " ל ו/או סיסמה.';
$lang['us_account_disabled']  = 'את החשבון הוא עדיין לא פעיל. להשתמש את הקישור שנשלח אליך או אל %s כדי לקבל אחד חדש.';
$lang['us_account_banned']    = 'משתמש זה הוא מורחק מהאתר.';
$lang['us_account_deleted']   = 'החשבון שלך נמחק אבל עדיין לא הוסרו מבסיס הנתונים. %s. אם אתה רוצה לשחזר אותו.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'איבדתי את הסיסמה';
$lang['us_recover_heading'] = 'איבדתי את הסיסמה';

$lang['us_recover_notice']  = 'הזן את שם המשתמש שלך או כתובת הדוא " ל ואנו נשלח לך קישור כדי לאפס את הסיסמה שלך.';
$lang['us_recover_success'] = 'איפוס הסיסמה הקישור נשלחו בהצלחה.';
$lang['us_recover_error']   = 'אין אפשרות לשלוח קישור לאיפוס הסיסמה.';


// ------------------------------------------------------------------------
// Reset password page.
// ------------------------------------------------------------------------
$lang['us_reset_title']   = 'איפוס הסיסמה';
$lang['us_reset_heading'] = 'איפוס הסיסמה';

$lang['us_reset_invalid_key'] = 'זה איפוס הסיסמה הקישור כבר לא תקף.';
$lang['us_reset_error']       = 'אין אפשרות לאפס את הסיסמה.';
$lang['us_reset_success']     = 'הסיסמה בהצלחה לאפס.';

// ------------------------------------------------------------------------
// Restore account page.
// ------------------------------------------------------------------------
$lang['us_restore_title']   = 'שחזור החשבון';
$lang['us_restore_heading'] = 'שחזור החשבון';

$lang['us_restore_notice']  = 'הזן את שם המשתמש/כתובת דוא " ל וסיסמה כדי לשחזר את החשבון שלך.';
$lang['us_restore_deleted'] = 'רק חשבונות שנמחקו ניתן לשחזר.';
$lang['us_restore_error']   = 'אין אפשרות לשחזר את החשבון.';
$lang['us_restore_success'] = 'חשבון שחזר בהצלחה. ברוך שובך!';
