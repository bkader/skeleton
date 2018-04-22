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
	 * Class constructor
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		// We add translations lines to head.
		add_filter('admin_head', array($this, '_admin_head'));

		$this->scripts[] = 'activities';
	}

	// ------------------------------------------------------------------------

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
		if ($activities)
		{
			foreach ($activities as &$activity)
			{
				// User anchor
				if (false !== $activity->user)
				{
					$activity->user_anchor = admin_anchor(
						'activities?user='.$activity->user_id.(isset($get['module']) ? '&module='.$get['module'] : ''),
						$activity->user->full_name
					);
				}

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

				// Does the activity have a translation?
				$string = $activity->activity;
				if (0 === strpos($string, 'lang:'))
				{
					// we remove the "lang:" part first.
					$string = str_replace('lang:', '', $string);

					// Does it need arguments passed?
					if (false !== strpos($string, '::'))
					{
						$exp    = explode('::', $string);
						$line   = lang(array_shift($exp));
						$string = vsprintf($line, $exp);
					}
					else
					{
						$string = lang($string);
					}
				}
				$activity->activity = $string;
			}
		}

		// Add activities to view.
		$data['activities'] = $activities;

		// Set page title and render view.
		$this->theme
			->set_title(lang('sac_activity_log'))
			->render($data);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Add the head part to output.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function _admin_head($output)
	{
		$lines['delete'] = lang('sac_activity_delete_confirm');
		$output .= '<script type="text/javascript">';
		$output .= 'csk.i18n = csk.i18n || {};';
		$output .= ' csk.i18n.activities = '.json_encode($lines).';';
		$output .= '</script>';
		return $output;
	}

}
