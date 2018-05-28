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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins language file (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

// Main lines.
$lang['CSK_PLUGINS']         = 'Plug-ins';
$lang['CSK_PLUGINS_PLUGIN']  = 'Plug-in';
$lang['CSK_PLUGINS_PLUGINS'] = 'Plug-ins';

// Settings lines.
$lang['CSK_PLUGINS_SETTINGS']      = 'Paramètre du plug-in';
$lang['CSK_PLUGINS_SETTINGS_NAME'] = 'Paramètre du plug-in: %s';

// Plugins actions.
$lang['CSK_PLUGINS_ACTIVATE']   = 'Activer';
$lang['CSK_PLUGINS_ADD']        = 'Ajouter un plug-in';
$lang['CSK_PLUGINS_DEACTIVATE'] = 'Désactiver';
$lang['CSK_PLUGINS_DELETE']     = 'Supprimer';
$lang['CSK_PLUGINS_DETAILS']    = 'Détails';
$lang['CSK_PLUGINS_INSTALL']    = 'Installer le plug-in';
$lang['CSK_PLUGINS_SETTINGS']   = 'Paramètres';
$lang['CSK_PLUGINS_UPLOAD']     = 'Téléverser un plug-in';

// Upload tip.
$lang['CSK_PLUGINS_UPLOAD_TIP'] = 'Si vous avez un plug-in au format .zip, vous pouvez l\'installer en la téléversant ici.';

// Confirmation messages.
$lang['CSK_PLUGINS_CONFIRM_ACTIVATE']   = 'Êtes-vous sûr de vouloir activer le plug-in %s?';
$lang['CSK_PLUGINS_CONFIRM_DEACTIVATE'] = 'Êtes-vous sûr de vouloir désactiver le plug-in %s?';
$lang['CSK_PLUGINS_CONFIRM_DELETE']     = 'Êtes-vous sûr de vouloir supprimer le plug-in %s et toutes ses données?';

// Success messages.
$lang['CSK_PLUGINS_SUCCESS_ACTIVATE']        = 'Plug-in %s activé avec succès.';
$lang['CSK_PLUGINS_SUCCESS_DEACTIVATE']      = 'Plug-in %s désactivé avec succès.';
$lang['CSK_PLUGINS_SUCCESS_DELETE']          = 'Plug-in %s supprimé avec succès.';
$lang['CSK_PLUGINS_SUCCESS_INSTALL']         = 'Plug-in installé avec succès.';
$lang['CSK_PLUGINS_SUCCESS_SETTINGS']        = 'Les paramètres du plug-in ont bien été mis à jour.';
$lang['CSK_PLUGINS_SUCCESS_UPLOAD']          = 'Plug-in téléversé avec succès.';
$lang['CSK_PLUGINS_SUCCESS_BULK_ACTIVATE']   = 'Les plug-ins sélectionnés ont été activés avec succès.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DEACTIVATE'] = 'Les plug-ins sélectionnés ont été désactivés avec succès.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DELETE']     = 'Les plug-ins sélectionnés ont été supprimés avec succès.';

// Error messages.
$lang['CSK_PLUGINS_ERROR_ACTIVATE']        = 'Impossible d\'activer le plug-in %s.';
$lang['CSK_PLUGINS_ERROR_DEACTIVATE']      = 'Impossible de désactiver le plug-in %s.';
$lang['CSK_PLUGINS_ERROR_DELETE']          = 'Impossible de supprimer le plug-in %s.';
$lang['CSK_PLUGINS_ERROR_INSTALL']         = 'Impossible d\'installer le plug-in.';
$lang['CSK_PLUGINS_ERROR_SETTINGS']        = 'Impossible de mettre à jour les paramètres du plug-in.';
$lang['CSK_PLUGINS_ERROR_UPLOAD']          = 'Impossible de téléverser le plug-in.';
$lang['CSK_PLUGINS_ERROR_BULK_ACTIVATE']   = 'Impossible d\'activer les plug-ins sélectionnés.';
$lang['CSK_PLUGINS_ERROR_BULK_DEACTIVATE'] = 'Impossible de désactiver les plug-ins sélectionnés.';
$lang['CSK_PLUGINS_ERROR_BULK_DELETE']     = 'Impossible de supprimer les plug-ins sélectionnés.';

// Errors when performing actions.
$lang['CSK_PLUGINS_ERROR_PLUGIN_MISSING']    = 'Ce plug-in n\'existe pas.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_DISABLED'] = 'Vous pouvez uniquement mettre à jour les paramètres des plug-ins activés.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_MISSING']  = 'Ce plug-in n\'a pas de page de paramètres.';

// Plugin details.
$lang['CSK_PLUGINS_DETAILS']      = 'Détails du plug-in';
$lang['CSK_PLUGINS_NAME']         = 'Nom';
$lang['CSK_PLUGINS_FOLDER']       = 'Répertoire';
$lang['CSK_PLUGINS_URI']          = 'Lien du plug-in';
$lang['CSK_PLUGINS_DESCRIPTION']  = 'Description';
$lang['CSK_PLUGINS_VERSION']      = 'Version';
$lang['CSK_PLUGINS_LICENSE']      = 'Licence';
$lang['CSK_PLUGINS_LICENSE_URI']  = 'Lien de la licence';
$lang['CSK_PLUGINS_AUTHOR']       = 'Auteur';
$lang['CSK_PLUGINS_AUTHOR_URI']   = 'Site de l\'auteur';
$lang['CSK_PLUGINS_AUTHOR_EMAIL'] = 'Email de l\'auteur';
$lang['CSK_PLUGINS_TAGS']         = 'Mots clés';
$lang['CSK_PLUGINS_ZIP']          = 'Fichier ZIP du plug-in';

// With extra string after.
$lang['CSK_PLUGINS_DETAILS_NAME'] = 'Détails du plug-in: %s';
$lang['CSK_PLUGINS_VERSION_NUM']  = 'Version: %s';
$lang['CSK_PLUGINS_LICENSE_NAME'] = 'Licence: %s';
$lang['CSK_PLUGINS_AUTHOR_NAME']  = 'Par %s';
$lang['CSK_PLUGINS_TAGS_LIST']    = 'Mots Clés: %s';

// Plugins filters.
$lang['CSK_PLUGINS_FILTER_ALL']      = 'Tous (%s)';
$lang['CSK_PLUGINS_FILTER_ACTIVE']   = 'Activés (%s)';
$lang['CSK_PLUGINS_FILTER_INACTIVE'] = 'Désactivés (%s)';

// Plugin install filters.
$lang['CSK_PLUGINS_FILTER_FEATURED']    = 'Mis en avant';
$lang['CSK_PLUGINS_FILTER_POPULAR']     = 'Populaires';
$lang['CSK_PLUGINS_FILTER_RECOMMENDED'] = 'Recommandés';
$lang['CSK_PLUGINS_FILTER_NEW']         = 'Nouveaux';
$lang['CSK_PLUGINS_SEARCH']             = 'Rechercher des plug-ins...';

// Plugin details with links.
$lang['CSK_PLUGINS_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';
