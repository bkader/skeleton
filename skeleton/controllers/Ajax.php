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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main AJAX controller.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.0
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
	 * @return 	AJAX_Controller::response()
	 */
	public function __construct()
	{
		parent::__construct();

		// Add safe reports.
		$this->safe_admin_methods[] = '_languages';
		$this->safe_admin_methods[] = '_plugins';
		$this->safe_admin_methods[] = '_reports';
		$this->safe_admin_methods[] = '_themes';
		$this->safe_admin_methods[] = '_users';
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
	 * _languages
	 *
	 * Method for interacting with languages.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$action 	The action to perform.
	 * @param 	string 	$name 		The plugin's folder name;
	 * @return 	AJAX_Controller::response()
	 */
	public function _languages($action = null, $name = null)
	{
		$this->load->language('csk_languages');
		$actions = array('enable', 'disable', 'make_default');

		/**
		 * Here are conditions in order to proceed:
		 * 1. The action is provided and available.
		 * 2. The language name is provided and available.
		 * 3. The action passes nonce check.
		 */
		if ((null === $action OR ! in_array($action, $actions))
			OR (null === $name OR ! array_key_exists($name, $this->lang->languages()))
			OR true !== $this->check_nonce())
		{
			$this->response->header = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = __('CSK_ERROR_NONCE_URL');
			return;
		}

		// Make sure to lower the name.
		ctype_lower($name) OR $name = strtolower($name);

		// We cannot touch "English" language.
		if ('english' === $name && 'make_default' !== $action)
		{
			$this->response->header = self::HTTP_NOT_ACCEPTABLE;
			$this->response->message = __('CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED');
			return;
		}

		// Get database languages for later use.
		$languages = $this->config->item('languages');
		$languages OR $languages = array();

		switch ($action)
		{
			// Enabling a language.
			case 'enable':

				// Already enabled? Nothing to do..
				if (in_array($name, $languages))
				{
					$this->response->header = self::HTTP_NOT_MODIFIED;
					$this->response->message = __('CSK_LANGUAGES_ALREADY_ENABLE');
					return;
				}

				// Add language to languages array.
				$languages[] = $name;
				asort($languages);
				$languages = array_values($languages);

				// Successfully updated?
				if (false !== $this->kbcore->options->set_item('languages', $languages))
				{
					// TODO: Log the activity.
					log_activity($this->c_user->id, 'Enabled language: '.$name);

					$this->response->header = self::HTTP_OK;
					$this->response->message = __('CSK_LANGUAGES_SUCCESS_ENABLE');
					return;
				}
				
				$this->response->message = __('CSK_LANGUAGES_ERROR_ENABLE');

				break;

			// Disabling a language.
			case 'disable':

				// Already disabled? Nothing to do..
				if ( ! in_array($name, $languages))
				{
					$this->response->header = self::HTTP_NOT_MODIFIED;
					$this->response->message = __('CSK_LANGUAGES_ALREADY_DISABLE');
					return;
				}

				// Remove language from languages array.
				$languages[] = $name;
				foreach ($languages as $i => $lang)
				{
					if ($lang === $name)
					{
						unset($languages[$i]);
					}
				}
				asort($languages);
				$languages = array_values($languages);

				// Successfully updated?
				if (false !== $this->kbcore->options->set_item('languages', $languages))
				{
					/**
					 * If the language is the site's default language, we make
					 * sure to set English as the default one.
					 */
					if ($name === $this->kbcore->options->item('language'))
					{
						$this->kbcore->options->set_item('language', 'english');
					}

					// TODO: Log the activity.
					log_activity($this->c_user->id, 'Disabled language: '.$name);

					$this->response->header = self::HTTP_OK;
					$this->response->message = __('CSK_LANGUAGES_SUCCESS_DISABLE');
					return;
				}
				
				$this->response->message = __('CSK_LANGUAGES_ERROR_DISABLE');

				break;
			
			// Making language default.
			case 'make_default':

				// If the language is not enabled, we make sure to enable it first.
				if ( ! in_array($name, $languages))
				{
					$languages[] = $name;
					asort($languages);
					if (false === $this->kbcore->options->set_item('languages', $languages))
					{
						$this->response->header = self::HTTP_CONFLICT;
						$this->response->message = __('CSK_LANGUAGES_ERROR_DEFAULT');
						return;
					}
				}

				// Successfully changed?
				if (false !== $this->kbcore->options->set_item('language', $name))
				{
					// TODO: Log the activity.
					log_activity($this->c_user->id, 'Set default language: '.$name);

					$this->response->header = self::HTTP_OK;
					$this->response->message = __('CSK_LANGUAGES_SUCCESS_DEFAULT');
					return;
				}

				$this->response->message = __('CSK_LANGUAGES_ERROR_DEFAULT');

				break;
		}
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
	 * @return 	AJAX_Controller::response()
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
			$this->response->message = __('CSK_ERROR_NONCE_URL');
			return;
		}

		switch ($action) {
			
			// Delete report.
			case 'delete':
				
				// Successfully deleted?
				if (false !== $this->kbcore->activities->delete($id))
				{
					$this->response->header  = self::HTTP_OK;
					$this->response->message = __('CSK_REPORTS_SUCCESS_DELETE');
					return;
				}

				// Otherwise, the activity could not be deleted.
				$this->response->message = __('CSK_REPORTS_ERROR_DELETE');
				return;

				break;
		}
	}

}
