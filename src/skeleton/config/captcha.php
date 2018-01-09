<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Captcha Configuration
 *
 * @package 	CodeIgniter
 * @category 	Configuration
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

// Images path and URL.
$config['img_path']    = './content/captcha/';
$config['img_url']     = base_url('content/captcha/');

// Catpcha font path, font size, word length and characters used.
$config['font_path']   = apply_filters('captcha_font_path', './content/common/fonts/MomsTypewriter.ttf');
$config['font_size']   = apply_filters('captcha_font_size', 16);
$config['word_length'] = apply_filters('captcha_word_length', 6);
$config['pool']        = apply_filters('captcha_pool', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

// Captcha image dimensions and ID.
$config['img_width']   = apply_filters('captcha_img_width', 150);
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
