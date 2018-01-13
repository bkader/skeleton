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
 * Because this file is the first one to be loaded, we make sure
 * to load our needed resources here.
 */
require_once(KBPATH.'core/compat/print_d.php');
require_once(KBPATH.'core/compat/str_to_bool.php');
require_once(KBPATH.'core/compat/is_serialized.php');
require_once(KBPATH.'core/compat/is_json.php');
require_once(KBPATH.'core/compat/bool_or_serialize.php');

/**
 * KB_Config Class
 *
 * This file extending CI_Config class in order to add, alter
 * or enhance some of the parent's methods.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
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
	 * Returns the name or details about the language currently in use.
	 * @access 	public
	 * @param 	mixed 	what to retrieve.
	 * @return 	mixed
	 */
	public function lang()
	{
		return call_user_func_array(array(get_instance()->lang, 'lang'), func_get_args());
	}

}
