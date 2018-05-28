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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities Module - List Activities
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.3
 * @version 	2.0.0
 */

echo '<div class="box">',
'<div class="table-responsive-sm mb-3">',
	'<table class="table table-sm table-hover table-striped">',
		'<thead>',
			'<tr>',
				'<th class="w-20">', __('CSK_REPORTS_USER'), '</th>',
				'<th class="w-15">', __('CSK_REPORTS_MODULE'), '</th>',
				'<th class="w-15">', __('CSK_REPORTS_CONTROLLER'), '</th>',
				'<th class="w-15">', __('CSK_REPORTS_METHOD'), '</th>',
				'<th class="w-15">', __('CSK_REPORTS_IP_ADDRESS'), '</th>',
				'<th class="w-15">', __('CSK_REPORTS_DATE'), '</th>',
				'<th class="w-5 text-right">', __('CSK_ADMIN_ACTION'), '</th>',
			'</tr>',
		'</thead>';

if ($reports) {
	echo '<tbody id="reports-list">';

	foreach ($reports as $report) {
		echo '<tr id="report-'.$report->id.'" data-id="'.$report->id.'" class="report-item">',
			'<td>', $report->user_anchor, '</td>',
			'<td>', $report->module_anchor, '</td>',
			'<td>', $report->controller_anchor, '</td>',
			'<td>', $report->method_anchor, '</td>',
			'<td>', $report->ip_address, '</td>',
			'<td>', date('Y/m/d H:i', $report->created_at), '</td>',
			'<td class="text-right">',
				html_tag('button', array(
					'type' => 'button',
					'data-endpoint' => nonce_ajax_url(
						'reports/delete/'.$report->id,
						'delete-report_'.$report->id
					),
					'class' => 'btn btn-default btn-xs btn-icon report-delete',
				), fa_icon('trash-o text-danger').__('CSK_BTN_DELETE')),
			'</td>',
			
		'</tr>';
	}
	echo '</tbody>';
}
echo '</table>',
'</div>',
'</div>',
$pagination;
