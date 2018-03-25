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
 * Menus Module - Admin Language (Spanish)
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
$lang['manage_menus'] = 'Administrar Los Menús';

// Add menu.
$lang['add_menu']         = 'Añadir Menú';
$lang['add_menu_success'] = 'Menú creado con éxito.';
$lang['add_menu_error']   = 'No se puede crear el menú.';

// Edit menu.
$lang['save_menu']         = 'Menú Guardar';
$lang['edit_menu']         = 'Menú Edición';
$lang['edit_menu_success'] = 'Menú actualizado correctamente.';
$lang['edit_menu_error']   = 'No se puede actualizar el menú.';
$lang['edit_menu_no_menu'] = 'Este menú no existe.';

// Delete menu.
$lang['delete_menu']         = 'Eliminar Del Menú';
$lang['delete_menu_success'] = 'Menú de borrado con éxito.';
$lang['delete_menu_error']   = 'No se puede eliminar del menú.';

// Menu name.
$lang['menu_name']     = 'Nombre Del Menú';
$lang['menu_name_tip'] = 'Dar a su menú un nombre, a continuación, haga clic en Añadir (add).';

// Menu slug
$lang['menu_slug']     = 'Menu De Acceso Directo';
$lang['menu_slug_tip'] = 'Escriba una ÚNICA slug para tu menú.';

// Menu description.
$lang['menu_description']     = 'Descripción De Menú';
$lang['menu_description_tip'] = '(Opcional) Escriba la descripción del menú.';

// ------------------------------------------------------------------------

$lang['menu_items']             = 'Los Elementos De Menú';
$lang['menu_structure']         = 'Estructura De Menú';
$lang['menu_structure_tip']     = 'Arrastre cada elemento en el orden que usted prefiera.';
$lang['menu_structure_success'] = 'Los elementos de menú de fin de actualizar correctamente.';
$lang['menu_structure_error']   = 'No se puede actualizar el menú orden de los elementos.';

// Add menu.
$lang['add_item']         = 'Agregar Elemento';
$lang['add_item_success'] = 'Elemento de menú creado con éxito.';
$lang['add_item_error']   = 'No se puede crear un elemento de menú.';

// Edit item.
$lang['save_item']         = 'Guardar Elemento';
$lang['edit_item']         = 'Edición De Elementos';
$lang['edit_item_success'] = 'Artículo actualizado correctamente.';
$lang['edit_item_error']   = 'No se puede actualizar el elemento de menú.';
$lang['edit_item_no_menu'] = 'Este elemento de menú no existe.';

// Delete item.
$lang['delete_item']         = 'Eliminar Elemento';
$lang['delete_item_success'] = 'Elemento de menú elimina correctamente.';
$lang['delete_item_error']   = 'No se puede eliminar el elemento de menú.';

// Item title.
$lang['item_title']     = 'Título Del Elemento';
$lang['item_title_tip'] = 'Este será el texto a mostrar.';

// Item URL
$lang['item_href']     = 'Dirección URL del elemento';
$lang['item_href_tip'] = 'Introduzca la URL de su elemento de menú.';

// Item description.
$lang['item_description']     = 'Descripción Del Artículo';
$lang['item_description_tip'] = 'La descripción se mostrará en el menú si el tema actual admite.';

// Item order.
$lang['item_order']     = 'Orden De Los Elementos';
$lang['item_order_tip'] = '(Opcional) El orden de su elemento en el menú.';

// Advanced item inputs.
$lang['title_attr'] = 'Atributo Title';
$lang['css_classes'] = 'Clases CSS';
$lang['link_relation'] = 'Vínculo de Relación (XFN)';

// Linkt target.
$lang['link_target']     = 'Destino Del Enlace';
$lang['link_target_tip'] = 'Abrir el enlace en una nueva ventana.';

// ------------------------------------------------------------------------

// Manage locations.
$lang['manage_locations']     = 'Administrar Ubicaciones';
$lang['menu_location']        = 'Ubicación Del Menú';
$lang['theme_locations']      = 'Tema Ubicaciones';
$lang['assign_menu']          = 'Menú Asignar';
$lang['theme_locations_tip']  = 'Su tema es compatible con %s de los menús. Seleccionar del menú que aparece en cada ubicación.';
$lang['theme_locations_none'] = 'Que el tema no admite menús.';
$lang['select_menu']          = '&#151; Seleccionar un Menú &#151;';

$lang['menu_location_success'] = 'Menús lugares actualizado correctamente.';
$lang['menu_location_error']   = 'No se puede actualizar los menús de ubicaciones.';
