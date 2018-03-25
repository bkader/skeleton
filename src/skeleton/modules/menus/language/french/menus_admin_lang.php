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
 * Menus Module - Admin Language (French)
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
$lang['manage_menus'] = 'Gestion des menus';

// Add menu.
$lang['add_menu']         = 'Ajouter un menu';
$lang['add_menu_success'] = 'Menu créé avec succès.';
$lang['add_menu_error']   = 'Impossible de créer le menu.';

// Edit menu.
$lang['save_menu']         = 'Enregistrer le menu';
$lang['edit_menu']         = 'Modifier le menu';
$lang['edit_menu_success'] = 'Menu mis à jour avec succès.';
$lang['edit_menu_error']   = 'Impossible de mettre à jour le menu.';
$lang['edit_menu_no_menu'] = 'Ce menu n\'existe pas.';

// Delete menu.
$lang['delete_menu']         = 'Supprimer le menu';
$lang['delete_menu_success'] = 'Menu supprimer avec succès.';
$lang['delete_menu_error']   = 'Impossible de supprimer le menu.';

// Menu name.
$lang['menu_name']     = 'Nom du menu';
$lang['menu_name_tip'] = 'Donner un nom à votre menu.';

// Menu slug
$lang['menu_slug']     = 'Menu Slug';
$lang['menu_slug_tip'] = 'Entrez un identifiant unique pour votre menu.';

// Menu description.
$lang['menu_description']     = 'Description du menu';
$lang['menu_description_tip'] = '(Facultatif) Décrivez votre menu.';

// ------------------------------------------------------------------------

$lang['menu_items']             = 'Éléments du menu';
$lang['menu_structure']         = 'Structure du menu';
$lang['menu_structure_tip']     = 'Glissez chanque élément dans l\'ordre que vous préférez.';
$lang['menu_structure_success'] = 'Éléments du menu ont été mis à jour avec succès.';
$lang['menu_structure_error']   = 'Impossible de mettre à jour les éléments du menu.';

// Add menu.
$lang['add_item']         = 'Ajouter un élément';
$lang['add_item_success'] = 'Élément ajouter avec succès.';
$lang['add_item_error']   = 'Impossible d\'ajouter l\'élément.';

// Edit item.
$lang['save_item']         = 'Enregistrer l\'élément';
$lang['edit_item']         = 'Modifier l\'élément';
$lang['edit_item_success'] = 'Élément mis à jour avec succès.';
$lang['edit_item_error']   = 'Impossible de mettre à jour l\'élément.';
$lang['edit_item_no_menu'] = 'Cet élément de menu n\'existe pas.';

// Delete item.
$lang['delete_item']         = 'Supprimer l\'élément';
$lang['delete_item_success'] = 'Élément supprimé avec succès.';
$lang['delete_item_error']   = 'Impossible de supprimer l\'élément.';

// Item title.
$lang['item_title']     = 'Titre de l\'élément';
$lang['item_title_tip'] = 'Ceci sera le texte à afficher.';

// Item URL
$lang['item_href']     = 'URL';
$lang['item_href_tip'] = 'Entrez l\'URL de votre élément.';

// Item description.
$lang['item_description']     = 'Description de l\'élément';
$lang['item_description_tip'] = 'La description sera affichée dans le menu si votre thème actuel l\'autorise.';;

// Item order.
$lang['item_order']     = 'Ordre de l\'élément';
$lang['item_order_tip'] = '(Facultatif) L\'ordre de votre élément dans le menu.';

// Advanced item inputs.
$lang['title_attr'] = 'Attribut de title';
$lang['css_classes'] = 'classes CSS';
$lang['link_relation'] = 'Relation de lien (XFN)';

// Linkt target.
$lang['link_target']     = 'Cible du lien';
$lang['link_target_tip'] = 'Ouvrir le lien dans une nouvelle fenêtre.';

// ------------------------------------------------------------------------

// Manage locations.
$lang['manage_locations']     = 'Gestion des emplacements';
$lang['menu_location']        = 'Emplacement du menu';
$lang['theme_locations']      = 'emplacements du thème';
$lang['assign_menu']          = 'Menu assigné';
$lang['theme_locations_tip']  = 'Votre thème peut utiliser %s menus. Sélectionnez les menu qui devront apparaître dans chaque emplacement.';
$lang['theme_locations_none'] = 'Votre thème ne supporte pas les menus.';
$lang['select_menu']          = '&#151; Choisir un menu &#151;';

$lang['menu_location_success'] = 'Les emplacements des menus ont été mis à jour avec succès.';
$lang['menu_location_error']   = 'Impossible de mettre à jour les emplacements des menus.';
