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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities Module - Admin Controller
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Controllers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.3
 * @version 	2.0.0
 */
class Reports extends Reports_Controller
{
	/**
	 * List reports.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		parse_str($_SERVER['QUERY_STRING'], $get);

		// Hold our back link.
		$this->data['back_anchor'] = null;
		if ( ! empty($get))
		{
			$this->load->helper('security');
			$this->data['back_anchor'] = admin_anchor('reports', line('back'), array(
				'class' => 'btn btn-default btn-sm pull-right'
			));
		}

		// Custom $_GET appended to pagination links and WHERE clause.
		$_get  = null;
		$where = null;
		
		// Filtering by module, controller or method?
		foreach (array('module', 'controller', 'method') as $filter)
		{
			if (isset($get[$filter]))
			{
				$_get[$filter]  = $get[$filter];
				$where[$filter] = strval(xss_clean($get[$filter]));
			}
		}

		// We cannot search by method :D.
		if (isset($where['method']) 
			&& ( ! isset($where['controller']) OR empty($where['controller'])))
		{
			unset($where['method']);
		}

		// Filtering by user ID?
		if (isset($get['user']))
		{
			$_get['user']     = $get['user'];
			$where['user_id'] = intval(xss_clean($get['user']));
		}

		// Build the query appended to pagination links.
		(empty($_get)) OR $_get = '?'.http_build_query($_get);
		
		// Load pagination library and set configuration.
		$this->load->library('pagination');
		$config['base_url'] = $config['first_ul'] = admin_url('reports'.$_get);
		$config['per_page'] = $this->config->item('per_page');

		// Count total rows.
		$config['total_rows'] = $this->kbcore->activities->count($where);

		// Initialize pagination.
		$this->pagination->initialize($config);

		// Create pagination links.
		$this->data['pagination'] = $this->pagination->create_links();

		// Prepare the offset and limit users to get reports.
		$limit  = $config['per_page'];
		$offset = (isset($get['page'])) ? $config['per_page'] * ($get['page'] - 1) : 0;

		// Retrieve reports.
		$reports = $this->kbcore->activities->get_many($where, null, $limit, $offset);

		// Loop through reports to complete data.
		if ($reports)
		{
			foreach ($reports as &$report)
			{
				// User anchor
				if (false !== $report->user)
				{
					$report->user_anchor = admin_anchor(
						'reports?user='.$report->user_id.(isset($get['module']) ? '&module='.$get['module'] : ''),
						$report->user->full_name
					);
				}

				// Module anchor
				$report->module_anchor = '';
				if ( ! empty($report->module))
				{
					$report->module_anchor = html_tag('a', array(
						'href' => admin_url('reports/'.$report->module),
						'class' => 'btn btn-default btn-xs btn-icon',
					), fa_icon('link').$report->module);
				}

				// Controller anchor
				$report->controller_anchor = '';
				if ( ! empty($report->controller))
				{
					$controller_url = (empty($report->module))
						? admin_url('reports?controller='.$report->controller)
						: admin_url("reports/{$report->module}?controller={$report->controller}");
					$report->controller_anchor = html_tag('a', array(
						'href' => $controller_url,
						'class' => 'btn btn-default btn-xs btn-icon',
					), fa_icon('link').$report->controller);
				}

				// Method anchor
				$report->method_anchor = '';
				if ( ! empty($report->method))
				{
					if ( ! empty($report->module))
					{
						$method_url = (empty($report->controller))
							? admin_url("reports/{$report->module}?method=$report->method")
							: admin_url("reports/{$report->module}?controller={$report->controller}&method={$report->method}");
					}
					else
					{
						$method_url = (empty($report->controller))
							? admin_url('reports?method='.$report->method)
							: admin_url("reports?controller={$report->controller}&method={$report->method}");
					}
					$report->method_anchor = html_tag('a', array(
						'href' => $method_url,
						'class' => 'btn btn-default btn-xs btn-icon',
						'rel' => 'tooltip',
						'title' => $report->activity,
					), fa_icon('info-circle').$report->method);
				}

				// IP location link.
				$report->ip_address = anchor(
					'https://www.iptolocation.net/trace-'.$report->ip_address,
					$report->ip_address,
					'target="_blank"'
				);
			}
		}

		// Add reports to view.
		$this->data['reports'] = $reports;

		// Set page title and render view.
		$this->theme
			->set_title(line('CSK_REPORTS_ACTIVITY_LOG'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Admin subheading.
	 * @access 	protected
	 * @param 	none
	 * @return	 void
	 */
	public function _subhead()
	{
		// We add the back button only if there are $_GET params.
		empty($_GET) OR add_action('admin_subhead', function() {
			$this->_btn_back('reports');
		});
	}

}
