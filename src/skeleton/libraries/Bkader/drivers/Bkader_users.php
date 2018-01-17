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
 * Bkader_users Class
 *
 * Handles all operations done on users accounts.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Bkader_users extends CI_Driver
{
	/**
	 * Holds users table fields.
	 * @var array
	 */
	private $fields;

	/**
	 * Initialize class preferences.
	 * @access 	public
	 * @return 	void
	 */
	public function initialize()
	{
		log_message('info', 'Bkader_users Class Initialized');
	}

    // ------------------------------------------------------------------------

    /**
     * Generates the SELECT portion of the query
     */
    public function select($select = '*', $escape = null)
    {
    	$this->ci->db->select($select, $escape);
    	return $this;
    }

	// ------------------------------------------------------------------------

	/**
	 * Return an array of users table fields.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function fields()
	{
		if (isset($this->fields))
		{
			return $this->fields;
		}

		$this->fields = $this->ci->db->list_fields('users');
		return $this->fields;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new user.
	 * @access 	public
	 * @param 	array 	$data
	 * @return 	int 	the user's ID if created, else false.
	 */
	public function create(array $data = array())
	{
		// Nothing provided? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Multiple users?
		if (isset($data[0]) && is_array($data[0]))
		{
			$ids = array();
			foreach ($data as $_data)
			{
				$ids[] = $this->create($_data);
			}
			return $ids;
		}

		// Split data.
		list($entity, $user, $meta) = $this->_split_data($data);

		// Make sure to alwayas add the entity's type.
		$entity['type'] = 'user';

		// Make sure user's type is always set.
		(isset($entity['subtype'])) OR $entity['subtype'] = 'regular';

		// Should the user be enabled?
		$activation_code = null;
		if ( ! isset($entity['enabled'])
			&& $this->_parent->options->item('email_activation', false) === true)
		{
			// Add the column.
			$entity['enabled'] = 0;

			// Generate the activation code for later use.
			(function_exists('random_string')) OR $this->ci->load->helper('string');
			$activation_code = random_string('alnum', 40);
		}

		// Let's insert the entity first and make sure it's created.
		$guid = $this->_parent->entities->create($entity);
		if ( ! $guid)
		{
			return false;
		}

		// Add the id to user.
		$user['guid'] = $guid;

		// Hash the password if present.
		if (isset($user['password']) && ! empty($user['password']))
		{
			$user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
		}

		// Make sure the the gender is valid.
		if (isset($user['gender']) 
			&& ! in_array($user['gender'], array('unspecified', 'male', 'female')))
		{
			$user['gender'] = 'unspecified';
		}

		// Insert the user.
		$this->ci->db->insert('users', $user);

		// Is the user enabled?
		if ($activation_code !== null)
		{
			// Create the variable.
			$this->_parent->variables->create(
				$guid,
				'activation_code',
				$activation_code,
				'requested from: '.$this->ci->input->ip_address()
			);
		}

		// Some metadata?
		if ( ! empty($meta))
		{
			$this->_parent->metadata->create($guid, $meta);
		}

		return $guid;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update a single user.
	 * @access 	public
	 * @param 	int 	$user_id
	 * @param 	array 	$data
	 * @return 	bool
	 */
	public function update($id, array $data = array())
	{
		// Empty $data? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $user, $meta) = $this->_split_data($data);

		// Update entity.
		if ( ! empty($entity) && ! $this->_parent->entities->update($id, $entity))
		{
			return false;
		}

		// Hash the password if present.
		if (isset($user['password']) && ! empty($user['password']))
		{
			$user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
		}

		// Make sure the the gender is valid.
		if (isset($user['gender']) 
			&& ! in_array($user['gender'], array('unspecified', 'male', 'female')))
		{
			$user['gender'] = 'unspecified';
		}

		$this->ci->db->update('users', $user, array('guid' => $id));

		// Some metadata?
		if ( ! empty($meta))
		{
			$this->_parent->metadata->update($id, $meta);
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a single user by ID, username or email address.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function delete($id)
	{
		// Delete by ID.
		if (is_numeric($id))
		{
			return $this->_parent->entities->delete($id);
		}

		// Delete by username.
		$user = (false !== filter_var($id, FILTER_VALIDATE_EMAIL))
			? $this->get_by('users.email', $id)
			: $this->get_by('entities.username', $id);

		return ($user) ? $this->ci->_parent->entities->delete($user->id) : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete multiple users by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function delete_by($field = null, $match = null)
	{
		// See if users exist.
		$users = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($users)
		{
			$ids = array();
			foreach ($users as $user)
			{
				$ids[] = $user->id;
			}

			return $this->_parent->entities->delete_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove a single user by ID, username or email address.
	 * @access 	public
	 * @param 	mixed 	$id
	 * @return 	boolean
	 */
	public function remove($id)
	{
		// Completely remove by ID.
		if (is_numeric($id))
		{
			return $this->_parent->entities->remove($id);
		}

		// Completely remove by username.
		$user = (false !== filter_var($id, FILTER_VALIDATE_EMAIL))
			? $this->get_by('users.email', $id)
			: $this->get_by('entities.username', $id);

		return ($user) ? $this->ci->_parent->entities->remove($user->id) : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Completely remove multiple users by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function remove_by($field = null, $match = null)
	{
		// See if users exist.
		$users = $this->get_many($field, $match);

		// If there are any, we collect their IDs to send only one request.
		if ($users)
		{
			$ids = array();
			foreach ($users as $user)
			{
				$ids[] = $user->id;
			}

			return $this->_parent->entities->remove_by('id', $ids);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore a previously soft-deleted user.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	boolean
	 */
	public function restore($id)
	{
		// Restore only entities of type "user".
		return $this->_parent->entities->restore_by(array(
			'id'   => $id,
			'type' => 'user',
		));
	}

	// ------------------------------------------------------------------------

	/**
	 * Restore multiple or all soft-deleted users.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	public function restore_by($field = null, $match = null)
	{
		// Collect users.
		$users = $this->get_many($field, $match);

		if ($users)
		{
			$ids = array();
			foreach ($users as $user)
			{
				if ($user->deleted > 0)
				{
					$ids[] = $user->id;
				}
			}

			// Restore users in IDS.
			return ( ! empty($ids))
				? $this->_parent->entities->restore_by('id', $ids)
				: false;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all users.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	public function count($field = null, $match = null)
	{
		$this->ci->db->where('entities.type', 'user');

		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->ci->db->where($field);
			}
			elseif (is_array($match))
			{
				$this->ci->db->where($field, $match);
			}
			else
			{
				$this->ci->db->where($field, $match);
			}
		}

		$rows = $this->ci->db
			->join('users', 'users.guid = entities.id')
			->get('entities');

		return $rows->num_rows();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single user by ID, username OR email address.
	 * @access 	public
	 * @param 	mixed 	$id 	The user's ID, username or email address.
	 * @return 	object if found, else null.
	 */
	public function get($id)
	{
		// Getting by ID?
		if (is_numeric($id))
		{
			return $this->get_by('entities.id', $id);
		}

		// Retrieving by email address?
		if (false !== filter_var($id, FILTER_VALIDATE_EMAIL))
		{
			return 'here';
			return $this->get_by('users.email', $id);
		}

		// Retrieve by username.
		if (is_string($id))
		{
			return $this->get_by('entities.username', $id);
		}

		// Fall-back to get_by method.
		return $this->get_by($id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve a single user by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	public function get_by($field, $match = null)
	{
		// Try to get the user and make sure only one row it found.
		$user = $this->get_many($field, $match);
		return ($user && count($user) === 1) ? $user[0] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve multiple users by arbitrary WHERE clause.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	public function get_many($field = null, $match = null, $limit = 0, $offset = 0)
	{
		// Prepare entities type.
		$this->ci->db->where('entities.type', 'user');

		// There some arguments?
		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->ci->db->where($field);
			}
			elseif (is_array($match))
			{
				$this->ci->db->where_in($field, $match);
			}
			else
			{
				$this->ci->db->where($field, $match);
			}
		}

		// Proceed to join and get.
		return $this->ci->db
			->join('users', 'users.guid = entities.id')
			->limit($limit, $offset)
			->get('entities')
			->result();
	}

	// ------------------------------------------------------------------------

	/**
	 * Retrieve all users with optional limit and offset.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	public function get_all($limit = 0, $offset = 0)
	{
		return $this->get_many(null, null, $limit, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Split data upon creation or update into entity and user.
	 * @access 	private
	 * @param 	array 	$data
	 * @return 	array.
	 */
	private function _split_data(array $data = array())
	{
		if (empty($data))
		{
			return $data;
		}

		$_data = array();

		foreach ($data as $key => $val)
		{
			// Entities table.
			if (in_array($key, $this->_parent->entities->fields()))
			{
				$_data[0][$key] = $val;
			}
			// Users table.
			elseif (in_array($key, $this->fields()))
			{
				$_data[1][$key] = $val;
			}
			else
			{
				$_data[2][$key] = $val;
			}
		}

		if (empty($_data))
		{
			return $data;
		}

		// Make sure all three elements are set.
		(isset($_data[0])) OR $_data[0] = array();
		(isset($_data[1])) OR $_data[1] = array();
		(isset($_data[2])) OR $_data[2] = array();

		// Sort things up.
		ksort($_data);

		return $_data;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('add_user'))
{
	/**
	 * Create a single user.
	 * @param 	array 	$data 	array of data to insert.
	 * @return 	int 	The user's id if created, else false.
	 */
	function add_user(array $data = array())
	{
		return get_instance()->app->users->create($data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('update_user'))
{
	/**
	 * Update a single user by ID.
	 * @param 	int 	$id 	The user's ID.
	 * @param 	array 	$data 	Array of data to set.
	 * @return 	boolean
	 */
	function update_user($id, array $data = array())
	{
		return get_instance()->app->users->update($id, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_user'))
{
	/**
	 * Delete a single user by ID, username or email address.
	 * @param 	mixed 	$id 	ID, username or email address.
	 * @return 	boolean
	 */
	function delete_user($id)
	{
		return get_instance()->app->users->delete($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_user_by'))
{
	/**
	 * Soft delete multiple users by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_user_by($field, $match = null)
	{
		return get_instance()->app->users->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_users'))
{
	/**
	 * Soft delete multiple or all users by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function delete_users($field = null, $match = null)
	{
		return get_instance()->app->users->delete_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_user'))
{
	/**
	 * Completely remove a user from database.
	 * @param 	int 	$id 	The user's ID, username or email address.
	 * @return 	boolean
	 */
	function remove_user($id)
	{
		return get_instance()->app->users->remove($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_user_by'))
{
	/**
	 * Completely remove multiple users from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_user_by($field, $match = null)
	{
		return get_instance()->app->users->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('remove_users'))
{
	/**
	 * Completely remove multiple or all users from database.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function remove_users($field = null, $match = null)
	{
		return get_instance()->app->users->remove_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_user'))
{
	/**
	 * Restore a previously soft-deleted user.
	 * @access 	public
	 * @param 	int 	$id 	The user's ID.
	 * @return 	boolean
	 */
	function restore_user($id)
	{
		return get_instance()->app->users->restore($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_user_by'))
{
	/**
	 * Restore multiple soft-deleted users.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_user_by($field, $match = null)
	{
		return get_instance()->app->users->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restore_users'))
{
	/**
	 * Restore multiple or all soft-deleted users.
	 * @access 	public
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	boolean
	 */
	function restore_users($field, $match = null)
	{
		return get_instance()->app->users->restore_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('count_users'))
{
	/**
	 * Count all users on database with arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	int
	 */
	function count_users($field = null, $match = null)
	{
		return get_instance()->app->users->count($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_user'))
{
	/**
	 * Retrieve a single user by ID, username, email or arbitrary
	 * WHERE clause if $id an array.
	 * @param 	mixed 	$id
	 * @return 	object if found, else null.
	 */
	function get_user($id)
	{
		return get_instance()->app->users->get($id);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_user_by'))
{
	/**
	 * Retrieve a single user by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @return 	object if found, else null.
	 */
	function get_user_by($field, $match = null)
	{
		return get_instance()->app->users->get_by($field, $match);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_users'))
{
	/**
	 * Retrieve multiple users by arbitrary WHERE clause.
	 * @param 	mixed 	$field
	 * @param 	mixed 	$match
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects if found, else null.
	 */
	function get_users($field = null, $match = null, $limit = 0, $offset = 0)
	{
		return get_instance()->app->users->get_many($field, $match, $limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_all_users'))
{
	/**
	 * Retrieve all users with optional limit and offset.
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	function get_all_users($limit = 0, $offset = 0)
	{
		return get_instance()->app->users->get_all($limit, $offset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('user_avatar')):
	/**
	 * Returns the avatar of the selected user.
	 * @param 	int 	$size 	size of the image to display.
	 * @param 	int 	$id 	the user's id.
	 * @param 	mixed 	$attrs 	html attributes (string or array)
	 */
	function user_avatar($size = 100, $id = null, $attrs = array())
	{
		$CI =& get_instance();

		// An email is passed?
		if (filter_var($id, FILTER_VALIDATE_EMAIL) !== false)
		{
			$hash = md5($id);
		}

		// An md5 hashed string?
		elseif (is_string($id) && strlen($id) === 32)
		{
			$hash = $id;
		}

		// An ID?
		else
		{
			// If the user is logged in and ID is the same
			if ($CI->auth->online() && $CI->auth->user()->id == $id)
			{
				$hash = $CI->auth->user()->avatar;
			}
			// If the user exists, generate the hash.
			elseif ($user = $CI->app->users->get_user('id', $id))
			{
				$hash = md5($user->email);
			}
			// Otherwise, nothing to return.
			else
			{
				return null;
			}
		}

		// The path where the avatar should be.
		$avatar = $hash.'.jpg';
		$avatar_path = get_upload_path("avatars/{$avatar}");

		if (false === $avatar_path)
		{
			$avatar_url = "https://www.gravatar.com/avatar/{$hash}?r=g&amp;d=mm";

			// Cache the image for security
			// file_put_contents(
			// 	FCPATH."content/uploads/avatars/{$avatar}",
			// 	file_get_contents("https://www.gravatar.com/avatar/{$hash}?r=g&amp;d=mm&amp;s=100")
			// );

			($size >= 1) && $avatar_url .= "&amp;s={$size}";
		}
		else
		{
			$avatar_url = get_upload_url("avatars/{$avatar}");
		}

		// Another security layer is to load theme library if the function
		// img() is not found.
		(function_exists('img')) OR $CI->load->helper('html');

		return img($avatar_url, $attrs);
	}
endif; // End of: user_avatar.
