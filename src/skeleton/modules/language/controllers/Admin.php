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
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->language('language/language_admin');
	}

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
		// foreach ($data['languages'] as $folder => &$lang)
		// {
		// 	$lang['available'] = false;
		// 	if (is_dir(APPPATH.'language/'.$folder) OR is_dir(KBPATH.'language/'.$folder))
		// 	{
		// 		$lang['available'] = true;
		// 	}
		// 	else
		// 	{
		// 		$lang['available'] = false;
		// 	}
		// }


		// Set page title and render view.
		$this->theme
			->set_title(lang('manage_languages'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Enable the selected language.
	 * @access 	public
	 * @param 	string 	$folder 	The language folder.
	 * @return 	void
	 */
	public function enable($folder = null)
	{
		// Check safe URL.
		if ( ! check_safe_url() OR $folder === 'english')
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/language');
			exit;
		}

		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			set_alert(lang('language_enable_missing'), 'error');
			redirect('admin/language');
			exit;
		}

		$db_langs = $this->config->item('languages') ?: array();
		if (in_array($folder, $db_langs))
		{
			set_alert(lang('language_enable_already'), 'error');
			redirect('admin/language');
			exit;
		}

		$db_langs[] = $folder;
		asort($db_langs);

		if ($this->app->options->set_item('languages', $db_langs))
		{
			set_alert(lang('language_enable_success'), 'success');
		}
		else
		{
			set_alert(lang('language_enable_error'), 'error');
		}

		redirect('admin/language');
		exit;
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
		// Check safe URL.
		if ( ! check_safe_url() OR $folder === 'english')
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/language');
			exit;
		}

		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			set_alert(lang('language_disable_missing'), 'error');
			redirect('admin/language');
			exit;
		}

		$db_langs = $this->config->item('languages') ?: array();
		if ( ! in_array($folder, $db_langs))
		{
			set_alert(lang('language_disable_already'), 'error');
			redirect('admin/language');
			exit;
		}

		foreach ($db_langs as $key => $lang)
		{
			if ($lang === $folder)
			{
				unset($db_langs[$key]);
			}
		}
		asort($db_langs);

		if ($this->app->options->set_item('languages', $db_langs))
		{
			/**
			 * If the language folder is the default selected 
			 * language, we make sure to fallback to english.
			 */
			if ($folder === $this->config->item('language'))
			{
				$this->app->options->set_item('language', 'english');
			}
			set_alert(lang('language_disable_success'), 'success');
		}
		else
		{
			set_alert(lang('language_disable_error'), 'error');
		}

		redirect('admin/language');
		exit;
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
		// Check safe URL.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/language');
			exit;
		}

		if (empty($folder) OR ! array_key_exists($folder, $this->lang->languages()))
		{
			set_alert(lang('language_default_missing'), 'error');
			redirect('admin/language');
			exit;
		}

		$db_langs = $this->config->item('languages') ?: array();
		if ( ! in_array($folder, $db_langs))
		{
			$db_langs[] = $folder;
			asort($db_langs);
			$this->app->options->set_item('languages', $db_langs);
		}

		if ($this->app->options->set_item('language', $folder))
		{
			set_alert(lang('language_default_success'), 'success');
		}
		else
		{
			set_alert(lang('language_default_error'), 'error');
		}

		redirect('admin/language');
		exit;
	}

}
