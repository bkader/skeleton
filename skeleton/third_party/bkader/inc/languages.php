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
 * This file holds an array of languages details.
 * You can add as many as you want, just respect the structure.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.3.3
 */
return array(

	// Arabic
	'arabic' => array(
		'name'      => 'العربية',
		'name_en'   => 'Arabic',
		'folder'    => 'arabic',
		'locale'    => 'ar-DZ',
		'gettext'   => 'ar_DZ',
		'direction' => 'rtl',
		'code'      => 'ar',
		'flag'      => 'dz',
	),

	// Armenian
	'armenian' => array(
		'name'      => 'հայերեն',
		'name_en'   => 'Armenian',
		'folder'    => 'armenian',
		'locale'    => 'hy-AM',
		'gettext'   => 'hy_AM',
		'direction' => 'ltr',
		'code'      => 'hy',
		'flag'      => 'AM',
	),

	// Czech
	'czech' => array(
		'name'      => 'Čeština',
		'name_en'   => 'Czech',
		'folder'    => 'czech',
		'locale'    => 'cs-CZ',
		'gettext'   => 'cs_CZ',
		'direction' => 'ltr',
		'code'      => 'cs',
		'flag'      => 'cz',
	),

	// English
	'english' => array(
		'name'      => 'English',
		'name_en'   => 'English',
		'folder'    => 'english',
		'locale'    => 'en-US',
		'gettext'   => 'en_US',
		'direction' => 'ltr',
		'code'      => 'en',
		'flag'      => 'us',
	),

	// French
	'french' => array(
		'name'      => 'Français',
		'name_en'   => 'French',
		'folder'    => 'french',
		'locale'    => 'fr-FR',
		'gettext'   => 'fr_FR',
		'direction' => 'ltr',
		'code'      => 'fr',
		'flag'      => 'fr',
	),

	// German
	'german' => array(
		'name'      => 'Deutsch',
		'name_en'   => 'German',
		'folder'    => 'german',
		'locale'    => 'de-DE',
		'gettext'   => 'de_DE',
		'direction' => 'ltr',
		'code'      => 'de',
		'flag'      => 'de',
	),

	// Greek
	'greek' => array(
		'name'      => 'ελληνικά',
		'name_en'   => 'Greek',
		'folder'    => 'greek',
		'locale'    => 'el-GR',
		'gettext'   => 'el_GR',
		'direction' => 'ltr',
		'code'      => 'el',
		'flag'      => 'gr',
	),

	// Hindi
	'hindi' => array(
		'name'      => 'हिन्दी',
		'name_en'   => 'Hindi',
		'folder'    => 'hindi',
		'locale'    => 'hi-IN',
		'gettext'   => 'hi_IN',
		'direction' => 'ltr',
		'code'      => 'hi',
		'flag'      => 'in',
	),

	// Italian
	'italian' => array(
		'name'      => 'Italiano',
		'name_en'   => 'Italian',
		'folder'    => 'italian',
		'locale'    => 'it-IT',
		'gettext'   => 'it_IT',
		'direction' => 'ltr',
		'code'      => 'it',
		'flag'      => 'it',
	),

	// Japanese
	'japanese' => array(
		'name'      => '日本語',
		'name_en'   => 'Japanese',
		'folder'    => 'japanese',
		'locale'    => 'ja-JP',
		'gettext'   => 'ja_JP',
		'direction' => 'ltr',
		'code'      => 'ja',
		'flag'      => 'jp',
	),

	// Persian
	'persian' => array(
		'name'      => 'فارسی',
		'name_en'   => 'Persian',
		'folder'    => 'persian',
		'locale'    => 'fa-IR',
		'gettext'   => 'fa_IR',
		'direction' => 'rtl',
		'code'      => 'fa',
		'flag'      => 'ir',
	),

	// Portuguese
	'portuguese' => array(
		'name'      => 'Português',
		'name_en'   => 'Portuguese',
		'folder'    => 'portuguese',
		'locale'    => 'pt-PT',
		'gettext'   => 'pt_PT',
		'direction' => 'ltr',
		'code'      => 'pt',
		'flag'      => 'pt',
	),

	// Russian
	'russian' => array(
		'name'      => 'ру́сский',
		'name_en'   => 'Russian',
		'folder'    => 'russian',
		'locale'    => 'ru-RU',
		'gettext'   => 'ru_RU',
		'direction' => 'ltr',
		'code'      => 'ru',
		'flag'      => 'ru',
	),

	// Spanish
	'spanish' => array(
		'name'      => 'Español',
		'name_en'   => 'Spanish',
		'folder'    => 'spanish',
		'locale'    => 'es-ES',
		'gettext'   => 'es_ES',
		'direction' => 'ltr',
		'code'      => 'es',
		'flag'      => 'es',
	),

	// Turkish
	'turkish' => array(
		'name'      => 'Türkçe',
		'name_en'   => 'Turkish',
		'folder'    => 'turkish',
		'locale'    => 'tr-TR',
		'gettext'   => 'tr_TR',
		'direction' => 'ltr',
		'code'      => 'tr',
		'flag'      => 'tr',
	),

	// Ukrainian
	'ukrainian' => array(
		'name'      => 'українська мова',
		'name_en'   => 'Ukrainian',
		'folder'    => 'ukrainian',
		'locale'    => 'uk-UA',
		'gettext'   => 'uk_UA',
		'direction' => 'ltr',
		'code'      => 'uk',
		'flag'      => 'ua',
	),

	// Vietnamese
	'vietnamese' => array(
		'name'      => 'tiếng Việt',
		'name_en'   => 'Vietnamese',
		'folder'    => 'vietnamese',
		'locale'    => 'vi-VN',
		'gettext'   => 'vi_VN',
		'direction' => 'ltr',
		'code'      => 'vi',
		'flag'      => 'vn',
	),

);
