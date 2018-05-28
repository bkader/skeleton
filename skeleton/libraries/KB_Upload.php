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
 * @since 		1.4.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Upload Class
 *
 * This class was added since version 1.4.0 in order to use our awesome hooks
 * system do allow the user alter settings.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.4.0
 * @version 	1.4.0
 */
class KB_Upload extends CI_Upload {

	/**
	 * Holds a cached version of default config to avoid repeating.
	 * @var array
	 */
	protected $_config;

	/**
	 * __construct
	 *
	 * Simply loads the default configuration if not set then pass it to parent.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	array
	 * @return 	void
	 */
	public function __construct($config = array())
	{
		$config = array_replace_recursive($this->_default_config(), $config);
		log_message('info', 'KB_Upload Class Initialized');
		parent::__construct($config);
	}

	// ------------------------------------------------------------------------

	/**
	 * validate_upload_path
	 *
	 * Verifies that the upload is valid and has proper permissions.
	 * If the folder does not exist, it will create it if possible.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	bool
	 */
	public function validate_upload_path()
	{
		$path = $this->_config['upload_path'];
		empty($this->upload_path) && $this->upload_path = $path;
		$this->upload_path = rtrim($this->upload_path, '/').'/';

		// Are we using YEAR/MONTH path? (Ignore avatars).
		if (false === strpos($this->upload_path, 'avatars') 
			&& true === get_option('upload_year_month', true))
		{
			$this->upload_path .= date('Y/m/');
		}

		// We make sure to create the folder if it does not exist.
		if (true !== is_dir($this->upload_path) 
			&& false === mkdir($this->upload_path, 0755, true))
		{
			$this->set_error('upload_no_filepath', 'error');
			return false;
		}

		// Another layer of formatting.
		$this->upload_path = str_replace('\\', '/', realpath($this->upload_path));

		if ( ! is_really_writable($this->upload_path))
		{
			$this->set_error('upload_not_writable', 'error');
			return FALSE;
		}

		$this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/',  $this->upload_path);
		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * _default_config
	 *
	 * Returns an array of default configuration in case no config is passed,
	 * with extra filters applied to them.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _default_config()
	{
		// If not cached, cache it first.
		if ( ! isset($this->_config))
		{
			$this->_config = array(
				// Options stored in database.
				'upload_path'      => get_option('upload_path', 'content/uploads'),
				'allowed_types'    => get_option('allowed_types', 'gif|png|jpeg'),
				'max_size'         => get_option('max_size', 2048),
				'max_width'        => get_option('max_width', 1024),
				'max_height'       => get_option('max_height', 1024),
				'min_width'        => get_option('min_width', 0),
				'min_height'       => get_option('min_height', 0),

				// Other options.
				'file_ext_tolower' => false,
				'encrypt_name'     => false,
				'remove_spaces'    => false,
			);

			// Apply filters on settings.
			foreach ($this->_config as $key => &$val)
			{
				$val = ('upload_path' === $key)
					? apply_filters('upload_dir', $val)
					: apply_filters('upload_'.$key, $val);
			}
		}

		return $this->_config;
	}

}
