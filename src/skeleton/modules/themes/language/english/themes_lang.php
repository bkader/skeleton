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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Module - Admin Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.4.0
 */

// Theme: singular and plural forms.
$lang['sth_theme']  = 'Theme';
$lang['sth_themes'] = 'Themes';

// Dashboard title.
$lang['sth_theme_settings'] = 'Themes Settings';

// Theme actions and buttons.
$lang['sth_theme_activate'] = 'Activate';
$lang['sth_theme_add']      = 'Add Theme';
$lang['sth_theme_delete']   = 'Delete';
$lang['sth_theme_details']  = 'Details';
$lang['sth_theme_install']  = 'Install Theme';
$lang['sth_theme_upload']   = 'Upload Theme';

$lang['sth_theme_upload_tip'] = 'If you have a theme in a .zip format, you may install it by uploading it here.';

// Confirmation messages.
$lang['sth_theme_activate_confirm'] = 'Are you sure you want to activate this theme?';
$lang['sth_theme_delete_confirm']   = 'Are you sure you want to delete this theme?';
$lang['sth_theme_install_confirm']  = 'Are you sure you want to install this theme?';
$lang['sth_theme_upload_confirm']   = 'Are you sure you want to upload this theme?';

// Success messages.
$lang['sth_theme_activate_success'] = 'Theme successfully activated.';
$lang['sth_theme_delete_success']   = 'Theme successfully deleted.';
$lang['sth_theme_install_success']  = 'Theme successfully installed.';
$lang['sth_theme_upload_success']   = 'Theme successfully uploaded.';

// Error messages.
$lang['sth_theme_activate_error'] = 'Unable to activate theme.';
$lang['sth_theme_delete_error']   = 'Unable to delete theme.';
$lang['sth_theme_install_error']  = 'Unable to install theme.';
$lang['sth_theme_upload_error']   = 'Unable to upload theme.';
$lang['sth_theme_delete_active']  = 'You cannot delete the currently active theme.';

// Theme details.
$lang['sth_details']      = 'Theme Details';
$lang['sth_details_name'] = 'Theme Details: %s';
$lang['sth_name']         = 'Name';
$lang['sth_folder']       = 'Folder';
$lang['sth_theme_uri']    = 'Theme URI';
$lang['sth_description']  = 'Description';
$lang['sth_version']      = 'Version';
$lang['sth_license']      = 'License';
$lang['sth_license_uri']  = 'License URI';
$lang['sth_author']       = 'Author';
$lang['sth_author_uri']   = 'Author URI';
$lang['sth_author_email'] = 'Author Email';
$lang['sth_tags']         = 'Tags';
$lang['sth_screenshot']   = 'Screenshot';
$lang['sth_theme_zip']   = 'Theme ZIP Archive';

// Theme install filters.
$lang['sth_theme_featured'] = 'Featured';
$lang['sth_theme_popular']  = 'Popular';
$lang['sth_theme_new']      = 'New';
$lang['sth_theme_search']   = 'Search themes...';

// Details with links:
$lang['sth_theme_name']         = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_license']      = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author']       = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['sth_theme_author_email'] = '<a href="mailto:%1$s" target="_blank" rel="nofollow">Support</a>';
