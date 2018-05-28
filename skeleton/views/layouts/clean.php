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
 * Dashboard clean layout.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views - Layouts.
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

// Layout opening tags.
echo '<div class="container">',
'<div class="card">';

/**
 * Skeleton logo filter.
 * @since 	2.0.0
 */
$login_src = apply_filters('login_img_src', get_common_url('img/skeleton-inverse.png'));
$login_alt = apply_filters('login_img_alt', 'CodeIgniter Skeleton');
$login_url = apply_filters('login_img_url', site_url());

if ( ! empty($login_src)) {
	echo '<div class="card-body card-logo">';
	$login_img = html_tag('img', array(
		'src'   => $login_src,
		'class' => 'login-logo',
		'alt'   => $login_alt
	));

	echo empty($login_url) ? $login_img : "<a href=\"{$login_url}\" tabindex=\"-1\">{$login_img}</a>";
	echo '</div>';
}

echo '<div class="card-body">';

// Display the alert.
the_alert();

// Display the content.
the_content();

echo '</div></div></div>';

/**
 * Footer section.
 * @since 	2.0.0
 */
echo '<footer class="footer" id="footer" role="contactinfo">',
'<div class="container">';

// Left side of the footer.
echo '<span>',
html_tag('a', array(
	'href' => site_url(),
	'target' => '_blank',
), '<i class="fa fa-fw fa-external-link mr-1"></i>'.line('CSK_BTN_GO_HOMEPAGE')),
'</span>';

/**
 * Display centered Skeleton logo.
 * @var string
 */
$login_logo = html_tag('a', array(
	'href'   => 'https://goo.gl/jb4nQC',
	'target' => '_blank',
	'rel'    => 'tooltip',
	'title' => line('CSK_SKELETON_OPEN_SOURCE'),
	'class'  => 'skeleton-footer-logo',
));
$login_logo = apply_filters('login_logo', $login_logo);
if ( ! empty($login_logo)) {
	echo $login_logo;
}

/**
 * Filter Skeleton copyright on the clean layout.
 * @since 	2.0.0
 */
$default_copyright = sprintf(line('CSK_SKELETON_COPYRIGHT'), date('Y'));
$footer_copyright = apply_filters('login_copyright', $default_copyright);
if ( ! empty($footer_copyright)) {
	echo '<span class="pull-right">', $footer_copyright, '</span>';
}

// Layout closing tags.
echo '</div></footer>';
