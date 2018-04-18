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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menus Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
class Admin extends Admin_Controller {

	/**
	 * Class constructor.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Added AJAX methods and changes language file name.
	 * @since 	1.4.0 	Dashboard assets enqueue is handled by parent methods.
	 * 
	 * @return 	void
	 */
	public function __construct()
	{
		// Call parent's constructor
		parent::__construct();

		// Make sure to load menus language file.
		$this->load->language('menus/menus');

		// We load theme translation.
		$this->theme->load_translation();

		// We add our language lines to head tag.
		add_filter('admin_head', array($this, '_admin_head'));

		('items' === $this->router->fetch_method()) && $this->_jquery_ui(true);

		// Add our menus JS file.
		array_push($this->scripts, 'menus');
	}

	// ------------------------------------------------------------------------
	// Menus Methods.
	// ------------------------------------------------------------------------

	/**
	 * List all website available menus.
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		// Get all menus from database.
		$data['menus'] = $this->kbcore->menus->get_menus();

		// Set page title and render view.
		$this->theme
			->set_title(lang('smn_manage_menus'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Add a new menu.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Put back CSRF checker.
	 * 
	 * @access 	public
	 * @return  void
	 */
	public function add()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'name',
					'label' => 'lang:smn_menu_name',
					'rules' => 'required')
		));

		// Store form in flashdata to retrieve in case of an error.
		$name        = '';
		$description = '';
		
		if ($this->session->flashdata('form'))
		{
			extract($this->session->flashdata('form'));
		}

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['name'] = array_merge(
				$this->config->item('name', 'inputs'),
				array('value' => set_value('name', $name))
			);
			$data['description'] = array_merge(
				$this->config->item('description', 'inputs'),
				array('value' => set_value('description', $description))
			);

			// Add CSRF security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('smn_add_menu'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				// Store the details in session.
				$this->session->set_flashdata('form', $this->input->post());

				// Set alert and redirect back.
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/menus/add', 'refresh');
				exit;
			}

			// Proceed
			$status = $this->kbcore->menus->add_menu(
				$this->input->post('name', true),
				$this->input->post('description', true)
			);

			// Did not pass?
			if ($status === false)
			{
				// Store the details in session.
				$this->session->set_flashdata('form', $this->input->post());

				// Set alert and redirect back.
				set_alert(lang('smn_add_menu_error'), 'error');
				redirect('admin/menus/add', 'refresh');
				exit;
			}

			// Log the activity.
			log_activity($this->c_user->id, 'lang:act_menus_add_menu::'.$status);

			// Set alert and redirect to menus list.
			set_alert(lang('smn_add_menu_success'), 'success');
			redirect('admin/menus', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit action handler.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	public
	 * @param 	string 	$target 	menu or item.
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function edit($id = 0)
	{
		// Get the menu from database.
		$data['menu'] = $this->kbcore->menus->get_menu($id);
		
		// Make sure the menu exists.
		if ( ! $data['menu'])
		{
			set_alert(lang('smn_inexistent_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Prepare validation rules.
		$rules = array(
			array(	'field' => 'name',
					'label' => 'lang:smn_menu_name',
					'rules' => 'required'),
		);

		// The user changed the slug?
		if ($this->input->post('username')
			&& $this->input->post('username') <> $data['menu']->username) {
			$rules[] = array(
				'field' => 'username',
				'label' => 'lang:smn_menu_slug',
				'rules' => 'required|is_unique[entities.username]'
			);
		}

		// Prepare form validation and rules.
		$this->prep_form($rules);

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['name'] = array_merge(
				$this->config->item('name', 'inputs'),
				array('value' => set_value('name', $data['menu']->name))
			);
			$data['username'] = array_merge(
				$this->config->item('username', 'inputs'),
				array('value' => set_value('username', $data['menu']->username))
			);
			$data['description'] = array_merge(
				$this->config->item('description', 'inputs'),
				array('value' => set_value('description', $data['menu']->description))
			);

			// Add CSRF security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(sprintf(lang('smn_edit_menu_name'), $data['menu']->name))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				// Set alert and redirect back.
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/menus/add', 'refresh');
				exit;
			}

			// Proceed
			$status = $this->kbcore->menus->update_menu(
				$id,
				$this->input->post('name', true),
				$this->input->post('description', true),
				$this->input->post('username', true)
			);

			// Did not pass?
			if (false === $status)
			{
				// Store the details in session.
				$this->session->set_flashdata('form', $data);

				// Set alert and redirect back.
				set_alert(lang('smn_save_menu_error'), 'error');
				redirect('admin/menus/edit/'.$id, 'refresh');
				exit;
			}

			// Log the activity.
			log_activity($this->c_user->id, 'lang:act_menus_edit_menu::'.$id);

			// Set alert and redirect to menus list.
			set_alert(lang('smn_save_menu_success'), 'success');
			redirect('admin/menus', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit menus locations.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Added CSRF security check.
	 * 
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function locations()
	{
		// Get all locations and menus.
		$data['locations'] = $this->kbcore->menus->get_locations();
		$data['menus']     = $this->kbcore->menus->get_menus();

		// Prepare form validation and rules.
		$this->prep_form(array(array(
			'field' => 'menu_location[]',
			'label' => 'lang:smn_menu_location',
			'rules' => 'required',
		)));


		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Add CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('smn_manage_locations'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				// Set alert and redirect back.
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/menus/locations', 'refresh');
				exit;
			}

			// Collect data.
			$data = $this->input->post('menu_location', true);

			// Try to update menus locations.
			if (true === $this->kbcore->menus->set_location_menu($data))
			{
				set_alert(lang('smn_update_locations_success'), 'success');

				// Log the activity.
				log_activity($this->c_user->id, 'lang:act_menus_update_locations');
			}
			else
			{
				set_alert(lang('smn_update_locations_error'), 'error');
			}

			redirect('admin/menus/locations', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * List and create menu items for the selected menu.
	 * @access 	public
	 * @param 	int 	$id 	the menu's ID.
	 * @return 	void
	 */
	public function items($id = 0)
	{
		// Get the menu from database and make sure it exists.
		$data['menu'] = $this->kbcore->menus->get_menu($id);
		if ( ! $data['menu'])
		{
			set_alert(lang('smn_inexistent_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Get all menu items.
		$data['items'] = $this->kbcore->menus->get_menu_items($id);

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'name',
					'label' => 'lang:smn_item_title',
					'rules' => 'required'),
			array(	'field' => 'href',
					'label' => 'lang:smn_item_url',
					'rules' => 'required'),
		));

		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Prepare form fields.
			$data['title'] = array_merge(
				$this->config->item('title', 'inputs'),
				array('value' => set_value('name'))
			);
			$data['href'] = array_merge(
				$this->config->item('href', 'inputs'),
				array('value' => set_value('href'))
			);
			$data['description'] = array_merge(
				$this->config->item('description', 'inputs'),
				array('value' => set_value('description'))
			);

			// Add CSRF token.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(sprintf(lang('smn_menu_items_name'), $data['menu']->name))
				->render($data);
		}
		// The form has been processed?
		else
		{
			// Check CSRF.
			if ( ! $this->check_csrf())
			{
				// Set alert and redirect back.
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/menus/items/'.$id, 'refresh');
				exit;
			}

			// Let's collect attributes first.
			$attrs = $this->input->post('attrs', true);
			if ($this->input->post('attrs[target]') == '1')
			{
				$attrs['target'] = '_blank';
			}

			// Proceed.
			$status = $this->kbcore->menus->add_item(
				$data['menu']->id,
				$this->input->post('name', true),
				$this->input->post('href', true),
				$this->input->post('description', true),
				array_filter($attrs) // So we don't insert empty attributes.
			);

			// Set alert message.
			if (false !== $status)
			{
				set_alert(lang('smn_add_item_success'), 'success');

				// Log the activity.
				log_activity($this->c_user->id, 'lang:act_menus_add_item::'.$status);
			}
			else
			{
				set_alert(lang('smn_add_item_error'), 'error');
			}

			redirect('admin/menus/items/'.$id,'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Update menu items order and details all in one function.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	int 	$id 	The menu's ID.
	 * @return 	void
	 */
	public function update($id = 0)
	{
		// We make sure a valid ID is provided and the menu exists.
		if ( ! is_numeric($id) OR $id < 0 OR ! $this->kbcore->menus->get_menu($id))
		{
			set_alert(lang('smn_inexistent_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Collect data and make sure we have some.
		$data = $this->input->post('menu-item', true);
		if (empty($data))
		{
			set_alert(lang('error_fields_required'), 'error');
			redirect('admin/menus/items/'.$id);
			exit;
		}

		// We update all menu items.
		foreach ($data as $item_id => $item)
		{
			// We we have an issue with one of them, we stop?
			if ( ! $this->kbcore->objects->update($item_id, $item))
			{
				set_alert(lang('smn_save_menu_error'), 'error');
				redirect('admin/menus/items/'.$id);
				exit;
			}
		}

		log_activity($this->c_user->id, 'lang:act_menus_update_items::'.$id);
		set_alert(lang('smn_save_menu_success'), 'success');
		redirect('admin/menus/items/'.$id);
		exit;
	}

	// ------------------------------------------------------------------------
	// Private Methods.
	// ------------------------------------------------------------------------

	/**
	 * We add translations to global i18n object.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	string 	$output
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		// Confirmation messages.
		$lines = array(
			'delete_menu' => lang('smn_delete_menu_confirm'),
			'delete_item' => lang('smn_delete_item_confirm'),
		);

		// We append it then return the final output.
		$output .= '<script type="text/javascript">var i18n=i18n||{};i18n.menus='.json_encode($lines).';</script>';
		return $output;
	}

}
