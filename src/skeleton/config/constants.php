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
 * Adding some useful constants.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Configuration
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.5.2
 */

/*
|--------------------------------------------------------------------------
| Skeleton Version.
|--------------------------------------------------------------------------
*/
defined('KB_VERSION') OR define('KB_VERSION', '1.5.2');

/*
|--------------------------------------------------------------------------
| Time-related Constants
|--------------------------------------------------------------------------
*/
defined('MINUTE_IN_SECONDS') OR define('MINUTE_IN_SECONDS', 60);
defined('HOUR_IN_SECONDS')   OR define('HOUR_IN_SECONDS', 60 * MINUTE_IN_SECONDS);
defined('DAY_IN_SECONDS')    OR define('DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS);
defined('WEEK_IN_SECONDS')   OR define('WEEK_IN_SECONDS', 7 * DAY_IN_SECONDS);
defined('MONTH_IN_SECONDS')  OR define('MONTH_IN_SECONDS', 30 * DAY_IN_SECONDS);
defined('YEAR_IN_SECONDS')   OR define('YEAR_IN_SECONDS', 365 * DAY_IN_SECONDS);

/*
|--------------------------------------------------------------------------
| Sizes-related Constants
|--------------------------------------------------------------------------
*/
defined('KB_IN_BYTES') OR define('KB_IN_BYTES', 1024);
defined('MB_IN_BYTES') OR define('MB_IN_BYTES', 1024 * KB_IN_BYTES);
defined('GB_IN_BYTES') OR define('GB_IN_BYTES', 1024 * MB_IN_BYTES);
defined('TB_IN_BYTES') OR define('TB_IN_BYTES', 1024 * GB_IN_BYTES);

/*
 * ------------------------------------------------------
 *  Instantiate the plugins class
 * ------------------------------------------------------
 */
require_once(KBPATH.'third_party/Plugins/Plugins.php');
