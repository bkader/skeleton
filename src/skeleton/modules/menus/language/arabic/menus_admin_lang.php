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
 * Menus Module - Admin Language (Arabic)
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

// Manage menus.
$lang['manage_menus'] = 'إدارة القوائم';

// Add menu.
$lang['add_menu']         = 'إضافة قائمة';
$lang['add_menu_success'] = 'تم إنشاء القائمة بنجاح.';
$lang['add_menu_error']   = 'تعذر إنشاء القائمة.';

// Edit menu.
$lang['save_menu']         = 'حفظ القائمة';
$lang['edit_menu']         = 'تعديل القائمة';
$lang['edit_menu_success'] = 'تم تحديث القائمة بنجاح.';
$lang['edit_menu_error']   = 'تعذر تحديث القائمة.';
$lang['edit_menu_no_menu'] = 'هذه القائمة غير موجودة.';

// Delete menu.
$lang['delete_menu']         = 'حذف القائمة';
$lang['delete_menu_success'] = 'تم حذف القائمة بنجاح.';
$lang['delete_menu_error']   = 'تعذر حذف القائمة.';

// Menu name.
$lang['menu_name']     = 'اسم القائمة';
$lang['menu_name_tip'] = 'أدخل اسما للقائمة، ثم انقر على إضافة قائمة.';

// Menu slug
$lang['menu_slug']     = 'الاسم اللطيف';
$lang['menu_slug_tip'] = 'أدخل اسما اللطيفا فريدا.';

// Menu description.
$lang['menu_description']     = 'وصف القائمة';
$lang['menu_description_tip'] = '(اختياري) أدخل وصف القائمة.';

// ------------------------------------------------------------------------

$lang['menu_items']             = 'عناصر القائمة';
$lang['menu_structure']         = 'هيكل القائمة';
$lang['menu_structure_tip']     = 'اسحب كل عنصر حسب الترتيب الذي تفضله.';
$lang['menu_structure_success'] = 'تم تحديث عناصر القائمة بنجاح.';
$lang['menu_structure_error']   = 'تعذر تحديث ترتيب عناصر القائمة.';

// Add menu.
$lang['add_item']         = 'اضافة عنصر';
$lang['add_item_success'] = 'تم إنشاء عنصر القائمة بنجاح.';
$lang['add_item_error']   = 'تعذر إنشاء عنصر القائمة.';

// Edit item.
$lang['save_item']         = 'حفظ العنصر';
$lang['edit_item']         = 'تعديل عنصر';
$lang['edit_item_success'] = 'تم تحديث العنصر بنجاح.';
$lang['edit_item_error']   = 'تعذر تحديث عنصر القائمة.';
$lang['edit_item_no_menu'] = 'عنصر القائمة هذا غير موجود.';

// Delete item.
$lang['delete_item']         = 'حذف العنصر';
$lang['delete_item_success'] = 'تم حذف عنصر القائمة بنجاح.';
$lang['delete_item_error']   = 'تعذر حذف عنصر القائمة.';

// Item title.
$lang['item_title']     = 'عنوان العنصر';
$lang['item_title_tip'] = 'سيكون هذا النص للعرض.';

// Item URL
$lang['item_href']     = 'عنوان URL';
$lang['item_href_tip'] = 'أدخل عنوان URL لعنصر القائمة.';

// Item description.
$lang['item_description']     = 'وصف العنصر';
$lang['item_description_tip'] = 'سيتم عرض الوصف في القائمة إذا كان القالب الحالي يدعم ذلك.';

// Item order.
$lang['item_order']     = ' ترتيب العنصر';
$lang['item_order_tip'] = '(اختياري) ترتيب العنصر داخل القائمة.';

// Advanced item inputs.
$lang['title_attr'] = 'سمة العنوان';
$lang['css_classes'] = 'فئات CSS';
$lang['link_relation'] = 'علاقة الرابط (XFN)';

// Linkt target.
$lang['link_target']     = 'هدف الرابط';
$lang['link_target_tip'] = 'افتح الرابط في نافذة جديدة.';

// ------------------------------------------------------------------------

// Manage locations.
$lang['manage_locations']     = 'إدارة مواضع القوائم';
$lang['menu_location']        = 'موضع القائمة';
$lang['theme_locations']      = 'مواضع القالب';
$lang['assign_menu']          = 'القائمة المعينّة';
$lang['theme_locations_tip']  = 'Your theme supports %s menus. Select which menu appears in each location.';
$lang['theme_locations_tip']  = 'القالب الخاص بك يدعم %s قوائم. حدد مكان ظهور كل قائمة.';
$lang['theme_locations_none'] = 'القالب  الحالي لا يدعم القوائم.';
$lang['select_menu']          = '&#151; اختر قائمة &#151;';

$lang['menu_location_success'] = 'تم تحديث مواقع القوائم بنجاح.';
$lang['menu_location_error']   = 'تعذر تحديث مواقع القوائم.';
