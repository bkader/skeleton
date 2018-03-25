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
 * Menus Module - Admin Language (English)
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
$lang['manage_menus'] = 'Manage Menus';

// Add menu.
$lang['add_menu']         = 'Add Menu';
$lang['add_menu_success'] = 'Menu successfully created.';
$lang['add_menu_error']   = 'Unable to create menu.';

// Edit menu.
$lang['save_menu']         = 'Save Menu';
$lang['edit_menu']         = 'Edit Menu';
$lang['edit_menu_success'] = 'Menu successfully updated.';
$lang['edit_menu_error']   = 'Unable to update menu.';
$lang['edit_menu_no_menu'] = 'This menu does not exist.';

// Delete menu.
$lang['delete_menu']         = 'Delete Menu';
$lang['delete_menu_success'] = 'Menu successfully deleted.';
$lang['delete_menu_error']   = 'Unable to delete menu.';

// Menu name.
$lang['menu_name']     = 'Menu Name';
$lang['menu_name_tip'] = 'Give your menu a name, then click Add Menu.';

// Menu slug
$lang['menu_slug']     = 'Menu Slug';
$lang['menu_slug_tip'] = 'Enter a UNIQUE slug for your menu.';

// Menu description.
$lang['menu_description']     = 'Menu Description';
$lang['menu_description_tip'] = '(Optional) Enter your menu description.';

// ------------------------------------------------------------------------

$lang['menu_items']             = 'Menu Items';
$lang['menu_structure']         = 'Menu Structure';
$lang['menu_structure_tip']     = 'Drag each item into the order you prefer.';
$lang['menu_structure_success'] = 'Menu items order successfully updated.';
$lang['menu_structure_error']   = 'Unable to update menu items order.';

// Add menu.
$lang['add_item']         = 'Add Item';
$lang['add_item_success'] = 'Menu item successfully created.';
$lang['add_item_error']   = 'Unable to create menu item.';

// Edit item.
$lang['save_item']         = 'Save Item';
$lang['edit_item']         = 'Edit Item';
$lang['edit_item_success'] = 'Item item successfully updated.';
$lang['edit_item_error']   = 'Unable to update menu item.';
$lang['edit_item_no_menu'] = 'This menu item does not exist.';

// Delete item.
$lang['delete_item']         = 'Delete Item';
$lang['delete_item_success'] = 'Menu item successfully deleted.';
$lang['delete_item_error']   = 'Unable to delete menu item.';

// Item title.
$lang['item_title']     = 'Item Title';
$lang['item_title_tip'] = 'This will be the text to display.';

// Item URL
$lang['item_href']     = 'Item URL';
$lang['item_href_tip'] = 'Enter the URL of your menu item.';

// Item description.
$lang['item_description']     = 'Item Description';
$lang['item_description_tip'] = 'The description will be displayed in the menu if the current theme supports it.';

// Item order.
$lang['item_order']     = 'Item Order';
$lang['item_order_tip'] = '(Optional) The order of your item within the menu.';

// Advanced item inputs.
$lang['title_attr'] = 'Title Attribute';
$lang['css_classes'] = 'CSS Classes';
$lang['link_relation'] = 'Link Relationship (XFN)';

// Linkt target.
$lang['link_target']     = 'Link Target';
$lang['link_target_tip'] = 'Open the link in a new window.';

// ------------------------------------------------------------------------

// Manage locations.
$lang['manage_locations']     = 'Manage Locations';
$lang['menu_location']        = 'Menu Location';
$lang['theme_locations']      = 'Theme Locations';
$lang['assign_menu']          = 'Assign Menu';
$lang['theme_locations_tip']  = 'Your theme supports %s menus. Select which menu appears in each location.';
$lang['theme_locations_none'] = 'You theme does not support menus.';
$lang['select_menu']          = '&#151; Select a Menu &#151;';

$lang['menu_location_success'] = 'Menus locations successfully updated.';
$lang['menu_location_error']   = 'Unable to update menus locations.';
