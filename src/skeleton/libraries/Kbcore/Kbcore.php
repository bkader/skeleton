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
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://github.com/bkader
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('CRUD_interface.php');

/**
 * Main application library.
 *
 * @package 	CodeIgniter
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Kbcore extends CI_Driver_Library
{
	/**
	 * Instance of CI object.
	 * @var object
	 */
	public $ci;

	/**
	 * Array of valid drivers.
	 * @var array
	 */
	public $valid_drivers;

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		$this->ci =& get_instance();

		// Fill valid drivers.
		$this->valid_drivers = array(
			'activities',
			'entities',
			'groups',
			'menus',
			'metadata',
			'objects',
			'options',
			'plugins',
			'relations',
			'users',
			'variables',
		);

		// Here we load all what we need.
		$this->ci->load->database();
		$this->ci->load->library('session');

		// Let's assign options from database to CodeIgniter config.
		$this->ci->load->config('defaults');

		foreach ($this->valid_drivers as $driver)
		{
			$this->{$driver}->initialize();
		}

		// Store language in session.
		if ( ! $this->ci->session->language)
		{
			$this->_set_language();
		}

		// Make sure to load the URL helper.
		$this->ci->load->helper('url');

		/**
		 * Loading the language helper is now useless because the 
		 * lang() function was moved to KB_Lang.php file so it is
		 * available even if we don't load the helpe.
		 */
		// $this->ci->load->helper('language');

		// Loading theme library.
		$this->ci->load->library('theme');

		// Make current language available to themes.
		$languages = $this->ci->lang->languages();
		$this->ci->theme->set(
			'current_language',
			$languages[$this->ci->session->language],
			true
		);

		// Make language selection available to themes.
		$langs = array();
		if (count($this->ci->config->item('languages')) > 0)
		{
			foreach ($languages as $folder => $details)
			{
				if (in_array($folder, $this->ci->config->item('languages')) 
					&& $folder !== $this->ci->session->language)
				{
					$langs[$folder] = $details;
				}
			}
		}
		$this->ci->theme->set('site_languages', $langs, true);

		// Load main language file.
		$this->ci->load->language('bkader_main');

		// Attempt to authenticate the current user.
		// $this->auth->authenticate();
		$this->ci->load->library('users/auth', array('kbcore' => $this));

		// Initialize plugins if plugins system is enabled.
		$this->plugins->load_plugins();

		log_message('info', 'Kbcore Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Quick action to add meta tags to given page.
	 * @access 	public
	 * @param 	object 	$object 	the page or course.
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return 	void
	 */
	public function set_meta($object = null)
	{
		// Add favicon.
		$this->ci->theme->add_meta('icon', base_url('favicon.ico'), 'rel', 'type="image/x-icon"');

		// Default meta tags that will be overridden later.

		// Site name and default title.
		if ($this->ci->config->item('site_name'))
		{
			$this->ci->theme->set_title($this->ci->config->item('site_name'));
			$this->ci->theme->set('site_name', $this->ci->config->item('site_name'));
			$this->ci->theme->add_meta('application-name', $this->ci->config->item('site_name'));
			$this->ci->theme->add_meta('title', $this->ci->config->item('site_name'));
		}

		// Site description.
		if ($this->ci->config->item('site_description'))
		{
			$this->ci->theme->add_meta('description', $this->ci->config->item('site_description'));
		}

		// Site keywords.
		if ($this->ci->config->item('site_keywords'))
		{
			$this->ci->theme->add_meta('keywords', $this->ci->config->item('site_keywords'));
		}

		// Add site's author if found.
		if ($this->ci->config->item('site_author'))
		{
			$this->ci->theme->add_meta('author', $this->ci->config->item('site_author'));
		}

		// Add google site verification IF found.
		if ($this->ci->config->item('google_site_verification'))
		{
			$this->ci->theme->add_meta(
				'google-site-verification',
				$this->ci->config->item('google_site_verification')
			);
		}

		// Add Google Anaytilcs IF found!
		if ($this->ci->config->item('google_analytics_id')
			&& $this->ci->config->item('google_analytics_id') !== 'UA-XXXXX-Y')
		{
			$this->ci->theme->add_meta(
				'google-analytics',
				$this->ci->config->item('google_analytics_id')
			);
		}

		// Add canonical tag.
		$this->ci->theme->add_meta('canonical', current_url(), 'rel');

		// if ($this->ci->config->item('site_name'))
		// {
		// 	$this->ci->theme->add_meta('og:title', $this->ci->config->item('site_name'));
		// }

		// if ($this->ci->config->item('site_description'))
		// {
		// 	$this->ci->theme->add_meta('og:description', $this->ci->config->item('site_description'));
		// }

		// // Default open graph tags.
		// $this->ci->theme->add_meta('og:type', 'website');
		// $this->ci->theme->add_meta('og:url', current_url());

		// If no $object provided, we stop.
		if ( ! empty($object))
		{
			$this->ci->theme->add_meta('title', $object->name);
			$this->ci->theme->add_meta('og:title', $object->name);

			if ( ! empty($object->description))
			{
				$this->ci->theme->add_meta('description', $object->description);
				$this->ci->theme->add_meta('og:description', $object->description);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Quick method to send emails.
	 * @access 	public
	 * @param 	string 	$to 		the whom send the email.
	 * @param 	string 	$subject 	the email's subject?
	 * @param 	string 	$messages 	the email's body.
	 * @param 	string 	$cc 		carbon copy.
	 * @param 	string 	$bcc 		blind carbon copy.
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return 	bool 	true if the email is sent.
	 */
	public function send_email($to, $subject, $message, $cc = null, $bcc = null)
	{
		$this->ci->load->library('email');

		// Start by setting up the email config.
		$mail_protocol = $this->ci->config->item('mail_protocol');
		$config['mail_protocol'] = $mail_protocol;

		/*
			Now we set the rest of the config parameters
			depending on the mail protocol.
		 */
		switch ($mail_protocol)
		{
			// The old fashion way?
			case 'mail':
				// Nothing to add.
				break;

			// Using SMTP?
			case 'smtp':
				$config['smtp_host']   = $this->ci->config->item('smtp_host');
				$config['smtp_user']   = $this->ci->config->item('smtp_user');
				$config['smtp_pass']   = $this->ci->config->item('smtp_pass');
				$config['smtp_port']   = $this->ci->config->item('smtp_port');
				$config['smtp_crypto'] = $this->ci->config->item('smtp_crypto');
				($config['smtp_crypto'] == 'none') && $config['smtp_crypto'] = '';
				break;

			// Using sendmain?
			case 'sendmail':
				// The server path to Sendmail. Default: '/usr/sbin/sendmail'
				$config['mailpath'] = $this->ci->config->item('sendmail_path');
				break;

			// Default (which is mail).
			default:
				/*
					$mail_protocol ended up being something
					other than the 3 we check for, so we override
					whatever it was and go with 'mail'
				 */
				$config['protocol'] = 'mail';
				break;
		}

		/*
			the rest of the config items we don't need to
			worry about which protocol the site is using...
		 */
		$config['charset']   = 'utf8';
		$config['wordwrap']  = true;
		$config['useragent'] = $this->ci->config->item('site_name');
		$config['mailtype']  = 'html';

		// Let's now initialize email library.
		$this->ci->email->initialize($config);

		// The from is obviously from the database.
		$this->ci->email->from(
			$this->ci->config->item('server_email'),
			$this->ci->config->item('site_name')
		);

		// To whow send this email.
		$this->ci->email->to($to);

		// A carbon copy is set?
		if ( ! empty($cc))
		{
			$this->ci->email->cc($cc);
		}

		// A blind carbon copy is set?
		if ( ! empty($bcc))
		{
			$this->ci->email->bcc($bcc);
		}

		// Prepare the email subject.
		$this->ci->email->subject($subject);

		// Set the email message.
		$this->ci->email->message($message);

		// And here we go! Send it.
		if ( ! $this->ci->email->send())
		{
			log_message('error', 'Emails are not being sent!');
			$this->ci->email->print_debugger();
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure to store language in session.
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function _set_language()
	{
		// Hold the default language.
		$default = $this->ci->config->item('language');

		// Site available languages.
		$site_languages = $this->ci->config->item('languages');

		// All languages to details to search in.
		$languages = $this->ci->lang->languages();

		// Attempt to detect user's language.
		$code = substr($this->ci->input->server('HTTP_ACCEPT_LANGUAGE', true), 0, 2);

		foreach ($languages as $folder => $details)
		{
			if ($details['code'] === $code && in_array($folder, $site_languages))
			{
				$default = $folder;
				break;
			}
		}

		// Now we setup the session data.
		$this->ci->session->set_userdata('language', $default);
	}

}
