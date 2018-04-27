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
 * Main application language file (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.3
 */

// ------------------------------------------------------------------------
// General Buttons and Links.
// ------------------------------------------------------------------------
$lang['home']       = 'Accueil';
$lang['click_here'] = 'Cliquer Ici';
$lang['settings']   = 'Paramètres';

// ------------------------------------------------------------------------
// Forms Input.
// ------------------------------------------------------------------------

$lang['name']        = 'Nome';
$lang['title']       = 'Titre';
$lang['description'] = 'Description';
$lang['content']     = 'Contenu';
$lang['unspecified'] = 'Non spécifié';
$lang['slug']        = 'Slug';
$lang['order']       = 'Ordre';
$lang['url']         = 'URL';

$lang['meta_title']       = 'Meta Titre';
$lang['meta_description'] = 'Meta Description';
$lang['meta_keywords']    = 'Mots-clés';

$lang['email']   = 'E-mail';
$lang['captcha'] = 'Captcha';
$lang['upload']  = 'Upload';
$lang['uploads'] = 'Uploads';

// Selection options.
$lang['none'] = 'Aucun';
$lang['both'] = 'Les deux';
$lang['all']  = 'Tout';

// "More" links.
$lang['more']         = 'Plus';
$lang['more_details'] = 'Plus de détails';
$lang['view_more']    = 'Voir plus';

// Yes and No.
$lang['no']  = 'Non';
$lang['yes'] = 'Oui';

// Version and version number.
$lang['version']     = 'Version';
$lang['version_num'] = 'Version: %s';

// ------------------------------------------------------------------------
// Application buttons.
// ------------------------------------------------------------------------
$lang['action']  = 'Action';
$lang['actions'] = 'Actions';

$lang['add']    = 'Ajouter';
$lang['new']    = 'Nouveau';
$lang['create'] = 'Créer';

$lang['edit']   = 'Éditer';
$lang['update'] = 'Mettre à jour';
$lang['save']   = 'Enregister';

$lang['delete'] = 'Supprimer';
$lang['remove'] = 'Retirer';

$lang['activate']   = 'Activer';
$lang['deactivate'] = 'Désactiver';

$lang['enable']  = 'Activer';
$lang['disable'] = 'Désactiver';

$lang['back']   = 'Retour';
$lang['cancel'] = 'Annuler';

$lang['advanced'] = 'Avancé';

// Changes buttons.
$lang['discard_changed'] = 'Ignorer les modifications';
$lang['save_changes']    = 'Enregister les modifications';

// Different statuses.
$lang['status']   = 'Statut';
$lang['statuses'] = 'Statuts';

$lang['added']   = 'Ajouté';
$lang['created'] = 'Créé';

$lang['edited']  = 'Édité';
$lang['updated'] = 'Mis à jour';
$lang['saved']   = 'Sauvegardé';

$lang['deleted'] = 'Supprimé';
$lang['removed'] = 'Retiré';

$lang['activated']   = 'Activé';
$lang['deactivated'] = 'Désactivé';

$lang['active']   = 'Actif';
$lang['inactive'] = 'inactif';

$lang['enabled']  = 'Activé';
$lang['disabled'] = 'Désactivé';

$lang['canceled'] = 'Annulé';

// Actions performed by.
$lang['created_by']     = 'Créé par';
$lang['updated_by']     = 'Mis à jour par';
$lang['deleted_by']     = 'Supprimé par';
$lang['removed_by']     = 'Retiré par';
$lang['activated_by']   = 'Activé par';
$lang['deactivated_by'] = 'Désactivé par';
$lang['enabled_by']     = 'Activé par';
$lang['disabled_by']    = 'Désactivé par';
$lang['canceled_by']    = 'Annulé par';

// ------------------------------------------------------------------------
// General notices and messages.
// ------------------------------------------------------------------------

// Error messages.
$lang['error_csrf']              = 'Ce formulaire n\'a pas passé nos contrôles de sécurité.';
$lang['error_safe_url']          = 'Cette action n\'a pas réussi nos contrôles de sécurité.';
$lang['error_captcha']           = 'Le code captcha que vous avez entré est incorrect.';
$lang['error_fields_required']   = 'Tous les champs sont requis.';
$lang['error_permission']        = 'Vous n\'avez pas la permission d\'accéder à cette page.';
$lang['error_logged_in']         = 'Vous êtes déjà connecté.';
$lang['error_logged_out']        = 'Vous devez être connecté pour accéder à cette page.';
$lang['error_account_missing']   = 'Cet utilisateur n\'existe pas.';
$lang['error_action_permission'] = 'Vous n\'êtes pas autorisé à effectuer cette action.';

// ------------------------------------------------------------------------
// Form validation lines.
// ------------------------------------------------------------------------

$lang['form_validation_alpha_extra']       = 'Le champ {field} peut contenir uniquement des caractères alphanumériques, des espaces, des points, des traits de soulignement et des tirets.';
$lang['form_validation_check_credentials'] = 'Nom d\'utilisateur/adresse e-mail et/ou mot de passe invalide';
$lang['form_validation_current_password']  = 'Votre mot de passe actuel est incorrect.';
$lang['form_validation_unique_email']      = 'Cette adresse email est déjà utilisée.';
$lang['form_validation_unique_username']   = 'Ce nom d\'utilisateur n\'est pas disponible.';
$lang['form_validation_user_exists']       = 'Aucun utilisateur n\'a été trouvé avec ce nom d\'utilisateur ou adresse e-mail.';

// ========================================================================
// Dashboard Lines.
// ========================================================================

$lang['admin_panel'] = 'Panneau d\'administration';
$lang['dashboard']   = 'Tableau de bord';
$lang['view_site']   = 'Voir le site';

// Confirmation before action.
$lang['are_you_sure'] = 'Êtes-vous sûr de vouloir %s?';

// Dashboard footer.
$lang['admin_footer_text']  = 'Merci de votre création avec <a href="%s" target="_blank">CodeIgniter Skeleton</a>.';
$lang['admin_version_text'] = 'Version: <strong>%s</strong> &#124; {elapsed_time}';

// ------------------------------------------------------------------------
// Dashboard sections (singular and plural forms).
// ------------------------------------------------------------------------

// Updates page.
$lang['updates']        = 'Mises à jour';
$lang['updates_recent'] = 'Vous avez la dernière version de Codeigniter Skeleton.';
$lang['updates_old']    = 'Une nouvelle version de CodeIgniter Skeleton a été publiée. Téléchargez-la depuis <a href="%s" target="_blank">Github</a>.';

// manifest.json error.
$lang['manifest_missing_heading'] = 'Erreur de fichier manifeste';
$lang['manifest_missing_message'] = 'Le fichier "manifest.json" de ce module est manquant ou mal formaté.';

// Module disabled.
$lang['module_disabled_heading'] = 'Module désactivé';
$lang['module_disabled_message'] = 'Ce module est désactivé. Activez-le sur le tableau de bord pour l\'utiliser.';
