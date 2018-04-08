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
 * Settings Module - Admin Controller
 *
 * This controller handles site settings.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.2
 */
class Admin extends Admin_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load settings language file.
		$this->load->language('settings/settings_admin');
	}

	// ------------------------------------------------------------------------

	/**
	 * General site settings.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		list($data, $rules) = $this->_prep_settings('general');

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('site_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/settings', 'refresh');
				exit;
			}

			$settings = $this->input->post(array_keys($data), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->kbcore->options->set_item($key, $val))
				{
					set_alert(lang('set_update_error'), 'error');
					redirect('admin/settings', 'refresh');
					exit;
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, 'updated site settings: general');

			set_alert(lang('set_update_success'), 'success');
			redirect('admin/settings', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Users settings.
	 * @access 	public
	 * @return 	void
	 */
	public function users()
	{
		list($data, $rules) = $this->_prep_settings('users');

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('users_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/settings/users', 'refresh');
				exit;
			}

			$settings = $this->input->post(array(
				'allow_registration',
				'email_activation',
				'manual_activation',
				'login_type',
				'allow_multi_session',
				'use_gravatar'
			), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->kbcore->options->set_item($key, $val))
				{
					set_alert(lang('set_update_error'), 'error');
					redirect('admin/settings/users', 'refresh');
					exit;
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, 'updated site settings: users');

			set_alert(lang('set_update_success'), 'success');
			redirect('admin/settings/users', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Email settings.
	 * @access 	public
	 * @return 	void
	 */
	public function email()
	{
		list($data, $rules) = $this->_prep_settings('email');

		// Adding rules if SMTP is selected.
		if ($this->input->post('mail_protocol') == 'smtp')
		{
			$data['mail_protocol']['selected'] = 'smtp';
			// SMTP host.
			$rules[] = array(
				'field' => 'smtp_host',
				'label' => 'lang:set_smtp_host',
				'rules' => 'required',
			);
			// SMTP port.
			$rules[] = array(
				'field' => 'smtp_port',
				'label' => 'lang:set_smtp_port',
				'rules' => 'required|numeric',
			);
			// SMTP user.
			$rules[] = array(
				'field' => 'smtp_user',
				'label' => 'lang:set_smtp_user',
				'rules' => 'required',
			);
			// SMTP pass.
			$rules[] = array(
				'field' => 'smtp_pass',
				'label' => 'lang:set_smtp_pass',
				'rules' => 'required',
			);
		}
		// Using sendmail?
		elseif ($this->input->post('mail_protocol') == 'sendmail')
		{
			$data['mail_protocol']['selected'] = 'sendmail';
			$rules[] = array(
				'field' => 'sendmail_path',
				'label' => 'lang:set_sendmail_path',
				'rules' => 'required',
			);
		}

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('email_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/settings/email', 'refresh');
				exit;
			}

			$settings = $this->input->post(array(
				'admin_email',
				'mail_protocol',
				'sendmail_path',
				'server_email',
				'smtp_host',
				'smtp_port',
				'smtp_crypto',
				'smtp_user',
				'smtp_pass'
			), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->kbcore->options->set_item($key, $val))
				{
					set_alert(lang('set_update_error'), 'error');
					redirect('admin/settings/email', 'refresh');
					exit;
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, 'updated site settings: email');

			set_alert(lang('set_update_success'), 'success');
			redirect('admin/settings/email', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Uploads settings.
	 * @access 	public
	 * @return 	void
	 */
	public function uploads()
	{
		list($data, $rules) = $this->_prep_settings('upload');

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('upload_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/settings/uploads', 'refresh');
				exit;
			}

			$settings = $this->input->post(array('upload_path', 'allowed_types'), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->kbcore->options->set_item($key, $val))
				{
					set_alert(lang('set_update_error'), 'error');
					redirect('admin/settings/uploads', 'refresh');
					exit;
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, 'updated site settings: uploads');

			set_alert(lang('set_update_success'), 'success');
			redirect('admin/settings/uploads', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Captcha settings.
	 * @access 	public
	 * @return 	void
	 */
	public function captcha()
	{
		list($data, $rules) = $this->_prep_settings('captcha');

		// Using reCAPTCHA.
		if ($this->input->post('use_recaptcha') == 'true')
		{
			$data['use_recaptcha']['selected'] = 'true';
			// reCAPTCHA site key.
			$rules[] = array(
				'field' => 'recaptcha_site_key',
				'label' => 'lang:set_recaptcha_site_key',
				'rules' => 'required',
			);
			// reCAPTCHA private key.
			$rules[] = array(
				'field' => 'recaptcha_private_key',
				'label' => 'lang:set_recaptcha_private_key',
				'rules' => 'required',
			);
		}

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before form processing.
		if ($this->form_validation->run() == false)
		{
			// Extra security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(lang('captcha_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/settings/captcha', 'refresh');
				exit;
			}

			$settings = $this->input->post(array('use_captcha', 'use_recaptcha', 'recaptcha_site_key', 'recaptcha_private_key'), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->kbcore->options->set_item($key, $val))
				{
					set_alert(lang('set_update_error'), 'error');
					redirect('admin/settings/captcha', 'refresh');
					exit;
				}
			}

			// Log the activity.
			log_activity($this->c_user->id, 'updated site settings: captcha');

			set_alert(lang('set_update_success'), 'success');
			redirect('admin/settings/captcha', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Prepares form fields and validation rules.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added the base controller setting handler.
	 * 
	 * @access 	private
	 * @param 	string 	$tab 	settings tab.
	 * @return 	array 	containing rules and fields.
	 */
	private function _prep_settings($tab = 'general')
	{
		$settings = $this->kbcore->options->get_by_tab($tab);

		// Prepare empty form validation rules.
		$rules = array();

		foreach ($settings as $option)
		{
			$data[$option->name] = array(
				'type'  => $option->field_type,
				'name'  => $option->name,
				'id'    => $option->name,
				'value' => $option->value,
			);

			if ($option->required == 1)
			{
				$data[$option->name]['required'] = 'required';
				$rules[$option->name] = array(
					'field' => $option->name,
					'label' => "lang:set_{$option->name}",
					'rules' => 'required',
				);
			}

			/**
			 * In case of the base controller settings, we make sure to 
			 * grab a list of all available controllers/modules and prepare
			 * the dropdown list.
			 */
			if ('base_controller' === $option->name && empty($option->options))
			{
				// We start with an empty controllers list.
				$controllers = array();

				// We set controllers locations.
				$locations   = array(
					APPPATH.'controllers/' => null,
					KBPATH.'controllers/'  => null,
				);

				// We add modules locations to controllers locations.
				$modules = $this->router->list_modules();
				foreach ($modules as $module)
				{
					// We add it only if the "controller" folder is found.
					if (null !== $c = $this->router->module_path($module.'/controllers'))
					{
						$locations[$c] = $module;
					}
				}

				// Array of files to be ignored.
				$_to_eliminate = array(
					'.',
					'..',
					'.gitkeep',
					'index.html',
					'.htaccess',
					'Admin.php',
					'Ajax.php',
					'Process.php',
				);

				// Fill controllers.
				foreach ($locations as $location => $module)
				{
					// We read the directory.
					if ($handle = opendir($location))
					{
						while (false !== ($file = readdir($handle)))
						{
							// We ignore files to eliminate.
							if ( ! in_array($file, $_to_eliminate))
							{
								// We format the file's name.
								$file = strtolower(str_replace('.php', '', $file));

								/**
								 * If the controller's name is different from module's, we 
								 * make sure to add the module to the start.
								 */
								if (null !== $module && $file <> $module)
								{
									$file = $module.'/'.$file;
								}

								// We fill $controllers array.
								$controllers[$file] = $file;
							}
						}
					}
				}

				// We add controllers list.
				$option->options = $controllers;
			}
			
			if ($option->field_type == 'dropdown' && ! empty($option->options))
			{
				$data[$option->name]['options'] = array_map(function($val) {
					if (is_numeric($val))
					{
						return $val;
					}

					return (sscanf($val, 'lang:%s', $lang_val) === 1) ? lang($lang_val) : $val;
				}, $option->options);

				if ( ! empty(to_bool_or_serialize($option->value)))
				{
					$data[$option->name]['selected'] = to_bool_or_serialize($option->value);
					$rules[$option->name]['rules'] .= '|in_list['.implode(',', array_keys($option->options)).']';
				}
				else
				{
					$data[$option->name]['selected'] = '';
				}
			}
			else
			{
				$data[$option->name]['placeholder'] = lang('set_'.$option->name);
			}
		}

		return array($data, array_values($rules));
	}

}
