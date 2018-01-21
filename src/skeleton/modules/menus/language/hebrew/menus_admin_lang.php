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
 * Menus Module - Admin Language (Hebrew)
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
$lang['manage_menus'] = 'ניהול תפריטים';

// Add menu.
$lang['add_menu']         = 'הוספת תפריט';
$lang['add_menu_success'] = 'התפריט נוצר בהצלחה.';
$lang['add_menu_error']   = 'אין אפשרות ליצור תפריט.';

// Edit menu.
$lang['save_menu']         = 'להציל תפריט';
$lang['edit_menu']         = 'עריכה';
$lang['edit_menu_success'] = 'התפריט עודכן בהצלחה.';
$lang['edit_menu_error']   = 'לא ניתן לעדכן את התפריט.';
$lang['edit_menu_no_menu'] = 'תפריט זה אינו קיים.';

// Delete menu.
$lang['delete_menu']         = 'מחיקת תפריט';
$lang['delete_menu_success'] = 'תפריט נמחק בהצלחה.';
$lang['delete_menu_error']   = 'אין אפשרות למחוק את התפריט.';

// Menu name.
$lang['menu_name']     = 'שם התפריט';
$lang['menu_name_tip'] = 'תביא את התפריט שלך שם ולאחר מכן לחץ על הוסף בתפריט.';

// Menu slug
$lang['menu_slug']     = 'תפריט תווית';
$lang['menu_slug_tip'] = 'הזן ייחודי חילזון על התפריט שלך.';

// Menu description.
$lang['menu_description']     = 'תפריט תיאור';
$lang['menu_description_tip'] = '(אופציונלי) הזן את תפריט תיאור.';

// ------------------------------------------------------------------------

$lang['menu_items']             = 'פריטי תפריט';
$lang['menu_structure']         = 'מבנה התפריטים';
$lang['menu_structure_tip']     = 'גרור כל אחד מהפריטים לתוך הסדר שאתה מעדיף.';
$lang['menu_structure_success'] = 'פריטי תפריט סדר עודכן בהצלחה.';
$lang['menu_structure_error']   = 'לא ניתן לעדכן את תפריט פריטים סדר.';

// Add menu.
$lang['add_item']         = 'הוספת פריט';
$lang['add_item_success'] = 'תפריט פריט נוצר בהצלחה.';
$lang['add_item_error']   = 'אין אפשרות ליצור פריט תפריט.';

// Edit item.
$lang['save_item']         = 'שמור פריט';
$lang['edit_item']         = 'עריכת פריט';
$lang['edit_item_success'] = 'פריט פריט עודכן בהצלחה.';
$lang['edit_item_error']   = 'לא ניתן לעדכן את תפריט הפריט.';
$lang['edit_item_no_menu'] = 'פריט תפריט זה אינו קיים.';

// Delete item.
$lang['delete_item']         = 'מחיקת פריט';
$lang['delete_item_success'] = 'תפריט פריט נמחק בהצלחה.';
$lang['delete_item_error']   = 'אין אפשרות למחוק את פריט התפריט.';

// Item title.
$lang['item_title']     = 'כותרת הפריט';
$lang['item_title_tip'] = 'זה יהיה טקסט התצוגה.';

// Item URL
$lang['item_href']     = 'פריט URL';
$lang['item_href_tip'] = 'הזן את כתובת האתר של פריט התפריט.';

// Item description.
$lang['item_description']     = 'תיאור פריט';
$lang['item_description_tip'] = 'תיאור יוצגו בתפריט אם הנושא הנוכחי תומך בכך.';

// Item order.
$lang['item_order']     = 'פריט סדר';
$lang['item_order_tip'] = '(אופציונלי) את ההזמנה של הפריט שלך בתוך תפריט.';

// Advanced item inputs.
$lang['title_attr'] = 'כותרת תכונה';
$lang['css_classes'] = 'מחלקות CSS';
$lang['link_relation'] = 'קישור יחסים (XFN)';

// Linkt target.
$lang['link_target']     = 'יעד קישור';
$lang['link_target_tip'] = 'פתח את הקישור בחלון חדש.';

// ------------------------------------------------------------------------

// Manage locations.
$lang['manage_locations']     = 'נהל מיקומים';
$lang['menu_location']        = 'תפריט מיקום';
$lang['theme_locations']      = 'נושא מיקומים';
$lang['assign_menu']          = 'להקצות תפריט';
$lang['theme_locations_tip']  = 'הנושא שלך תומך %s תפריטים. לבחור איזה תפריט מופיע בכל מיקום.';
$lang['theme_locations_none'] = 'אתה נושא אינו תומך תפריטים.';
$lang['select_menu']          = '&#151; בחר תפריט &#151;';

$lang['menu_location_success'] = 'תפריטים מקומות עודכן בהצלחה.';
$lang['menu_location_error']   = 'לא ניתן לעדכן את תפריטי מקומות.';
