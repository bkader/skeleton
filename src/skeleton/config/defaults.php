<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// General settings.
$config['site_name']        = 'Skeleton';
$config['site_description'] = 'A skeleton application for building CodeIgniter application.';
$config['site_keywords']    = 'these, are, site, keywords';
$config['site_favicon']     = 'favicon.ico';
$config['site_author']      = 'Kader Bouyakoub';

// Trace URL key.
$config['trace_url_key'] = 'trk';

// Themes settings.
$config['theme']       = 'default';
$config['theme_admin'] = 'acp';

// Google analytics and verification.
$config['google_analytics_id']      = '';
$config['google_site_verification'] = '';

// Elements per page.
$config['per_page'] = 10;

// Users settings
$config['allow_registration'] = true;
$config['email_activation']   = false;
$config['manual_activation']  = false;
$config['login_type']         = 'both';
$config['use_gravatar']       = false;

// Email settings.
$config['admin_email']   = 'admin@localhost';
$config['server_email']  = '';
$config['mail_protocol'] = 'mail';
$config['sendmail_path'] = '/usr/sbin/sendmail';
$config['smtp_crypto']   = 'none';
$config['smtp_host']     = '';
$config['smtp_pass']     = '';
$config['smtp_port']     = '';
$config['smtp_user']     = '';

// Upload settings.
$config['upload_path']   = 'content/uploads';
$config['allowed_types'] = 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4';

// Captcha settings.
$config['use_captcha']           = false;
$config['use_recaptcha']         = false;
$config['recaptcha_site_key']    = '';
$config['recaptcha_private_key'] = '';

/* End of file defaults.php */
/* Location: ./application/config/defaults.php */
