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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modules language file (French)
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

$lang['CSK_MODULES']         = 'Modules';
$lang['CSK_MODULES_MODULE']  = 'Module';
$lang['CSK_MODULES_MODULES'] = 'Modules';

// Modules actions.
$lang['CSK_MODULES_ACTIVATE']   = 'Activer';
$lang['CSK_MODULES_ADD']        = 'Ajouter';
$lang['CSK_MODULES_DEACTIVATE'] = 'Désactiver';
$lang['CSK_MODULES_DELETE']     = 'Supprimer';
$lang['CSK_MODULES_DETAILS']    = 'Détails';
$lang['CSK_MODULES_INSTALL']    = 'Installer';
$lang['CSK_MODULES_SETTINGS']   = 'Paramètres';
$lang['CSK_MODULES_UPLOAD']     = 'Téléverser';

// Upload tip.
$lang['CSK_MODULES_UPLOAD_TIP'] = 'Si vous avez un module au format .zip, vous pouvez l\'installer en la téléversant ici.';

// Confirmation messages.
$lang['CSK_MODULES_CONFIRM_ACTIVATE']   = 'Êtes-vous sûr de vouloir activer le module %s?';
$lang['CSK_MODULES_CONFIRM_DEACTIVATE'] = 'Êtes-vous sûr de vouloir désactiver le module %s?';
$lang['CSK_MODULES_CONFIRM_DELETE']     = 'Êtes-vous sûr de vouloir supprimer le module %s et toutes ses données?';

// Success messages.
$lang['CSK_MODULES_SUCCESS_ACTIVATE']   = 'Le module %s a été activé avec succès.';
$lang['CSK_MODULES_SUCCESS_DEACTIVATE'] = 'Le module %s a été désactivé avec succès.';
$lang['CSK_MODULES_SUCCESS_DELETE']     = 'Le module %s a été supprimer avec succès.';
$lang['CSK_MODULES_SUCCESS_INSTALL']    = 'Module installé avec succès.';
$lang['CSK_MODULES_SUCCESS_UPLOAD']     = 'Module supprimé avec succès.';

// Error messages.
$lang['CSK_MODULES_ERROR_ACTIVATE']      = 'Impossible d\'activer le module %s.';
$lang['CSK_MODULES_ERROR_DEACTIVATE']    = 'Impossible de désactiver le module %s.';
$lang['CSK_MODULES_ERROR_DELETE']        = 'Impossible de supprimer le module %s.';
$lang['CSK_MODULES_ERROR_INSTALL']       = 'Impossible d\'installer le module.';
$lang['CSK_MODULES_ERROR_UPLOAD']        = 'Impossible de téléverser le module.';
$lang['CSK_MODULES_ERROR_DELETE_ACTIVE'] = 'Veuillez désactiver le module %s avant de le supprimer.';

// Errors when performing actions.
$lang['CSK_MODULES_ERROR_MODULE_MISSING'] = 'Ce module n\'existe pas.';

// Module upload location.
$lang['CSK_MODULES_LOCATION_SELECT']      = '&#151; Emplacement &#151;';
$lang['CSK_MODULES_LOCATION_PUBLIC']      = 'Public';
$lang['CSK_MODULES_LOCATION_APPLICATION'] = 'Application';

// Module details.
$lang['CSK_MODULES_DETAILS']      = 'Détails du module';
$lang['CSK_MODULES_NAME']         = 'Nom';
$lang['CSK_MODULES_FOLDER']       = 'Répertoire';
$lang['CSK_MODULES_URI']          = 'Lien du module';
$lang['CSK_MODULES_DESCRIPTION']  = 'Description';
$lang['CSK_MODULES_VERSION']      = 'Version';
$lang['CSK_MODULES_LICENSE']      = 'Licence';
$lang['CSK_MODULES_LICENSE_URI']  = 'Lien de la licence';
$lang['CSK_MODULES_AUTHOR']       = 'Auteur';
$lang['CSK_MODULES_AUTHOR_URI']   = 'Site de l\'auteur';
$lang['CSK_MODULES_AUTHOR_EMAIL'] = 'Email de l\'auteur';
$lang['CSK_MODULES_TAGS']         = 'Mots clés';
$lang['CSK_MODULES_ZIP']          = 'Fichier ZIP du module';

// With extra string after.
$lang['CSK_MODULES_DETAILS_NAME'] = 'Détails du module: %s';
$lang['CSK_MODULES_VERSION_NUM']  = 'Version: %s';
$lang['CSK_MODULES_LICENSE_NAME'] = 'Licence: %s';
$lang['CSK_MODULES_AUTHOR_NAME']  = 'Par %s';
$lang['CSK_MODULES_TAGS_LIST']    = 'Mots clés: %s';

// Module install filters.
$lang['CSK_MODULES_FILTER_FEATURED']    = 'Mis en avant';
$lang['CSK_MODULES_FILTER_POPULAR']     = 'Populaires';
$lang['CSK_MODULES_FILTER_RECOMMENDED'] = 'Recommandés';
$lang['CSK_MODULES_FILTER_NEW']         = 'Nouveaux';
$lang['CSK_MODULES_SEARCH']             = 'Rechercher des modules...';

// Module details with links.
$lang['CSK_MODULES_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';
