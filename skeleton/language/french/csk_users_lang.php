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
 * Users language file (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

$lang['CSK_USERS_MANAGE_USERS'] = 'Gérer les utilisateurs';
$lang['CSK_USERS_MEMBER_LOGIN'] = 'Espace Membres';

// Users actions.
$lang['CSK_USERS_ADD_USER']  = 'Nouvel utilisateur';
$lang['CSK_USERS_ADD_GROUP'] = 'Nouveau groupe';
$lang['CSK_USERS_ADD_LEVEL'] = 'Nouveau niveau d\'accès';

$lang['CSK_USERS_EDIT_USER']  = 'Modifier l\'utilisateur';
$lang['CSK_USERS_EDIT_GROUP'] = 'Modifier le groupe';
$lang['CSK_USERS_EDIT_LEVEL'] = 'Modifier le niveau d\'accès';

$lang['CSK_USERS_DELETE_USER']  = 'Supprimer l\'utilisateur';
$lang['CSK_USERS_DELETE_GROUP'] = 'Supprimer le groupe';
$lang['CSK_USERS_DELETE_LEVEL'] = 'Supprimer le niveau d\'accès';

$lang['CSK_USERS_ACTIVATE_USER']   = 'Activer le compte';
$lang['CSK_USERS_DEACTIVATE_USER'] = 'Désactiver le compte';
$lang['CSK_USERS_RESTORE_USER']    = 'Récupérer le compte';
$lang['CSK_USERS_REMOVE_USER']     = 'Supprimer définitivement';

// Actions with name.
$lang['CSK_USERS_EDIT_USER_NAME']       = 'Modifier le compte: %s';
$lang['CSK_USERS_DELETE_USER_NAME']     = 'Supprimer le compte: %s';
$lang['CSK_USERS_ACTIVATE_USER_NAME']   = 'Activer le compte: %s';
$lang['CSK_USERS_DEACTIVATE_USER_NAME'] = 'Désactiver le compte: %s';

// Users roles.
$lang['CSK_USERS_ROLE']  = 'Rôle';
$lang['CSK_USERS_ROLES'] = 'Rôles';

$lang['CSK_USERS_ROLE_REGULAR']   = 'Ordinaire';	// Level: 1
$lang['CSK_USERS_ROLE_PREMIUM']   = 'Premium';		// Level: 2
$lang['CSK_USERS_ROLE_AUTHOR']    = 'Auteur';		// Level: 3
$lang['CSK_USERS_ROLE_EDITOR']    = 'Éditeur';		// Level: 4
$lang['CSK_USERS_ROLE_MANAGER']   = 'Manager'; 		// Level: 6
$lang['CSK_USERS_ROLE_ADMIN']     = 'Admin';		// Level: 9
$lang['CSK_USERS_ROLE_OWNER']     = 'Propriétaire';	// Level: 10

$lang['CSK_USERS_ROLE_ADMINISTRATOR'] = 'Admin'; // Alias of Admin.

// Users statuses.
$lang['CSK_USERS_ACTIVE']   = 'Actif';
$lang['CSK_USERS_INACTIVE'] = 'Inactif';
$lang['CSK_USERS_DELETED']  = 'Supprimé';

// Confirmation messages.
$lang['CSK_USERS_ADMIN_CONFIRM_ACTIVATE']   = 'Êtes-vous sûr de vouloir activer ce compte?';
$lang['CSK_USERS_ADMIN_CONFIRM_DEACTIVATE'] = 'Êtes-vous sûr de vouloir désactiver ce compte?';
$lang['CSK_USERS_ADMIN_CONFIRM_DELETE']     = 'Êtes-vous sûr de vouloir supprimer cet utilisateur?';
$lang['CSK_USERS_ADMIN_CONFIRM_RESTORE']    = 'Êtes-vous sûr de vouloir récupérer ce compte?';
$lang['CSK_USERS_ADMIN_CONFIRM_REMOVE']     = 'Êtes-vous sûr de vouloir supprimer définitivement ce compte et toutes ses données?';

// Success messages.
$lang['CSK_USERS_ADMIN_SUCCESS_ADD']        = 'Utilisateur créé avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_EDIT']       = 'Compte mis à jour avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_ACTIVATE']   = 'Compte activé avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_DEACTIVATE'] = 'Compte désactivé avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_DELETE']     = 'Utilisateur supprimé avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_RESTORE']    = 'Compte récupéré avec succès.';
$lang['CSK_USERS_ADMIN_SUCCESS_REMOVE']     = 'Le compte ainsi que toutes ses données ont été supprimés avec succès.';

// Error messages.
$lang['CSK_USERS_ADMIN_ERROR_ADD']        = 'Impossible d\'ajouter un utilisateur.';
$lang['CSK_USERS_ADMIN_ERROR_EDIT']       = 'Impossible de mettre à jour le compte.';
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE']   = 'Impossible d\'activer le compte.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE'] = 'Impossible de désactiver le compte.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE']     = 'Impossible de supprimer le l\'utilisateur.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE']    = 'Impossible de récupérer le compte.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE']     = 'Impossible de suppromer définitivement le compte et toutes ses données.';

// Messages on own account.
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE_OWN']   = 'Vous ne pouvez pas activer votre propre compte.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE_OWN'] = 'Vous ne pouvez pas désactiver votre propre compte.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE_OWN']     = 'Vous ne pouvez pas supprimer votre propre compte.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE_OWN']    = 'Vous ne pouvez pas récupérer votre propre compte.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE_OWN']     = 'Vous ne pouvez pas supprimer définitivement votre propre compte.';

// ------------------------------------------------------------------------
// Account creation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_CREATE']       = 'Compte créé avec succès.';
$lang['CSK_USERS_SUCCESS_CREATE_LOGIN'] = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';

// Info messages.
$lang['CSK_USERS_INFO_CREATE']        = 'Compte créé avec succès. Le lien d\'activation vous a été envoyé.';
$lang['CSK_USERS_INFO_CREATE_MANUAL'] = 'Tous les comptes doivent être approuvés par un admin. Vous recevrez un e-mail de confirmation une fois approuvé.';

// Error messages.
$lang['CSK_USERS_ERROR_CREATE'] = 'Impossible de créer le compte.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_ACTIVATE']       = 'Compté activé avec succès.';
$lang['CSK_USERS_SUCCESS_ACTIVATE_LOGIN'] = 'Compté activé avec succès. Vous pouvez maintenant vous connecter.';

// Error messages.
$lang['CSK_USERS_ERROR_ACTIVATE']         = 'Impossible d\'activer le compte.';
$lang['CSK_USERS_ERROR_ACTIVATE_ALREADY'] = 'Ce compte est déjà actif.';
$lang['CSK_USERS_ERROR_ACTIVATE_CODE']    = 'Ce lien d\'activation de compte n\'est plus valide.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RESEND_LINK'] = 'Renvoyer le lien d\'activation';
$lang['CSK_USERS_RESEND_TIP']  = 'Entrer votre nom d\'utilisateur ou adresse e-mail et nous vous enverrons un lien pour activer votre compte.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESEND'] = 'Le lien d\'activation vous a été envoyé. Veuillez vérifier votre e-mail.';

// Error message.
$lang['CSK_USERS_ERROR_RESEND'] = 'Impossible de renvoyer le lien d\'activation de compte.';

// ------------------------------------------------------------------------
// Member login.
// ------------------------------------------------------------------------
$lang['CSK_USERS_REMEMBER_ME'] = 'Se souvenir de moi';

// Error messages.
$lang['CSK_USERS_ERROR_ACCOUNT_MISSING']       = 'Cet utilisateur n\'existe pas.';
$lang['CSK_USERS_ERROR_ACCOUNT_INACTIVE']      = 'Votre compte n\'a pas encore été activé. Veuillez utiliser le lien d\'activation qui vous a été envoyé, ou bien %s pour en recevoir un nouveau.';
$lang['CSK_USERS_ERROR_ACCOUNT_BANNED']        = 'Cet utilisateur est banni du site.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED']       = 'Votre compte a été supprimé mais pas encore retiré de la base de données. %s si vous souhaitez le récupérer.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED_ADMIN'] = 'Votre compte a été supprimé par un administrateur, vous ne pouvez donc pas le récupérer. N\'hésitez pas à nous contacter pour plus de détails.';

$lang['CSK_USERS_ERROR_LOGIN_CREDENTIALS'] = 'Nom d\'utilisateur/adresse e-mail et/ou mot de passe Invalide.';

// ------------------------------------------------------------------------
// Lost password section.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RECOVER_TIP'] = 'Entrez votre nom d\'utilisateur ou votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RECOVER'] = 'Le lien de réinitialisation du mot de passe vous a été envoyé.';

// Error messages.
$lang['CSK_USERS_ERROR_RECOVER']         = 'Impossible d\'envoyer le lien de réinitialisation du mot de passe.';
$lang['CSK_USERS_ERROR_RECOVER_DELETED'] = 'Votre compte a été supprimé mais pas encore retiré de la base de données. Veuillez nous contacter si vous désirez le récupérer.';

// ------------------------------------------------------------------------
// Password reset section.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_RESET'] = 'Mot de passe réinitialisé avec succès.';

// Error messages.
$lang['CSK_USERS_ERROR_RESET']      = 'Impossible de réinitialiser le mot de passe.';
$lang['CSK_USERS_ERROR_RESET_CODE'] = 'Ce lien de réinitialisation de mot de passe n\'est plus valide.';

// ------------------------------------------------------------------------
// Restore account section.
// ------------------------------------------------------------------------

$lang['CSK_USERS_RESTORE_ACCOUNT'] = 'Récupérer le compte';
$lang['CSK_USERS_RESTORE_TIP'] = 'Entrez votre nom d\'utilisateur/adresse e-mail et mot de passe pour récupérer votre compte.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESTORE'] = 'Compte récupéré avec succès. Bon retour parmi nous!';

// Error messages.
$lang['CSK_USERS_ERROR_RESTORE']         = 'Impossible de récupérer le compte.';
$lang['CSK_USERS_ERROR_RESTORE_DELETED'] = 'Seuls les comptes supprimés peuvent être récupérés.';

// ------------------------------------------------------------------------
// Users emails subjects.
// ------------------------------------------------------------------------
$lang['CSK_USERS_EMAIL_ACTIVATED']         = 'Compte activé';
$lang['CSK_USERS_EMAIL_EMAIL']             = 'changement de l\'adresse e-mail';
$lang['CSK_USERS_EMAIL_EMAIL_PREP']        = 'Adresse e-mail changée';
$lang['CSK_USERS_EMAIL_MANUAL_ACTIVATION'] = 'Activation manuelle';
$lang['CSK_USERS_EMAIL_PASSWORD']          = 'Mot de passe changé';
$lang['CSK_USERS_EMAIL_RECOVER']           = 'Réinitialisation du mot de passe';
$lang['CSK_USERS_EMAIL_REGISTER']          = 'Activation de compte';
$lang['CSK_USERS_EMAIL_RESEND']            = 'Nouveau lien d\'activation';
$lang['CSK_USERS_EMAIL_RESTORE']           = 'Compte récupéré';
$lang['CSK_USERS_EMAIL_WELCOME']           = 'Bienvenue sur {site_name}';
