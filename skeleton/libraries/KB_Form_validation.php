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
 * KB_Form_validation Class
 *
 * Extends CodeIgniter validation class to add/edit some methods.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.3.3
 */
class KB_Form_validation extends CI_Form_validation
{
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct($config = array())
	{
		$this->ci =& get_instance();

		/**
		 * Here we merge super-global $_FILES to $_POST to allow for
		 * better file validation or Form_validation library.
		 * @see 	https://goo.gl/NpsmMJ (Bonfire)
		 */
		( ! empty($_FILES) && is_array($_FILES)) && $_POST = array_merge($_POST, $_FILES);

		log_message('info', 'KB_Form_validation Class Initialized');

		// Call parent's constructor.
		parent::__construct($config);
	}

	// ------------------------------------------------------------------------

	/**
	 * Run the form validation.
	 * @access 	public
	 * @param 	string 	$module
	 * @param 	string 	$group
	 * @return 	boolean
	 */
	public function run($module = '', $group = '')
	{
		(is_object($module)) && $this->ci =& $module;
		return parent::run($group);
	}

	// ------------------------------------------------------------------------

	/**
	 * Return form validation errors in custom HTML list.
	 * Default: unordered list.
	 * @access 	public
	 * @return 	string 	if found, else empty string.
	 */
	public function validation_errors_list()
	{
		$errors = parent::error_string('<li>', '</li>');
		return (empty($errors)) ? '' : '<ul>'.PHP_EOL.$errors.'</ul>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Allow alpha-numeric characters with periods, underscores, 
	 * spaces and dashes.
	 * @access 	public
	 * @param 	string 	$str 	The string to check.
	 * @return 	boolean
	 */
	public function alpha_extra($str)
	{
		return (preg_match("/^([\.\s-a-z0-9_-])+$/i", $str));
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure the entered username is unique.
	 *
	 * @access 	public
	 * @param 	string 	$str 	the usernme to check.
	 * @return 	boolean
	 */
	public function unique_username($str)
	{
		return ( ! is_forbidden_username($str) && parent::is_unique($str, 'entities.username'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure the selected email address is unique.
	 * @access 	public
	 * @param 	string 	$str 	the email address to check.
	 * @return 	boolean
	 */
	public function unique_email($str)
	{
		return (parent::is_unique($str, 'users.email')
			&& parent::is_unique($str, 'metadata.value')
			&& parent::is_unique($str, 'variables.params'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure the user exists using ID, username or email address.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Update the check method.
	 * 
	 * @access 	public
	 * @param 	string 	$str
	 * @return 	boolean
	 */
	public function user_exists($str)
	{
		return (false !== $this->ci->kbcore->users->get($str));
	}

	// ------------------------------------------------------------------------

	/**
	 * user_admin
	 *
	 * Method for making sure the user trying to login is an admin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	mixed 	User username or email address.
	 * @return 	bool
	 */
	public function user_admin($str)
	{
		if (false !== ($user = $this->ci->kbcore->users->get($str)))
		{
			return ('administrator' === $user->subtype);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Check user's credentials on login page.
	 * @access 	public
	 * @param 	string 	$password
	 * @param 	string 	$login 	The login field (username or email)
	 * @return 	boolean
	 */
	public function check_credentials($password, $login)
	{
		$user = $this->ci->kbcore->users->get($this->ci->input->post($login, true));
		return ($user && password_verify($password, $user->password));
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks user's current password.
	 * @access 	public
	 * @param 	string 	$str 	The current password.
	 * @return 	boolean
	 */
	public function current_password($str)
	{
		/**
		 * 1. The user is logged in.
		 * 2. The password is correct.
		 */
		return ($this->ci->auth->online() 
			&& (password_verify($str, $this->ci->auth->user()->password)));
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original min_length to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function min_length($str, $val)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::min_length($str, $val);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original max_length to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function max_length($str, $val)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::max_length($str, $val);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original exact_length to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function exact_length($str, $val)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::exact_length($str, $val);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original greater_than to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function greater_than($str, $min)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::greater_than($str, $min);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original greater_than_equal_to to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function greater_than_equal_to($str, $min)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::greater_than_equal_to($str, $min);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original less_than to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function less_than($str, $max)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::less_than($str, $max);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit original less_than_equal_to to use items from config
	 * @access 	public
	 * @param 	string 	$str 	The string to check
	 * @param 	mixed 	$val 	Integer or string from config.
	 * @return 	boolean
	 */
	public function less_than_equal_to($str, $max)
	{
		$val = (is_numeric($val)) ? $val : $this->ci->config->item($val);
		return parent::less_than_equal_to($str, $max);
	}

	// ------------------------------------------------------------------------

	/**
	 * Makes sure the input is not in the given array.
	 * @since 	2.1.2
	 * @access 	public
	 * @param 	string 	$value 	The value to check.
	 * @param 	string 	$list 	The list used to check.
	 * @return 	bool 	true if not found in the list, else false.
	 */
	public function not_in_list($value, $list)
	{
		return (true !== in_array($value, explode(',', $list), TRUE));
	}

	// ------------------------------------------------------------------------


	/**
	 * Build an error message using the field and param with the possibility
	 * to have $param stored in config.
	 * @param	string	The error message line
	 * @param	string	A field's human name
	 * @param	mixed	A rule's optional parameter
	 * @return	string
	 */
	protected function _build_error_msg($line, $field = '', $param = '')
	{
		// Look for $param in config.
		(is_string($param) && $nparam = config_item($param)) && $param = $nparam;

		// Let the parent do the rest.
		return parent::_build_error_msg($line, $field, $param);
	}

}
