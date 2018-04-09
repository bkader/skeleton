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
 * Activities language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.0.0
 */

$lang['activities'] = 'Activities';
$lang['activity'] = 'Activity';

// Dashboard title;
$lang['activities_log'] = 'Activities Log';

// Activities table headings.
$lang['module']     = 'Module';
$lang['method']     = 'Method';
$lang['ip_address'] = 'IP Address';
$lang['date']       = 'Date';

// Activities delete messages.
$lang['delete_activity_confirm'] = 'Are you sure you want to delete this activity log?';
$lang['delete_activity_success'] = 'Activity successfully deleted.';
$lang['delete_activity_error']   = 'Unable to delete activity.';

// ------------------------------------------------------------------------
// Modules activities lines.
// ------------------------------------------------------------------------

// Language module.
$lang['act_language_enable'] = 'Enabled language: %s.';
$lang['act_language_disable'] = 'Disabled language: %s.';
$lang['act_language_default'] = 'Set %s as default language.';

// Media module.
$lang['act_media_upload'] = 'Uploaded media: #%s';
$lang['act_media_update'] = 'Updated media: #%s';
$lang['act_media_delete'] = 'Deleted media: #%s';
