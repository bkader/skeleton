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
defined('DOING_AJAX') OR define('DOING_AJAX', true);

/**
 * Ajax_Controller Class
 *
 * Controllers extending this class accept only AJAX requests.
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
class Ajax_Controller extends KB_Controller
{
	/**
	 * Some needed header codes.
	 * @var integer
	 */
	const HTTP_OK = 200;
	const HTTP_CREATED = 201;
	const HTTP_NO_CONTENT = 204;
	const HTTP_NOT_MODIFIED = 304;
	const HTTP_BAD_REQUEST = 400;
	const HTTP_UNAUTHORIZED = 401;
	const HTTP_FORBIDDEN = 403;
	const HTTP_NOT_FOUND = 404;
	const HTTP_METHOD_NOT_ALLOWED = 405;
	const HTTP_NOT_ACCEPTABLE = 406;
	const HTTP_CONFLICT = 409;
	const HTTP_INTERNAL_SERVER_ERROR = 500;
	const HTTP_NOT_IMPLEMENTED = 501;

	/**
	 * HTTP status codes and their respective description.
	 * @var array
	 */
	protected $http_status_codes = array(
		self::HTTP_OK                    => 'OK',
		self::HTTP_CREATED               => 'CREATED',
		self::HTTP_NO_CONTENT            => 'NO CONTENT',
		self::HTTP_NOT_MODIFIED          => 'NOT MODIFIED',
		self::HTTP_BAD_REQUEST           => 'BAD REQUEST',
		self::HTTP_UNAUTHORIZED          => 'UNAUTHORIZED',
		self::HTTP_FORBIDDEN             => 'FORBIDDEN',
		self::HTTP_NOT_FOUND             => 'NOT FOUND',
		self::HTTP_METHOD_NOT_ALLOWED    => 'METHOD NOT ALLOWED',
		self::HTTP_NOT_ACCEPTABLE        => 'NOT ACCEPTABLE',
		self::HTTP_CONFLICT              => 'CONFLICT',
		self::HTTP_INTERNAL_SERVER_ERROR => 'INTERNAL SERVER ERROR',
		self::HTTP_NOT_IMPLEMENTED       => 'NOT IMPLEMENTED'
	);

	/**
	 * Default response.
	 * @var array
	 */
	protected $response = array(
		'header'  => 404,
		'status'  => false,
		'message' => null,
		'action'  => null,
	);

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We make sure that the controller accepts only AJAX requests.
		if ( ! $this->input->is_ajax_request())
		{
			show_404();
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Remapping all method so they always return the response.
	 * @access 	public
	 * @param 	string 	$method 	The called method.
	 * @param 	array 	$params 	 Arguments to pass to method.
	 * @return 	void
	 */
	public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			call_user_func_array(array($this, $method), $params);
		}

		return $this->output
			->set_content_type('json')
			->set_status_header($this->response['header'])
			->set_output(json_encode($this->response));
		die();
	}

}
