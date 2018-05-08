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
 * Language Module - Admin Language (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.3.2
 */

// Dashboard page title and tip.
$lang['sln_manage_languages']     = 'Gérer Les Langues';
$lang['sln_manage_languages_tip'] = 'Activer, désactiver, installer et choisir la langue par défault. Les langues activées seront disponibles pour les visiteurs du site.';

// Language details.
$lang['sln_folder']       = 'Dossier';
$lang['sln_abbreviation'] = 'Abréviation';
$lang['sln_is_default']   = 'Par défault';
$lang['sln_enabled']      = 'Activée';

// Language actions.
$lang['sln_make_default'] = 'Par Défaut';

// Success messages.
$lang['sln_language_enable_success']  = 'Langue activée avec succès.';
$lang['sln_language_disable_success'] = 'Langue désactivée avec succès.';
$lang['sln_language_default_success'] = 'Langue par défaut modifiée avec succès.';

// Error messages.
$lang['sln_english_required']       = 'Requis et inchageable.';
$lang['sln_language_enable_error']  = 'Impossible d\'activer la langue.';
$lang['sln_language_disable_error'] = 'Impossible de désactiver la langue.';
$lang['sln_language_default_error'] = 'Impossible de modifier la langue par défaut.';

// Missing language errors.
$lang['sln_language_missing_folder']  = 'Le dossier de langue est introuvable. Les lignes ne peuvent pas être traduites.';
$lang['sln_language_missing_line']    = 'La ligne de langue demandée n\'a pas pu être trouvée.';
$lang['sln_language_enable_missing']  = 'La langue que vous essayez d\'activer n\'est pas disponible.';
$lang['sln_language_disable_missing'] = 'La langue que vous essayez de désactiver n\'est pas disponible.';
$lang['sln_language_default_missing'] = 'La langue par défaut que vous essayez de choisir n\'est pas disponible.';

// Already enabled/disable/default message.
$lang['sln_language_enable_already']  = 'Cette langue est déjà activée.';
$lang['sln_language_disable_already'] = 'Cette langue est déjà désactivée.';
$lang['sln_language_default_already'] = 'Cette langue est déjà celle par défaut.';
