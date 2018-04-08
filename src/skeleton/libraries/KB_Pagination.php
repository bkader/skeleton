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
 * KB_Pagination Class
 *
 * We are extending CodeIgniter pagination library so we
 * can use our hooks system and filters some of configuration
 * parameters before passing them back to the parent.
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
class KB_Pagination extends CI_Pagination
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct($params = array())
	{
		// We first the filter only if there is one.
		if (has_filter('pagination'))
		{
			// List of elements that accept the 'pagination' filter.
			$filterable_params = array(
				'full_tag_open',
				'full_tag_close',
				'num_links',
				'prev_tag_open',
				'prev_tag_close',
				'next_tag_open',
				'next_tag_close',
				'cur_tag_open',
				'cur_tag_close',
				'num_tag_open',
				'num_tag_close',
				'first_tag_open',
				'first_tag_close',
				'last_tag_open',
				'last_tag_close',
			);

			// Create the array of filtered params.
			$filtered_params = array_intersect_key($params, array_flip($filterable_params));

			// Fire pagination filter.
			$filtered_params = apply_filters('pagination', $filtered_params);

			// For security, we remove any added parm.
			foreach ($filtered_params as $key => $param)
			{
				if ( ! in_array($key, $filterable_params))
				{
					unset($filtered_params[$key]);
				}
			}

			// Merge all params.
			$params = array_merge($params, $filtered_params);
		}

		log_message('info', 'KB_Pagination Class Initialized');

		// Now we let the parent do the rest.
		parent::__construct($params);
	}

}
