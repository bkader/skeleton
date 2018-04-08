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
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

$config['full_tag_open']   = '<div class="text-center"><ul class="pagination pagination-small pagination-centered mb0">';
$config['full_tag_close']  = '</ul></div>';
$config['num_links']       = 5;
$config['prev_tag_open']   = '<li>';
$config['prev_tag_close']  = '</li>';
$config['next_tag_open']   = '<li>';
$config['next_tag_close']  = '</li>';
$config['cur_tag_open']    = '<li class="active"><span>';
$config['cur_tag_close']   = '<span class="sr-only">(current)</span></span></li>';
$config['num_tag_open']    = '<li>';
$config['num_tag_close']   = '</li>';
$config['first_tag_open']  = '<li>';
$config['first_tag_close'] = '</li>';
$config['last_tag_open']   = '<li>';
$config['last_tag_close']  = '</li>';

// ------------------------------------------------------------------------
// DON'T EDIT BELOW LINES.
// ------------------------------------------------------------------------

$config['use_page_numbers']     = true;
$config['page_query_string']    = true;
$config['query_string_segment'] = 'page';
