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
 * Site Title Plugin
 *
 * This is a another example plugin that demonstrate the plugins system.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Plugins
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

// Action to do after plugin's activation.
add_action('plugin_activate_the-title', function() {
	return true;
});

// Action to do after plugin's deactivation.
add_action('plugin_deactivate_the-title', function() {
	return true;
});

// Action to do if the plugin is used.
add_action('plugin_install_the-title', 'pages_title_add_site_name');

/**
 * Adding site name to pages title.
 * @param 	none
 * @return 	void.
 */
function pages_title_add_site_name()
{
	// We simply apply the filter.
	add_filter('the_title', function($title)
	{
		// We only add the site name if not detected.
		$site_name = config_item('site_name');
		if (strpos($title, $site_name) === false)
		{
			$title .= ' &#150; '.config_item('site_name');
		}
		return $title;
	});
}

add_filter('plugin_settings_the-title', 'the_title_settings');

if ( ! function_exists('the_title_settings'))
{
	function the_title_settings($content)
	{
		$content .=<<<EOT
<div class="panel panel-default">
	<div class="panel-body">
		<h4 class="page-header">The Title Plugin Settings</h4>
		<p>The content you see on this page is found within this plugins main file <strong>the-title.php</strong>. Look for a function called <strong>the_title_settings</strong></p>

		<h4>How to create settings page for a plugin?</h4>
		<p>Easy! Simply add a new filter with your plugin's folder name, like so:</p>
		<pre><code>// Here I am using this plugin's folder name, "the-title".<br />add_filter('plugin_settings_<strong>the-title</strong>', function(\$content) {<br />&nbsp;&nbsp;&nbsp;&nbsp;\$content .= '&lt;h1&gt;Hell There&lt;/h1&gt;';<br/>&nbsp;&nbsp;&nbsp;&nbsp;return \$content;<br />});</code></pre><br />
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem voluptas pariatur necessitatibus quod porro amet libero molestias hic debitis commodi quos doloribus reprehenderit sequi, recusandae, voluptatem aut dolores voluptate in!</p>
	</div>
</div>
EOT;
		return $content;
	}
}
