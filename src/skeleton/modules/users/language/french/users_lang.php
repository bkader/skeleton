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
 * Users Module - Users Language (French)
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

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'Connexion';
$lang['logout']          = 'Déconnexion';
$lang['register']        = 'Inscription';
$lang['create_account']  = 'Créer un compte';
$lang['forgot_password'] = 'Mot de passe oublié?';
$lang['lost_password']   = 'Mot de passe perdu';
$lang['send_link']       = 'Envoyer le lien';
$lang['resend_link']     = 'Renvoyer le lien';
$lang['restore_account'] = 'Récupérer le compte';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'Nom d\'utilisateur';
$lang['identity']          = 'Identifiant ou adresse e-mail';

$lang['email_address']     = 'Adresse e-mail';
$lang['new_email_address'] = 'Nouvelle adresse e-mail';

$lang['password']          = 'Mot de passe';
$lang['new_password']      = 'Nouveau mot de passe';
$lang['confirm_password']  = 'Confirmer le mot de passe';
$lang['current_password']  = 'Mot de passe actuel';

$lang['first_name']        = 'Prénom';
$lang['last_name']         = 'Nom';
$lang['full_name']         = 'Nom complet';

$lang['gender']            = 'Sexe';
$lang['male']              = 'Home';
$lang['female']            = 'Femme';

$lang['company']  = 'Entreprise';
$lang['phone']    = 'Téléphone';
$lang['address']  = 'Adresse';
$lang['location'] = 'Localisation';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title'] = 'Inscription';
$lang['us_register_heading'] = 'Créer un compte';

$lang['us_register_success'] = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
$lang['us_register_info']    = 'Compte créé avec succès. Le lien d\'activation vous a été envoyé.';
$lang['us_register_error']   = 'Impossible de créer le compte.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'Ce lien d\'activation de compte n\'est plus valide.';
$lang['us_activate_error']       = 'Impossible d\'activer le compte.';
$lang['us_activate_success']     = 'Compte activé avec succès. Vous pouvez maintenant vous connecter.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title'] = 'Renvoyer le lien d\'activation';
$lang['us_resend_heading'] = 'Envoyer le lien';

$lang['us_resend_notice']  = 'Entrez votre nom d\'utilisateur ou votre adresse e-mail et nous vous enverrons un lien pour activer votre compte.';
$lang['us_resend_error']   = 'Impossible de renvoyer le lien d\'activation du compte.';
$lang['us_resend_enabled'] = 'This account is already enabled.';
$lang['us_resend_success'] = 'Account activation link successfully resent. Check your inbox or spam.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'Connexion';
$lang['us_login_heading'] = 'Espace Membre';
$lang['remember_me']      = 'Se souvenir de moi';

$lang['us_wrong_credentials'] = 'Identifiant/adresse e-mail et/ou mot de passe incorrect.';
$lang['us_account_disabled']  = 'Votre compte n\'est pas encore actif. Utilisez le lien qui vous a été envoyé ou %s pour en recevoir un nouveau.';
$lang['us_account_banned']    = 'Cet utilisateur est banni du site.';
$lang['us_account_deleted']   = 'Votre compte a été supprimé mais pas encore supprimé de la base de données. %s si vous souhaitez le récupérer.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'Mot de passe perdu';
$lang['us_recover_heading'] = 'Mot de passe perdu';

$lang['us_recover_notice']  = 'Entrez votre nom d\'utilisateur ou votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.';
$lang['us_recover_success'] = 'Le lien de réinitialisation du mot de passe a été envoyé.';
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
$lang['us_restore_title']   = 'Récupérer le compte';
$lang['us_restore_heading'] = 'Récupérer le compte';

$lang['us_restore_notice']  = 'Entrez votre nom d\'utilisateur/adresse e-mail et mot de passe pour récupérer votre compte.';
$lang['us_restore_deleted'] = 'Seuls les comptes supprimés peuvent être restaurés.';
$lang['us_restore_error']   = 'Impossible de récupérer le compte.';
$lang['us_restore_success'] = 'Compte récupéré avec succès. Bon retour parmi nous!';
