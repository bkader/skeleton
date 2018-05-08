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
 * Menus Module - Admin Language (Arabic)
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

// Pages title.
$lang['smn_manage_menus']     = 'إدارة القوائم';
$lang['smn_manage_locations'] = 'إدارة مواقع القوائم';
$lang['smn_menu_items']       = 'عناصر القائمة';
$lang['smn_menu_items_name']  = 'عناصر القائمة: %s';

// Action buttons.
$lang['smn_add_menu']    = 'إضافة القائمة';
$lang['smn_add_item']    = 'اضافة عنصر';
$lang['smn_edit_menu']   = 'عدل القائمة';
$lang['smn_edit_item']   = 'تعديل عنصر';
$lang['smn_save_menu']   = 'حفظ القائمة';
$lang['smn_save_item']   = 'حفظ البند';
$lang['smn_delete_menu'] = 'حذف القائمة';
$lang['smn_delete_item'] = 'حذف عنصر';

// Actions buttons with placeholders.
$lang['smn_edit_menu_name']   = 'تعديل القائمة: %s';
$lang['smn_edit_item_name']   = 'تعديل البنود';
$lang['smn_delete_menu_name'] = 'حذف القائمة: %s';
$lang['smn_delete_item_name'] = 'حذف العناصر: %s';

// Confirmation messages.
$lang['smn_delete_menu_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذه القائمة؟';
$lang['smn_delete_item_confirm'] = 'هل أنت متأكد من أنك تريد حذف عنصر القائمة هذا؟';

// Success messages.
$lang['smn_add_menu_success']         = 'تم إنشاؤها القائمة بنجاح.';
$lang['smn_add_item_success']         = 'تم إنشاؤها عنصر القائمة بنجاح.';
$lang['smn_save_menu_success']        = 'تم تحديث القائمة بنجاح.';
$lang['smn_save_item_success']        = 'تم تحديث عنصر القائمة بنجاح.';
$lang['smn_delete_menu_success']      = 'تم حذف القائمة بنجاح.';
$lang['smn_delete_item_success']      = 'تم حذف عنصر القائمة بنجاح.';
$lang['smn_update_locations_success'] = 'تم تحديث مواقع القوائم بنجاح.';

// Error messages.
$lang['smn_add_menu_error']         = 'تعذر إضافة القائمة.';
$lang['smn_add_item_error']         = 'تعذر إضافة عنصر القائمة.';
$lang['smn_save_menu_error']        = 'تعذر تحديث القائمة.';
$lang['smn_save_item_error']        = 'تعذر تحديث عنصر القائمة.';
$lang['smn_delete_menu_error']      = 'تعذر حذف القائمة.';
$lang['smn_delete_item_error']      = 'تعذر حذف عنصر القائمة.';
$lang['smn_update_locations_error'] = 'تعذر تحديث مواقع القوائم.';

// Menu or item inexistent.
$lang['smn_inexistent_menu'] = 'هذه القائمة غير موجودة.';
$lang['smn_inexistent_item'] = 'عنصر القائمة هذا غير موجود.';

// Menus details and tips.
$lang['smn_menu_name']        = 'اسم القائمة';
$lang['smn_menu_slug']        = 'قائمة الطعام';
$lang['smn_menu_description'] = 'وصف القائمة';

$lang['smn_menu_name_tip']        = 'امنح القائمة اسمًا ، ثم انقر على "إضافة قائمة".';
$lang['smn_menu_slug_tip']        = 'أدخل سبيكة فريدة لقائمتك.';
$lang['smn_menu_description_tip'] = '(اختياري) أدخل وصف القائمة الخاصة بك.';

// Items details and tips.
$lang['smn_item_title']            = 'العنوان';
$lang['smn_item_url']              = 'الرابط';
$lang['smn_item_attribute_title']  = 'سمة العنوان';
$lang['smn_item_attribute_class']  = 'فئات CSS';
$lang['smn_item_attribute_rel']    = 'علاقات الرابط (XFN)';
$lang['smn_item_attribute_target'] = 'فتح الرابط في علامة تبويب جديدة';
$lang['smn_item_description']      = 'الوصف';

$lang['smn_item_title_tip']       = 'النص الذي سيتم عرضه.';
$lang['smn_item_url_tip']         = 'أدخل عنوان الرابط الخاص بعنصر القائمة.';
$lang['smn_item_description_tip'] = 'سيتم عرض الوصف في القائمة إذا كان القالب الحالي يدعم ذلك.';

// Menu structure.
$lang['smn_menu_structure']        = 'مبنى القائمة';
$lang['smn_menu_structure_tip']    = 'اسحب كل عنصر حسب الترتيب الذي تفضله.';

// Locations select none item.
$lang['smn_select_menu']          = '&#151; اختر قائمة &#151;';
$lang['smn_theme_locations']      = 'القالب الخاص بك يدعم %s قوائم. حدّد مكان ظهور كل قائمة.';
$lang['smn_theme_locations_none'] = 'القالب الممكن لا يدعم القوائم.';
