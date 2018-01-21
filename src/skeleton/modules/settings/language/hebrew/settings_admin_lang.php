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
 * Settings Module - Admin Language (Hebrew)
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

$lang['settings'] = 'הגדרות';

$lang['set_update_error']   = 'לא ניתן לעדכן את הגדרות.';
$lang['set_update_success'] = 'הגדרות עודכן בהצלחה.';

// ------------------------------------------------------------------------
// General Settings.
// ------------------------------------------------------------------------
$lang['general'] = 'כללי';
$lang['site_settings'] = 'הגדרות אתר';

// Site name.
$lang['set_site_name']     = 'שם האתר';
$lang['set_site_name_tip'] = 'הזן את השם של אתר האינטרנט שלך.';

// Site description.
$lang['set_site_description']     = 'תיאור האתר';
$lang['set_site_description_tip'] = 'להזין תיאור קצר על האתר שלך.';

// Site keywords.
$lang['set_site_keywords']     = 'האתר מילות מפתח';
$lang['set_site_keywords_tip'] = 'הזן את מופרדים באמצעות פסיקים האתר מילות מפתח.';

// Site author.
$lang['set_site_author']     = 'האתר מחבר תגובה';
$lang['set_site_author_tip'] = 'הזן את האתר מחבר תגובה אם את רוצה להוסיף המחבר תג meta.';

// Per page.
$lang['set_per_page']     = 'לכל דף';
$lang['set_per_page_tip'] = 'כמה פריטים מוצגים על דפים באמצעות עימוד.';

// Google analytics.
$lang['set_google_analytics_id'] = 'גוגל Anaytilcs ID';
$lang['set_google_analytics_id_tip'] = 'הזן את Google Anaytilcs ID';

// Google site verification.
$lang['set_google_site_verification'] = 'באתר\' של Google אימות';
$lang['set_google_site_verification_tip'] = 'הזן את האתר של Google קוד אימות.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'משתמשים הגדרות';

// Allow registration.
$lang['set_allow_registration']     = 'לאפשר רישום';
$lang['set_allow_registration_tip'] = 'האם לאפשר למשתמשים ליצור חשבון באתר שלך.';

// Email activation.
$lang['set_email_activation']     = 'דוא " ל הפעלה';
$lang['set_email_activation_tip'] = 'אם לאלץ משתמשים כדי לאמת את כתובות הדוא " ל שלהם, בטרם יורשו להיכנס.';

// Manual activation.
$lang['set_manual_activation']     = 'הפעלה ידנית';
$lang['set_manual_activation_tip'] = 'בין אם ידני כדי לאמת משתמשים חשבונות.';

// Login type.
$lang['set_login_type']     = 'סוג התחברות';
$lang['set_login_type_tip'] = 'משתמשים יכולים להתחבר באמצעות שמות משתמש, כתובות דוא " ל או שניהם.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'לאפשר ריבוי הפעלות';
$lang['set_allow_multi_session_tip'] = 'אם לאפשר למשתמשים מרובים כדי להתחבר לאותו חשבון באותו הזמן.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'השתמש Gravatar';
$lang['set_use_gravatar_tip'] = 'השתמש gravatar או לאפשר למשתמשים להעלות תמונות אישיות.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'הגדרות דוא " ל';

// Admin email.
$lang['set_admin_email']     = 'הדוא " ל של מנהל';
$lang['set_admin_email_tip'] = 'את כתובת הדוא " ל באתר הודעות שנשלחו.';

// Server email.
$lang['set_server_email']     = 'שרת דוא " ל';
$lang['set_server_email_tip'] = 'את כתובת הדוא "ל נהג לשלוח הודעות דוא" ל למשתמשים. להגדיר כ "מ". אתה יכול להשתמש "noreply@...", או כתובת אימייל קיימת.';

// Mail protocol.
$lang['set_mail_protocol'] = 'פרוטוקול הדואר';
$lang['set_mail_protocol_tip'] = 'בחר את פרוטוקול הדואר שברצונך לשלוח מיילים עם.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'Sendmail נתיב';
$lang['set_sendmail_path_tip'] = 'הזן את sendmail הדרך. ברירת מחדל: /usr/sbin/sendmail. נדרש רק אם באמצעות Sendmail פרוטוקול.';

// SMTP host.
$lang['set_smtp_host'] = 'SMTP המארח';
$lang['set_smtp_host_tip'] = 'הזן את SMTP שם המארח (.e: smtp.gmail.com). נדרש רק אם באמצעות פרוטוקול SMTP.';

// SMTP port.
$lang['set_smtp_port'] = 'יציאת SMTP';
$lang['set_smtp_port_tip'] = 'הזן את מספר יציאת SMTP המסופק על ידי המארח שלך. נדרש רק אם באמצעות פרוטוקול SMTP.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'SMTP הצפנה';
$lang['set_smtp_crypto_tip'] = 'בחר את SMTP הצפנה.';

// SMTP user.
$lang['set_smtp_user'] = 'SMTP Username';
$lang['set_smtp_user_tip'] = 'הזן את שם המשתמש שלך לחשבון ה-SMTP.';

// SMTP pass.
$lang['set_smtp_pass'] = 'סיסמה';
$lang['set_smtp_pass_tip'] = 'הזן את הסיסמה שלך לחשבון ה-SMTP.';

// ------------------------------------------------------------------------
// Upload settings
// ------------------------------------------------------------------------
$lang['upload_settings'] = 'טען הגדרות';

// Upload path.
$lang['set_upload_path'] = 'טען נתיב';
$lang['set_upload_path_tip'] = 'את הנתיב בו שונה מותר הקבצים שהועלו. ברירת מחדל: תכנים/קבצים/';

// Allowed file types.
$lang['set_allowed_types'] = 'מותר קבצים';
$lang['set_allowed_types_tip'] = 'רשימה של קבצים מותרים להעלאה. השתמש "&#124;" כדי להפריד בין סוגים.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'Captcha הגדרות';

// Use captcha.
$lang['set_use_captcha'] = 'להשתמש captcha';
$lang['set_use_captcha_tip'] = 'האם לאפשר captcha על איזה אתר הטפסים.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'שימוש-קאפצ\' ה';
$lang['set_use_recaptcha_tip'] = 'השתמש ב-Google reCAPTCHA אם אפשרות זו מופעלת, אחרת להשתמש CodeIgniter מובנית captcha אם להשתמש captcha נקבעה למצב כן.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'קאפצ\' ה באתר המפתח';
$lang['set_recaptcha_site_key_tip'] = 'הזן את reCAPTCHA האתר המפתח המסופק על ידי Google.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'מפתח פרטי reCAPTCHA';
$lang['set_recaptcha_private_key_tip'] = 'הזן את מפתח פרטי reCAPTCHA המסופק על ידי Google.';
