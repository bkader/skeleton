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
 * Plugins Module - Admin Language (French)
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

// Plugin: singular and plural forms.
$lang['spg_plugin']  = 'Extension';
$lang['spg_plugins'] = 'Extensions';

// Dashboard title.
$lang['spg_manage_plugins'] = 'Gérer les extensions';

// Plugin' settings page.
$lang['spg_plugin_settings']      = 'Paramètres de l\'extension';
$lang['spg_plugin_settings_name'] = 'Paramètres: %s';

// Plugins actions.
$lang['spg_plugin_activate']   = 'Activer';
$lang['spg_plugin_add']        = 'Ajouter des extensions';
$lang['spg_plugin_deactivate'] = 'Désactiver';
$lang['spg_plugin_delete']     = 'Supprimer';
$lang['spg_plugin_details']    = 'Détails';
$lang['spg_plugin_install']    = 'Installer l\'extension';
$lang['spg_plugin_settings']   = 'Paramètres';
$lang['spg_plugin_upload']     = 'Téléverser une extension';

$lang['spg_plugin_upload_tip'] = 'Si vous avez une extension au format .zip, vous pouvez l\'installer en la téléversant ici.';

// Confirmation messages.
$lang['spg_plugin_delete_confirm'] = 'Êtes-vous s$ur de vouloir supprimer cette extension et toutes ses données?';

// Success messages.
$lang['spg_plugin_activate_success']   = 'Extension activé avec succès.';
$lang['spg_plugin_deactivate_success'] = 'Extension désactivée avec succès.';
$lang['spg_plugin_delete_success']     = 'Extension supprimée avec succès.';
$lang['spg_plugin_install_success']    = 'Extension installée avec succès.';
$lang['spg_plugin_settings_success']   = 'Les paramètres de l\'extension ont été mis à jour.';
$lang['spg_plugin_upload_success']     = 'Extension téléversée avec succès.';

// Error messages.
$lang['spg_plugin_activate_error']   = 'Impossible d\'activer l\'extension.';
$lang['spg_plugin_deactivate_error'] = 'Impossible de désactiver l\'extension.';
$lang['spg_plugin_delete_error']     = 'Impossible de supprimer l\'extension.';
$lang['spg_plugin_install_error']    = 'Impossible d\'installer l\'extension.';
$lang['spg_plugin_settings_error']   = 'Impossible de mettre à jour les paramètres de l\'extension.';
$lang['spg_plugin_upload_error']     = 'Impossible de téléverer l\'extension.';

// Errors when performing actions.
$lang['spg_plugin_missing']           = 'Cette extension n\'existe pas.';
$lang['spg_plugin_settings_disabled'] = 'Vous ne pouvez mettre à jour que les paramètres des extensions activées.';
$lang['spg_plugin_settings_missing']  = 'Cette extension n\'a pas une page de paramètres';

// Plugin details.
$lang['spg_details']      = 'Détails de l\'extension';
$lang['spg_name']         = 'Nome';
$lang['spg_folder']       = 'Répertoire';
$lang['spg_plugin_uri']   = 'Site de l\'extension';
$lang['spg_description']  = 'Description';
$lang['spg_version']      = 'Version';
$lang['spg_license']      = 'Licence';
$lang['spg_license_uri']  = 'Licence URI';
$lang['spg_author']       = 'Auteur';
$lang['spg_author_uri']   = 'Site de l\'auteur';
$lang['spg_author_email'] = 'Email de l\'auteur';
$lang['spg_tags']         = 'Étiquettes';
$lang['spg_plugin_zip']   = 'Fichier ZIP de l\'extension';

// With extra string after.
$lang['spg_details_name'] = 'Détails de l\'extension: %s';
$lang['spg_version_num']  = 'Version: %s';
$lang['spg_license_name'] = 'Licence: %s';
$lang['spg_author_name']  = 'par %s';
$lang['spg_tags_list']    = 'Étiquettes: %s';

// Plugins filters.
$lang['spg_all']     = 'Toutes (%s)';
$lang['spg_active']  = 'Activées (%s)';
$lang['spg_inactive'] = 'Désactivées (%s)';

// Plugin install filters.
$lang['spg_featured']    = 'Mises en avant';
$lang['spg_popular']     = 'Populaires';
$lang['spg_recommended'] = 'Recommandées';
$lang['spg_new']         = 'Nouvelles';
$lang['spg_search']      = 'Rechercher des extensions...';

// Plugin details with links.
$lang['spg_plugin_author_uri']   = '<a href="%1$s" target="_blank" rel="nofollow">Site Web</a>';
$lang['spg_plugin_license']      = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['spg_plugin_author']       = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['spg_plugin_author_email'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';
