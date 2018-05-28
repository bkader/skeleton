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
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Captcha Configuration
 *
 * This files holds some default configurations that are passed
 * through filters making them editable by plugins and themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

// Images path and URL.
$config['img_path']    = './content/captcha/';
$config['img_url']     = base_url('content/captcha/');

// Catpcha font path, font size, word length and characters used.
$config['font_path']   = apply_filters('captcha_font_path', './content/common/fonts/edmunds.ttf');
$config['font_size']   = apply_filters('captcha_font_size', 16);
$config['word_length'] = apply_filters('captcha_word_length', 6);
$config['pool']        = apply_filters('captcha_pool', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

// Captcha image dimensions and ID.
$config['img_width']   = apply_filters('captcha_img_width', 120);
$config['img_height']  = apply_filters('captcha_img_height', 30);
$config['img_id']      = apply_filters('captcha_img_id', 'captcha');

// Captcha expiration time.
$config['expiration']  = (MINUTE_IN_SECONDS * 5);

// Different elements colors.
$config['colors'] = array(
	'background' => apply_filters('captcha_background_color', array(255, 255, 255)),
	'border'     => apply_filters('captcha_border_color',     array(255, 255, 255)),
	'text'       => apply_filters('captcha_text_color',       array(0, 0, 0)),
	'grid'       => apply_filters('captcha_grid_color',       array(255, 40, 40)),
);
