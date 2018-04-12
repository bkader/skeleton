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
 * Language Module - Admin Controller
 *
 * Allow administrators to manage site's languages.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @since 		1.3.3 	Added dynamically loaded assets.
 * 
 * @version 	1.3.3
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added dynamically loaded assets.
	 * 
	 * @return 	void
	 */
	public function __construct()
	{
		// We add our AJAX methods.
		array_push($this->safe_ajax_methods, 'enable', 'disable', 'make_default');

		// We add JS files.
		array_push($this->scripts, 'language');

		// We call parent constructor.
		parent::__construct();

		// We load module language file.
		$this->load->language('language/language');
	}

	// ------------------------------------------------------------------------

	/**
	 * List site languages.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Get site's current language.
		$data['language'] = $this->config->item('language');

		// Get site's available languages.
		$data['available_languages'] = $this->config->item('languages') ?: array();

		// Get all languages details.
		$data['languages'] = $this->lang->languages();
		ksort($data['languages']);

		/**
		 * We check if the language folder is available or not and set 
		 * it to available if found. This way we avoid installing languages
		 * that are not really available.
		 */
		foreach ($data['languages'] as $folder => &$lang)
		{
			// Language availability.
			$lang['available'] =  (is_dir(APPPATH.'language/'.$folder) && is_dir(KBPATH.'language/'.$folder));

			// Language action.
			$lang['action'] = null; // Ignore english.
			if ('english' !== $folder)
			{
				$lang['action'] = (in_array($folder, $data['available_languages'])) ? 'disable' : 'enable';
			}
		}

		// Set page title and render view.
		$this->theme
			->set_title(lang('sln_manage_languages'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// AJAX Methods.
	// ------------------------------------------------------------------------

	/**
	 * Enable the selected language.
	 * @access 	public
	 * @param 	string 	$folder 	The language folder.
	 * @return 	void
	 */
	public function enable($folder = null)
	{
		// Default process status header code.
		$this->response->header = 409;

		// No valid language provided?
		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			$this->response->header  = 406;
			$this->response->message = lang('sln_language_enable_missing');
			return;
		}

		// Get language stored in database.
		$db_langs = $this->config->item('languages') ?: array();

		// The language already enabled?
		if (in_array($folder, $db_langs))
		{
			$this->response->message = lang('sln_language_enable_already');
			return;
		}

		// We add the language to database languages.
		$db_langs[] = $folder;
		asort($db_langs);

		// We update languages in database.
		if ($this->kbcore->options->set_item('languages', $db_langs))
		{
			$this->response->header  = 200;
			$this->response->message = lang('sln_language_enable_success');

			// We log the activity.
			log_activity($this->c_user->id, 'lang:act_language_enable::'.$folder);

			return;
		}

		// Default message is that we are unable to enable the language.
		$this->response->message = lang('sln_language_enable_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * Disable the selected language.
	 * @access 	public
	 * @param 	string 	$folder 	The language folder.
	 * @return 	void
	 */
	public function disable($folder = null)
	{
		// Default status header code.
		$this->response->header = 409;

		// No valid language provided?
		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			$this->response->header  = 406;
			$this->response->message = lang('sln_language_disable_missing');
			return;
		}

		// Get language from database.
		$db_langs = $this->config->item('languages') ?: array();

		// The language is already disabled?
		if ( ! in_array($folder, $db_langs))
		{
			$this->response->message = lang('sln_language_disable_already');
			return;
		}

		// We remove the language from database languages array.
		foreach ($db_langs as $key => $lang)
		{
			if ($lang === $folder)
			{
				unset($db_langs[$key]);
			}
		}
		asort($db_langs);

		// We proceed to update.
		if ($this->kbcore->options->set_item('languages', $db_langs))
		{
			/**
			 * If the language folder is the default selected 
			 * language, we make sure to fallback to english.
			 */
			if ($folder === $this->config->item('language'))
			{
				$this->kbcore->options->set_item('language', 'english');
			}

			$this->response->header  = 200;
			$this->response->message = lang('sln_language_disable_success');

			// Log the activity.
			log_activity($this->c_user->id, 'lang:act_language_disable::'.$folder);
			return;
		}

		// Default message is that we are unable to disable the language.
		$this->response->message = lang('sln_language_enable_error');
	}

	// ------------------------------------------------------------------------

	/**
	 * Set site's default language..
	 * @access 	public
	 * @param 	string 	$folder 	The language folder.
	 * @return 	void
	 */
	public function make_default($folder = null)
	{
		// Default header status code.
		$this->response->header = 409;

		// No valid language provided?
		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			$this->response->header  = 409;
			$this->response->message = lang('sln_language_default_missing');
			return;
		}

		// Retrieve languages from database.
		$db_langs = $this->config->item('languages') ?: array();

		// If the language is not available, we add it.
		if ( ! in_array($folder, $db_langs))
		{
			$db_langs[] = $folder;
			asort($db_langs);

			// We had issues with adding the language?
			if ( ! $this->kbcore->options->set_item('languages', $db_langs))
			{
				$this->response->message = lang('sln_language_default_error');
				return;
			}
		}

		// We update the site's default language.
		if ($this->kbcore->options->set_item('language', $folder))
		{
			$this->response->header  = 200;
			$this->response->message = lang('sln_language_default_success');

			// Log the activity.
			log_activity($this->c_user->id, 'lang:act_language_default::'.$folder);
			return;
		}

		// Otherwise, we could not set default language.
		$this->response->message = lang('sln_language_default_error');
	}

}
