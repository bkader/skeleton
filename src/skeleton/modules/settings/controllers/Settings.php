<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Module - Settings Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Controllers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Settings extends User_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure to load settings language file.
		$this->load->language('settings/kb_settings');
		// Make sure to load settings_lib.
		$this->load->library('settings/settings_lib', array(), 'settings');
	}

	// ------------------------------------------------------------------------

	/**
	 * This method redirect to profile settings.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		redirect('settings/profile');
		exit;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update user's profile.
	 * @access 	public
	 * @return 	void
	 */
	public function profile()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'first_name',
					'label' => 'lang:first_name',
					'rules' => 'required|max_length[32]'),
			array(	'field' => 'last_name',
					'label' => 'lang:last_name',
					'rules' => 'required|max_length[32]'),
		));

		// Clone the current user.
		$user = clone $this->c_user;

		// Get user's metadata.
		if ( ! empty($meta = $this->app->metadata->get_many_by('guid', $user->id)))
		{
			foreach ($meta as $single)
			{
				$user->{$single->name} = $single->value;
			}
		}

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['first_name'] = array_merge(
				$this->config->item('first_name', 'inputs'),
				array('value' => set_value('first_name', $user->first_name))
			);
			$data['last_name'] = array_merge(
				$this->config->item('last_name', 'inputs'),
				array('value' => set_value('last_name', $user->last_name))
			);
			$data['company'] = array_merge(
				$this->config->item('company', 'inputs'),
				array('value' => set_value('company', @$user->company))
			);
			$data['phone'] = array_merge(
				$this->config->item('phone', 'inputs'),
				array('value' => set_value('phone', @$user->phone))
			);
			$data['location'] = array_merge(
				$this->config->item('location', 'inputs'),
				array('value' => set_value('location', @$user->location))
			);

			// Use any filter targeting these fields.
			$data = apply_filters('user_profile_form_fields', $data);

			// CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and load view.
			$this->theme
				->set_title(__('set_profile_title'))
				->render($data);
		}
		// After form processing.
		else
		{
			$post = apply_filters('user_profile_update_fields', array(
				'first_name',
				'last_name',
				'company',
				'phone',
				'location',
			));

			$data = $this->input->post($post, true);

			$this->settings->update_profile($user->id, $data);
			redirect('settings/profile', 'refresh');
			exit;
		}
	}

}
