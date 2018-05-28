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
 * Language Module - Admin
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

echo '<div class="box">',
'<div class="table-responsive-sm">',
	'<table class="table table-sm table-striped table-hover mb-0">',
		'<thead>',
			'<tr>',
				'<th class="w-25">', __('CSK_LANGUAGES_LANGUAGE'), '</th>',
				'<th class="w-15">', __('CSK_LANGUAGES_ABBREVIATION'), '</th>',
				'<th class="w-15">', __('CSK_LANGUAGES_FOLDER'), '</th>',
				'<th class="w-10">', __('CSK_LANGUAGES_IS_DEFAULT'), '</th>',
				'<th class="w-10">', __('CSK_LANGUAGES_ENABLED'), '</th>',
				'<th class="w-25 text-right">', __('CSK_ADMIN_ACTIONS'), '</th>',
			'</tr>',
		'</thead>';

if ($languages) {
	echo '<tbody id="languages-list">';

	foreach ($languages as $folder => $lang) {
		echo '<tr id="lang-'.$folder.'" data-name="'.$lang['name'].'">',

			'<td>';

			if (true === $lang['available']) {
				echo $lang['name_en'];
			} else {
				echo html_tag('del', array(
					'class' => 'text-danger',
					'title' => __('CSK_LANGUAGES_MISSING_FOLDER'),
				), $lang['name_en']);
			}
			echo html_tag('span', array(
				'class' => 'text-muted ml-2'
			), $lang['name']),
			'</td>',

			'<td>', $lang['code'], html_tag('small', array(
				'class' => 'text-muted ml-2'
			), $lang['locale']), '</td>',

			'<td>', $lang['folder'], '</td>',

			'<td>', label_condition($folder === $language), '</td>',
			
			'<td>', label_condition(in_array($folder, $available_languages)), '</td>',
			
			'<td class="text-right">', implode('', $lang['actions']), '</td>',

		'</tr>';
	}

	echo '</tbody>';
}

echo '</table>',
'</div>',
'</div>';
