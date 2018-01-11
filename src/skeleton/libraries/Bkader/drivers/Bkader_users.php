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
		// Make sure to load entities model.
		$this->ci->load->model('bkader_users_m');

		log_message('info', 'Bkader_users Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic __call method to use users model methods too.
	 * @access 	public
	 * @param 	string 	$method 	the method's name.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	mixed 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		if (method_exists($this->ci->bkader_users_m, $method))
		{
			return call_user_func_array(
				array($this->ci->bkader_users_m, $method),
				$params
			);
		}

		throw new BadMethodCallException("No such method ".get_called_class()."::{$method}().");
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
		(isset($entity['type']) && $entity['type'] == 'user') OR $entity['type'] = 'user';

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
			(class_exists('CI_Hash', false)) OR $this->ci->load->library('hash');
			$activation_code = $this->ci->hash->random(40);
		}

		// Let's insert the entity first and make sure it's created.
		$guid = $this->_parent->entities->insert($entity);
		if ( ! $guid)
		{
			return false;
		}

		// Add the id to user.
		$user['guid'] = $guid;

		// Insert the user.
		$this->ci->bkader_users_m->insert($user);

		// If there are any metadata, insert them.
		if ( ! empty($meta))
		{
			$this->_parent->metadata->create_for($guid, $meta);
		}

		// Is the user enabled?
		if ($activation_code !== null)
		{
			// Create the variable.
			$this->_parent->variables->insert(array(
				'guid'   => $guid,
				'name'   => 'activation_code',
				'value'  => $activation_code,
				'params' => 'requested from: '.$this->ci->input->ip_address(),
			));
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
	public function update($user_id, array $data = array())
	{
		// Empty $data? Nothing to do.
		if (empty($data))
		{
			return false;
		}

		// Split data.
		list($entity, $user, $meta) = $this->_split_data($data);

		// Update entity.
		if ( ! empty($entity) && ! $this->_parent->entities->update($user_id, $entity))
		{
			return false;
		}

		// Update user.
		if ( ! empty($user) && ! $this->ci->bkader_users_m->update($user_id, $user))
		{
			return false;
		}

		// Some metadata.
		if ( ! empty($meta) && ! $this->_parent->metadata->update_for($user_id, $meta))
		{
			return false;
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Count all users.
	 *
	 * @access 	public
	 * @return 	int
	 */
	public function count_all()
	{
		return $this->ci->bkader_users_m->count_all();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all users.
	 *
	 * @access 	public
	 * @param 	int 	$limit
	 * @param 	int 	$offset
	 * @return 	array of objects.
	 */
	public function get_all_users($limit = 0, $offset = 0)
	{
		return $this->ci->bkader_users_m->limit($limit, $offset)->get_all();
	}

	// ------------------------------------------------------------------------

	/**
	 * Split data upon creation or update into entities, users and metadata.
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
			// Anything else is metadata.
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

// --------------------------------------------------------------------

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
