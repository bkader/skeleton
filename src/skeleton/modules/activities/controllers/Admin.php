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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */
class Admin extends Admin_Controller
{
	/**
	 * Array of method that accept only AJAX requests.
	 * @var array
	 */
	protected $ajax_methods = array('delete');

	/**
	 * List activities.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		// We hold $_GET parameters to build our URLs.
		parse_str($_SERVER['QUERY_STRING'], $get);

		// Hold our back link.
		$data['back_anchor'] = (empty($get))
			? null
			: admin_anchor('activities', lang('back'), 'class="btn btn-default btn-sm pull-right"');

		// Custom $_GET appended to pagination links and WHERE clause.
		$_get  = null;
		$where = null;
		(isset($get['user'])) && $_get['user'] = $where['user_id'] = $get['user'];
		(isset($get['module'])) && $_get['module'] = $where['module'] = $get['module'];

		// Build the query appended to pagination links.
		(empty($_get)) OR $_get = '?'.http_build_query($_get);
		
		// Load pagination library and set configuration.
		$this->load->library('pagination');
		$config['base_url'] = $config['first_ul'] = admin_url('activities'.$_get);
		$config['per_page'] = $this->config->item('per_page');

		// Count total rows.
		$config['total_rows'] = $this->kbcore->activities->count($where);

		// Initialize pagination.
		$this->pagination->initialize($config);

		// Create pagination links.
		$data['pagination'] = $this->pagination->create_links();

		// Prepare the offset and limit users to get activities.
		$limit  = $config['per_page'];
		$offset = (isset($get['page'])) ? $config['per_page'] * ($get['page'] - 1) : 0;

		// Retrieve activities.
		$activities = $this->kbcore->activities->get_many($where, null, $limit, $offset);

		// Loop through activities to complete data.
		foreach ($activities as &$activity)
		{
			// User anchor
			$activity->user_anchor = admin_anchor(
				'activities?user='.$activity->user_id.(isset($get['module']) ? '&module='.$get['module'] : ''),
				$activity->user->full_name
			);

			// Module anchor
			$activity->module_anchor = '';
			if ( ! empty($activity->module))
			{
				$activity->module_anchor = admin_anchor(
					'activities?'.(isset($get['user']) ? 'user='.$get['user'].'&' : '').'module='.$activity->module,
					$activity->module
				);
			}

			// IP location link.
			$activity->ip_address = anchor(
				'https://www.iptolocation.net/trace-'.$activity->ip_address,
				$activity->ip_address,
				'target="_blank"'
			);
		}

		// Add activities to view.
		$data['activities'] = $activities;

		// Set page title and render view.
		$this->theme
			->set_title(lang('activities_log'))
			->add_inline('js', $this->_delete_script())
			->render($data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete the selected activity.
	 * @access 	public
	 * @param 	int 	$id 	The activity's ID.
	 * @return 	void
	 */
	public function delete($id = 0)
	{
		// We proceed only if the $id is provided and the activity is deleted.
		if ($id > 0 && $this->kbcore->activities->delete($id))
		{
			$this->response->header  = 200;
			$this->response->message = lang('delete_activity_success');
		}
		else
		{
			$this->response->header = 406;
			$this->response->message = lang('delete_activity_error');
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Print the delete activity script.
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	private function _delete_script()
	{
		// Confirmation message and current URL.
		$confirm     = lang('delete_activity_confirm');
		$current_url = current_url();

		// Build our script.
		$output = <<<EOT

<script type="text/javascript">
jQuery(document).on("click", ".delete-activity", function (e) {
	e.preventDefault();
	var that = jQuery(this),
		href = that.attr("data-href"),
		id   = that.attr("data-id"),
		row  = jQuery("#activity-" + id);
	if (id.length && href.length && confirm("{$confirm}")) {
		jQuery.get(href, function (response, textStatus) {
			if (textStatus == "success") {
				toastr.success(response);
				row.animate({opacity: 0}, function () {
                    jQuery("#wrapper").load("{$current_url} #wrapper > *", function () {
                    	row.remove();
                    });
				});
			} else {
				toastr.error(response);
			}
		});
	}
	return false;
});
</script>
EOT;
		// We return the final output.
		return $output;
	}

}
