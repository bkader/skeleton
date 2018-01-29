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
 * Additional form validation errors (Arabic)
 *
 * This file is here to override or add language lines to
 * form validation library.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

$lang['form_validation_alpha_extra']       = 'الحقل {field} يمكن أن يحتوى على أحرف أبجدية، رقمية، ومسافات، نقاط، شرطات سفلية وشرطات.';
$lang['form_validation_unique_username']   = 'اسم المستخدم هذا غير متوفر.';
$lang['form_validation_unique_email']      = 'عنوان البريد الإلكتروني هذا قيد الاستخدام.';
$lang['form_validation_user_exists']       = 'لم يتم العثور على مستخدم باستخدام اسم المستخدم أو عنوان البريد الإلكتروني.';
$lang['form_validation_check_credentials'] = 'اسم المستخدم/البريد الإلكتروني و/أو كلمة المرور غير صالح.';
$lang['form_validation_current_password']  = 'كلمة المرور الحالية غير صحيحة.';
