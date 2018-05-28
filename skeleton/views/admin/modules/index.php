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
 * Modules List.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

echo '<div class="box">',
'<div class="table-responsive-md">',
	'<table class="table table-sm table-hover table-striped mb-0">',
		'<thead>',
			'<tr>',
				'<th class="w-15">', __('CSK_MODULES_MODULE'), '</th>',
				'<th class="w-50">', __('CSK_MODULES_DESCRIPTION'), '</th>',
				'<th class="w-35 text-right">', __('CSK_ADMIN_ACTIONS'), '</th>',
			'</tr>',
		'</thead>';
if ($modules) {
	echo '<tbody>';

	foreach ($modules as $folder => $module) {

		echo '<tr id="module-'.$folder.'" data-module="'.$folder.'" data-name="'.$module['name'].'">',
			'<td>',
				html_tag(($module['enabled'] ? 'strong' : 'span'), array(
					'data-module' => $folder,
				), $module['name']),
			'</td>',
			'<td>',
				'<p>', $module['description'], '</p>',
				implode(' &#124; ', $module['details']),
			'</td>',
			'<td class="text-right">',
				implode('', $module['actions']),
			'</td>',
		'</tr>';
	}

	echo '</tbody>';
}
echo '</table>',
'</div>',
'</div>';
