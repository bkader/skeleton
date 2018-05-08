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
 * Main AJAX controller.
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
class Ajax extends AJAX_Controller {

	/**
	 * Array of available contexts.
	 * @var array
	 */
	private $_targets = array(
		'languages',
		'modules',
		'plugins',
		'reports',
		'themes',
		'users',
	);

	/**
	 * __constructr
	 *
	 * Added safe methods.
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

		// Add safe reports.
		$this->safe_admin_methods[] = '_modules';
		$this->safe_admin_methods[] = '_reports';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * This method handles all operation done on the reserved sections of the
	 * dashboard.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$target 	The target to perform action on.
	 * @param 	string 	$action 	The action to perform on the target.
	 * @param 	mixed 	$id 		The target name/id.
	 * @return 	AJAX_Controller:response()
	 */
	public function index($target, $action = null, $id = 0)
	{
		// We proceed only if both target and method are available.
		if ((empty($target) OR ! in_array($target, $this->_targets)) 
			OR ! method_exists($this, '_'.$target))
		{
			return;
		}

		return call_user_func_array(array($this, '_'.$target), array($action, $id));
	}

	// ------------------------------------------------------------------------

	/**
	 * _reports
	 *
	 * Method for interacting with reports.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	int  	$id 		The report ID.
	 * @return 	void
	 */
	public function _reports($action = null, $id = 0)
	{
		// We make sure to load Reports language file.
		$this->load->language('csk_reports');

		// Array of available reports action.
		$actions = array('delete');

		/**
		 * In order to proceed, the following conditions are required:
		 * 1. The action is provided and is available.
		 * 2. The is is provided and is numeric.
		 * 3. The action passes nonce check.
		 */
		if ((null === $action OR ! in_array($action, $actions)) 
			OR ( ! is_numeric($id) OR $id < 0)
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		switch ($action) {
			
			// Delete report.
			case 'delete':
				
				// Successfully deleted?
				if (false !== $this->kbcore->activities->delete($id))
				{
					$this->response->header  = self::HTTP_OK;
					$this->response->message = line('CSK_REPORTS_SUCCESS_DELETE');
					return;
				}

				// Otherwise, the activity could not be deleted.
				$this->response->message = line('CSK_REPORTS_ERROR_DELETE');
				return;

				break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * _modules
	 *
	 * Method for interacting with modules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The module's folder name;
	 * @return 	void
	 */
	public function _modules($action = null, $name = null)
	{
		// Load modules language file.
		$this->load->language('csk_modules');

		// Array of available actions.
		$actions = array('activate', 'deactivate', 'delete');

		if ((null === $action OR ! in_array($action, $actions))
			OR (null === $name OR ! is_string($name))
			OR true !== $this->check_nonce())
		{
			$this->response->header  = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = line('CSK_ERROR_NONCE_URL');
			return;
		}

		// Grab details for later use and to make sure the module exists.
		$details = $this->router->module_details($name);
		if (false === $details)
		{
			$this->response->header  = self::HTTP_NOT_FOUND;
			$this->response->message = line('CSK_MODULES_ERROR_MODULE_MISSING');
			return;
		}

		// Load file helper for other actions.
		if ('delete' !== $action)
		{
			function_exists('write_file') OR $this->load->helper('file');
		}
		// Load directory helper for delete action.
		elseif ( ! function_exists('directory_delete'))
		{
			$this->load->helper('directory');
		}


		switch ($action) {
			
			// In case of activating a module.
			case 'activate':
				// Already enabled? Nothing to do...
				if (true === $details['enabled'])
				{
					$this->response->header = self::HTTP_CONFLICT;
					$this->response->message = line('CSK_MODULES_ERROR_ACTIVATE');
					return;
				}

				// Successfully enabled?
				$details['enabled'] = true;
				$manifest = $details['full_path'].'manifest.json';
				if (true === write_file($manifest, json_encode($details)))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(
						line('CSK_MODULES_SUCCESS_ACTIVATE'),
						$details['name']
					);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_MODULES_ERROR_ACTIVATE');
				break;
			
			// In case of deactivating a module.
			case 'deactivate':
				// Already enabled? Nothing to do...
				if (true !== $details['enabled'])
				{
					$this->response->header = self::HTTP_CONFLICT;
					$this->response->message = line('CSK_MODULES_ERROR_DEACTIVATE');
					return;
				}

				// Successfully enabled?
				$details['enabled'] = false;
				$manifest = $details['full_path'].'manifest.json';
				if (true === write_file($manifest, json_encode($details)))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(
						line('CSK_MODULES_SUCCESS_DEACTIVATE'),
						$details['name']
					);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_MODULES_ERROR_DEACTIVATE');
				break;

			// In case of deleting a module.
			case 'delete':
				$modules = $this->router->list_modules(false);
				// Passed?
				if (isset($modules[$name]) && true === directory_delete($modules[$name]))
				{
					$this->response->header = self::HTTP_OK;
					$this->response->message = sprintf(
						line('CSK_MODULES_SUCCESS_DELETE'),
						$details['name']
					);
					return;
				}

				// An error occurred somewhere!
				$this->response->header = self::HTTP_CONFLICT;
				$this->response->message = line('CSK_MODULES_ERROR_DELETE');
				break;
		}
	}

}
