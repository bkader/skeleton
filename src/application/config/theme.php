<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Library Configuration
 *
 * This files holds theme settings
 *
 * @package 	CodeIgniter
 * @category 	Configuration
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 * @link 	https://twitter.com/KaderBouyakoub
 */

/**
 * Set the path to where themes are located. They must be
 * somewhere next to FCPATH with you mush not include.
 */
$config['themes_folder']  = 'content/themes';
$config['uploads_folder'] = 'content/uploads';
$config['common_folder']  = 'content/common';

// Site default theme
$config['theme'] = 'default';

// Site title separator
$config['title_sep'] = '&#150;';

// Minify HTML Output
$config['compress'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');

// Cache life time
$config['cache_lifetime'] = 0;

// Enable CDN (to use 2nd argument of css() & js() functions)
$config['cdn_enabled'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');

// The CDN URL if you host your files there
$config['cdn_server'] = ''; // i.e: 'http://static.myhost.com/';

/**
 * Set this to true to detect browser details.
 * This is useful if you want to check if the
 * user is on mobile or not and it gives you access
 * to browser's name, version and the platform the
 * client is using.
 */
$config['detect_browser'] = false;

/**
 * Setting this to true will make the library deletect
 * client's language and set the language if config
 * array to client's.
 */
$config['i18n_enabled']   = false;
$config['i18n_available'] = array('english', 'french');

// ------------------------------------------------------------------------
// Backup plan :D for site name, desription & keywords
// ------------------------------------------------------------------------

// Default site name, description and keywords.
$config['site_name']        = 'CI-Theme';
$config['site_description'] = 'Simply makes your CI-based applications themable. Easy and fun to use.';
$config['site_keywords']    = 'codeigniter, themes, libraries, bkader, bouyakoub';

/* End of file theme.php */
/* Location: ./application/config/theme.php */
