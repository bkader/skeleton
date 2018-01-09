<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure to load language file.
		$this->load->language('themes/kb_themes_admin');
	}

	// ------------------------------------------------------------------------

	/**
	 * Theme settings.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Get themes from database.
		$themes = get_option('themes', null);
		// Make sure themes are stored in database
		if ($themes && $themes <> $this->theme->get_themes())
		{
			set_option('themes', $this->theme->get_themes());
		}
		elseif (empty($themes))
		{
			$themes = $this->theme->get_themes();
			$this->app->options->insert(array(
				'name'  => 'themes',
				'value' => $themes,
				'tab'   => 'theme',
			));
		}

		// Add enabled element.
		foreach ($themes as &$theme)
		{
			$theme['enabled'] = false;
			if ($theme['folder'] == get_option('theme'))
			{
				$theme['enabled'] = true;
			}
		}

		$data['themes'] = $themes;

		$this->theme
			->set_title(lang('theme_settings'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Activate the selected theme.
	 * @access 	public
	 * @param 	string 	$theme 	the theme's folder.
	 * @return 	void
	 */
	public function activate($theme = null)
	{
		// We first check the safe URL.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/themes');
			exit;
		}

		/**
		 * Make sure the $theme is provided and is different
		 * from the currently used one.
		 */
		if (empty($theme) OR $theme == get_option('theme'))
		{
			set_alert(lang('theme_activate_error'), 'error');
			redirect('admin/themes');
			exit;
		}

		// XSS clean theme's folder and update option.
		$status = set_option('theme', xss_clean($theme));

		if ($status === true)
		{
			set_alert(lang('theme_activate_success'), 'success');
		}
		else
		{
			set_alert(lang('theme_activate_error'), 'error');
		}

		redirect('admin/themes');
		exit;
	}
}

/* End of file Admin.php */
/* Location: ./application/modules/themes/controllers/Admin.php */
