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
 * Bkader_users_m Class
 *
 * This model handles operations done on users table.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Models
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Bkader_users_m extends KB_Model
{
	/**
	 * Class constuctor
	 * @return 	void
	 */
	public function __construct()
	{
		// Model preferences.
		$this->_table      = 'users';
		$this->primary_key = 'guid';

		// Add observers.
		array_unshift($this->before_create, 'hash_password');
		array_unshift($this->before_update, 'hash_password');
		array_unshift($this->before_get,    'join_entity');

		// Call parent's constructor.
		parent::__construct();
	}

	// ------------------------------------------------------------------------
	// Observers.
	// ------------------------------------------------------------------------

	/**
	 * Make sure to hash the password if present.
	 * @access 	protected
	 * @param 	mixed 	$row 	array or object
	 * @return 	the $row afer modification.
	 */
	protected function hash_password($row)
	{
		// In case of an array.
		if (is_array($row) && (isset($row['password']) && ! empty($row['password'])))
		{
			$row['password'] = password_hash($row['password'], PASSWORD_BCRYPT);
		}
		// In case of an array.
		elseif (is_object($row) && (isset($row->password) && ! empty($row->password)))
		{
			$row->password = password_hash($row->password, PASSWORD_BCRYPT);
		}
		return $row;
	}

	// ------------------------------------------------------------------------

	/**
	 * Make sure to always join the entity before getting the user.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	protected function join_entity()
	{
		$this->_database->join('entities', 'entities.id = users.guid');
		$this->_database->where('entities.type', 'user');
	}

}
