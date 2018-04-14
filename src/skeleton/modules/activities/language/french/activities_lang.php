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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */

$lang['sac_activity'] = 'Activité';
$lang['sac_activities'] = 'Activités';

// Dashboard title;
$lang['sac_activity_log'] = 'Historique d\'activité';

// Activities table headings.
$lang['sac_user']       = 'Utilisateur';
$lang['sac_module']     = 'Module';
$lang['sac_method']     = 'Méthode';
$lang['sac_ip_address'] = 'Adresse IP';
$lang['sac_date']       = 'Date';
$lang['sac_action']     = 'Action';

// Activities delete messages.
$lang['sac_activity_delete_confirm'] = 'Êtes-vous sûr de vouloir supprimer cette activité?';
$lang['sac_activity_delete_success'] = 'Activité supprimée avec succès.';
$lang['sac_activity_delete_error']   = 'Impossible de supprimer l\'activité.';

// ------------------------------------------------------------------------
// Modules activities lines.
// ------------------------------------------------------------------------

// Language module.
$lang['act_language_enable']  = 'Langue activée: %s.';
$lang['act_language_disable'] = 'Langue désactivée: %s.';
$lang['act_language_default'] = '%s utilisé comme langue par défaut.';

// Media module.
$lang['act_media_upload'] = 'Média téléchargé: #%s';
$lang['act_media_update'] = 'Média mis à jour: #%s';
$lang['act_media_delete'] = 'Média supprimé: #%s';

// Users module.
$lang['act_user_register']  = 'Nouvelle inscription.';
$lang['act_user_resend']    = 'Demande de Code d\'activation: <abbr title="%s">%s</abbr>';
$lang['act_user_restore']   = 'Compte restauré.';
$lang['act_user_activated'] = 'Adresse e-mail vérifiée.';
$lang['act_user_recover']   = 'Demande de réinitialisation du mot de passe: <abbr title="%s">%s</abbr>';
$lang['act_user_reset']     = 'Mot de passe réinitialisé.';
$lang['act_user_login']     = 'Nouvelle connexion.';

$lang['act_user_create']     = 'Utilisateur créé: #%s';
$lang['act_user_update']     = 'Utilisateur mis à jour: #%s';
$lang['act_user_activate']   = 'Utilisateur activé: #%s';
$lang['act_user_deactivate'] = 'Utilisateur désactivé: #%s';
$lang['act_user_delete']     = 'Utilisateur supprimé: #%s';
$lang['act_user_restore']    = 'Utilisateur restauré: #%s';
$lang['act_user_remove']     = 'Utilisateur retiré: #%s';

// Menus module.
$lang['act_menus_add_menu']         = 'Menu ajouté: #%s';
$lang['act_menus_edit_menu']        = 'Menu modifié: #%s';
$lang['act_menus_update_locations'] = 'Emplacements des menus mis à jour.';
$lang['act_menus_add_item']         = 'Élément de menu ajouté: #%s';
$lang['act_menus_update_items']     = 'Éléments de menu mis à jour: #%s';
$lang['act_menus_delete_menu']      = 'Menu supprimé: #%s';
$lang['act_menus_delete_item']      = 'Élément de menu supprimé: #%s';

// Plugins Module.
$lang['act_plugin_activate']   = 'Extension activée: %s';
$lang['act_plugin_deactivate'] = 'Extension désactivée: %s';
$lang['act_plugin_delete']     = 'Extension supprimée: %s';

// Themes plugin.
$lang['act_themes_activate'] = 'Thème activé: %s';
$lang['act_themes_delete']   = 'Thème supprimé: %s';
$lang['act_themes_install']  = 'Thème installé: %s';
$lang['act_themes_upload']   = 'Thème téléchargé: %s';
