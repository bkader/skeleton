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
 * @since 		1.0.0
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
 * @since 		1.0.0
 * @version 	1.3.3
 */

// Pages title.
$lang['smn_manage_menus']     = 'Manage Menus';
$lang['smn_manage_locations'] = 'Manage Locations';
$lang['smn_menu_items']       = 'Menu Items';
$lang['smn_menu_items_name']  = 'Menu Items: %s';

// Action buttons.
$lang['smn_add_menu']    = 'Add Menu';
$lang['smn_add_item']    = 'Add Item';
$lang['smn_edit_menu']   = 'Edit Menu';
$lang['smn_edit_item']   = 'Edit Item';
$lang['smn_save_menu']   = 'Save Menu';
$lang['smn_save_item']   = 'Save Item';
$lang['smn_delete_menu'] = 'Delete Menu';
$lang['smn_delete_item'] = 'Delete Item';

// Actions buttons with placeholders.
$lang['smn_edit_menu_name']   = 'Edit Menu: %s';
$lang['smn_edit_item_name']   = 'Edit Item: %s';
$lang['smn_delete_menu_name'] = 'Delete Menu: %s';
$lang['smn_delete_item_name'] = 'Delete Item: %s';

// Confirmation messages.
$lang['smn_delete_menu_confirm'] = 'Are you sure you want to delete this menu?';
$lang['smn_delete_item_confirm'] = 'Are you sure you want to delete this menu item?';

// Success messages.
$lang['smn_add_menu_success']         = 'Menu successfully created.';
$lang['smn_add_item_success']         = 'Menu item successfully created.';
$lang['smn_save_menu_success']        = 'Menu successfully updated.';
$lang['smn_save_item_success']        = 'Menu item successfully updated.';
$lang['smn_delete_menu_success']      = 'Menu successfully deleted.';
$lang['smn_delete_item_success']      = 'Menu item successfully deleted.';
$lang['smn_update_locations_success'] = 'Menus locations successfully updated.';

// Error messages.
$lang['smn_add_menu_error']         = 'Unable to add menu.';
$lang['smn_add_item_error']         = 'Unable to add menu item.';
$lang['smn_save_menu_error']        = 'Unable to update menu.';
$lang['smn_save_item_error']        = 'Unable to update menu item.';
$lang['smn_delete_menu_error']      = 'Unable to delete menu.';
$lang['smn_delete_item_error']      = 'Unable to delete menu item.';
$lang['smn_update_locations_error'] = 'Unable to update menus locations.';

// Menu or item inexistent.
$lang['smn_inexistent_menu'] = 'That menu does not exists.';
$lang['smn_inexistent_item'] = 'That menu item does not exists.';

// Menus details and tips.
$lang['smn_menu_name']        = 'Menu Name';
$lang['smn_menu_slug']        = 'Menu Slug';
$lang['smn_menu_description'] = 'Menu Description';

$lang['smn_menu_name_tip']        = 'Give your menu a name, then click Add Menu.';
$lang['smn_menu_slug_tip']        = 'Enter a UNIQUE slug for your menu.';
$lang['smn_menu_description_tip'] = '(Optional) Enter your menu description.';

// Items details and tips.
$lang['smn_item_title']            = 'Title';
$lang['smn_item_url']              = 'URL';
$lang['smn_item_attribute_title']  = 'Title Attribute';
$lang['smn_item_attribute_class']  = 'CSS Classes';
$lang['smn_item_attribute_rel']    = 'Link Relationship (XFN)';
$lang['smn_item_attribute_target'] = 'Open the link in a new window';
$lang['smn_item_description']      = 'Description';

$lang['smn_item_title_tip']       = 'This will be the text to display.';
$lang['smn_item_url_tip']         = 'Enter the URL of your menu item.';
$lang['smn_item_description_tip'] = 'The description will be displayed in the menu if the current theme supports it.';

// Menu structure.
$lang['smn_menu_structure']        = 'Menu Structure';
$lang['smn_menu_structure_tip']    = 'Drag each item into the order you prefer.';

// Locations select none item.
$lang['smn_select_menu']          = '&#151; Select a Menu &#151;';
$lang['smn_theme_locations']      = 'Your theme supports %s menus. Select which menu appears in each location.';
$lang['smn_theme_locations_none'] = 'You theme does not support menus.';
