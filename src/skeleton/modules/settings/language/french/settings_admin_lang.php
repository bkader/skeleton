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
 * Settings Module - Admin Language (French)
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

$lang['settings'] = 'Paramètres';

$lang['set_update_error']   = 'Impossible de mettre à jour les paramètres.';
$lang['set_update_success'] = 'Paramètres mis à jour avec succès.';

// ------------------------------------------------------------------------
// General Settings.
// ------------------------------------------------------------------------
$lang['general'] = 'Général';
$lang['site_settings'] = 'Paramètres du site';

// Site name.
$lang['set_site_name']     = 'Nom du site';
$lang['set_site_name_tip'] = 'Entrez le nom de votre site Web';

// Site description.
$lang['set_site_description']     = 'Description du site';
$lang['set_site_description_tip'] = 'Entrez une courte description pour votre site Web.';

// Site keywords.
$lang['set_site_keywords']     = 'Mots clés du site';
$lang['set_site_keywords_tip'] = 'Entrez vos mots clés de site séparés par des virgules.';

// Site author.
$lang['set_site_author']     = 'Auteur du site';
$lang['set_site_author_tip'] = 'Entrez l\'auteur du site si vous voulez ajouter la balise META auteur.';

// Per page.
$lang['set_per_page']     = 'Par page';
$lang['set_per_page_tip'] = 'Combien d\'éléments sont affichés sur les pages utilisant la pagination.';

// Google analytics.
$lang['set_google_analytics_id'] = 'Google Anaytilcs ID';
$lang['set_google_analytics_id_tip'] = 'Entrez votre identifiant Google Anaytilcs';

// Google site verification.
$lang['set_google_site_verification'] = 'Google Site Verification';
$lang['set_google_site_verification_tip'] = 'Entrez le code de vérification de votre site Google.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'Paramètres des utilisateurs';

// Allow registration.
$lang['set_allow_registration']     = "Autoriser l'inscription";
$lang['set_allow_registration_tip'] = 'Permetter aux utilisateurs de créer des comptes sur votre site.';

// Email activation.
$lang['set_email_activation']     = 'Activation d\'e-mail';
$lang['set_email_activation_tip'] = 'Indiquez si les utilisateurs doivent vérifier leurs adresses e-mail avant de pouvoir se connecter.';

// Manual activation.
$lang['set_manual_activation']     = 'Activation manuelle';
$lang['set_manual_activation_tip'] = 'Un administrateur doit activer les comptes manuellement.';

// Login type.
$lang['set_login_type']     = 'Type de connexion';
$lang['set_login_type_tip'] = 'Les utilisateurs peuvent se connecter en utilisant des noms d\'utilisateur, des adresses e-mail ou les deux.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'Autoriser plusieurs sessions';
$lang['set_allow_multi_session_tip'] = 'Permettre à plusieurs utilisateurs à se connecter au même compte en même temps.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'Utiliser Gravatar';
$lang['set_use_gravatar_tip'] = 'Utilisez gravatar ou permettre aux utilisateurs de télécharger leurs avatars.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'Paramètres E-mail';

// Admin email.
$lang['set_admin_email']     = 'Email de l\'administrateur';
$lang['set_admin_email_tip'] = 'L\'adresse e-mail à laquelle les notifications de site seront envoyées.';

// Server email.
$lang['set_server_email']     = 'Email du serveur';
$lang['set_server_email_tip'] = 'L\'adresse e-mail utilisée pour envoyer des e-mails aux utilisateurs. Définie comme "De:". Vous pouvez utiliser "noreply@..." ou une adresse e-mail existante.';

// Mail protocol.
$lang['set_mail_protocol'] = 'Protocole de messagerie';
$lang['set_mail_protocol_tip'] = 'Choisissez le protocole de messagerie avec lequel vous souhaitez envoyer des e-mails.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'Chemin de Sendmail';
$lang['set_sendmail_path_tip'] = 'Entrez le chemin sendmail. Par défaut: /usr/sbin/sendmail. Obligatoire uniquement si vous utilisez le protocole Sendmail.';

// SMTP host.
$lang['set_smtp_host'] = 'Hôte SMTP';
$lang['set_smtp_host_tip'] = 'Entrez le nom d\'hôte SMTP (Exemple: smtp.gmail.com). Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP port.
$lang['set_smtp_port'] = 'Port SMTP';
$lang['set_smtp_port_tip'] = 'Entrez le numéro de port SMTP fourni par votre hôte. Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'Chiffrement SMTP';
$lang['set_smtp_crypto_tip'] = 'Choisissez la méthode de cryptage SMTP.';

// SMTP user.
$lang['set_smtp_user'] = 'Nom d\'utilisateur SMTP';
$lang['set_smtp_user_tip'] = 'Entrez le nom d\'utilisateur de votre compte SMTP.';

// SMTP pass.
$lang['set_smtp_pass'] = 'Mot de passe SMTP';
$lang['set_smtp_pass_tip'] = 'Entrez le mot de passe de votre compte SMTP.';

// ------------------------------------------------------------------------
// Upload settings
// ------------------------------------------------------------------------
$lang['upload_settings'] = 'Paramètres de téléchargement';

// Upload path.
$lang['set_upload_path'] = 'Chemin de téléchargement';
$lang['set_upload_path_tip'] = 'Chemin vers le répertoire dans lequel les fichiers autorisés sont téléchargés. Par défaut: contenu/uploads/';

// Allowed file types.
$lang['set_allowed_types'] = 'Fichiers autorisés';
$lang['set_allowed_types_tip'] = 'Liste des fichiers autorisés à être téléchargés. Utilisez "|" pour séparer entre les types.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'Paramètres Captcha';

// Use captcha.
$lang['set_use_captcha'] = 'Utiliser captcha';
$lang['set_use_captcha_tip'] = 'Utilisation du champs captcha sur certains formulaires de site.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'Utilisez reCAPTCHA';
$lang['set_use_recaptcha_tip'] = 'Utiliser Google reCAPTCHA si activé, sinon utiliser captcha de CodeIgniter si "Utiliser captcha" est activé.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'Clé reCAPTCHA publique';
$lang['set_recaptcha_site_key_tip'] = 'Entrez la clé de site reCAPTCHA fournie par Google.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'Clé reCAPTCHA privée';
$lang['set_recaptcha_private_key_tip'] = 'Entrez la clé privée reCAPTCHA fournie par Google.';
