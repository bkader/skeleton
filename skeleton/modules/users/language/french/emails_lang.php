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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Emails Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.3
 * @version 	1.4.0
 */

// ========================================================================
// User registration.
// ========================================================================

// -------------------------------------------------------------------
// Welcome message.
// -------------------------------------------------------------------
$lang['us_email_welcome_subject'] = 'Bienvenue sur {site_name}';
$lang['us_email_welcome_message'] = <<<EOT
Salut {name},

La plupart des gens ont de très longues phrases de bienvenue après votre inscription sur leur site.

Bonne nouvelle: nous ne sommes pas la plupart des gens.
Mais nous souhaitons tout de même vous accueillir et vous remercier de nous avoir rejoints sur {site_link}.

En espérant que vous apprécierez votre séjour, veuillez accepter nos salutations distinguées.

- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Manual activation message.
// -------------------------------------------------------------------
$lang['us_email_manual_subject'] = 'Activation manuelle';
$lang['us_email_manual_message'] = <<<EOT
Salut {name},

Merci de vous être joint à {site_link}. Votre compte est créé mais doit être approuvé par un administrateur du site avant d'être actif.
Nous nous excusons sincèrement pour cette étape cruciale, mais ce n'est que pour des raisons de sécurité.

Vous recevrez un email de confirmation dès que votre compte aura été approuvé.

En espérant que vous apprécierez votre séjour, veuillez accepter nos salutations distinguées.

- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Account activation email.
// -------------------------------------------------------------------
$lang['us_email_activation_subject'] = 'Activation de compte';
$lang['us_email_activation_message'] = <<<EOT
Salut {name},

Merci de vous être enregistré sur {site_link}. Votre compte est créé et doit être activé avant de pouvoir l'utiliser.

Pour activer votre compte, cliquez sur le lien suivant ou copiez-collez-le dans votre navigateur:
{link}

Amicalement,
- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Account activated email.
// -------------------------------------------------------------------
$lang['us_email_activated_subject'] = 'Compte activé';
$lang['us_email_activated_message'] = <<<EOT
Salut {name},

Votre compte sur {site_link} a bien été activé. Vous pouvez maintenant <a href="{login_url}" target="_blank">vous connecter</a> à tout moment.

En espérant que vous apprécierez votre séjour, veuillez accepter nos salutations distinguées.

- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// New activation link email.
// -------------------------------------------------------------------
$lang['us_email_new_activation_subject'] = 'Nouveau lien d\'activation';
$lang['us_email_new_activation_message'] = <<<EOT
Salut {name},

Vous avez récemment demandé un nouveau lien d'activation sur {site_link}, car votre compte n'était pas actif.
Pour activer votre compte, cliquez sur le lien suivant ou copiez-collez-le dans votre navigateur:
{link}

Si vous ne l'avez pas demandé, aucune autre action n'est requise.

Cette action a été demandée à partir de cette adresse IP: {ip_link}.

Amicalement,
- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Password recover email.
// -------------------------------------------------------------------
$lang['us_email_recover_subject'] = 'Réinitialisation du mot de passe';
$lang['us_email_recover_message'] = <<<EOT
Salut {name},

Vous recevez cet e-mail, car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte sur {site_link}.

Cliquez sur le lien suivant ou copiez-collez-le dans votre navigateur si vous souhaitez continuer:
{link}

Si vous n'avez pas demandé la réinitialisation du mot de passe, aucune autre action n'est requise.

Cette action a été demandée à partir de cette adresse IP: {ip_link}.

Amicalement,
- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Password reset/change email.
// -------------------------------------------------------------------
$lang['us_email_password_subject'] = 'Mot de passe changé';
$lang['us_email_password_message'] = <<<EOT
Salut {name},

Cet e-mail confirme que votre mot de passe sur {site_link} a bien été modifié. Vous pouvez maintenant <a href="{login_url}" target="_blank">vous connecter</a> en utilisant le nouveau.

Si vous n'avez pas effectué cette action, veuillez nous contacter le plus vite possible pour résoudre ce problème.

Cette action a été effectuée à partir de cette adresse IP: {ip_link}.

Amicalement,
- Équipe {site_name}.
EOT;

// -------------------------------------------------------------------
// Restored account email.
// -------------------------------------------------------------------
$lang['us_email_restore_subject'] = 'Compte restauré';
$lang['us_email_restore_message'] = <<<EOT
Salut {name},

Cet e-mail confirme que votre compte sur {site_link} a bien été restauré.

Bienvenue à nouveau avec nous et nous espérons que cette fois vous apprécierez votre séjour.

Amicalement,
- Équipe {site_name}.
EOT;

// ------------------------------------------------------------------------
// Email change request.
// ------------------------------------------------------------------------
$lang['us_email_prep_email_subject'] = 'changement de l\'adresse e-mail';
$lang['us_email_prep_email_message'] = <<<EOT
Salut {name},

Vous recevez cet e-mail, car nous avons reçu une demande de changement d'adresse e-mail pour votre compte sur {site_link}.

Cliquez sur le lien suivant ou copiez-collez-le dans votre navigateur si vous souhaitez continuer:
{link}

Si vous n'avez pas demandé à changer votre adresse e-mail, aucune autre action n'est requise.

Cette action a été demandée à partir de cette adresse IP: {ip_link}.

Amicalement,
- Équipe {site_name}.
EOT;

// ------------------------------------------------------------------------
// Email changed.
// ------------------------------------------------------------------------
$lang['us_email_email_subject'] = 'Adresse e-mail changée';
$lang['us_email_email_message'] = <<<EOT
Salut {name},

Cet e-mail confirme que votre adrese e-mail utilisée sur {site_link} a bien été modifiée.

Si vous n'avez pas effectué cette action, veuillez nous contacter le plus vite possible pour résoudre ce problème.

Cette action a été effectuée à partir de cette adresse IP: {ip_link}.

Amicalement,
- Équipe {site_name}.
EOT;
