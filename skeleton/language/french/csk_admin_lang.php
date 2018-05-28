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
 * Dashboard main language file (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.1
 */
// ------------------------------------------------------------------------
// Navbar items.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_DASHBOARD']   = 'Tableau de bord';
$lang['CSK_ADMIN_ADMIN_PANEL'] = 'Panneau d\'administration';

// System menu.
$lang['CSK_ADMIN_SYSTEM']             = 'Système';
$lang['CSK_ADMIN_GLOBAL_SETTINGS']    = 'Configuration';
$lang['CSK_ADMIN_SYSTEM_INFORMATION'] = 'Informations système';

// Users menu.
$lang['CSK_ADMIN_USERS']        = 'Utilisateurs';
$lang['CSK_ADMIN_USERS_MANAGE'] = 'Gérer les utilisateurs';
$lang['CSK_ADMIN_USERS_GROUPS'] = 'Groupes';
$lang['CSK_ADMIN_USERS_LEVELS'] = 'Niveaux d\'accès';

// Content menu.
$lang['CSK_ADMIN_CONTENT'] = 'Contenu';

// Components Menu.
$lang['CSK_ADMIN_COMPONENTS'] = 'Composants';

// Extensions menu.
$lang['CSK_ADMIN_EXTENSIONS']        = 'Extensions';
$lang['CSK_ADMIN_MODULES']           = 'Modules';
$lang['CSK_ADMIN_PLUGINS']           = 'Plug-ins';
$lang['CSK_ADMIN_THEMES']            = 'Thèmes';
$lang['CSK_ADMIN_LANGUAGES']         = 'Langues';
$lang['CSK_ADMIN_LANGUAGES_DEFAULT'] = 'Langue - Default';

// Reports menu.
$lang['CSK_ADMIN_REPORTS'] = 'Activités';

// Help menu.
$lang['CSK_ADMIN_DOCUMENTATION'] = 'Documentation';
$lang['CSK_ADMIN_TRANSLATIONS']  = 'Traductions';
$lang['CSK_ADMIN_SKELETON_SHOP'] = 'Boutique Skeleton';

// ------------------------------------------------------------------------
// General confirmation messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_CONFIRM_ACTIVATE']         = 'Êtes-vous sûr de vouloir activer %s?';
$lang['CSK_ADMIN_CONFIRM_DEACTIVATE']       = 'Êtes-vous sûr de vouloir désactiver %s?';
$lang['CSK_ADMIN_CONFIRM_DELETE']           = 'Êtes-vous sûr de vouloir supprimer %s?';
$lang['CSK_ADMIN_CONFIRM_DELETE_PERMANENT'] = 'Êtes-vous sûr de vouloir supprimer %s et toutes ses données?';
$lang['CSK_ADMIN_CONFIRM_DELETE_SELECTED']  = 'Êtes-vous sûr de vouloir supprimer les %s sélectionnés et toutes leurs données?';
$lang['CSK_ADMIN_CONFIRM_DISABLE']          = 'Êtes-vous sûr de vouloir désactiver %s?';
$lang['CSK_ADMIN_CONFIRM_ENABLE']           = 'Êtes-vous sûr de vouloir activer %s?';
$lang['CSK_ADMIN_CONFIRM_INSTALL']          = 'Êtes-vous sûr de vouloir installer %s?';
$lang['CSK_ADMIN_CONFIRM_RESTORE']          = 'Êtes-vous sûr de vouloir récupérer %s?';
$lang['CSK_ADMIN_CONFIRM_UPLOAD']           = 'Êtes-vous sûr de vouloir téléverser %s?';

// ------------------------------------------------------------------------
// General success messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_SUCCESS_ACTIVATE']         = '%s activé avec succès.';
$lang['CSK_ADMIN_SUCCESS_DEACTIVATE']       = '%s désactivé avec succès.';
$lang['CSK_ADMIN_SUCCESS_DELETE']           = '%s supprimé avec succès.';
$lang['CSK_ADMIN_SUCCESS_DELETE_PERMANENT'] = '%s et ses données supprimés avec succès.';
$lang['CSK_ADMIN_SUCCESS_DELETE_SELECTED']  = 'Les %s sélectionnés et toutes leurs données supprimés avec succès.';
$lang['CSK_ADMIN_SUCCESS_DISABLE']          = '%s déctivé avec succès.';
$lang['CSK_ADMIN_SUCCESS_ENABLE']           = '%s activé avec succès.';
$lang['CSK_ADMIN_SUCCESS_INSTALL']          = '%s installé avec succès.';
$lang['CSK_ADMIN_SUCCESS_RESTORE']          = '%s récupéré avec succès.';
$lang['CSK_ADMIN_SUCCESS_UPLOAD']           = '%s téléversé avec succès.';

// ------------------------------------------------------------------------
// General Error messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_ERROR_ACTIVATE']         = 'Impossible d\'activer %s.';
$lang['CSK_ADMIN_ERROR_DEACTIVATE']       = 'Impossible de désactiver %s.';
$lang['CSK_ADMIN_ERROR_DELETE']           = 'Impossible de supprimer %s.';
$lang['CSK_ADMIN_ERROR_DELETE_PERMANENT'] = 'Impossible de supprimer %s et ses données.';
$lang['CSK_ADMIN_ERROR_DELETE_SELECTED']  = 'Impossible de supprimer les %s sélectionnés et toutes leurs données.';
$lang['CSK_ADMIN_ERROR_DISABLE']          = 'Impossible de désactiver %s.';
$lang['CSK_ADMIN_ERROR_ENABLE']           = 'Impossible d\'activer %s.';
$lang['CSK_ADMIN_ERROR_INSTALL']          = 'Impossible d\'installer %s.';
$lang['CSK_ADMIN_ERROR_RESTORE']          = 'Impossible de récupérer %s.';
$lang['CSK_ADMIN_ERROR_UPLOAD']           = 'Impossible de téléverser %s.';

// ------------------------------------------------------------------------
// Footer section.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_FOOTER_TEXT']  = 'Merci de votre création avec <a href="%s" target="_blank">CodeIgniter Skeleton</a>.';
$lang['CSK_ADMIN_VERSION_TEXT'] = 'Version: <strong>%s</strong> &#124; {elapsed_time}';

// ------------------------------------------------------------------------
// Misc.
// ------------------------------------------------------------------------

// Table actions.
$lang['CSK_ADMIN_ACTION']  = 'Action';
$lang['CSK_ADMIN_ACTIONS'] = 'Actions';

// ------------------------------------------------------------------------
// Different statuses.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_STATUS']   = 'Statut';
$lang['CSK_ADMIN_STATUSES'] = 'Statuts';

$lang['CSK_ADMIN_ACTIVATED']   = 'Activé';
$lang['CSK_ADMIN_ACTIVE']      = 'Actif';
$lang['CSK_ADMIN_ADDED']       = 'Ajouté';
$lang['CSK_ADMIN_CANCELED']    = 'Annulé';
$lang['CSK_ADMIN_CREATED']     = 'Créé';
$lang['CSK_ADMIN_DEACTIVATED'] = 'Désactivé';
$lang['CSK_ADMIN_DELETED']     = 'Supprimé';
$lang['CSK_ADMIN_DISABLED']    = 'Désactivé';
$lang['CSK_ADMIN_EDITED']      = 'Modifié';
$lang['CSK_ADMIN_ENABLED']     = 'Activé';
$lang['CSK_ADMIN_INACTIVE']    = 'Inactif';
$lang['CSK_ADMIN_REMOVED']     = 'Retiré';
$lang['CSK_ADMIN_SAVED']       = 'Enregistré';
$lang['CSK_ADMIN_UPDATED']     = 'Mis à jour';
