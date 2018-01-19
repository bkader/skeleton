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
 * Language Module - Admin Language (French)
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

$lang['manage_languages'] = 'Gestion des langues';
$lang['manage_languages_tip'] = 'Activer, désactiver et définir la langue par défaut du site. Les langues activées seront disponibles pour les visiteurs du site.';

$lang['folder']       = 'Répertoire';
$lang['abbreviation'] = 'Abbréviation';
$lang['is_default']   = 'Par défault';
$lang['enabled']      = 'Activé';

$lang['make_default'] = 'Par défault';

$lang['missing_language_folder'] = 'Le répertoire de langue est manquant.';

$lang['english_required'] = 'Obligatoire et intouchable.';

// ------------------------------------------------------------------------
// Messages.
// ------------------------------------------------------------------------

// Enable language.
$lang['language_enable_missing'] = 'La langue que vous essayez d\'activer n\'est pas disponible.';
$lang['language_enable_success'] = 'Language successfully enabled.';
$lang['language_enable_error']   = 'La langue a bien été activée.';
$lang['language_enable_already'] = 'Impossible d\'activer la langue.';

// Disable language.
$lang['language_disable_missing'] = 'La langue que vous essayez de désactiver n\'est pas disponible.';
$lang['language_disable_success'] = 'La langue a bien été désactivée.';
$lang['language_disable_error']   = 'Impossible de désactiver la langue.';
$lang['language_disable_already'] = 'Cette langue est déjà désactivée.';

// Set default language.
$lang['language_default_missing'] = 'La langue que vous essayez de mettre par défaut n\'est pas disponible.';
$lang['language_default_success'] = 'La langue par défaut a bien été changée.';
$lang['language_default_error']   = 'Impossible de changer la langue par défaut.';
$lang['language_default_already'] = 'Cette langue est déjà celle par défaut.';
