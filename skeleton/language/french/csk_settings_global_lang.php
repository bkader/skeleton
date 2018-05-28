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
 * Global settings language (French')
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

// ------------------------------------------------------------------------
// Tabs sections.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SYSTEM_INFORMATION'] = 'Informations système';
$lang['CSK_SETTINGS_PHP_SETTINGS']       = 'Paramètres PHP';
$lang['CSK_SETTINGS_PHP_INFO']           = 'Informations PHP';

// ------------------------------------------------------------------------
// Table headings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SETTING'] = 'Paramètre';
$lang['CSK_SETTINGS_VALUE']   = 'Valeur';

// ------------------------------------------------------------------------
// System information.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_PHP_BUILT_ON']     = 'PHP exécuté sur';
$lang['CSK_SETTINGS_PHP_VERSION']      = 'Version de PHP';
$lang['CSK_SETTINGS_DATABASE_TYPE']    = 'Type de la base de données';
$lang['CSK_SETTINGS_DATABASE_VERSION'] = 'Version de la base de données';
$lang['CSK_SETTINGS_WEB_SERVER']       = 'Serveur web';
$lang['CSK_SETTINGS_SKELETON_VERSION'] = 'Version Skeleton';
$lang['CSK_SETTINGS_USER_AGENT']       = 'Navigateur';

// ------------------------------------------------------------------------
// PHP Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SAFE_MODE']          = 'Safe Mode (mode de sécurité PHP)';
$lang['CSK_SETTINGS_DISPLAY_ERRORS']     = 'Display Errors (afficher les erreurs)';
$lang['CSK_SETTINGS_SHORT_OPEN_TAG']     = 'Short open tags (balises courtes d\'ouverture)';
$lang['CSK_SETTINGS_FILE_UPLOADS']       = 'File Uploads (transfert HTTP de fichiers)';
$lang['CSK_SETTINGS_MAGIC_QUOTES_GPC']   = 'Magic quotes (ajout antislash aux guillemets)';
$lang['CSK_SETTINGS_REGISTER_GLOBALS']   = 'Register Globals (EGPCS variables globales)';
$lang['CSK_SETTINGS_OUTPUT_BUFFERING']   = 'Output Buffering (limitation du buffer de sortie)';
$lang['CSK_SETTINGS_OPEN_BASEDIR']       = 'Open basedir (dossier limite d\'arborescence)';
$lang['CSK_SETTINGS_SESSION.SAVE_PATH']  = 'Session Save Path (répertoire de sessions)';
$lang['CSK_SETTINGS_SESSION.AUTO_START'] = 'Session auto start (démarrer à chaque script)';
$lang['CSK_SETTINGS_DISABLE_FUNCTIONS']  = 'Disabled Functions (fonctions désactivées)';
$lang['CSK_SETTINGS_XML']                = 'XML activé (lire et écrire les fichiers XML)';
$lang['CSK_SETTINGS_ZLIB']               = 'Zlib activé (lire et écrire les fichiers gzip)';
$lang['CSK_SETTINGS_ZIP']                = 'Zip natif activé';
$lang['CSK_SETTINGS_MBSTRING']           = 'Mbstring actif (interprétation des chaînes)';
$lang['CSK_SETTINGS_ICONV']              = 'Iconv activé (conversion des chaînes)	';
$lang['CSK_SETTINGS_MAX_INPUT_VARS']     = 'Nombre maximum de champs de saisie (Maximum Input Variables)';

// ------------------------------------------------------------------------
// General Settings
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_GENERAL'] = 'Général';

// Site name.
$lang['CSK_SETTINGS_SITE_NAME'] = 'Nom du site';
$lang['CSK_SETTINGS_SITE_NAME_TIP'] = 'Entrez le nom de votre site Web.';

// Site description.
$lang['CSK_SETTINGS_SITE_DESCRIPTION'] = 'Description du site';
$lang['CSK_SETTINGS_SITE_DESCRIPTION_TIP'] = 'Entrez une courte description pour votre site Web.';

// Site keywords.
$lang['CSK_SETTINGS_SITE_KEYWORDS'] = 'Mots clés du site';
$lang['CSK_SETTINGS_SITE_KEYWORDS_TIP'] = 'Entrez vos mots clés de site séparés par des virgules.';

// Site author.
$lang['CSK_SETTINGS_SITE_AUTHOR'] = 'Auteur du site';
$lang['CSK_SETTINGS_SITE_AUTHOR_TIP'] = 'Entrez l\'auteur du site si vous voulez ajouter la balise META auteur.';

// Site favicon.
$lang['CSK_SETTINGS_SITE_FAVICON'] = 'Favicon du site';
$lang['CSK_SETTINGS_SITE_FAVICON_TIP'] = 'Entez l\'adresse de l\'image à utiliser comme favicon du site.';

// Base controller.
$lang['CSK_SETTINGS_BASE_CONTROLLER'] = 'Contrôleur de base';
$lang['CSK_SETTINGS_BASE_CONTROLLER_TIP'] = 'Le contrôleur utilisé pour votre page d\'accueil.';

// Per page.
$lang['CSK_SETTINGS_PER_PAGE'] = 'Éléments par page';
$lang['CSK_SETTINGS_PER_PAGE_TIP'] = 'Combien d\'éléments sont affichés sur les pages utilisant la pagination.';

// Google analytics.
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID'] = 'ID Google Analytics';
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID_TIP'] = 'Entrez votre identifiant Google Analytics.';

// Google site verification.
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION'] = 'Google Site Verification';
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION_TIP'] = 'Entrez le code de vérification de votre site Google.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_CAPTCHA'] = 'Captcha';

// Use captcha.
$lang['CSK_SETTINGS_USE_CAPTCHA'] = 'Utiliser Captcha';
$lang['CSK_SETTINGS_USE_CAPTCHA_TIP'] = 'Activer ou désactiver l\'utilisation de la sécurité par captcha.';

// Use reCAPTCHA.
$lang['CSK_SETTINGS_USE_RECAPTCHA'] = 'Utiliser reCAPTCHA';
$lang['CSK_SETTINGS_USE_RECAPTCHA_TIP'] = 'Utiliser Google reCAPTCHA si activé, sinon utiliser le captcha par défault si Utiliser Captcha est activé.';

// reCAPTCHA site key.
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY'] = 'Clé de site reCAPTCHA';
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY_TIP'] = 'Entrez la clé de site reCAPTCHA fournie par Google.';

// reCAPTCHA private key.
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY'] = 'Clé privée reCAPTCHA';
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY_TIP'] = 'Entrez la clé privée reCAPTCHA fournie par Google.';

// ------------------------------------------------------------------------
// Email Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_EMAIL'] = 'E-mail';

// Admin email.
$lang['CSK_SETTINGS_ADMIN_EMAIL'] = 'Email de l\'administrateur';
$lang['CSK_SETTINGS_ADMIN_EMAIL_TIP'] = 'L\'adresse e-mail à laquelle les notifications de site sont envoyées.';

// Server email.
$lang['CSK_SETTINGS_SERVER_EMAIL'] = 'Email du serveur';
$lang['CSK_SETTINGS_SERVER_EMAIL_TIP'] = 'L\'adresse e-mail utilisée pour envoyer des e-mails aux utilisateurs. Vous pouvez utiliser "noreply@..." ou une adresse e-mail existante.';

// Mail protocol.
$lang['CSK_SETTINGS_MAIL_PROTOCOL'] = 'Protocole de messagerie';
$lang['CSK_SETTINGS_MAIL_PROTOCOL_TIP'] = 'Choisissez le protocole de messagerie avec lequel vous souhaitez envoyer des e-mails.';

// Sendmail Path.
$lang['CSK_SETTINGS_SENDMAIL_PATH'] = 'Chemin de Sendmail';
$lang['CSK_SETTINGS_SENDMAIL_PATH_TIP'] = 'Entrez le chemin sendmail. Par défaut: /usr/sbin/. Requis uniquement si vous utilisez le protocole Sendmail.';

// SMTP host.
$lang['CSK_SETTINGS_SMTP_HOST'] = 'Hôte SMTP';
$lang['CSK_SETTINGS_SMTP_HOST_TIP'] = 'Entrez le nom d\'hôte SMTP (i.e: smtp.gmail.com). Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP port.
$lang['CSK_SETTINGS_SMTP_PORT'] = 'Port SMTP';
$lang['CSK_SETTINGS_SMTP_PORT_TIP'] = 'Entrez le numéro de port SMTP fourni par votre hôte. Requis uniquement si vous utilisez le protocole SMTP.';

// SMTP crypt.
$lang['CSK_SETTINGS_SMTP_CRYPTO'] = 'Chiffrement SMTP';
$lang['CSK_SETTINGS_SMTP_CRYPTO_TIP'] = 'Choisissez le cryptage SMTP.';

// SMTP user.
$lang['CSK_SETTINGS_SMTP_USER'] = 'Nom d\'utilisateur SMTP';
$lang['CSK_SETTINGS_SMTP_USER_TIP'] = 'Entrez le nom d\'utilisateur de votre compte SMTP.';

// SMTP pass.
$lang['CSK_SETTINGS_SMTP_PASS'] = 'Mot de passe SMTP';
$lang['CSK_SETTINGS_SMTP_PASS_TIP'] = 'Entrez le mot de passe de votre compte SMTP.';

// ------------------------------------------------------------------------
// Upload Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_UPLOAD'] = 'Téléversement';

// Upload path.
$lang['CSK_SETTINGS_UPLOAD_PATH'] = 'Chemin de téléchargement';
$lang['CSK_SETTINGS_UPLOAD_PATH_TIP'] = 'Chemin d\'accès aux différents fichiers. Par défaut: contenu/uploads/';

// Allowed file types.
$lang['CSK_SETTINGS_ALLOWED_TYPES'] = 'Extensions autorisées';
$lang['CSK_SETTINGS_ALLOWED_TYPES_TIP'] = 'Liste des extensions autorisées séparées par "|".';

// Max file sizes.
$lang['CSK_SETTINGS_MAX_SIZE'] = 'Taille maximale';
$lang['CSK_SETTINGS_MAX_SIZE_TIP'] = 'La taille maximale (en kilo-octets) des fichiers envoyés. Zéro pour aucune limite.';

// Images min width and height
$lang['CSK_SETTINGS_MIN_WIDTH']      = 'Largeur minimale';
$lang['CSK_SETTINGS_MIN_WIDTH_TIP']  = 'La largeur minimale en pixels. Zéro pour aucune limite.';
$lang['CSK_SETTINGS_MIN_HEIGHT']     = 'Hauteur minimale';
$lang['CSK_SETTINGS_MIN_HEIGHT_TIP'] = 'La heuteur minimale en pixels. Zéro pour aucune limite.';

// Images max width and height
$lang['CSK_SETTINGS_MAX_WIDTH']      = 'Largeur maximale';
$lang['CSK_SETTINGS_MAX_WIDTH_TIP']  = 'La largeur maximale en pixels. Zéro pour aucune limite.';
$lang['CSK_SETTINGS_MAX_HEIGHT']     = 'Hauteur maximale';
$lang['CSK_SETTINGS_MAX_HEIGHT_TIP'] = 'La heuteur minimale en pixels. Zéro pour aucune limite.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_USERS'] = 'Utilisateurs';

// Allow registration.
$lang['CSK_SETTINGS_ALLOW_REGISTRATION']     = 'Allow Registration';
$lang['CSK_SETTINGS_ALLOW_REGISTRATION_TIP'] = 'Whether to allow users to create account on your site.';

// Email activation.
$lang['CSK_SETTINGS_EMAIL_ACTIVATION']     = 'Email Activation';
$lang['CSK_SETTINGS_EMAIL_ACTIVATION_TIP'] = 'Whether to force users to verify their email addresses before being allowed to log in.';

// Manual activation.
$lang['CSK_SETTINGS_MANUAL_ACTIVATION']     = 'Manual Activation';
$lang['CSK_SETTINGS_MANUAL_ACTIVATION_TIP'] = 'Whether to manually verify users accounts.';

// Login type.
$lang['CSK_SETTINGS_LOGIN_TYPE']     = 'Login Type';
$lang['CSK_SETTINGS_LOGIN_TYPE_TIP'] = 'Users may log in using usernames, email addresses or both.';

// Allow multi sessions.
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION']     = 'Allow Multi Sessions';
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION_TIP'] = 'Whether to allow multiple users to login to the same account at the same time.';

// Use Gravatar.
$lang['CSK_SETTINGS_USE_GRAVATAR']     = 'Use Gravatar';
$lang['CSK_SETTINGS_USE_GRAVATAR_TIP'] = 'Use gravatar or allow users to upload their avatars.';
