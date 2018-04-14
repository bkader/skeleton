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
 * Users Module - Users Language (French)
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

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'Connexion';
$lang['logout']          = 'Déconnexion';
$lang['register']        = 'Inscription';
$lang['create_account']  = 'Ouvrir un compte';
$lang['forgot_password'] = 'Mot de passe oublié?';
$lang['lost_password']   = 'Mot de passe perdu';
$lang['send_link']       = 'Envoyer le lien';
$lang['resend_link']     = 'Renvoyer le lien';
$lang['restore_account'] = 'Restaurer le compte';

$lang['profile']      = 'Profil';
$lang['view_profile'] = 'Voir le profil';
$lang['edit_profile'] = 'Modifier le profil	';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'Nom d\'utilisateur';
$lang['identity']          = 'Nom d\'utilisateur ou adresse e-mail';

$lang['email_address']     = 'Adresse e-mail';
$lang['new_email_address'] = 'Nouvelle adresse e-mail';

$lang['password']          = 'Mot de passe';
$lang['new_password']      = 'Nouveau mot de passe';
$lang['confirm_password']  = 'Confirmer le mot de passe';
$lang['current_password']  = 'Mot de passe actuel';

$lang['first_name']        = 'Prénom';
$lang['last_name']         = 'Nom de famille';
$lang['full_name']         = 'Nom complet';

$lang['gender']            = 'Sexe';
$lang['male']              = 'Homme';
$lang['female']            = 'Femme';

$lang['company']  = 'Entreprise';
$lang['phone']    = 'Téléphone';
$lang['address']  = 'Adresse';
$lang['location'] = 'Emplacement';
$lang['avatar']   = 'Avatar';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title']   = 'Inscription';
$lang['us_register_heading'] = 'Ouvrir un compte';

$lang['us_register_success']     = 'Compte créé avec succès. Vous pouvez vous connecter.';
$lang['us_register_info']        = 'Compte créé avec succès. Le lien d\'activation vous a été envoyé.';
$lang['us_register_info_manual'] = 'Tous les comptes doivent être approuvés par un admin. Vous recevrez un e-mail de confirmation une fois approuvé.';
$lang['us_register_error']       = 'Impossible de créer le compte.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'Ce lien d\'activation de compte n\'est plus valide.';
$lang['us_activate_error']       = 'Impossible d\'activer le compte.';
$lang['us_activate_error']       = 'Compté activé avec succès. Vous pouvez vous connecter.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title']   = 'Renvoyer le lien';
$lang['us_resend_heading'] = 'Renvoyer le lien';

$lang['us_resend_notice']  = 'Entrer votre nom d\'utilisateur ou adresse e-mail et nous vous enverrons un lien pour activer votre compte.';
$lang['us_resend_error']   = 'Impossible de renvoyer le lien d\'activation de compte.';
$lang['us_resend_enabled'] = 'Ce compte est déjà activé.';
$lang['us_resend_success'] = 'Le lien d\'activation vous a été envoyé. Veuillez vérifier votre e-mail.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'Connexion';
$lang['us_login_heading'] = 'Espace Membre';
$lang['remember_me']      = 'Se souvenir de moi';

$lang['us_wrong_credentials'] = 'Nom d\'utilisateur/adresse e-mail et/ou mot de passe Invalide.';
$lang['us_account_missing']   = 'Cet utilisateur n\'existe pas.';
$lang['us_account_disabled']  = 'Votre compte n\'a pas encore été activé. Veuillez utiliser le lien d\'activation qui vous a été envoyé, ou bien %s pour en recevoir un nouveau.';
$lang['us_account_banned']        = 'Cet utilisateur est banni du site.';
$lang['us_account_deleted']       = 'Votre compte a été supprimé mais pas encore retiré de la base de données. %s si vous souhaitez le restaurer.';
$lang['us_account_deleted_admin'] = 'Votre compte a été supprimé par un administrateur, vous ne pouvez donc pas le restaurer. N\'hésitez pas à nous contacter pour plus de détails.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'Mot de passe perdu';
$lang['us_recover_heading'] = 'Mot de passe perdu';

$lang['us_recover_notice']  = 'Entrez votre nom d\'utilisateur ou votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.';
$lang['us_recover_success'] = 'Le lien de réinitialisation du mot de passe vous a été envoyé';
$lang['us_recover_error']   = 'Impossible d\'envoyer le lien de réinitialisation du mot de passe.';

// ------------------------------------------------------------------------
// Reset password page.
// ------------------------------------------------------------------------
$lang['us_reset_title']   = 'Réinitialiser le mot de passe';
$lang['us_reset_heading'] = 'Réinitialiser le mot de passe';

$lang['us_reset_invalid_key'] = 'Ce lien de réinitialisation de mot de passe n\'est plus valide.';
$lang['us_reset_error']       = 'Impossible de réinitialiser le mot de passe.';
$lang['us_reset_success']     = 'Mot de passe réinitialisé avec succès.';

// ------------------------------------------------------------------------
// Restore account page.
// ------------------------------------------------------------------------
$lang['us_restore_title']   = 'Restaurer le compte';
$lang['us_restore_heading'] = 'Restaurer le compte';

$lang['us_restore_notice']  = 'Entrez votre nom d\'utilisateur/adresse e-mail et mot de passe pour restaurer votre compte.';
$lang['us_restore_deleted'] = 'Seuls les comptes supprimés peuvent être restaurés.';
$lang['us_restore_error']   = 'Impossible de restaurer le compte.';
$lang['us_restore_success'] = 'Compte restauré avec succès. Bon retour parmi nous!';

// ========================================================================
// Dashboard lines.
// ========================================================================

$lang['user']  = 'Utilisateur';
$lang['users'] = 'Utilisateurs';

// Main dashboard heading.
$lang['us_manage_users'] = 'Gérer les utilisateurs';

// Users actions.
$lang['add_user']        = 'Ajouter un utilisateur';
$lang['edit_user']       = 'Modifier l\'utilisateur';
$lang['activate_user']   = 'Activer l\'utilisateur';
$lang['deactivate_user'] = 'Désactiver l\'utilisateur';
$lang['delete_user']     = 'Supprimer l\'utilisateur';
$lang['restore_user']    = 'Restaurer l\'utilisateur';
$lang['remove_user']     = 'Retirer l\'utilisateur';

// Users roles.
$lang['role']  = 'Rôle';
$lang['roles'] = 'Rôles';

$lang['regular']       = 'Ordinaire';
$lang['premium']       = 'Premium';
$lang['author']        = 'Auteur';
$lang['editor']        = 'Éditeur';
$lang['admin']         = 'Admin';
$lang['administrator'] = 'Administrateur';

// Users statuses.
$lang['active']   = 'Actif';
$lang['inactive'] = 'Inactif';

// Confirmation messages.
$lang['us_admin_activate_confirm']   = 'Êtes-vous sûr de vouloir activer cet utilisateur?';
$lang['us_admin_deactivate_confirm'] = 'Êtes-vous sûr de vouloir désactiver cet utilisateur?';
$lang['us_admin_delete_confirm']     = 'Êtes-vous sûr de vouloir supprimer cet utilisateur?';
$lang['us_admin_restore_confirm']    = 'Êtes-vous sûr de vouloir restaurer cet utilisateur?';
$lang['us_admin_remove_confirm']     = 'Êtes-vous sûr de vouloir supprimer cet utilisateur et toutes ses données?';

// Success messages.
$lang['us_admin_add_success']        = 'Utilisateur créé avec succès.';
$lang['us_admin_edit_success']       = 'Utilisateur mis à jour avec succès.';
$lang['us_admin_activate_success']   = 'L\'utilisateur a été activé avec succès.';
$lang['us_admin_deactivate_success'] = 'L\'utilisateur a été désactivé avec succès.';
$lang['us_admin_delete_success']     = 'Utilisateur supprimé avec succès.';
$lang['us_admin_restore_success']    = 'Utilisateur restauré avec succès.';
$lang['us_admin_remove_success']     = 'L\'utilisateur ainsi que toutes ses données ont été supprimés avec succès.';

// Error messages.
$lang['us_admin_add_error']        = 'Impossible de créer l\'utilisateur.';
$lang['us_admin_edit_error']       = 'Impossible de mettre à jour l\'utilisateur.';
$lang['us_admin_activate_error']   = 'Impossible d\'activer l\'utilisateur.';
$lang['us_admin_deactivate_error'] = 'Impossible de désactiver l\'utilisateur.';
$lang['us_admin_delete_error']     = 'Impossible de supprimer l\'utilisateur.';
$lang['us_admin_restore_error']    = 'Impossible de restaurer l\'utilisateur.';
$lang['us_admin_remove_error']     = 'Impossible de supprimer l\'utilisateur et toutes ses données.';

// Messages on own account.
$lang['us_admin_activate_error_own']   = 'Vous ne pouvez pas activer votre propre compte.';
$lang['us_admin_deactivate_error_own'] = 'Vous ne pouvez pas désactiver votre propre compte.';
$lang['us_admin_delete_error_own']     = 'Vous ne pouvez pas supprimer votre propre compte.';
$lang['us_admin_restore_error_own']    = 'Vous ne pouvez pas restaurer votre propre compte.';
$lang['us_admin_remove_error_own']     = 'Vous ne pouvez pas supprimer votre propre compte.';

// ========================================================================
// Users settings lines.
// ========================================================================

// Pages titles.
$lang['set_profile_title']  = 'Mettre à jour le profil';
$lang['set_avatar_title']   = 'Mettre à jour Avatar';
$lang['set_password_title'] = 'Changer le mot de passe';
$lang['set_email_title']    = 'Changer l\'e-mail';

// Pages headings.
$lang['set_profile_heading']  = $lang['set_profile_title'];
$lang['set_avatar_heading']   = $lang['set_avatar_title'];
$lang['set_password_heading'] = $lang['set_password_title'];
$lang['set_email_heading']    = $lang['set_email_title'];

// Success messages.
$lang['set_profile_success']  = 'Profil mis à jour avec succès.';
$lang['set_avatar_success']   = 'Avatar mis à jour avec succès.';
$lang['set_password_success'] = 'Mot de passe changé avec succès.';
$lang['set_email_success']    = 'Adresse e-mail changée avec succès.';

// Error messages.
$lang['set_profile_error']     = 'Impossible de mettre à jour le profil.';
$lang['set_avatar_error']      = 'Impossible de mettre à jour l\'avatar.';
$lang['set_password_error']    = 'Impossible de changer le mot de passe.';
$lang['set_email_error']       = 'Impossible de changer l\'adresse e-mail';
$lang['set_email_invalid_key'] = 'Ce lien de confirmation d\'adresse e-mail n\'est plus valide.';

// Info messages.
$lang['set_email_info'] = 'Un lien pour changer votre adresse email a été envoyé à votre nouvelle adresse.';

// Avatar extra lines.
$lang['update_avatar']       = 'Mettre à jour Avatar';
$lang['add_image']           = 'Ajouter une image';
$lang['use_gravatar']        = 'Utilisez Gravatar';
$lang['use_gravatar_notice'] = 'Si vous cochez cette option, votre photo de profil téléchargée sera supprimée et votre image <a href="%s" target="_blank">Gravatar</a> sera utilisée à la place.';
