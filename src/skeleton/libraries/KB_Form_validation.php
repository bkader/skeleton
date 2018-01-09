<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extending CodeIgniter Form validation library
 *
 * @package 	CodeIgniter
 * @subpackage 	Libraries
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class KB_Form_validation extends CI_Form_validation
{

	// public function run($group = '')
	// {
	// 	$this->CI->lang->load('form_validation', null, false, true, KBCORE);
	// 	return parent::run($group);
	// }

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
		return parent::is_unique($str, 'entities.username');
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure the selected email address is unique.
	 *
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

	public function user_exists($str)
	{}

	// ------------------------------------------------------------------------

	public function check_credentials($password, $login)
	{}

	// ------------------------------------------------------------------------

	public function current_password($str)
	{}

	// ------------------------------------------------------------------------

	public function min_length($str, $val)
	{
		return parent::min_length($str, $val);
	}

	public function max_length($str, $val)
	{
		return parent::max_length($str, $val);
	}

	// ------------------------------------------------------------------------

	public function exact_length($str, $val)
	{
		return parent::exact_length($str, $val);
	}

	// ------------------------------------------------------------------------

	public function greater_than($str, $min)
	{
		return parent::greater_than($str, $min);
	}

	// ------------------------------------------------------------------------

	public function greater_than_equal_to($str, $min)
	{
		return parent::greater_than_equal_to($str, $min);
	}

	// ------------------------------------------------------------------------

	public function less_than($str, $max)
	{
		return parent::less_than($str, $max);
	}

	// ------------------------------------------------------------------------

	public function less_than_equal_to($str, $max)
	{
		return parent::less_than_equal_to($str, $max);
	}

}
