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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Module - Admin Language (French)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.3.4
 */

// Theme: singular and plural forms.
$lang['sth_theme']  = 'Thème';
$lang['sth_themes'] = 'Thèmes';

// Dashboard title.
$lang['sth_theme_settings'] = 'Paramètres des thèmes';

// Theme actions and buttons.
$lang['sth_theme_activate'] = 'Activer';
$lang['sth_theme_add']      = 'Ajouter de thèmes';
$lang['sth_theme_delete']   = 'Supprimer';
$lang['sth_theme_details']  = 'Détails';
$lang['sth_theme_install']  = 'Installer';
$lang['sth_theme_upload']   = 'Téléverser un thème';

$lang['sth_theme_upload_tip'] = 'Si vous avez un thème au format .zip, vous pouvez l’installer en le téléversant ici.';

// Confirmation messages.
$lang['sth_theme_activate_confirm'] = 'Êtes-vous sûr de vouloir activer ce thème?';
$lang['sth_theme_delete_confirm']   = 'Êtes-vous sûr de vouloir supprimer ce thème?';
$lang['sth_theme_install_confirm']  = 'Êtes-vous sûr de vouloir installer ce thème?';
$lang['sth_theme_upload_confirm']   = 'Êtes-vous sûr de vouloir télécharger ce thème?';

// Success messages.
$lang['sth_theme_activate_success'] = 'Thème activé avec succès.';
$lang['sth_theme_delete_success']   = 'Thème supprimé avec succès';
$lang['sth_theme_install_success']  = 'Thème installé avec succès.';
$lang['sth_theme_upload_success']   = 'Thème téléchargé avec succès.';

// Error messages.
$lang['sth_theme_activate_error'] = 'Impossible d\'activer le thème.';
$lang['sth_theme_delete_error']   = 'Impossible de supprimer le thème.';
$lang['sth_theme_install_error']  = 'Impossible d\'installer le thème.';
$lang['sth_theme_upload_error']   = 'Impossible de télécharger le thème.';
$lang['sth_theme_delete_active']  = 'Vous ne pouvez pas supprimer le thème actuellement utilisé.';

// Theme details.
$lang['sth_details']      = 'Détails du thème';
$lang['sth_details_name'] = 'Détails du thème: %s';
$lang['sth_name']         = 'Nom';
$lang['sth_folder']       = 'Répertoire';
$lang['sth_theme_uri']    = 'URI du thème';
$lang['sth_description']  = 'Description';
$lang['sth_version']      = 'Version';
$lang['sth_license']      = 'Licence';
$lang['sth_license_uri']  = 'URI de licence';
$lang['sth_author']       = 'Auteur';
$lang['sth_author_uri']   = 'Auteur URI';
$lang['sth_author_email'] = 'Email de l\'auteur';
$lang['sth_tags']         = 'Étiquettes';
$lang['sth_screenshot']   = 'Capture d\'écran';
$lang['sth_theme_zip']    = 'Fichier ZIP du thème';

// Theme install filters.
$lang['sth_theme_featured'] = 'Mise en avant';
$lang['sth_theme_popular']  = 'Populaires';
$lang['sth_theme_new']      = 'Nouveaux';
$lang['sth_theme_search']   = 'Rechercher des thèmes...';

// Details with links:
$lang['sth_theme_name']         = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_license']      = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author']       = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author_email'] = '<a href="mailto:%1$s" target="_blank" rel="nofollow">Support</a>';
