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
 * Menus Module - Admin Language (French)
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
$lang['smn_manage_menus']     = 'Gérer les menus';
$lang['smn_manage_locations'] = 'Gérer les emplacements';
$lang['smn_menu_items']       = 'Éléments du menu';
$lang['smn_menu_items_name']  = 'Éléments du menu: %s';

// Action buttons.
$lang['smn_add_menu']    = 'Nouveau menu';
$lang['smn_add_item']    = 'Nouvel élément';
$lang['smn_edit_menu']   = 'Modifier le menu';
$lang['smn_edit_item']   = 'Modifier l\'élément';
$lang['smn_save_menu']   = 'Enregister le menu';
$lang['smn_save_item']   = 'Enregister l\'élément';
$lang['smn_delete_menu'] = 'Supprimer le menu';
$lang['smn_delete_item'] = 'Supprimer l\'élément';

// Actions buttons with placeholders.
$lang['smn_edit_menu_name']   = 'Modifier le menu: %s';
$lang['smn_edit_item_name']   = 'Modifier l\'élément: %s';
$lang['smn_delete_menu_name'] = 'Supprimer le menu: %s';
$lang['smn_delete_item_name'] = 'Supprimer l\'élément: %s';

// Confirmation messages.
$lang['smn_delete_menu_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce menu?';
$lang['smn_delete_item_confirm'] = 'Êtes-vous sûr de vouloir supprimer cet élément de menu?';

// Success messages.
$lang['smn_add_menu_success']         = 'Menu créé avec succès.';
$lang['smn_add_item_success']         = 'Élément de menu créé avec succès.';
$lang['smn_save_menu_success']        = 'Menu mis à jour avec succès.';
$lang['smn_save_item_success']        = 'Élément de menu mis à jour avec succès.';
$lang['smn_delete_menu_success']      = 'Menu supprimé avec succès.';
$lang['smn_delete_item_success']      = 'Élément de menu supprimé avec succès.';
$lang['smn_update_locations_success'] = 'Les emplacements des menus ont été mis à jour avec succès.';

// Error messages.
$lang['smn_add_menu_error']         = 'Impossible d\'ajouter le menu';
$lang['smn_add_item_error']         = 'Impossible d\'ajouter l\'élément de menu.';
$lang['smn_save_menu_error']        = 'Impossible de mettre à jour le menu.';
$lang['smn_save_item_error']        = 'Impossible de mettre à jour l\'élément de menu.';
$lang['smn_delete_menu_error']      = 'Impossible de supprimer le menu.';
$lang['smn_delete_item_error']      = 'Impossible de supprimer l\'élément de menu.';
$lang['smn_update_locations_error'] = 'Impossible de modifier les emplacements des menus.';

// Menu or item inexistent.
$lang['smn_inexistent_menu'] = 'Ce menu n\'existe pas.';
$lang['smn_inexistent_item'] = 'Cet élément de menu n\'existe pas.';

// Menus details and tips.
$lang['smn_menu_name']        = 'Nom';
$lang['smn_menu_slug']        = 'Identifiant';
$lang['smn_menu_description'] = 'Description';

$lang['smn_menu_name_tip']        = 'Donnez un nom à votre menu, puis cliquez sur Nouveau menu.';
$lang['smn_menu_slug_tip']        = 'Entrez un identifiant UNIQUE pour votre menu.';
$lang['smn_menu_description_tip'] = '(Facultatif) Donnez une description à votre menu.';

// Items details and tips.
$lang['smn_item_title']            = 'Titre';
$lang['smn_item_url']              = 'URL';
$lang['smn_item_attribute_title']  = 'Attribut de titre';
$lang['smn_item_attribute_class']  = 'Classes CSS';
$lang['smn_item_attribute_rel']    = 'Relation avec le propriétaire du site lié (XFN)';
$lang['smn_item_attribute_target'] = 'Ouvrir le lien dans un nouvel onglet';
$lang['smn_item_description']      = 'Description';

$lang['smn_item_title_tip']       = 'Ce sera le texte à afficher.';
$lang['smn_item_url_tip']         = 'Entrez l\'URL de votre élément de menu.';
$lang['smn_item_description_tip'] = 'La description sera affichée dans le menu si le thème actuel l\'accepte.';

// Menu structure.
$lang['smn_menu_structure']        = 'Structure du menu';
$lang['smn_menu_structure_tip']    = 'Glissez chaque élément pour les placer dans l’ordre que vous préférez.';

// Locations select none item.
$lang['smn_select_menu']          = '&#151; Choisir un menu &#151;';
$lang['smn_theme_locations']      = 'Votre thème peut utiliser %s menus. Sélectionnez les menu qui devront apparaître dans chaque emplacement.';
$lang['smn_theme_locations_none'] = 'Votre thème ne prend pas en charge nativement les menus.';
