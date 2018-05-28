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
 * @since 		2.0.1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_date_helper
 *
 * Extending CodeIgniter date helper.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.1
 * @version 	2.0.1
 */

if ( ! function_exists('human_time_diff'))
{
	/**
	 * Determines the differences between two timestamps and returns
	 * a human readable string.
	 *
	 * @param 	int 	$from 	Unix timestamp from which the different begins.
	 * @param 	int 	$to 	Unix timestamp to end the time difference. Default time().
	 * @return 	string 	Human readable time difference.
	 */
	function human_time_diff($from, $to = null)
	{
		empty($to) && $to = time();
		$diff = abs($to - $from);

		// return $diff;

		if ($diff < MINUTE_IN_SECONDS)
		{
			$num = $diff;
			$line = 'second';
		}
		elseif ($diff < HOUR_IN_SECONDS)
		{
			$num  = round($diff / MINUTE_IN_SECONDS);
			$line = 'minute';
		}
		elseif ($diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS)
		{
			$num  = round($diff / HOUR_IN_SECONDS);
			$line = 'hour';
		}
		elseif ($diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS)
		{
			$num  = round($diff / DAY_IN_SECONDS);
			$line = 'day';
		}
		elseif ($diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS)
		{
			$num  = round($diff / WEEK_IN_SECONDS);
			$line = 'week';
		}
		elseif ($diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS)
		{
			$num  = round($diff / MONTH_IN_SECONDS);
			$line = 'month';
		}
		elseif ($diff >= YEAR_IN_SECONDS)
		{
			$num  = round($diff / YEAR_IN_SECONDS);
			$line = 'year';
		}

		$num = ($num <= 1) ? 1 : $num;
		($num >= 2) && $line .= 's';

		$since = $num.' '.$line;

		return apply_filters('human_time_diff', $since, $line, $num, $from, $to);
	}
}
