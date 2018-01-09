<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Controller Class
 *
 * All controllers must extend this class.
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class KB_Controller extends CI_Controller
{
	/**
	 * Holds the current user's object.
	 * @var object
	 */
	protected $c_user;

	/**
	 * Holds the redirection URL.
	 * @var string
	 */
	protected $redirect = '';

	/**
	 * Array of data to pass to views.
	 * @var array
	 */
	protected $data = array();

	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load authentication library.
		$this->c_user = $this->auth->user();
		$this->theme->set('c_user', $this->c_user, true);

		// Always hold the redirection URL for eventual use.
		if ($this->input->get_post('next'))
		{
			$this->redirect = rawurldecode($this->input->get_post('next'));
		}

		// Add all necessary meta tags.
		$this->app->set_meta();

		log_message('debug', 'KB_Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Prepare form validation.
	 * @access 	public
	 * @param 	array 	$rules 	array of validation rules.
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return void
	 */
	public function prep_form($rules = array())
	{
		// Load form validation library if not loaded.
		if ( ! class_exists('CI_Form_validation', false))
		{
			$this->load->library('form_validation');
		}

		// Load form helper if not loaded.
		if ( ! function_exists('form_open'))
		{
			$this->load->helper('form');
		}

		// If there are any rules, set them.
		if (is_array($rules) && ! empty($rules))
		{
			$this->form_validation->set_rules($rules);
		}

		// Load inputs config file.
		if ( ! $this->config->item('inputs'))
		{
			$this->load->config('inputs', true);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generate a CSRF protection token.
	 * @access 	public
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return array
	 */
	public function create_csrf()
	{
		// Make sure to load string helper.
		(function_exists('random_string')) OR $this->load->helper('string');

		// Generate key and value.
		$csrf_key   = random_string('alnum', 8);
		$csrf_value = random_string('alnum', 32);

		// Store flash data.
		$this->session->set_flashdata(array(
			'csrf_key'   => $csrf_key,
			'csrf_value' => $csrf_value,
		));

		// Return the array for later use.
		return array($csrf_key => $csrf_value);
	}

	// --------------------------------------------------------------------

	/**
	 * Checks a CSRF protection token.
	 * @access 	public
	 * @author 	Kader Bouyakoub
	 * @version 1.0
	 * @return array
	 */
	public function check_csrf()
	{
		$csrf_key = $this->input->post($this->session->flashdata('csrf_key'));

		// It returns true only of the key is set and the value is valid.
		return ($csrf_key && $csrf_key == $this->session->flashdata('csrf_value'));
	}

	// ------------------------------------------------------------------------
	// Captcha Methods.
	// ------------------------------------------------------------------------

	/**
	 * Generate a captcha field.
	 * @access 	public
	 * @param 	int 	$guid 	the user's ID.
	 * @return 	array 	captcha image URL and form details.
	 */
	public function create_captcha($guid = 0)
	{
		// Not using captcha at all?
		if (get_option('use_captcha', false) === false)
		{
			return array('captcha' => null, 'image' => null);
		}

		// Using reCAPTCHA?
		if (get_option('use_recaptcha', false) === true && ! empty(get_option('recaptcha_site_key', null)))
		{
			// Add reCAPTCHA script tag.
			$this->theme->add('js', 'https://www.google.com/recaptcha/api.js', 'recaptcha');

			// Return both captcha field and empty image.
			return array(
				'captcha' => '<div class="g-recaptcha" data-sitekey="'.get_option('recaptcha_site_key').'"></div>',
				'image'   => null,
			);
		}

		// Load captcha config file.
		$this->load->config('captcha', true);

		// Load captcha helper.
		$this->load->helper('captcha');

		// Generate the new captcha.
		$cap = create_captcha($this->config->item('captcha'));

		// Insert catpcha details into database if not found.
		$var = $this->app->variables->get_by(array(
			'guid'   => $guid,
			'name'   => 'captcha',
			'params' => $this->input->ip_address(),
		));

		// If not found, create it.
		if ( ! $var)
		{
			$this->app->variables->insert(array(
				'guid'   => $guid,
				'name'   => 'captcha',
				'value'  => $cap['word'],
				'params' => $this->input->ip_address(),
			));
		}
		// Found? Update it.
		else
		{
			$this->app->variables->update($var->id, array(
				'value'      => $cap['word'],
				'created_at' => time(),
				'params'     => $this->input->ip_address(),
			));
		}

		return array(
			'image' => $cap['image'],
			'captcha' => array(
				'type'        => 'text',
				'name'        => 'captcha',
				'id'          => 'captcha',
				'placeholder' => __('captcha'),
				'maxlength'   => $this->config->item('word_length', 'captcha'),
			),
		);
	}

	// ------------------------------------------------------------------------

	/**
	 * Check captcha.
	 * @access 	public
	 * @param 	string 	$str 	captcha word
	 * @return 	bool
	 */
	public function check_captcha($str)
	{
		// Return true if captcha is disabled.
		if (get_option('use_captcha', false) === false)
		{
			return true;
		}

		// Using Google reCAPTCHA?
		if (get_option('use_recaptcha', false) === true && ! empty(get_option('recaptcha_site_key', null)))
		{
			// Catch reCAPTCHA field.
			$recaptcha = $this->input->post('g-recaptcha-response');

			// Not set? Set the error message and return false.
			if (empty($recaptcha))
			{
				$this->form_validation->set_message('check_captcha', __('form_validation_required'));
				return false;
			}

			$data = array(
				'secret'   => get_option('recaptcha_private_key'),
				'remoteip' => $this->input->ip_address(),
				'response' => $recaptcha,
			);

			// cURL is enabled?
			if (function_exists('curl_init'))
			{
				$verify = curl_init();
				curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
				curl_setopt($verify, CURLOPT_POST, true);
				curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($verify);
			}
			else
			{
				// Prepare the verification URL.
				$verify_url = 'https://www.google.com/recaptcha/api/siteverify?'.http_build_query($data);

				// Catch response and decode it.
				$response = file_get_contents($verify_url);
			}

			// Decode the response.
			$response = json_decode($response, true);

			echo print_d($response);
			exit;

			// Valid captcha?
			if (isset($response['success']) && $response['success'] === true)
			{
				return true;
			}
			// Invalid captcha?
			else
			{
				$this->form_validation->set_message('check_captcha', __('form_validation_required'));
				return false;
			}
		}

		// No captcha set?
		if (empty($str))
		{
			$this->form_validation->set_message('check_captcha', __('form_validation_required'));
			return false;
		}

		// First, we delete old captcha
		$this->app->variables->delete_by(array(
			'name'         => 'captcha',
			'created_at <' => time() - (MINUTE_IN_SECONDS * 5),
		));

		// Check if the captcha exists or not.
		$var = $this->app->variables->get_by(array(
			'name'          => 'captcha',
			'BINARY(value)' => $str,
			'params'        => $this->input->ip_address(),
		));

		// Found?
		if ($var)
		{
			return true;
		}
		// Not found? Generate the error.
		else
		{
			$this->form_validation->set_message('check_captcha', __('error_captcha'));
			return false;
		}
	}

}
