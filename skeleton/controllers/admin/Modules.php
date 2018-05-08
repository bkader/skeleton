<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends Admin_Controller {

	/**
	 * index
	 *
	 * List all available modules.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function index()
	{
		$modules = $this->router->list_modules(true);

		foreach ($modules as $folder => &$m)
		{
			// Add module actions.
			$m['actions'] = array();
			$action = (true === $m['enabled']) ? 'disable' : 'enable';
			$m['actions'][] = nonce_admin_anchor(
				"modules/{$action}/{$folder}",
				"{$action}-module_{$folder}",
				line($action),
				array(
					'class'       => "module-{$action}",
					'data-module' => $folder,
				)
			);
			if (true === $m['has_settings'])
			{
				$m['actions'][] = html_tag('a', array(
					'href' => admin_url('settings/'.$folder)
				), line('settings'));
			}
			if (true !== $m['enabled'])
			{
				$m['actions'][] = nonce_admin_anchor(
					"modules/delete/{$folder}",
					"delete-module_{$folder}",
					line('delete'),
					'class="text-danger module-delete"'
				);
			}

			// Module details.
			$details = array();

			if ( ! empty($m['version'])) {
				$details[] = sprintf(line('version_num'), $m['version']);
			}
			if ( ! empty($m['author'])) {
				$author = (empty($m['author_uri'])) 
					? $m['author'] 
					: sprintf(line('anchor_tmp'), $m['author'], $m['author_uri']);
				$details[] = sprintf(line('author_name'), $author);
			}
			if ( ! empty($m['license'])) {
				$license = empty($m['license_uri'])
					? $m['license']
					: sprintf(line('anchor_tmp'), $m['license'], $m['license_uri']);
				$details[] = sprintf(line('license_name'), $license);
				// Reset license.
				$license = null;
			}
			if ( ! empty($m['plugin_uri'])) {
				$details[] = html_tag('a', array(
					'href'   => $m['plugin_uri'],
					'target' => '_blank',
					'rel'    => 'nofollow',
				), line('website'));
			}
			if ( ! empty($m['author_email'])) {
				$details[] = html_tag('a', array(
					'href'   => "mainto:{$m['author_email']}?subject=".rawurlencode("Support: {$m['name']}"),
					'target' => '_blank',
				), line('support'));
			}

			$m['details'] = $details;
		}

		$this->data['modules'] = $modules;
		$this->theme
			->set_title(line('modules'))
			->render($this->data);
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * _subhead
	 *
	 * Display admin subhead section.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	protected function _subhead()
	{
		$this->data['page_icon']  = 'cubes';
		$this->data['page_title'] = line('modules');
		$this->data['page_donate']  = 'https://goo.gl/jb4nQC';
		$this->data['page_help']  = 'https://goo.gl/jb4nQC';

		if ('install' === $this->router->fetch_method())
		{
			//
		}
		else
		{
			add_action('admin_subhead', function() {
				echo html_tag('a', array(
					'href'  => admin_url('modules/install'),
					'class' => 'btn btn-primary btn-sm btn-icon',
				), fa_icon('upload').line('module_add'));
			});
		}
	}

}
