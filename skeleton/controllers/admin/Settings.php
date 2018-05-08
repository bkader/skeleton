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
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
class Settings extends Admin_Controller {

	/**
	 * __construct
	 *
	 * Load needed files.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->language('csk_settings');
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Method for updating site global settings.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		$this->theme
			->set_title(line('CSK_ADMIN_GLOBAL_SETTINGS'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * sysinfo
	 *
	 * Method for displaying system information.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function sysinfo()
	{
		// System information.
		$this->data['info'] = array(
			'php_built_on'     => php_uname(),
			'php_version'      => phpversion(),
			'database_type'    => $this->db->platform(),
			'database_version' => $this->db->version(),
			'web_server'       => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : getenv('SERVER_SOFTWARE'),
			'skeleton_version' => KB_VERSION,
			'user_agent'       => $this->agent->agent_string(),
		);

		// PHP Settings.
		$this->data['php'] = array(
			'safe_mode'          => ini_get('safe_mode') == '1',
			'display_errors'     => ini_get('display_errors') == '1',
			'short_open_tag'     => ini_get('short_open_tag') == '1',
			'file_uploads'       => ini_get('file_uploads') == '1',
			'magic_quotes_gpc'   => ini_get('magic_quotes_gpc') == '1',
			'register_globals'   => ini_get('register_globals') == '1',
			'output_buffering'   => (int) ini_get('output_buffering') !== 0,
			'open_basedir'       => ini_get('open_basedir'),
			'session.save_path'  => ini_get('session.save_path'),
			'session.auto_start' => ini_get('session.auto_start'),
			'disable_functions'  => ini_get('disable_functions'),
			'xml'                => extension_loaded('xml'),
			'zlib'               => extension_loaded('zlib'),
			'zip'                => function_exists('zip_open') && function_exists('zip_read'),
			'mbstring'           => extension_loaded('mbstring'),
			'iconv'              => function_exists('iconv'),
			'max_input_vars'     => ini_get('max_input_vars'),
		);

		// PHP Info.
		$this->data['phpinfo'] = $this->_get_phpinfo();

		// Page icon and heading.
		$this->data['page_icon'] = 'info-circle';
		$this->data['page_title'] = line('CSK_SETTINGS_SYSTEM_INFORMATION');

		$this->theme
			->set_title(line('CSK_SETTINGS_SYSTEM_INFORMATION'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * _get_phpinfo
	 *
	 * Method for getting PHP information.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	protected function _get_phpinfo()
	{
		ob_start();
		date_default_timezone_set('UTC');
		phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_MODULES);
		$phpInfo = ob_get_contents();
		ob_end_clean();

		preg_match_all('#<body[^>]*>(.*)</body>#siU', $phpInfo, $output);

		$output = preg_replace('#<table[^>]*>#', '<table class="table table-sm table-hover table-striped">', $output[1][0]);
		$output = preg_replace('#(\w),(\w)#', '\1, \2', $output);
		$output = preg_replace('#<hr />#', '', $output);
		$output = str_replace('<div class="center">', '', $output);
		$output = preg_replace('#<tr class="h">(.*)<\/tr>#', '<thead><tr class="h">$1</tr></thead><tbody>', $output);
		$output = str_replace('</table>', '</tbody></table>', $output);
		$output = str_replace('</div>', '', $output);
		
		return $output;
	}

}
