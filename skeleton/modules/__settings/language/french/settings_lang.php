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
 * @link 		https://goo.gl/wGXHO9
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
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @since 		1.3.3 	Renamed to "settings_lang" because the other file was merged
 *          			into "users_lang" file.
 *
 * @version 	1.3.3
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
$lang['set_site_name_tip'] = 'Entrez le nom de votre site Web.';

// Site description.
$lang['set_site_description']     = 'Description du site';
$lang['set_site_description_tip'] = 'Entrez une courte description pour votre site Web.';

// Site keywords.
$lang['set_site_keywords']     = 'Mots clés du site';
$lang['set_site_keywords_tip'] = 'Entrez vos mots clés de site séparés par des virgules.';

// Site author.
$lang['set_site_author']     = 'Auteur du site';
$lang['set_site_author_tip'] = 'Entrez l\'auteur du site si vous voulez ajouter la balise META auteur.';

// Base controller.
$lang['set_base_controller']     = 'Contrôleur de base';
$lang['set_base_controller_tip'] = 'Le contrôleur utilisé pour votre page d\'accueil.';

// Per page.
$lang['set_per_page']     = 'Éléments par page';
$lang['set_per_page_tip'] = 'Combien d\'éléments sont affichés sur les pages utilisant la pagination.';

// Google analytics.
$lang['set_google_analytics_id'] = 'ID Google Analytics';
$lang['set_google_analytics_id_tip'] = 'Entrez votre identifiant Google Analytics.';

// Google site verification.
$lang['set_google_site_verification'] = 'Google Site Verification';
$lang['set_google_site_verification_tip'] = 'Entrez le code de vérification de votre site Google.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'Paramètres des utilisateurs';

// Allow registration.
$lang['set_allow_registration']     = 'Autoriser l\'inscription';
$lang['set_allow_registration_tip'] = 'Autoriser les nouvelles inscriptions sur votre site.';

// Email activation.
$lang['set_email_activation']     = 'Vérification d\'e-mail';
$lang['set_email_activation_tip'] = 'Indiquez si les utilisateurs doivent vérifier leurs adresses e-mail avant de pouvoir se connecter.';

// Manual activation.
$lang['set_manual_activation']     = 'Activation manuelle';
$lang['set_manual_activation_tip'] = 'Si les nouveaux comptes doivent être manuellement approuvés.';

// Login type.
$lang['set_login_type']     = 'Type de connexion';
$lang['set_login_type_tip'] = 'Les utilisateurs peuvent se connecter en utilisant leurs noms d\'utilisateur, leurs adresses e-mail ou les deux.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'Sessions multiples';
$lang['set_allow_multi_session_tip'] = 'Autoriser plusieurs utilisateurs à se connecter au même compte en même temps.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'Utiliser Gravatar';
$lang['set_use_gravatar_tip'] = 'Utiliser gravatar ou permettre aux utilisateurs de télécharger leurs avatars.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'Paramètres de messagerie';

// Admin email.
$lang['set_admin_email']     = 'Email de l\'administrateur';
$lang['set_admin_email_tip'] = 'L\'adresse e-mail à laquelle les notifications de site sont envoyées.';

// Server email.
$lang['set_server_email']     = 'Email du serveur';
$lang['set_server_email_tip'] = 'L\'adresse e-mail utilisée pour envoyer des e-mails aux utilisateurs. Vous pouvez utiliser "noreply@..." ou une adresse e-mail existante.';

// Mail protocol.
$lang['set_mail_protocol'] = 'Protocole de messagerie';
$lang['set_mail_protocol_tip'] = 'Choisissez le protocole de messagerie avec lequel vous souhaitez envoyer des e-mails.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'Chemin de Sendmail';
$lang['set_sendmail_path_tip'] = 'Entrez le chemin sendmail. Par défaut: /usr/sbin/. Requis uniquement si vous utilisez le protocole Sendmail.';

// SMTP host.
$lang['set_smtp_host'] = 'Hôte SMTP';
$lang['set_smtp_host_tip'] = 'Entrez le nom d\'hôte SMTP (i.e: smtp.gmail.com). Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP port.
$lang['set_smtp_port'] = 'Port SMTP';
$lang['set_smtp_port_tip'] = 'Entrez le numéro de port SMTP fourni par votre hôte. Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'Chiffrement SMTP';
$lang['set_smtp_crypto_tip'] = 'Choisissez le cryptage SMTP.';

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
$lang['set_upload_path_tip'] = 'Chemin d\'accès aux différents fichiers. Par défaut: contenu/uploads/';

// Allowed file types.
$lang['set_allowed_types'] = 'Extensions autorisées';
$lang['set_allowed_types_tip'] = 'Liste des extensions autorisées séparées par "|".';

// Date/month folder.
$lang['set_upload_year_month'] = 'Organisation';
$lang['set_upload_year_month_tip'] = 'Organiser les fichiers envoyés dans des dossiers mensuels et annuels';

// Max file sizes.
$lang['set_max_size'] = 'Taille maximale';
$lang['set_max_size_tip'] = 'La taille maximale (en kilo-octets) des fichiers envoyés. Zéro pour aucune limite.';

// Images max width and height
$lang['set_min_image_size'] = 'Dimensions minimales';
$lang['set_min_height']     = 'Hauteur minimale';
$lang['set_min_width']      = 'Largeur minimale';
$lang['set_min_width_tip']  = 'La largeur minimale en pixels. Zéro pour aucune limite.';
$lang['set_min_height_tip'] = 'La heuteur minimale en pixels. Zéro pour aucune limite.';


// Images max width and height
$lang['set_max_image_size'] = 'Dimensions maximales';
$lang['set_max_height']     = 'Hauteur maximale';
$lang['set_max_width']      = 'Largeur maximale';
$lang['set_max_width_tip']  = 'La largeur maximale en pixels. Zéro pour aucune limite.';
$lang['set_max_height_tip'] = 'La heuteur minimale en pixels. Zéro pour aucune limite.';

// Small thumbnails with and height.
$lang['set_image_thumbnail']       = 'Taille des miniatures';
$lang['set_image_thumbnail_h']     = 'Hauteur en pixels';
$lang['set_image_thumbnail_w']     = 'Largeur en pixels';
$lang['set_image_thumbnail_h_tip'] = 'Hauteur des miniatures en pixels.';
$lang['set_image_thumbnail_w_tip'] = 'Largeur des miniatures en pixels.';

// Thumbnails crop.
$lang['set_image_thumbnail_crop']     = 'Recadrer les images';
$lang['set_image_thumbnail_crop_tip'] = ' Recadrer les images pour parvenir aux dimensions exactes.';

// Medium size images width and height.
$lang['set_image_medium']       = 'Taille moyenne';
$lang['set_image_medium_h']     = 'Hauteur en pixels';
$lang['set_image_medium_w']     = 'Largeur en pixels';
$lang['set_image_medium_h_tip'] = 'Hauteur des images de taille moyenne.';
$lang['set_image_medium_w_tip'] = 'Largeur des images de taille moyenne.';

// Large images width and height
$lang['set_image_large']       = 'Grande taille';
$lang['set_image_large_w']     = 'Largeur en pixels';
$lang['set_image_large_h']     = 'Heuteur en pixels';
$lang['set_image_large_w_tip'] = 'Largeur des images de grande taille.';
$lang['set_image_large_h_tip'] = 'Hauteur des images de grande taille.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'Paramètres Captcha';

// Use captcha.
$lang['set_use_captcha'] = 'Utiliser Captcha';
$lang['set_use_captcha_tip'] = 'Activer ou désactiver l\'utilisation de la sécurité par captcha.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'Utiliser reCAPTCHA';
$lang['set_use_recaptcha_tip'] = 'Utiliser Google reCAPTCHA si activé, sinon utiliser le captcha par défault si Utiliser Captcha est activé.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'Clé de site reCAPTCHA';
$lang['set_recaptcha_site_key_tip'] = 'Entrez la clé de site reCAPTCHA fournie par Google.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'Clé privée reCAPTCHA';
$lang['set_recaptcha_private_key_tip'] = 'Entrez la clé privée reCAPTCHA fournie par Google.';
