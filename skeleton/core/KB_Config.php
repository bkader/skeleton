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
 * KB_Config Class
 *
 * This file extending CI_Config class in order to add, alter
 * or enhance some of the parent's methods.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.1
 */
class KB_Config extends CI_Config
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		// Our our custom config path.
		$this->_config_paths[] = KBPATH;

		// Now we call parent's constructor.
		parent::__construct();
	}

	// ------------------------------------------------------------------------

	/**
	 * Add the possibility to set an item with an index.
	 * @access 	public
	 * @param 	string 	$item 	The key of the item.
	 * @param 	mixed 	$value 	The value of the item.
	 * @param 	mixed 	$index 	The index of the item.
	 */
	public function set_item($item, $value = null, $index = '')
	{
		if ($index == '')
		{
			$this->config[$item] = $value;
		}
		else
		{
			$this->config[$index][$item] = $value;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Builds a URI string.
	 *
	 * This method is called before parent's in order to use our named routes
	 * system.
	 *
	 * @access 	protected
	 * @param 	mixed 	$uri 	URI string or an array of segments.
	 * @return 	string
	 */
	protected function _uri_string($uri)
	{
		if (class_exists('Route', false))
		{
			$uri = is_array($uri)
				? array_map(array('Route', 'named'), $uri)
				: Route::named($uri);
		}

		return parent::_uri_string($uri);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the name or details about the language currently in use.
	 * @access 	public
	 * @param 	mixed 	what to retrieve.
	 * @return 	mixed
	 */
	public function lang()
	{
		return call_user_func_array(
			array(get_instance()->lang, 'lang'),
			func_get_args()
		);
	}

}
