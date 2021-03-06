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
 * Copyright (c) 2020, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @copyright	Copyright (c) 2003, 2005, 2006, 2009 Danilo Segan <danilo@kvota.net>.
 * @license 	https://opensource.org/licenses/MIT	MIT License
 * @link 		http://bit.ly/KaderGhb
 * @since 		2.1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stream_reader
 *
 * Simple class to wrap file streams, string streams, etc.
 * seek is essential, and it should be byte stream
 * 
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		http://bit.ly/KaderGhb
 * @copyright 	Copyright (c) 2020, Kader Bouyakoub (http://bit.ly/KaderGhb)
 * @since 		2.1.0
 * @version 	2.1.0
 */
class Stream_reader
{
	/**
	 * Should return a string.
	 * @param 	string
	 * @return 	mixed
	 */
	function read($bytes)
	{
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Should return a new position.
	 * @return 	int 	The new position.
	 */
	function seekto($position)
	{
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the current position.
	 * @param 	none
	 * @return 	int 	The current position.
	 */
	function currentpos()
	{
		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the length of the entire Stream (limit for seekto()).
	 * @param 	none
	 * @return 	int
	 */
	function length()
	{
		return false;
	}

}
