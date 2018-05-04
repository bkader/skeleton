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
 * @since 		1.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Hooks Class
 *
 * This file extends CI_Hooks class in order to make hooks available
 * to be loaded from the Skeleton folder.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.5.2
 */
class KB_Hooks extends CI_Hooks
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		log_message('info', 'KB_Hooks Class Initialized');

		// If hooks are not enabled in the config file
		// there is nothing else to do
		if (config_item('enable_hooks') === FALSE)
		{
			return;
		}

		// Grab the "hooks" definition file from skeleton path.
		if (file_exists(KBPATH.'config/hooks.php'))
		{
			include(KBPATH.'config/hooks.php');
		}

		parent::__construct();
	}

	// ------------------------------------------------------------------------

	/**
	 * call_hook
	 *
	 * Calls a particular hook. Added for Skeleton in order to execute action
	 * using the Plugins class.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.5.2
	 *
	 * @access 	public
	 * @param 	string 	$which 	The hook's name.
	 * @return 	bool 	true on success, else false.
	 */
	public function call_hook($which = '')
	{
		// We do any action first.
		do_action($which);

		// Then we let the parent do the rest.
		return parent::call_hook($which);
	}

	// ------------------------------------------------------------------------

	/**
	 * Run Hook
	 *
	 * Runs a particular hook
	 *
	 * @param	array	$data	Hook details
	 * @return	bool	TRUE on success or FALSE on failure
	 */
	protected function _run_hook($data)
	{
		// Closures/lambda functions and array($object, 'method') callables
		if (is_callable($data))
		{
			is_array($data)
				? $data[0]->{$data[1]}()
				: $data();

			return TRUE;
		}
		elseif ( ! is_array($data))
		{
			return FALSE;
		}

		// -----------------------------------
		// Safety - Prevents run-away loops
		// -----------------------------------

		// If the script being called happens to have the same
		// hook call within it a loop can happen
		if ($this->_in_progress === TRUE)
		{
			return;
		}

		// -----------------------------------
		// Set file path
		// -----------------------------------

		if ( ! isset($data['filepath'], $data['filename']))
		{
			return FALSE;
		}

		$filepath = KBPATH.$data['filepath'].'/'.$data['filename'];

		if ( ! file_exists($filepath))
		{
			$filepath = APPPATH.$data['filepath'].'/'.$data['filename'];

			if ( ! file_exists($filepath))
			{
				return FALSE;
			}
		}

		// Determine and class and/or function names
		$class		= empty($data['class']) ? FALSE : $data['class'];
		$function	= empty($data['function']) ? FALSE : $data['function'];
		$params		= isset($data['params']) ? $data['params'] : '';

		if (empty($function))
		{
			return FALSE;
		}

		// Set the _in_progress flag
		$this->_in_progress = TRUE;

		// Call the requested class and/or function
		if ($class !== FALSE)
		{
			// The object is stored?
			if (isset($this->_objects[$class]))
			{
				if (method_exists($this->_objects[$class], $function))
				{
					$this->_objects[$class]->$function($params);
				}
				else
				{
					return $this->_in_progress = FALSE;
				}
			}
			else
			{
				class_exists($class, FALSE) OR require_once($filepath);

				if ( ! class_exists($class, FALSE) OR ! method_exists($class, $function))
				{
					return $this->_in_progress = FALSE;
				}

				// Store the object and execute the method
				$this->_objects[$class] = new $class();
				$this->_objects[$class]->$function($params);
			}
		}
		else
		{
			function_exists($function) OR require_once($filepath);

			if ( ! function_exists($function))
			{
				return $this->_in_progress = FALSE;
			}

			$function($params);
		}

		$this->_in_progress = FALSE;

		return parent::_run_hook($data);
	}

}
