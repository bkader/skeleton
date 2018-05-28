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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins list.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

// Form opening tag.
echo form_open(KB_ADMIN.'/plugins', 'class="form-inline box"'),

// Form nonce field.
form_nonce('bulk-update-plugins'),

// Bulk action section.
'<div class="table-bulk-actions box-header">',

	form_dropdown('action', array(
		'activate-selected'   => __('CSK_PLUGINS_ACTIVATE'),
		'deactivate-selected' => __('CSK_PLUGINS_DEACTIVATE'),
		'delete-selected'     => __('CSK_PLUGINS_DELETE'),
	), 'activate-selected', 'class="form-control form-control-sm"'),

	form_submit('doaction', __('CSK_BTN_APPLY'), 'class="btn btn-primary btn-sm ml-1"'),

'</div>',

// Plugins list table.
'<div class="table-responsive-sm">',
'<table class="table table-sm table-hover table-striped mb-0">',
// Table heading.
'<thead>',
'<tr>',
	// Bulk Selection?
	'<th class="w-2">',
		form_label(__('CSK_PLUGINS_SELECT_ALL'), null, 'class="sr-only"'),
		form_checkbox('check-all', null, false),
	'</th>',
	
	'<th class="w-20">', __('CSK_PLUGINS_PLUGIN'), '</th>',
	'<th class="w-50">', __('CSK_PLUGINS_DESCRIPTION'), '</th>',
	'<th class="w-30 text-right">', __('CSK_ADMIN_ACTIONS'), '</th>',
'</tr>',
'</thead>';

// Plugins list.
if ($plugins) {
	echo '<tbody>';
	foreach ($plugins as $folder => $plugin) {
		echo '<tr id="plugin-'.$folder.'" data-plugin="'.$folder.'" data-name="'.$plugin['name'].'">',
			// Plugin selection.
			'<td>',
				form_label('Select '.$plugin['name'], 'checkbox-'.$folder, 'class="sr-only"'),
				form_checkbox('selected[]', $folder, false, 'id="checkbox-'.$folder.'" class="check-this"'),
			'</td>',
			
			'<td>',
				html_tag(($plugin['enabled'] ? 'strong' : 'span'), array(
					'data-plugin' => $folder,
				), $plugin['name']),
			'</td>',
			
			'<td>',
				html_tag('p', null, $plugin['description']),
				implode(' &#124; ', $plugin['details']),
			'</td>',
			'<td class="text-right">',
				implode('', $plugin['actions']),
			'</td>',
		'</tr>';
	}
	echo '</tbody>';
}

echo '</table></div>',
form_close();
