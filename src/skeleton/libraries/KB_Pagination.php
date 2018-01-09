<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Pagination Class
 *
 * We are extending CodeIgniter pagination library so we
 * can use our hooks system and filters some of configuration
 * parameters before passing them back to the parent.
 *
 * @package 	CodeIgniter
 * @subpackage 	Libraries
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class KB_Pagination extends CI_Pagination
{
	/**
	 * Class constructor
	 * @return 	void
	 */
	public function __construct($params = array())
	{
		// We first the filter only if there is one.
		if (has_filter('pagination'))
		{
			// List of elements that accept the 'pagination' filter.
			$filterable_params = array(
				'full_tag_open',
				'full_tag_close',
				'num_links',
				'prev_tag_open',
				'prev_tag_close',
				'next_tag_open',
				'next_tag_close',
				'cur_tag_open',
				'cur_tag_close',
				'num_tag_open',
				'num_tag_close',
			);

			// Create the array of filtered params.
			$filtered_params = array_intersect_key($params, array_flip($filterable_params));

			// Fire pagination filter.
			$filtered_params = apply_filters('pagination', $filtered_params);

			// For security, we remove any added parm.
			foreach ($filtered_params as $key => $param)
			{
				if ( ! in_array($key, $filterable_params))
				{
					unset($filtered_params[$key]);
				}
			}

			// Merge all params.
			$params = array_merge($params, $filtered_params);
		}

		// Now we let the parent do the rest.
		parent::__construct($params);
	}

}
