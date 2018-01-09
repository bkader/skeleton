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

/**
 * Native_session Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Libraries
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Native_session
{
	/**
	 * Useful in case of running multiple applications
	 * on the same site.
	 * @var string
	 */
    protected $sess_namespace = '';

    /**
     * Instance of CI object.
     * @var object
     */
    protected $ci;

    /**
     * Caches what's stored in $_SESSION.
     * @var array
     */
    protected $store = array();

    /**
     * Session flash database key.
     * @var string
     */
    protected $flashdata_key = 'flash';

    /**
     * Array of class config.
     * @var array
     */
    private $_config = array();

    /**
     * Class constructor
     * @return 	void
     */
    public function __construct($config = array())
    {
    	// Prepare instance of CI object.
        $this->CI = get_instance();

        // Session life. Default: 2 years if set to 0.
        $this->_expiration = 60 * 60 * 24 * 365 * 2;

        // Initialize class.
        $this->_initialize();

        // Delete old session flashdata.
        $this->_flashdata_sweep();

        // Mark current flashdata as old to be deleted later.
        $this->_flashdata_mark();
    }

    /**
     * Initialize the configuration options
     *
     * @access  private
     * @return void
     */
     private function _initialize()
     {
     	// Defaults settings.
     	$prefs = array(
            'sess_cookie_name',
            'sess_expire_on_close',
            'sess_expiration',
            'sess_match_ip',
            'sess_match_useragent',
            'sess_time_to_update',
            'cookie_prefix',
            'cookie_path',
            'cookie_domain',
            'cookie_secure',
            'cookie_httponly'
        );

        // Fill out $_config property with config.
        foreach ($prefs as $pref)
        {
        	$this->_config[$pref] = $this->CI->config($pref);
        }

        /**
         * This particular loop sets class preferences BUT it allows
         * you to add extra setters (method) to this class by simply
         * prepending the 'set_' to the method name.
         */
        foreach ($this->_config as $key => $val)
        {
        	// Calling a method?
            if (method_exists($this, 'set_'.$key))
            {
                $this->{'set_'.$key}($val);
            }
            // Setting a property.
            elseif (isset($this->$key))
            {
                $this->$key = $val;
            }
        }

        // Let's ow set default expiration, path, domain and security.
		$expire    = 7200;
		$path      = '/';
		$domain    = '';
		$secure    = (bool) $this->_config['cookie_secure'];
		$http_only = (bool) $this->_config['cookie_httponly'];

		// Make sure the sess_expiration is nicely set.
        if ($this->_config['sess_expiration'] !== FALSE)
        {
            // The default is to 2 years if sess_expiration is set to 0.
            $expire = ($this->_config['sess_expiration'] == 0)
            	? $this->_expiration
            	: $this->_config['sess_expiration'];
        }

        // Path to be overridden?
        ($this->_config['cookie_path']) && $path = $this->_config['cookie_path'];

        // Cookie domain specified? Use it.
        ($this->_config['cookie_domain']) && $domain = $this->_config['cookie_domain'];

        // Now we set cookie parameters.
        session_set_cookie_params(
        	($this->_config['sess_expire_on_close']) ? 0 : $expire,
        	$path,
        	$domain,
        	$secure,
        	$http_only
        );

        // Let's start the session if it did not already start.
        (isset($_SESSION)) OR session_start();

        // Add the sess_namespace if set.
        (isset($_SESSION[$this->sess_namespace])) && $this->store = $_SESSION[$this->sess_namespace];

        // Prepare initial session destruction status and current time.
		$destroyed = FALSE;
		$now       = time();

		// Hold activity time, ip address and user agent.
		$timestamp  = $this->userdata('timestamp');
		$ip_address = $this->userdata('ip_address');
		$user_agent = $this->userdata('user_agent');

		// Check if the session was destroyed or not.
        if ( ! empty($timestamp) && (($timestamp + $expire) < $now or $timestamp > $now))
        {
            // Sorry! Expired.
            $destroyed = TRUE;
            log_message('debug', 'Session: Expired');
        }
        // Match IP Address?
        elseif ($this->_config['sess_match_ip'] === TRUE
        	&& ! empty($ip_address)
            && $ip_address !== $this->CI->input->ip_address())
        {
            // Sorry! IP Changed.
            $destroyed = TRUE;
            log_message('debug', 'Session: IP address mismatch');
        }
        // Match user agent?
        elseif ($this->_config['sess_match_useragent'] === TRUE
        	&& ! empty($user_agent)
            && $user_agent !== trim(substr($this->CI->input->user_agent(), 0, 50)))
        {
            // Sorry, different user agent.
            $destroyed = TRUE;
            log_message('debug', 'Session: User Agent string mismatch');
        }

        // Update last activity time
        $this->set_userdata('timestamp', $now);

        // Create the session only if it was destroyed.
        ($destroyed === TRUE) && $this->sess_create();
    }

    // ------------------------------------------------------------------------

    /**
     * Create Session
     * @access  public
     * @return 	void
     */
    public function sess_create()
    {
    	// Send a new session id to client
        session_regenerate_id();

        // Store initial session data.
        $sess_data = array(
			'session_id' => md5(microtime()),
			'timestamp'  => time()
        );

        // Store the IP address only if set to match.
        if ($this->_config['sess_match_ip'] === TRUE)
        {
            $sess_data['ip_address'] = $this->CI->input->ip_address();
        }

        // Store the user agent if required.
        if ($this->_config['sess_match_useragent'] === TRUE)
        {
            $sess_data['user_agent'] = trim(substr($this->CI->input->user_agent(), 0, 50));
        }

        // Now we cache session data.
        $this->store = $_SESSION[$this->sess_namespace] = $sess_data;
    }

    // ------------------------------------------------------------------------

    /**
     * Destroy session
     * @access  public
     */
    public function sess_destroy()
    {
        // Get the session name.
        $name = session_name();

        // Proceed only if the cookie exists.
        if (isset($_COOKIE[$name]))
        {
            // Get session parameters to delete the cookie
            $params = session_get_cookie_params();

            // Let's now expire the cookie.
            setcookie(
            	$name,
            	NULL,
            	time() - 42000,
            	$params['path'],
            	$params['domain'],
            	$params['secure'],
            	$params['httponly']
			);

			// Now we unset the cookie
            unset($_COOKIE[$name]);
        }

        // Let's generate a new session id.
        $this->sess_create();
    }

    // ------------------------------------------------------------------------

    /**
     * Get specific user data element
     * @access  public
     * @param   string  element key
     * @return 	object element value
     */
    public function userdata($key = NULL)
    {
    	// $key provided and value found?
    	if ($key !== NULL && isset($this->store[$key]))
    	{
    		return $this->store[$key];
    	}

    	return FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Set value for specific user data element
     * @access  public
     * @param 	mmixed 	$data 	Session data key or an associative array.
     * @param   mixed 	$value 	Value to store.
     * @return 	void
     */
    public function set_userdata($data, $value = NULL)
    {
    	(is_array($data)) OR $data = array($data => $value);

    	// Cache them first.
    	foreach ($data as $key => $val)
    	{
    		$this->store[$key] = $val;
    	}

    	// Let's now update the session.
        $_SESSION[$this->sess_namespace] = $this->store;
    }

    // ------------------------------------------------------------------------

    /**
     * Unset user data.
     * @access  public
     * @param 	mixed 	Session data key(s).
     * @return 	void
     */
    public function unset_userdata()
    {
    	// Collect method arguments.
    	$args = func_get_args();

    	// Not argument provided? Nothing to do.
    	if (empty($args))
    	{
    		return;
    	}

    	// Get rid of nasty deep array first.
    	(is_array($args[0])) && $args = $args[0];

    	// Let's remove them all from cached session first.
    	foreach ($args as $key)
    	{
    		unset($this->store[$key]);
    	}

    	// Let's update the session now.
    	$_SESSION[$this->sess_namespace] = $this->store;
    }

    // ------------------------------------------------------------------------

    /**
     * Fetch all session data.
     * @access  public
     * @return 	array
     */
    public function all_userdata()
    {
        return $this->store;
    }

    // ------------------------------------------------------------------------
    // Flashdata Methods.
    // ------------------------------------------------------------------------

    /**
     * Set flashdata
     * @access  public
     * @param   mixed 	$data 	Session data key or associative array.
     * @param 	mixed 	$value 	Value to store.
     * @return 	void
     */
    public function set_flashdata($data, $value = NULL)
    {
    	// Let's make everything as an array first.
    	(is_array($data)) OR $data = array($data => $value);

    	foreach ($data as $key => $val)
    	{
    		$this->set_userdata($this->flashdata_key.':new:'.$key, $val);
    	}
    }

    // ------------------------------------------------------------------------

    /**
     * Keep flashdata
     * @access 	public
     * @param 	mixed
     * @return 	void
     */
    public function keep_flashdata()
    {
    	// Collect method arguments.
    	$args = func_get_args();

    	// No args? Nothing to do..
    	if (empty($args))
    	{
    		return;
    	}

    	/**
    	 * Because flashdata are session data marked as 'old' in order
    	 * to be deleted on the next request, here all we do is to
    	 * mark the selected keys as 'new' to preserve them from being
    	 * deleted by our _flashdata_sweep() sister method.
    	 */

    	foreach ($args as $key)
    	{
    		// Let's first get the flashdata value.
    		$value = $this->userdata($this->flashdata_key.':old:'.$key);

    		// Now we simply update the session.
    		$this->set_userdata($this->flashdata_key.':new:'.$key, $value);
    	}
    }

    // ------------------------------------------------------------------------

    /**
     * Flashdata (fetch)
     * @access 	public
     * @param 	string 	$key 	Flashdata key or null to get all.
     * @return 	mixed
     */
    public function flashdata($key = null)
    {
    	if ($key !== null)
    	{
    		return $this->userdata($this->flashdata_key.':old:'.$key);
    	}

    	// Prepare an empty array;
    	$flashdata = array();

    	foreach ($this->all_userdata() as $key => $val)
    	{
    		// Explore $key by the ":old" glue.
    		$parts = explode(':old:', $key);

    		// A valid flashdata has 2 parts.
    		if (is_array($parts) && count($parts) === 2)
    		{
    			$flashdata[$key] = $val;
    		}
    	}

    	// Return the final result.
    	return $flashdata;
    }

    // ------------------------------------------------------------------------

    /**
     * Mark all flashdata as old so they can be removed
     * by _flashdata_sweep() method.
     * @access  private
     * @return 	void
     */
    private function _flashdata_mark()
    {
        foreach ($this->all_userdata() as $key => $val)
        {
        	// Explode the $key by ':new:' glue.
            $parts = explode(':new:', $name);

            // A valid flashdata contains only 2 parts.
            if (is_array($parts) && count($parts) === 2)
            {
                // Mark it as old first.
                $this->set_userdata($this->flashdata_key.':old:'.$parts[1], $val);

                // Remove the original data.
                $this->unset_userdata($key);
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Removes all flashdata marked as 'old'
     * @access 	private
     * @return 	void
     */
    private function _flashdata_sweep()
    {
    	foreach ($this->all_userdata() as $key => $val)
    	{
    		if (strpos($key, ':old:'))
    		{
    			$this->unset_userdata($key);
    		}
    	}
    }

    // ------------------------------------------------------------------------
    // Class Magic Methods.
    // ------------------------------------------------------------------------

	/**
	 * __get()
	 * @param	string	$key 	'session_id' or a session data key
	 * @return	mixed
	 */
    public function __get($key)
    {
    	// Looking for a stored data?
    	if (isset($this->store[$key]))
    	{
    		return $this->store[$key];
    	}
    	// Looking for session_id?
    	elseif ($key === 'session_id')
    	{
    		return session_id();
    	}

    	return NULL;
    }

    // ------------------------------------------------------------------------

	/**
	 * __isset()
	 * @param	string	$key	'session_id' or a session data key
	 * @return	bool
	 */
	public function __isset($key)
	{
		if ($key === 'session_id')
		{
			return (session_status() === PHP_SESSION_ACTIVE);
		}

		return (isset($this->store[$key]));
	}

	// ------------------------------------------------------------------------

	/**
	 * __set()
	 *
	 * @param	string	$key	Session data key
	 * @param	mixed	$value	Session data value
	 * @return	void
	 */
	public function __set($key, $value)
	{
		// Update the cached data first.
		$this->store[$key] = $value;
		$_SESSION[$this->sess_namespace] = $this->store;
	}

}
