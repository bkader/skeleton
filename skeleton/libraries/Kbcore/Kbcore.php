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
 * Some of our drivers need to respect this interface's
 * structure. So we are importing it here.
 */
require_once('CRUD_interface.php');

/**
 * Kbcore Library
 *
 * This is the Skeleton main library that handles almost everything on the application.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.6
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
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Updated methods order to avoid loading different language (activities).
	 * @since 	2.1.6 	The "_set_language" was moved to "KB_Lang" class.
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		$this->ci =& get_instance();

		// Fill valid drivers.
		$this->valid_drivers = array(
			'auth',
			'activities',
			'entities',
			'groups',
			'metadata',
			'options',
			'objects',
			'plugins',
			'relations',
			'users',
			'variables',
		);

		// Load Skeleton required resources.
		$this->_load_dependencies();

		/**
		 * Here we are making an instance of this driver global
		 * so that themes, plugins or others can use it.
		 */
		global $KB, $DB;
		$KB = new stdClass();

		/**
		 * Fires early, before drivers are loaded.
		 * @since 	2.1.3
		 */
		do_action('init');

		// We initialize options.
		$this->options->initialize();
		$KB->options = $this->options;

		// Initialize authentication library.
		$this->auth->initialize();
		$KB->auth = $this->auth;
		$this->ci->auth =& $this->auth;

		// Initialize library drivers.
		foreach ($this->valid_drivers as $driver)
		{
			// Options already initialized.
			if ('options' !== $driver && 'auth' !== $driver)
			{
				if (method_exists($this->{$driver}, 'initialize'))
				{
					$this->{$driver}->initialize();
				}

				$KB->{$driver} = $this->{$driver};
			}
		}

		// We finally add add instance of CI and DB objects.
		$KB->ci =& $this->ci;
		$DB =& $this->ci->db;

		// Make current language available to themes.
		$this->_languages_list();

		log_message('info', 'Kbcore Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Quick action to add meta tags to given page.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Removed the favicon to let themes decide what to use.
	 * 
	 * @access 	public
	 * @param 	mixed 	$object 	the page or course. (object or array)
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return 	void
	 */
	public function set_meta($object = null)
	{
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

		// Is $object provided?
		if ($object !== null)
		{
			// Is it an object?
			if (is_object($object))
			{
				$this->ci->theme->add_meta('title', $object->name);
				$this->ci->theme->add_meta('og:title', $object->name);

				if ( ! empty($object->description))
				{
					$this->ci->theme->add_meta('description', $object->description);
					$this->ci->theme->add_meta('og:description', $object->description);
				}
			}
			// Is it an array?
			elseif (is_array($object))
			{
				$this->ci->theme->add_meta('title', $object['name']);
				$this->ci->theme->add_meta('og:title', $object['name']);

				if ( ! empty($object['description']))
				{
					$this->ci->theme->add_meta('description', $object['description']);
					$this->ci->theme->add_meta('og:description', $object['description']);
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Better way of sending email messages.
	 *
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	mixed 	$user 		The user's ID or object.
	 * @param 	string 	$subect 	The email subject.
	 * @param 	string 	$message 	The message to be sent.
	 * @param 	array 	$data 		Array of data to pass to views.
	 * @return 	Kbcore::_send_email()
	 */
	public function send_email($user, $subject, $message,$data = array())
	{
		if (empty($message) OR empty($user))
		{
			return false;
		}


		$user = ($user instanceof KB_User) ? $user : $this->users->get($user);
		if ( ! $user)
		{
			return false;
		}

		$email       = isset($data['email']) ? $data['email'] : $user->email;
		$name        = isset($data['name']) ? $data['name'] : $user->first_name;
		$site_name   = $this->ci->config->item('site_name');
		$site_anchor = anchor('', $site_name, 'target="_blank"');

		/**
		 * There are three options to load messages
		 * 1. Just pass the message.
		 * 2. Use "view:xx" to load a specific view file.
		 * 3. Use "lang:xx" to use a language file.
		 */
		if (1 === sscanf($message, 'view:%s', $view))
		{
			$message = $this->ci->load->view($view, null, true);
		}
		elseif (1 === sscanf($message, 'lang:%s', $line))
		{
			$message = line($line);
		}

		// Prepare default output replacements.
		$search  = array('{name}', '{site_name}', '{site_anchor}');
		$replace = array($name, $site_name, $site_anchor);

		// We add IP Address.
		if ( ! isset($data['ip_link']))
		{
			$ip_address = $this->ci->input->ip_address();
			$data['ip_link'] = html_tag('a', array(
				'href'   => 'https://www.iptolocation.net/trace-'.$ip_address,
				'target' => '_blank',
				'rel'    => 'nofollow',
			), $ip_address);
		}

		// If we have any other elements, use theme.
		if ( ! empty($data))
		{
			foreach ($data as $key => $val)
			{
				$search[]  = "{{$key}}";
				$replace[] = $val;
			}
		}

		// Message subject.
		$subject = str_replace($search, $replace, $subject);

		// Prepare message body and alternative message.
		$raw_message = str_replace($search, $replace, $message);
		$alt_message = strip_all_tags($raw_message);

		$message = $this->ci->load->view('emails/_header', null, true);
		$message .= nl2br($raw_message);
		$message .= $this->ci->load->view('emails/_footer', null, true);

		return $this->_send_email($email, $subject, $message, $alt_message);
	}

	// --------------------------------------------------------------------

	/**
	 * Quick method to send emails.
	 * @access 	protected
	 * @param 	string 	$to 			the whom send the email.
	 * @param 	string 	$subject 		the email's subject?
	 * @param 	string 	$message 		the email's body.
	 * @param 	string 	$alt_message 	Alternative message;
	 * @param 	string 	$cc 			carbon copy.
	 * @param 	string 	$bcc 			blind carbon copy.
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return 	bool 	true if the email is sent.
	 */
	protected function _send_email($to, $subject = '', $message = '', $alt_message = null, $cc = null, $bcc = null)
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

		// Set the email message and alternative message.
		$this->ci->email->message($message);

		if ( ! empty($alt_message))
		{
			$this->ci->email->set_alt_message(nl2br($alt_message));
		}

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
	 * Database WHERE clause generator.
	 *
	 * @since 	1.3.0
	 * @since 	1.3.3 	Added the possibility to use "or:" for single values.
	 * @since 	1.3.3 	Removed lines causing pagination not to work properly.
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	object 	it returns the DB object so that the method can be chainable.
	 */
	public function where($field = null, $match = null, $limit = 0, $offset = 0)
	{
		if ($field !== null)
		{
			// Make sure $field is an array.
			(is_array($field)) OR $field = array($field => $match);

			// Let's generate the WHERE clause.
			foreach ($field as $key => $val)
			{
				// We make sure to ignore empty key.
				if (empty($key) OR is_int($key))
				{
					continue;
				}

				// The default method to call.
				$method = 'where';

				// In case $val is an array.
				if (is_array($val))
				{
					// The default method to call is "where_in".
					$method = 'where_in';

					// Should we use the "or_where_not_in"?
					if (strpos($key, 'or:!') === 0)
					{
						$method = 'or_where_not_in';
						$key    = str_replace('or:!', '', $key);
					}
					// Should we use the "or_where_in"?
					elseif (strpos($key, 'or:') === 0)
					{
						$method = 'or_where_in';
						$key    = str_replace('or:', '', $key);
					}
					// Should we use the "where_not_in"?
					elseif (strpos($key, '!') === 0)
					{
						$method = 'where_not_in';
						$key    = str_replace('!', '', $key);
					}
				}
				elseif (strpos($key, 'or:') === 0)
				{
					$method = 'or_where';
					$key    = str_replace('or:', '', $key);
				}

				$this->ci->db->{$method}($key, $val);
			}
		}

		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		return $this->ci->db;
	}

	// ------------------------------------------------------------------------

	/**
	 * Database LIKE clause generator.
	 *
	 * @since 	1.3.0
	 * @since 	1.3.2 	The metadata column "key" was renamed back to "name".
	 * @since 	1.3.3 	Removed lines causing pagination not to work properly.
	 *
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @param 	string 	$type 	The type of search: users, groups, objects OR null.
	 * @return 	object 	it returns the DB object so that the method can be chainable.
	 */
	public function find($field, $match = null, $limit = 0, $offset = 0, $type = null)
	{
		// We make sure $field is an array.
		(is_array($field)) OR $field = array($field => $match);

		/**
		 * The search is triggered depending of what we are looking for.
		 * This is useful because sometimes we may want to retrieve entities
		 * by their metadata. Otherwise, we generate a default LIKE clause.
		 */
		switch ($type)
		{
			// In case of looking for an entity.
			case 'users':
			case 'groups':
			case 'objects':

				// We make sure to join the required table.
				$this->ci->load->helper('inflector');
				$this->ci->db
					// We select only main tables fields to avoid joining metadata.
					->select("entities.*, {$type}.*")
					->distinct()
					->where('entities.type', singular($type))
					->join($type, "{$type}.guid = entities.id");

				// The following anchoris  used to avoid multiple join.
				$metadata_joint = true;

				// Generate the query.
				$count = 1;
				foreach ($field as $key => $val)
				{
					/**
					 * If we are searching by a field that exists in one of the main
					 * tables: entities, users, groups or objects.
					 */
					if (in_array($key, $this->{$type}->fields()) 
						OR in_array($key, $this->entities->fields()))
					{
						// Make sure not to search in metadata.
						$metadata_joint = false;

						if ( ! is_array($val))
						{
							$method = ($count == 1) ? 'like' : 'or_like';
							if (strpos($key, '!') === 0)
							{
								$method = ($count == 1) ? 'not_like' : 'or_not_like';
								$key = str_replace('!', '', $key);
							}

							$this->ci->db->{$method}($key, $val);
						}
						else
						{
							foreach ($val as $_val)
							{
								$method = 'like';
								if (strpos($key, '!') === 0)
								{
									$method = 'not_like';
									$key = str_replace('!', '', $key);
								}

								$this->ci->db->{$method}($key, $val);
							}
						}

						$count++;
					}
					// Otherwise, we search by metadata.
					else
					{
						// Join metadata table?
						if ($metadata_joint === true)
						{
							$this->ci->db->join('metadata', 'metadata.guid = entities.id');

							// Stop multiple joins.
							$metadata_joint = false;
						}
						
						if ( ! is_array($val))
						{
							$method = ($count == 1) ? 'like' : 'or_like';
							if (strpos($key, '!') === 0)
							{
								$method = ($count == 1) ? 'not_like' : 'or_not_like';
								$key = str_replace('!', '', $key);
							}

							$this->ci->db->where('metadata.name', $key);
							$this->ci->db->{$method}('metadata.value', $val);
						}
						else
						{
							foreach ($val as $_val)
							{
								$method = 'like';
								if (strpos($key, '!') === 0)
								{
									$method = 'not_like';
									$key = str_replace('!', '', $key);
								}

								$this->ci->db->where('metadata.name', $key);
								$this->ci->db->{$method}('metadata.value', $val);
							}
						}

						$count++;
					}
				}

				break;	// End of case 'users', 'groups', 'objects'.
			
			// Generating default LIKE clause.
			default:

				// Let's now generate the query.
				$count = 1;
				foreach ($field as $key => $val)
				{
					if ( ! is_array($val))
					{
						$method = ($count == 1) ? 'like' : 'or_like';
						if (strpos($key, '!') === 0)
						{
							$method = ($count == 1) ? 'not_like' : 'or_not_like';
							$key = str_replace('!', '', $key);
						}

						$this->ci->db->{$method}($key, $val);
					}
					else
					{
						foreach ($val as $_val)
						{
							$method = 'like';
							if (strpos($key, '!') === 0)
							{
								$method = 'not_like';
								$key = str_replace('!', '', $key);
							}

							$this->ci->db->{$method}($key, $val);
						}
					}

					$count++;
				}

				break;	// End of "default".
		}

		// Did we provide a limit?
		if ($limit > 0)
		{
			$this->ci->db->limit($limit, $offset);
		}

		// Return this so the method can be chainable.
		return $this->ci->db;
	}

	// ------------------------------------------------------------------------
	// Update methods.
	// ------------------------------------------------------------------------


	/**
	 * update_check
	 *
	 * Method for checking for new releases of CodeIgniter SKeleton on Github.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function update_check()
	{
		$option_key = '_csk_update';
		$option = $this->options->get($option_key);

		// Just to avoid calling Github, we check only once every two days.
		if (false !== $option && $option->options > (time() - 172800))
		{
			$return = $option->value;
		}
		else
		{
			$git_url = 'https://api.github.com/repos/bkader/skeleton/releases/latest';

			if (function_exists('curl_init'))
			{
				$curl = curl_init(); 
				curl_setopt($curl, CURLOPT_URL, $git_url); 
				curl_setopt($curl, CURLOPT_USERAGENT, 'Awesome-Octocat-App');
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
				$content = curl_exec($curl); 
				curl_close($curl);   
			}
			else
			{
				$params = array(
					'http' => array(
						'method' => 'GET',
						'header' => 'User-Agent: Awesome-Octocat-App',
					)
				);

				$context = stream_context_create($params);
				$content = file_get_contents($git_url, false, $context);
			}

			$content = json_decode($content, true);

			$return = array(
				// The currently used version.
				'current'     => KB_VERSION,
				'current_num' => intval(str_replace('.', '', KB_VERSION)),

				// The latest release on Github.
				'latest'      => $content['tag_name'],
				'latest_num'  => intval(str_replace('.', '', $content['tag_name'])),
				'release'     => array(
					'id'          => $content['id'],
					'url'         => $content['html_url'],
					'tag'         => $content['tag_name'],
					'tarball_url' => $content['tarball_url'],
					'zipball_url' => $content['zipball_url'],
					'description' => $content['body'],

				),
			);

			if (false !== $option)
			{
				$option->update(array(
					'value' => $return,
					'options' => time(),
				));
			}
			else
			{
				$this->options->create(array(
					'name'       => $option_key,
					'value'      => $return,
					'tab'        => '',
					'field_type' => '',
					'required'   => false,
				));
			}
		}

		return $return;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Pass available site languages to theme views in order to use them
	 * for language switch.
	 * @access 	private
	 * @param 	void
	 * @return 	void
	 */
	private function _languages_list()
	{
		// Get the list of all languages details first.
		$languages = $this->ci->lang->languages($this->ci->config->item('languages'));

		// Make sure current language available to views.
		$this->ci->theme->set(
			'current_language',
			$languages[$this->ci->session->language],
			true
		);

		// Site languages stored in configuration.
		$config_languages = $this->ci->config->item('languages');

		// Add our available languages to views.
		$langs = array();

		if (count($config_languages) > 0)
		{
			foreach ($languages as $folder => $details)
			{
				if (in_array($folder, $config_languages) && $folder !== $this->ci->session->language)
				{
					$langs[$folder] = $details;
				}
			}
		}
		$this->ci->theme->set('site_languages', $langs, true);
	}

	// ------------------------------------------------------------------------

	/**
	 * Used to load required libraries and helpers.
	 * @access	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _load_dependencies()
	{
		static $loaded;

		if (true !== $loaded)
		{
			isset($this->ci->db) OR $this->ci->load->database();
			class_exists('CI_Session', false) OR $this->ci->load->library('session');
			class_exists('CI_User_agent', false) OR $this->ci->load->library('user_agent');
			function_exists('site_url') OR $this->ci->load->helper('url');
			function_exists('html_tag') OR $this->ci->load->helper('html');
			$loaded = true;
		}
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('get_siteinfo'))
{
	/**
	 * Retrieves information about the site.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$key 		Site info to retrieve. Default: site name.
	 * @param 	string 	$filter 	How to filter what's retrieved.
	 * @return 	string 	String value, might be empty.
	 */
	function get_siteinfo($key = '', $filter = 'raw')
	{
		static $cached;

		// Always use "name" if nothing is provided.
		empty($key) && $key = 'name';

		if ( ! isset($cached[$key]))
		{
			switch ($key)
			{
				case 'home':
				case 'siteurl':
				case 'site_url':
					$output = site_url();
					break;

				case 'url':
				case 'base':
				case 'baseurl':
				case 'base_url':
					$output = base_url();
					break;

				case 'stylesheet_url':
					$output = get_theme_url('style.css');
					break;

				case 'stylesheet_directory':
					$output = get_theme_url();
					break;

				case 'admin_email':
					$output = config_item('admin_email');
					break;

				case 'server_email':
					$output = config_item('server_email');
					break;

				case 'charset':
					$output = config_item('charset', 'UTF-8');
					break;

				case 'version':
					$output = KB_VERSION;
					break;

				case 'language':
					$output = langinfo('locale');
					break;

				case 'text_direction':
					$output = langinfo('direction');
					break;

				case 'description':
				case 'site_description':
					$output = config_item('site_description');
					break;
				
				case 'name':
				case 'site_name':
				default:
					$output = config_item('site_name');
					break;
			}

			$cached[$key] = $output;
		}

		$return = $cached[$key];

		$url = true;
		if (strpos($key, 'url') === false 
			&& strpos($key, 'directory') === false 
			&& strpos($key, 'home') === false)
		{
			$url = false;
		}

		if ('display' == $filter)
		{
			$return = (false !== $url)
				? apply_filters('siteinfo_url', $return, $key)
				: apply_filters('siteinfo', $return, $key);
		}

		return $return;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('siteinfo'))
{
	/**
	 * Displays information about the site.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$key 		Site info to retrieve. Default: site name.
	 * @param 	string 	$filter 	How to filter what's retrieved.
	 * @return 	void
	 */
	function siteinfo($key = '')
	{
		echo get_siteinfo($key, 'display');
	}
}
