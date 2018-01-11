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
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		log_message('info', 'KB_Form_validation Class Initialized');
	}

	// ------------------------------------------------------------------------

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
