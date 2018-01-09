<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Controllers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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
		$this->load->language('settings/kb_settings_admin');
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
				->set_title(__('site_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(__('error_csrf'), 'error');
				redirect('admin/settings', 'refresh');
				exit;
			}

			$settings = $this->input->post(array(
				'site_name',
				'site_description',
				'site_keywords',
				'site_author',
				'per_page',
				'google_analytics_id',
				'google_site_verification',
			), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->app->options->set_item($key, $val))
				{
					set_alert(__('set_update_error'), 'error');
					redirect('admin/settings', 'refresh');
					exit;
				}
			}

			set_alert(__('set_update_success'), 'success');
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
				->set_title(__('users_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(__('error_csrf'), 'error');
				redirect('admin/settings/users', 'refresh');
				exit;
			}

			$settings = $this->input->post(array('allow_registration', 'email_activation', 'manual_activation', 'login_type', 'use_gravatar'), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->app->options->set_item($key, $val))
				{
					set_alert(__('set_update_error'), 'error');
					redirect('admin/settings/users', 'refresh');
					exit;
				}
			}

			set_alert(__('set_update_success'), 'success');
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
				->set_title(__('email_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(__('error_csrf'), 'error');
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
				if ( ! $this->app->options->set_item($key, $val))
				{
					set_alert(__('set_update_error'), 'error');
					redirect('admin/settings/email', 'refresh');
					exit;
				}
			}

			set_alert(__('set_update_success'), 'success');
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
				->set_title(__('upload_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(__('error_csrf'), 'error');
				redirect('admin/settings/uploads', 'refresh');
				exit;
			}

			$settings = $this->input->post(array('upload_path', 'allowed_types'), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->app->options->set_item($key, $val))
				{
					set_alert(__('set_update_error'), 'error');
					redirect('admin/settings/uploads', 'refresh');
					exit;
				}
			}

			set_alert(__('set_update_success'), 'success');
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
				->set_title(__('captcha_settings'))
				->render($data);
		}
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				set_alert(__('error_csrf'), 'error');
				redirect('admin/settings/captcha', 'refresh');
				exit;
			}

			$settings = $this->input->post(array('use_captcha', 'use_recaptcha', 'recaptcha_site_key', 'recaptcha_private_key'), true);

			foreach ($settings as $key => $val)
			{
				if ( ! $this->app->options->set_item($key, $val))
				{
					set_alert(__('set_update_error'), 'error');
					redirect('admin/settings/captcha', 'refresh');
					exit;
				}
			}

			set_alert(__('set_update_success'), 'success');
			redirect('admin/settings/captcha', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Prepares form fields and validation rules.
	 * @access 	private
	 * @param 	string 	$tab 	settings tab.
	 * @return 	array 	containing rules and fields.
	 */
	private function _prep_settings($tab = 'general')
	{
		$settings = $this->app->options->get_by_tab($tab);

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

			if ($option->field_type == 'dropdown' && ! empty($option->options))
			{
				$data[$option->name]['options'] = array_map(function($val) {
					if (is_numeric($val))
					{
						return $val;
					}

					return (sscanf($val, 'lang:%s', $lang_val) === 1) ? __($lang_val) : $val;
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
				$data[$option->name]['placeholder'] = __('set_'.$option->name);
			}
		}

		return array($data, array_values($rules));
	}

}
