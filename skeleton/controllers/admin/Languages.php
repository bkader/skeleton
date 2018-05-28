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
 * @since 		1.0.0
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.1
 */
class Languages extends Admin_Controller
{
	/**
	 * __construct
	 *
	 * We simply call parent's constructor, load module's language file
	 * and we make sure to load our languages JS file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We load module language file.
		$this->load->language('csk_languages');

		add_action('admin_head', array($this, '_admin_head'));

		// We add JS files.
		$this->scripts[] = 'language';

		$this->data['page_icon']  = 'globe';
		$this->data['page_title'] = __('CSK_LANGUAGES');
		$this->data['page_help']  = 'https://goo.gl/cAmWt1';
	}

	// ------------------------------------------------------------------------

	/**
	 * index
	 *
	 * Method for displaying the list of available site languages.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// Get site's current language.
		$this->data['language'] = $this->kbcore->options->item('language');

		// Get site's available languages.
		$this->data['available_languages'] = $this->config->item('languages') ?: array();

		// Get all languages details.
		$this->data['languages'] = $this->lang->languages();
		ksort($this->data['languages']);

		/**
		 * Languages actions.
		 * @since 	2.1.1
		 */
		$action = $this->input->get('action', true);
		$lang   = $this->input->get('lang', true);

		if (($action && in_array($action, array('enable', 'disable', 'make_default')))
			&& check_nonce_url("language-{$action}_{$lang}")
			&& method_exists($this, '_'.$action))
		{
			return call_user_func_array(array($this, '_'.$action), array($lang));
		}

		/**
		 * We check if the language folder is available or not and set 
		 * it to available if found. This way we avoid installing languages
		 * that are not really available.
		 */
		foreach ($this->data['languages'] as $folder => &$l)
		{
			// Language availability.
			$l['available'] =  (is_dir(APPPATH.'language/'.$folder) && is_dir(KBPATH.'language/'.$folder));

			// Language action.
			$l['action'] = null; // Ignore english.
			if ('english' !== $folder)
			{
				$l['action'] = (in_array($folder, $this->data['available_languages'])) ? 'disable' : 'enable';
			}

			// Action buttons.
			$l['actions'] = array();

			/**
			 * No actions is available on "English" language except making
			 * it the language by default if it is not.
			 */
			if ('english' === $folder)
			{

				// Not by default? Display the "Make Default" button.
				if ('english' !== $this->data['language'])
				{
					$l['actions'][] = html_tag('button', array(
						'type' => 'button',
						'data-endpoint' => esc_url(nonce_admin_url(
							'languages?action=make_default&amp;lang=english',
							'language-make_default_english'
						)),
						'class' => 'btn btn-default btn-xs btn-icon language-default ml-2',
					), fa_icon('lock').__('CSK_LANGUAGES_MAKE_DEFAULT'));
				}

				// Ignore the rest.
				continue;
			}

			// Make default action.
			if ($folder !== $this->data['language'])
			{
				if (true === $l['available'])
				{
					$l['actions'][] = html_tag('button', array(
						'type' => 'button',
						'data-endpoint' => esc_url(nonce_admin_url(
							"languages?action=make_default&amp;lang={$folder}",
							"language-make_default_{$folder}"
						)),
						'class' => 'btn btn-default btn-xs btn-icon language-default ml-2',
					), fa_icon('lock').__('CSK_LANGUAGES_MAKE_DEFAULT'));
				}
				else
				{
					$l['actions'][] = html_tag('button', array(
						'type'     => 'button',
						'class'    => 'btn btn-default btn-xs btn-icon ml-2 op-2',
						'disabled' => 'disabled',
					), fa_icon('lock').__('CSK_LANGUAGES_MAKE_DEFAULT'));
				}
			}

			// Disable language action.
			if (in_array($folder, $this->data['available_languages']))
			{
				if (true === $l['available'])
				{
					$l['actions'][] = html_tag('button', array(
						'type' => 'button',
						'data-endpoint' => esc_url(nonce_admin_url(
							"languages?action=disable&amp;lang={$folder}",
							"language-disable_{$folder}"
						)),
						'class' => 'btn btn-default btn-xs btn-icon language-disable ml-2',
					), fa_icon('times text-danger').__('CSK_LANGUAGES_DISABLE'));
				}
				else
				{
					$l['actions'][] = html_tag('button', array(
						'type'     => 'button',
						'class'    => 'btn btn-default btn-xs btn-icon ml-2 op-2',
						'disabled' => 'disabled',
					), fa_icon('times text-danger').__('CSK_LANGUAGES_DISABLE'));
				}
			}

			// Enable language action.
			else
			{
				if (true === $l['available'])
				{
					$l['actions'][] = html_tag('button', array(
						'type' => 'button',
						'data-endpoint' => esc_url(nonce_admin_url(
							"languages?action=enable&amp;lang={$folder}",
							"language-enable_{$folder}"
						)),
						'class' => 'btn btn-default btn-xs btn-icon language-enable ml-2',
					), fa_icon('check text-success').__('CSK_LANGUAGES_ENABLE'));
				}
				else
				{
					$l['actions'][] = html_tag('button', array(
						'type'     => 'button',
						'class'    => 'btn btn-default btn-xs btn-icon ml-2 op-2',
						'disabled' => 'disabled',
					), fa_icon('check text-success').__('CSK_LANGUAGES_ENABLE'));
				}
			}
		}

		// Set page title and render view.
		$this->theme
			->set_title(lang('CSK_LANGUAGES'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------
	// Quick-access methods.
	// ------------------------------------------------------------------------

	/**
	 * Method for enabling the given language.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _enable($folder)
	{
		// Make sure to lower the name.
		ctype_lower($folder) OR $folder = strtolower($folder);
		
		// We cannot touch "English" language.
		if ('english' === $folder)
		{
			set_alert(__('CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED'), 'error');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		// Get database languages for later use.
		$languages = $this->config->item('languages');
		$languages OR $languages = array();

		// Already enabled? Nothing to do..
		if (in_array($folder, $languages))
		{
			set_alert(__('CSK_LANGUAGES_ALREADY_ENABLE'), 'error');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		// Add language to languages array.
		$languages[] = $folder;
		asort($languages);
		$languages = array_values($languages);

		// Successfully updated?
		if (false !== $this->kbcore->options->set_item('languages', $languages))
		{
			set_alert(__('CSK_LANGUAGES_SUCCESS_ENABLE'), 'success');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		set_alert(__('CSK_LANGUAGES_ERROR_ENABLE'), 'error');
		redirect(KB_ADMIN.'/languages');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for disabling the given language.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _disable($folder)
	{
		// Make sure to lower the name.
		ctype_lower($folder) OR $folder = strtolower($folder);
		
		// We cannot touch "English" language.
		if ('english' === $folder)
		{
			set_alert(__('CSK_LANGUAGES_ERROR_ENGLISH_REQUIRED'), 'error');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		// Get database languages for later use.
		$languages = $this->config->item('languages');
		$languages OR $languages = array();

		// Already disabled? Nothing to do..
		if ( ! in_array($folder, $languages))
		{
			set_alert(__('CSK_LANGUAGES_ALREADY_DISABLE'), 'error');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		// Remove language from languages array.
		$languages[] = $folder;
		foreach ($languages as $i => $lang)
		{
			if ($lang === $folder)
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
			if ($folder === $this->kbcore->options->item('language'))
			{
				$this->kbcore->options->set_item('language', 'english');
			}
			
			set_alert(__('CSK_LANGUAGES_SUCCESS_DISABLE'), 'success');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		set_alert(__('CSK_LANGUAGES_ERROR_DISABLE'), 'error');
		redirect(KB_ADMIN.'/languages');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for making a language site's default.
	 *
	 * @since 	2.1.0
	 *
	 * @access 	protected
	 * @param 	string 	$folder
	 * @return 	void
	 */
	protected function _make_default($folder)
	{
		// Make sure to lower the name.
		ctype_lower($folder) OR $folder = strtolower($folder);

		// Get database languages for later use.
		$languages = $this->config->item('languages');
		$languages OR $languages = array();

		// If the language is not enabled, we make sure to enable it first.
		if ( ! in_array($folder, $languages))
		{
			$languages[] = $folder;
			asort($languages);

			if (false === $this->kbcore->options->set_item('languages', $languages))
			{
				set_alert(__('CSK_LANGUAGES_ERROR_DEFAULT'), 'error');
				redirect(KB_ADMIN.'/languages');
				exit;
			}
		}

		// Successfully changed?
		if (false !== $this->kbcore->options->set_item('language', $folder))
		{
			set_alert(__('CSK_LANGUAGES_SUCCESS_DEFAULT'), 'success');
			redirect(KB_ADMIN.'/languages');
			exit;
		}

		set_alert(__('CSK_LANGUAGES_ERROR_DEFAULT'), 'error');
		redirect(KB_ADMIN.'/languages');
		exit;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * _admin_head
	 *
	 * Add some JS lines to admin head section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		$lines = array(
			'enable'       => __('CSK_LANGUAGES_CONFIRM_ENABLE'),
			'disable'      => __('CSK_LANGUAGES_CONFIRM_DISABLE'),
			'make_default' => __('CSK_LANGUAGES_CONFIRM_DEFAULT'),
		);

		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.languages = '.json_encode($lines).';';
		$output .= '</script>';

		return $output;
	}

	/**
	 * _subhead
	 *
	 * Added notice to dashboard subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		add_action('admin_subhead', function () {
			echo html_tag('span', array(
				'class' => 'navbar-text'
			), fa_icon('info-circle text-primary mr-1').__('CSK_LANGUAGES_TIP'));
		});
	}

}
