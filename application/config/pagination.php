<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagination Configuration
 *
 * This is the default pagination configuration that uses Bootstrap
 * pagination.
 * Notice that a MY_Pagination library has been provided in order to
 * use our custom KB_Pagination that uses hooks system to allow theme
 * to interact with pagination behavior and look.
 *
 * @package 	CodeIgniter
 * @category 	Configuration
 * @author 	Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 	https://goo.gl/wGXHO9
 */

// Enclosing Markup.
$config['full_tag_open']  = '<p>';
$config['full_tag_close'] = '</p>';

// Number of "digit" before and after the selected page.
$config['num_links'] = 5;

// Customizing the "Digit" Link.
$config['num_tag_open']    = '<div>';
$config['num_tag_close']   = '</div>';

// Customizing the "Previous" Link.
$config['prev_tag_open']   = '<div>';
$config['prev_tag_close']  = '</div>';

// Customizing the "Next" Link.
$config['next_tag_open']   = '<div>';
$config['next_tag_close']  = '</div>';

// Customizing the First Link.
$config['first_tag_open']  = '<div>';
$config['first_tag_close'] = '</div>';

// Customizing the Last Link.
$config['last_tag_open']  = '<div>';
$config['last_tag_close'] = '</div>';

// Customizing the "Current Page" Link
$config['cur_tag_open']    = '<b>';
$config['cur_tag_close']   = '</b>';

// Whether to hide pages numbers.
$config['display_pages'] = TRUE;

// Anchors attributes.
$config['attributes'] = NULL;
