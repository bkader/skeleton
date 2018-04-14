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
 * Cache Assets Plugin
 *
 * This plugins turns theme class assets cache on to reduce
 * HTTP requests and cache assets.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Plugins
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */

add_action('plugin_activate_cache-assets',        array('Cache_assets', 'activate'));	// Plugin activation.
add_action('plugin_deactivate_cache-assets',      array('Cache_assets', 'deactivate'));	// Plugin deactivation.
add_action('plugin_install_cache-assets',         array('Cache_assets', 'install'));	// Plugin enabled.
add_action('plugin_settings_cache-assets',        array('Cache_assets', 'settings'));	// Plugin settings page.

/**
 * Cache_assets Class.
 */
class Cache_assets
{
	/**
	 * Default assets cache time. Default: 48 hours.
	 * @var integer
	 */
	private static $cache_time = 172800;

	/**
	 * Whether to cache dashboard assets.
	 * @var boolean
	 */
	private static $cache_dashboard = false;

	/**
	 * Where to store cached assets.
	 * @var string
	 */
	private static $cache_folder = 'content/cache-assets/';

	/**
	 * Default dropdown array.
	 * @var array
	 */
	private static $time_dropdown = array(
		DAY_IN_SECONDS       => '1 day',
		(DAY_IN_SECONDS*2)   => '2 days',
		WEEK_IN_SECONDS      => '1 week',
		(WEEK_IN_SECONDS*2)  => '2 weeks',
		MONTH_IN_SECONDS     => '1 month',
		(MONTH_IN_SECONDS*2) => '2 months',
	);

	/**
	 * Dashboard cache options.
	 * @var array
	 */
	private static $dashboard_dropdown = array(
		'true' => 'lang:yes',
		'false' => 'lang:no',
	);

	// ------------------------------------------------------------------------

	/**
	 * This method is triggered upon plugin's activation.
	 * @access 	public
	 * @return 	boolean
	 */
	public static function activate()
	{
		global $KB;

		// Delete old keys first.
		self::deactivate();

		// We first check if the option is already set or not.
		$time_option = $KB->options->get('assets_cache_time');

		// Found? Make sure to format it well.
		if ($time_option)
		{
			// Array of data to update, just in case.
			$data = array();

			// Let's format few data.
			(is_numeric($time_option->value)) OR $data['value'] = self::$cache_time;

			// Check the field type.
			($time_option->field_type === 'dropdown') OR $data['field_type'] = 'dropdown';

			// Make sure available options is always an array.
			if ( ! is_array($time_option->options) OR empty($time_option->options))
			{
				$data['options'] = self::$time_dropdown;
			}

			// It must be required.
			($time_option->required == 1) OR $data['required'] = 1;

			// The data is not empty? Update the option.
			if ( ! empty($data))
			{
				return (bool) $KB->options->update('assets_cache_time', $data);
			}
		}
		// Not found? create it.
		else
		{
			$KB->options->create(array(
				'name'       => 'assets_cache_time',
				'value'      => self::$cache_time,
				'field_type' => 'dropdown',
				'options'    => self::$time_dropdown,
				'required'   => 1,
			));
		}

		// Dashboard cache option.
		$dashboard_option = $KB->options->get('assets_cache_dashboard');

		// Found? Make sure to format it well.
		if ($dashboard_option)
		{
			// Array of data to update, just in case.
			$data = array();

			// Let's format few data.
			(is_numeric($dashboard_option->value)) OR $data['value'] = self::$cache_dashboard;

			// Check the field type.
			($dashboard_option->field_type === 'dropdown') OR $data['field_type'] = 'dropdown';

			// Make sure available options is always an array.
			if ( ! is_array($dashboard_option->options) OR empty($dashboard_option->options))
			{
				$data['options'] = self::$dashboard_dropdown;
			}

			// It must be required.
			($dashboard_option->required == 1) OR $data['required'] = 1;

			// The data is not empty? Update the option.
			if ( ! empty($data))
			{
				return (bool) $KB->options->update('assets_cache_dashboard', $data);
			}
		}
		// Not found? create it.
		else
		{
			$KB->options->create(array(
				'name'       => 'assets_cache_dashboard',
				'value'      => self::$cache_dashboard ? 'true' : 'false',
				'field_type' => 'dropdown',
				'options'    => self::$dashboard_dropdown,
				'required'   => 1,
			));
		}

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get triggered upon plugin's deactivation.
	 * @access 	public
	 * @return 	boolean
	 */
	public static function deactivate()
	{
		global $KB;
		return $KB->options->delete_by('name', array('assets_cache_time', 'assets_cache_dashboard'));
	}

	// ------------------------------------------------------------------------

	/**
	 * This method is triggered if the the plugin is activated.
	 * @access 	public
	 * @return 	void
	 */
	public static function install()
	{
		// Check plugin translations if there are any.
		self::_check_translation();

		// Make sure the cache folder exists.
		if ( ! is_dir(FCPATH.self::$cache_folder))
		{
			mkdir(FCPATH.self::$cache_folder, 0777, true);
		}

		// We make sure the the cache folder is writable.
		if ( ! is_writable(FCPATH.self::$cache_folder))
		{
			if (is_controller('admin'))
			{
				set_alert(lang('assets_cache_writable'), 'error');
			}
			return;
		}

		global $KB;

		// Format options if not formatted.
		$db_time_option = $KB->options->item('assets_cache_time', false);
		$db_dash_option = $KB->options->item('assets_cache_dashboard', null);
		if (( ! $db_time_option OR ! is_numeric($db_time_option))
			OR ( ! $db_dash_option OR ! is_bool($db_dash_option)))
		{
			self::activate();
		}

		add_filter('print_styles', array('Cache_assets', 'cache_styles'));
		add_filter('print_scripts', array('Cache_assets', 'cache_scripts'));

		return true;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set plugin's update form validation rules.
	 * @access 	public
	 * @param 	array 	$rules 	Form validation rules.
	 * @return 	array
	 */
	public static function validate($rules = array())
	{
		// Add the assets cache time.
		$rules[] = array(
			'field' => 'assets_cache_time',
			'label' => 'lang:assets_cache_time',
			'rules' => 'required|in_list['.implode(',', array_keys(self::$time_dropdown)).']',
		);
		return $rules;
	}

	// ------------------------------------------------------------------------

	/**
	 * Plugin's settings page handles.
	 * @access 	public
	 * @return 	void
	 */
	public static function settings()
	{
		global $KB;
		// Load settings dependencies.
		self::_load_dependencies();

		// Before the form is submitted.
		if ($KB->ci->form_validation->run() == false)
		{
?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('', 'role="form"'); ?>
				<div class="form-group<?php echo form_error('assets_cache_time') ? ' has-error' : ''; ?>">
					<label for="assets_cache_time"><?php _e('assets_cache_time'); ?></label>
					<?php echo form_dropdown('assets_cache_time', self::$time_dropdown, self::_cache_time(), 'class="form-control" id="assets_cache_time"'); ?>
					<small class="help-block"><?php echo form_error('assets_cache_time') ?: lang('assets_cache_time_help'); ?></small>
				</div>

				<div class="form-group">
					<label for="assets_cache_dashboard"><?php _e('assets_cache_dashboard'); ?></label>
					<?php echo print_input(array(
						'type' => 'dropdown',
						'name' => 'assets_cache_dashboard',
						'options' => self::$dashboard_dropdown,
						'selected' => to_bool_or_serialize(self::_cache_dashboard()),
						'class' => 'form-control',
						)); ?>
					<small class="help-block"><?php echo form_error('assets_cache_dashboard') ?: lang('assets_cache_dashboard_help'); ?></small>
				</div>

				<button class="btn btn-primary btn-sm btn-block" type="submit"><?php _e('save_changes'); ?></button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php
		}
		// After the form is submitted.
		else
		{
			// Use Input class to secure POST.
			global $IN;
			$new_time = $IN->post('assets_cache_time', true);
			$new_dash = ($IN->post('assets_cache_dashboard') === 'true');

			// Successfully updated?
			if ( ! $KB->options->set_item('assets_cache_time', $new_time)
				&& ! $KB->options->set_item('assets_cache_dashboard', $new_dash))
			{
				set_alert(lang('spg_plugin_settings_error'), 'error');
			}

			set_alert(lang('spg_plugin_settings_success'), 'success');
			redirect(current_url(), 'refresh');
			exit;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the cache time.
	 * @return 	int
	 */
	private static function _cache_time()
	{
		global $KB;
		return $KB->options->item('assets_cache_time', self::$cache_time);
	}

	// ------------------------------------------------------------------------

	/**
	 * Whether to cache dashboard assets as well.
	 * @return 	boolean
	 */
	private static function _cache_dashboard()
	{
		global $KB;
		return $KB->options->item('assets_cache_dashboard', false);
	}

	// ------------------------------------------------------------------------

	/**
	 * If there are any translations, we make sure to load them.
	 * NOTE: The default language is loaded first.
	 * @access 	private
	 * @return 	void
	 */
	private static function _check_translation()
	{
		global $KB;

		// Hold the default language file for later use.
		$default = $KB->options->item('language');

		// Hold the current language file.
		$current = ($KB->ci->session->language)
			? $KB->ci->session->language
			: $KB->options->item('language');

		// Let's see if the default language file exists.
		$default_file = $KB->plugins->plugins_path('cache-assets/langs/'.$default.'.php');

		// The default language file found? load it.
		if (is_file($default_file))
		{
			include_once($default_file);

			// If the current language is different, load its file.
			$current_file = $KB->plugins->plugins_path('cache-assets/langs/'.$current.'.php');

			// The current language file found? load it.
			if (is_file($current_file))
			{
				include_once($current_file);
			}
		}

		// If any translation is found, merge it with global one.
		if (isset($lang))
		{
			$KB->ci->lang->language = array_replace_recursive($KB->ci->lang->language, $lang);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Simply load the form validation library and set rules.
	 * @access 	private
	 * @return 	void
	 */
	private static function _load_dependencies()
	{
		global $KB;
		$KB->ci->load->library('form_validation');
		$KB->ci->form_validation->set_rules(self::validate());
	}

	// ------------------------------------------------------------------------

	public static function cache_styles($args = null)
	{
		// Avoid caching admin panel.
		if (is_controller('admin') && ! self::_cache_dashboard())
		{
			return $args;
		}

		// We extract everything.
		extract($args);

		$cache_file = md5(ENVIRONMENT.config_item('theme').count($inline).implode(',', array_keys($styles)));
		$cache_file_path = FCPATH.self::$cache_folder.$cache_file.'.css';

		// Cache file found but dead? Delete it.
		if (is_file($cache_file_path)
			&& filemtime($cache_file_path) <= time() - self::_cache_time())
		{
			@unlink($cache_file_path);
		}

		// File not found? Cache it.
		if ( ! is_file($cache_file_path))
		{
			$_temp_output = '';
			foreach ($styles as $handle => $file)
			{
				// In-line style before it?
				if (isset($inline[$handle]))
				{
					$_temp_output .= str_replace(
						array('<style>', '</style>'),
						'',
						$inline[$handle]
					);
					unset($inline[$handle]);
				}

				if (false !== $file)
				{
					$_temp_output .= self::_load_asset($file['href']);
				}
			}
			if ( ! empty($inline))
			{
				$inline_css   = implode("\n\t", $inline);
				$_temp_output .= str_replace(array('<style>', '</style>'), '', $inline_css);
			}

			// We make sure to move all @imports to top.
	        if (preg_match_all('/(;?)(@import (?<url>url\()?(?P<quotes>["\']?).+?(?P=quotes)(?(url)\)))/', $_temp_output, $matches))
	        {
	            // remove from output
	            foreach ($matches[0] as $import)
	            {
	                $_temp_output = str_replace($import, '', $_temp_output);
	            }

	            // add to top
	            $_temp_output = implode(';', $matches[2]).';'.trim($_temp_output, ';');
	        }

			if ( ! isset($cache_file_path))
			{
				$cache_file_path = FCPATH.self::$cache_folder.$cache_file.'.css';
			}

			// Let's write the cache file.
			$cache_file_path = fopen($cache_file_path, 'w');
			fwrite($cache_file_path, self::_compress_css($_temp_output));
			fclose($cache_file_path);
		}

		return '<link rel="stylesheet" type="text/css" href="'.base_url(self::$cache_folder.$cache_file.'.css').'" />';
	}

	// ------------------------------------------------------------------------

	public static function cache_scripts($args = null)
	{
		// Avoid caching admin panel.
		if (is_controller('admin') && ! self::_cache_dashboard())
		{
			return $args;
		}

		// We extract everything.
		extract($args);

		$cache_file = md5(ENVIRONMENT.config_item('theme').count($inline).implode(',', array_keys($scripts)));
		$cache_file_path = FCPATH.self::$cache_folder.$cache_file.'.js';

		// Cache file found but dead? Delete it.
		if (is_file($cache_file_path)
			&& filemtime($cache_file_path) <= time() - self::_cache_time())
		{
			@unlink($cache_file_path);
		}

		// File not found? Cache it.
		if ( ! is_file($cache_file_path))
		{
			$_temp_output = '';
			foreach ($scripts as $handle => $file)
			{
				// In-line script before it?
				if (isset($inline[$handle]))
				{
					$_temp_output .= str_replace(
						array('<script>', '</script>'),
						'',
						$inline[$handle]
					);
					unset($inline[$handle]);
				}

				if (false !== $file)
				{
					$_temp_output .= self::_load_asset($file['src']);
				}
			}
			if ( ! empty($inline))
			{
				$inline_js    = implode("\n\t", $inline);
				$_temp_output .= str_replace(array('<script>', '</script>'), '', $inline_js);
			}

			if ( ! isset($cache_file_path))
			{
				$cache_file_path = FCPATH.self::$cache_folder.$cache_file.'.js';
			}

			// Let's write the cache file.
			$cache_file_path = fopen($cache_file_path, 'w');
			fwrite($cache_file_path, self::_compress_js($_temp_output));
			fclose($cache_file_path);
		}

		return '<script type="text/javascript" src="'.base_url(self::$cache_folder.$cache_file.'.js').'"></script>';
	}

	// ------------------------------------------------------------------------

	private static function _load_asset($file)
	{
		// Backup the file for later use.
		$old_file = $file;

		// Prepare an empty output.
		$output = '';

		// Make sure it's a full URL.
		if (filter_var($file, FILTER_VALIDATE_URL) === FALSE)
		{
			$file = theme_url($file);
		}

		/**
		 * NOTE:
		 * Commented lines below seem to cause problems on the demo
		 * this is why they have been commented out.
		 */

		// Check if the file exits first.
		// $found = false;
		// $file_headers = get_headers($file);
		// if (stripos($file_headers[0], '200 OK'))
		// {
		// 	$found = true;
		// }

		// // Not found? Return nothing.
		// if ($found === false)
		// {
		// 	return "/* Missing file: {$old_file} */";
		// }

		// Use cURL if enabled.
		if (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $file);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			$output .= curl_exec($curl);
			curl_close($curl);
		}
		// Otherwise, simply use file_get_contents.
		else
		{
			$output .= file_get_contents($file);
		}

		/**
		 * Remember, we have backed up the file right?
		 * The reason behind this it to set relative paths inside it.
		 * For instance, if an image or a fond is used in the CSS file,
		 * you might see something like this: url('../').
		 * Here we are simply replacing that relative path and use an
		 * absolute path so image or font don't get broken.
		 */
		if (pathinfo($file, PATHINFO_EXTENSION) === 'css'
			&& preg_match_all('/url\((["\']?)(.+?)\\1\)/i', $output, $matches, PREG_SET_ORDER))
		{
			$search  = array();
			$replace = array();

			$import_url = str_replace(array('http:', 'https:', basename($file)), '', $file);

			foreach ($matches as $match)
			{
				$count = substr_count($match[2], '../');
				$search[] = str_repeat('../', $count);
				$temp_import_url = $import_url;
				for ($i=1; $i <= $count; $i++) {
					$temp_import_url = str_replace(basename($temp_import_url), '', $temp_import_url);
				}
				$replace[] = rtrim($temp_import_url, '/').'/';
			}

			// Replace everything if the output.
			$output = str_replace(array_unique($search), array_unique($replace), $output);
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	private static function _compress_css($css = '')
	{
		// Striping C style comments and excess whitespace.
		$css = preg_replace(array("#/\*.*?\*/#s", "#\s\s+#"), '', $css);

		// Extra removal.
		$css = str_replace(
			array(
				": ",
				"; ",
				" {",
				" }",
				", ",
				"{ ",
				";}",	// Strip optional semicolons.
				",\n", 	// Don't wrap multiple selectors.
				"\n}",	// Don't wrap closing braces.
				"} ",	// Put each rule on it's own line.
			),
			array(
				":",
				";",
				"{",
				"}",
				",",
				"{",
				"}",
				",",
				"}",
				"}\n",
			),
			$css
		);

		// Remove all new lines and tabs.
		$css = str_replace(array("\n", "\r", "\t"), '', $css);

		// Add the auto-generated tag.
		$css = "/*! Cache Assets auto-generated file.\nCreated At: ".date('Y-m-d H:i:s')." */\n".$css;
		return trim($css);
	}

	// ------------------------------------------------------------------------

	private static function _compress_js($js = '')
	{
		return $js;
		include_once(__DIR__.'/inc/JShrink.php');
		$js = JShrink::minify($js, array(
			'flaggedComments' => false
		));
		$js = "/*! Cache Assets auto-generated file.\nCreated At: ".date('Y-m-d H:i:s')." */\n".$js;
		return $js;
	}

	// ------------------------------------------------------------------------

	private static function _delete_cache()
	{
		return true;
	}

}
