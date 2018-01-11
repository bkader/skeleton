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
 * Menus Module - Admin Controller
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

		// Make sure to load menus language file.
		$this->load->language('menus/menus_admin');
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
		$data['menus'] = $this->app->menus->get_menus();

		// Set page title and render view.
		$this->theme
			->set_title(lang('manage_menus'))
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Add a new menu.
	 * @access 	public
	 * @return  void
	 */
	public function add()
	{
		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'name',
					'label' => 'lang:menu_name',
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
				->set_title(lang('add_menu'))
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
			$status = $this->app->menus->add_menu(
				$this->input->post('name', true),
				$this->input->post('description', true)
			);

			// Did not pass?
			if ($status === false)
			{
				// Store the details in session.
				$this->session->set_flashdata('form', $data);

				// Set alert and redirect back.
				set_alert(lang('add_menu_error'), 'error');
				redirect('admin/menus/add', 'refresh');
				exit;
			}

			// Set alert and redirect to menus list.
			set_alert(lang('add_menu_success'), 'success');
			redirect('admin/menus', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit action handler.
	 * @access 	public
	 * @param 	string 	$target 	menu or item.
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function edit($target, $id = 0)
	{
		// Make sure only available option are set.
		if ( ! in_array($target, array('menu', 'item')))
		{
			show_404();
		}

		// Make sure the method exists.
		if (method_exists($this, "_edit_{$target}"))
		{
			return $this->{"_edit_{$target}"}($id);
		}

		show_404();
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit an existing menu.
	 * @access 	public
	 * @param 	int 	$id 	The menu's ID.
	 * @return  void
	 */
	public function _edit_menu($id = 0)
	{
		// Get the menu from database.
		$data['menu'] = $this->app->menus->get_menu($id);
		// Make sure the menu exists.
		if ( ! $data['menu'])
		{
			set_alert(lang('edit_menu_no_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Prepare validation rules.
		$rules = array(
			array(	'field' => 'name',
					'label' => 'lang:menu_name',
					'rules' => 'required'),
		);

		// The user changed the slug?
		if ($this->input->post('slug')
			&& $this->input->post('slug') <> $data['menu']->slug) {
			$rules[] = array(
				'field' => 'slug',
				'label' => 'lang:menu_slug',
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
			$data['slug'] = array_merge(
				$this->config->item('slug', 'inputs'),
				array('value' => set_value('slug', $data['menu']->slug))
			);
			$data['description'] = array_merge(
				$this->config->item('description', 'inputs'),
				array('value' => set_value('description', $data['menu']->description))
			);

			// Add CSRF security layer.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('edit_menu'), $data['menu']->name)
				->set_view('admin/edit_menu')
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
			$status = $this->app->menus->update_menu(
				$id,
				$this->input->post('name', true),
				$this->input->post('slug', true),
				$this->input->post('description', true)
			);

			// Did not pass?
			if ($status === false)
			{
				// Store the details in session.
				$this->session->set_flashdata('form', $data);

				// Set alert and redirect back.
				set_alert(lang('edit_menu_error'), 'error');
				redirect('admin/menus/edit/'.$id, 'refresh');
				exit;
			}

			// Set alert and redirect to menus list.
			set_alert(lang('edit_menu_success'), 'success');
			redirect('admin/menus', 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete an existing menu. This will remove all it's items from database
	 * as well.
	 * @access 	public
	 * @param 	int 	$id 	the menu's ID.
	 * @return 	void
	 */
	public function delete($target, $id)
	{
		if ((empty($target) OR ! in_array($target, array('menu', 'item')))
			OR empty($id))
		{
			redirect('admin/menus');
			exit;
		}

		// Check URL token.
		if ( ! check_safe_url())
		{
			set_alert(lang('error_safe_url'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Process status.
		$status = $this->app->menus->{"delete_{$target}"}($id);

		if ($status === true)
		{
			set_alert(lang("delete_{$target}_success"), 'success');
		}
		else
		{
			set_alert(lang("delete_{$target}_error"), 'error');
		}

		redirect($this->agent->referrer());
		exit;
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
		// $ord = $this->app->menus->items_order($id, array(20, 22, 23, 21));
		// echo print_d($ord);
		// exit;

		// Get the menu from database and make sure it exists.
		$data['menu'] = $this->app->menus->get_menu($id);
		if ( ! $data['menu'])
		{
			set_alert(lang('edit_menu_no_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Get all menu items.
		$data['items'] = $this->app->menus->get_menu_items($id);

		// Load jquery UI and prepare sortable list IF there are items.
		if ($data['items'])
		{
			$this->load_jquery_ui();
			$this->add_sortable_list(
				'#save-menu',
				'#sortable',
				admin_url('menus/update_order/'.$id),
				lang('menu_structure_success')
			);
		}

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'name',
					'label' => 'lang:item_title',
					'rules' => 'required'),
			array(	'field' => 'href',
					'label' => 'lang:item_href',
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
				->set_title(lang('menu_items'), $data['menu']->name)
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

			// Proceed.
			$status = $this->app->menus->add_item(
				$id,
				$this->input->post('name', true),
				$this->input->post('href', true),
				$this->input->post('description', true),
				$this->input->post('attrs', true)
			);

			// Set alert message.
			if ($status)
			{
				set_alert(lang('add_item_success'), 'success');
			}
			else
			{
				set_alert(lang('add_item_error'), 'error');
			}

			redirect('admin/menus/items/'.$id,'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit an existing menu item.
	 * @access 	public
	 * @param 	int 	$id 	The menu item's ID.
	 * @return  void
	 */
	public function _edit_item($id = 0)
	{
		// Get the menu from database.
		$data['item'] = $this->app->menus->get_item($id);
		// Make sure the menu exists.
		if ( ! $data['item'])
		{
			set_alert(lang('edit_item_no_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Prepare form validation and rules.
		$this->prep_form(array(
			array(	'field' => 'name',
					'label' => 'lang:item_title',
					'rules' => 'required'),
			array(	'field' => 'href',
					'label' => 'lang:item_href',
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
			$data['order'] = array_merge(
				$this->config->item('order', 'inputs'),
				array('value' => set_value('order'))
			);

			// Add CSRF token.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('edit_item'))
				->set_view('admin/edit_item')
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
				redirect('admin/menus/items/'.$data['item']->menu_id, 'refresh');
				exit;
			}

			// Proceed
			$status = $this->app->menus->update_item(
				$id,
				$this->input->post('name', true),
				$this->input->post('href', true),
				$this->input->post('description', true),
				$this->input->post('attrs', true)
			);

			// Did not pass?
			if ($status === false)
			{
				// Set alert and redirect back.
				set_alert(lang('edit_item_error'), 'error');
				redirect('admin/menus/edit/item/'.$id, 'refresh');
				exit;
			}

			// Set alert and redirect to menus list.
			set_alert(lang('edit_item_success'), 'success');
			redirect('admin/menus/items/'.$data['item']->menu_id, 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * AJAX menu items order.
	 * @access 	public
	 * @param 	int 	$id 	The menu's ID.
	 * @return 	void
	 */
	public function update_order($id = 0)
	{
		// It must be an AJAX request.
		if ( ! $this->input->is_ajax_request())
		{
			redirect('admin/menus/items/'.$id);
			exit;
		}

		// Process status.
		$status['status'] = false;

		// Make sure the menu exists.
		if ( ! $this->app->menus->get_menu($id))
		{
			echo json_encode($status);
			die();
		}

		// Attempt to update order.
		if ($this->app->menus->items_order($id, $this->input->post(null, true)))
		{
			$status['status'] = true;
		}

		// Return the process status.
		echo json_encode($status);
		die();
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit menus locations.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function locations()
	{
		// Get all locations and menus.
		$data['locations'] = $this->app->menus->get_locations();
		$data['menus']     = $this->app->menus->get_menus();
		$rules = array(
			'field' => 'menu_location[]',
			'label' => 'lang:menu_location',
			'rules' => 'required',
		);

		// Prepare form validation and rules.
		$this->prep_form(array($rules));


		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Add CSRF security.
			$data['hidden'] = null; //$this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('manage_locations'))
				->render($data);
		}
		// After the form is processed.
		else
		{
			// Collect data.
			$data = $this->input->post('menu_location', true);

			// Try to update menus locations.
			$status = $this->app->menus->set_menu_location($data);

			// Set alert message depending on the status.
			if ($status === true)
			{
				set_alert(lang('menu_location_success'), 'success');
			}
			else
			{
				set_alert(lang('menu_location_error'), 'error');
			}

			redirect('admin/menus/locations', 'refresh');
			exit;
		}
	}

}
