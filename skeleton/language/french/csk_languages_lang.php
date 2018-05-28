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
 * Language Module - Admin Language (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

$lang['CSK_LANGUAGES']           = 'Langues';
$lang['CSK_LANGUAGES_LANGUAGE']  = 'Langue';
$lang['CSK_LANGUAGES_LANGUAGES'] = 'Langues';

// Dashboard page title and tip.
$lang['CSK_LANGUAGES_TIP'] = 'Activé, désactiver et définir la langue par défaut du site. Les langues activées sont disponibles pour les visiteurs du site.';

// Language details.
$lang['CSK_LANGUAGES_FOLDER']       = 'Répertoire';
$lang['CSK_LANGUAGES_ABBREVIATION'] = 'Abréviation';
$lang['CSK_LANGUAGES_IS_DEFAULT']   = 'Par défaut';
$lang['CSK_LANGUAGES_ENABLED']      = 'Activé';

// Language actions.
$lang['CSK_LANGUAGES_DISABLE']      = 'Désactiver';
$lang['CSK_LANGUAGES_ENABLE']       = 'Activer';
$lang['CSK_LANGUAGES_MAKE_DEFAULT'] = 'Par défaut';

// Confirmation messages.
$lang['CSK_LANGUAGES_CONFIRM_ENABLE']  = 'Êtes-vous sûr de vouloir activer cette langue?';
$lang['CSK_LANGUAGES_CONFIRM_DISABLE'] = 'Êtes-vous sûr de vouloir désactiver cette langue?';
$lang['CSK_LANGUAGES_CONFIRM_DEFAULT'] = 'Êtes-vous sûr de vouloir faire de cette langue la langue par défaut du site?';

// Success messages.
$lang['CSK_LANGUAGES_SUCCESS_ENABLE']  = 'Langue activée avec succès.';
$lang['CSK_LANGUAGES_SUCCESS_DISABLE'] = 'Langue désactivée avec succès.';
$lang['CSK_LANGUAGES_SUCCESS_DEFAULT'] = 'Langue par défault changée avec succès.';

// Error messages.
$lang['CSK_LANGUAGES_ERROR_ENABLE']           = 'Impossible d\'activer la langue.';
$lang['CSK_LANGUAGES_ERROR_DISABLE']          = 'Impossible de désactiver la langue.';
$lang['CSK_LANGUAGES_ERROR_DEFAULT']          = 'Impossible de changer la langue par défaut.';
$lang['CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED'] = 'L\'Anglais est une langue requise, elle ne peut donc pas être touchée.';

// Missing language errors.
$lang['CSK_LANGUAGES_MISSING_FOLDER']  = 'Le répertoire de la langue est manquant. Les lignes ne peuvent pas être traduites.';

// Already enabled/disable/default message.
$lang['CSK_LANGUAGES_ALREADY_ENABLE']  = 'Cette langue est déjà activée.';
$lang['CSK_LANGUAGES_ALREADY_DISABLE'] = 'Cette langue est déjà désactivée.';
$lang['CSK_LANGUAGES_ALREADY_DEFAULT'] = 'Cette langue est déjà celle par défaut.';
