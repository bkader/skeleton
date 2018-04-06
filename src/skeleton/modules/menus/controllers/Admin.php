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
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Added AJAX methods and changes language file name.
	 * 
	 * @return 	void
	 */
	public function __construct()
	{
		// Add AJAX methods.
		array_unshift($this->ajax_methods, 'delete', 'update_order');
		parent::__construct();

		// Make sure to load menus language file.
		$this->load->language('menus/menus');
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
			->set_title(lang('manage_menus'))
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
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten for better code.
	 * 
	 * @access 	public
	 * @param 	string 	$target 	menu or item.
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function edit($target, $id = 0)
	{
		switch ($target) {
			case 'menu':
				return $this->_edit_menu($id);
				break;
			case 'item':
				return $this->_edit_item($id);
				break;
		}

		// Otherwise, nothing!
		show_404();
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
			set_alert(lang('edit_menu_no_menu'), 'error');
			redirect('admin/menus');
			exit;
		}

		// Get all menu items.
		$data['items'] = $this->kbcore->menus->get_menu_items($id);

		// Load jquery UI and prepare sortable list IF there are items.
		if ($data['items'])
		{
			$this->add_sortable_list(
				'#save-menu',
				'#sortable',
				admin_url('menus/update_order/'.$id),
				lang('menu_structure_success'),
				lang('menu_structure_error')
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
			'label' => 'lang:menu_location',
			'rules' => 'required',
		)));


		// Before the form is processed.
		if ($this->form_validation->run() == false)
		{
			// Add CSRF security.
			$data['hidden'] = $this->create_csrf();

			// Set page title and render view.
			$this->theme
				->set_title(lang('manage_locations'))
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

	// ------------------------------------------------------------------------
	// Ajax Methods.
	// ------------------------------------------------------------------------

	/**
	 * Delete action handle.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.0 	Rewritten to do the same as "edit" method.
	 * 
	 * @access 	public
	 * @param 	string 	$target 	menu or item.
	 * @param 	int 	$id
	 * @return 	void
	 */
	public function delete($target, $id = 0)
	{
		switch ($target) {
			case 'menu':
				return $this->_delete_menu($id);
				break;
			case 'item':
				return $this->_delete_item($id);
				break;
		}

		// Return nothing.
		return;
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
		// Process status.
		$status['status'] = false;

		// Make sure the menu exists.
		if ( ! $this->kbcore->menus->get_menu($id))
		{
			echo json_encode($status);
			die();
		}

		// Attempt to update order.
		if ($this->kbcore->menus->items_order($id, $this->input->post(null, true)))
		{
			$status['status'] = true;
		}

		// Return the process status.
		echo json_encode($status);
		die();
	}

	// ------------------------------------------------------------------------
	// Private Methods
	// ------------------------------------------------------------------------

	/**
	 * Edit an existing menu.
	 * @access 	public
	 * @param 	int 	$id 	The menu's ID.
	 * @return  void
	 */
	private function _edit_menu($id = 0)
	{
		// Get the menu from database.
		$data['menu'] = $this->kbcore->menus->get_menu($id);
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
		if ($this->input->post('username')
			&& $this->input->post('username') <> $data['menu']->username) {
			$rules[] = array(
				'field' => 'username',
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
			$status = $this->kbcore->menus->update_menu(
				$id,
				$this->input->post('name', true),
				$this->input->post('description', true),
				$this->input->post('username', true)
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
	 * Edit an existing menu item.
	 * @access 	public
	 * @param 	int 	$id 	The menu item's ID.
	 * @return  void
	 */
	private function _edit_item($id = 0)
	{
		// Get the menu from database.
		$data['item'] = $this->kbcore->menus->get_item($id);
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
				// Set alert and redirect back.
				set_alert(lang('error_csrf'), 'error');
				redirect('admin/menus/items/'.$data['item']->owner_id, 'refresh');
				exit;
			}

			// Let's collect attributes first.
			$attrs = $this->input->post('attrs', true);
			if ($this->input->post('attrs[target]') == '1')
			{
				$attrs['target'] = '_blank';
			}

			// Proceed.
			$status = $this->kbcore->menus->update_item(
				$id,
				$this->input->post('name', true),
				$this->input->post('href', true),
				$this->input->post('description', true),
				array_filter($attrs) // No array_filter here to override.
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
			redirect('admin/menus/items/'.$data['item']->owner_id, 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting a menu with AJAX request.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	private
	 * @param 	mixed 	$id 	The menu's ID or slug.
	 * @return 	void
	 */
	private function _delete_menu($id)
	{
		// Attempt to delete the menu.
		if (true === $this->kbcore->menus->delete_menu($id))
		{
			$this->response->header = 200;
			$this->response->message = 'Fuckit';
		}
		else
		{
			$this->response->header = 406;
			$this->response->message = 'Fuckit';
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for deleting a menu item.
	 *
	 * @since 	1.3.0
	 *
	 * @access 	private
	 * @param 	int 	$id 	The item's ID.
	 * @return 	void
	 */
	private function _delete_item($id)
	{
		// Attempt to delete the menu.
		if (true === $this->kbcore->menus->delete_item($id))
		{
			$this->response->header = 200;
			$this->response->message = 'Fuckit';
		}
		else
		{
			$this->response->header = 406;
			$this->response->message = 'Fuckit';
		}
	}

}
