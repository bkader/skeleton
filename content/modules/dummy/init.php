<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This action adds an alert to dashboard to invite the user to 
 * delete this dummy module, it's not needed.
 */
add_action('admin_page_header', function() {
	if ( ! function_exists('gettext_instance')) {
	  $message = <<<EOT
	The <strong>Dummy Module</strong> is kept to fill dashboard with dummy content, but also to show you how you can add content to it.
	Action: <code>admin_page_header</code>, so this content is visible at the top of all dashboard pages.
EOT;
	} else {
		$message = __('The <strong>Dummy Module</strong> is kept to fill dashboard with dummy content, but also to show you how you can add content to it.', 'dummy')."<br />";
		$message .= __('Action: <code>admin_page_header</code>, so this content is visible at the top of all dashboard pages.', 'dummy');
	}
	print_alert(nl2br($message), 'warning');
});

// ------------------------------------------------------------------------

/**
 * Add content to the top of dashboard main page.
 * @since 	2.1.0
 */
add_action('admin_index_header', function() {
	if ( ! function_exists('gettext_instance')) {
		$heading = '<strong>Remove this page\'s dummy content.</strong><br />';
		$message = <<<EOT
	The <code>dummy module</code> displays dummy content on the dashboard. Make sure to delete it on production mode.<br />
	Action: <code>admin_index_header</code>, so this alert is only visible on dashboard main page.
EOT;
	} else {
		$heading = '<strong>'.__('Remove this page\'s dummy content.', 'dummy').'</strong><br >';
		$message = __('The <code>dummy module</code> displays dummy content on the dashboard. Make sure to delete it on production mode.<br />Action: <code>admin_index_header</code>, so this alert is only visible on dashboard main page.', 'dummy');
	}
	print_alert($heading.$message, 'info');
});

// ------------------------------------------------------------------------

/**
 * This how you can add a content to the dashboard main page.
 * @since 	2.1.0
 */
add_action('admin_index_content', function() {
	get_instance()->load->view('dummy/index');
});

// ------------------------------------------------------------------------

/**
 * Display a simple "manifest.json" content in the footer.
 * @since 	2.1.0
 */
add_action('admin_index_footer', function() {
	$content = <<<EOT
<pre style="background:#f1f1f1;color:#000">{  
  <span style="color:#c03030">"name"</span>:<span style="color:#c03030">"Media Manager"</span>,
  <span style="color:#c03030">"module_uri"</span>:<span style="color:#c03030">"https://goo.gl/G26BTB"</span>,
  <span style="color:#c03030">"description"</span>:<span style="color:#c03030">"The Media Manager is a tool for uploading or deleting media on your CodeIgniter Skeleton application. Tools included are: upload new file(s), updating file(s) details and deleting file(s)."</span>,
  <span style="color:#c03030">"version"</span>:<span style="color:#c03030">"1.0.0"</span>,
  <span style="color:#c03030">"license"</span>:<span style="color:#c03030">"MIT"</span>,
  <span style="color:#c03030">"license_uri"</span>:<span style="color:#c03030">"http://opensource.org/licenses/MIT"</span>,
  <span style="color:#c03030">"author"</span>:<span style="color:#c03030">"Kader Bouyakoub"</span>,
  <span style="color:#c03030">"author_uri"</span>:<span style="color:#c03030">"https://goo.gl/wGXHO9"</span>,
  <span style="color:#c03030">"author_email"</span>:<span style="color:#c03030">"bkade@mail.com"</span>,
  <span style="color:#c03030">"tags"</span>:<span style="color:#c03030">"csk, codeigniter, skeleton, media, library"</span>,
  <span style="color:#c03030">"translations"</span>:{  
    <span style="color:#c03030">"french"</span>:{  
      <span style="color:#c03030">"name"</span>:<span style="color:#c03030">"Gestionnaire des médias"</span>,
      <span style="color:#c03030">"description"</span>:<span style="color:#c03030">"Le Gestionnaire de médias est un outil pour télécharger ou supprimer des médias sur votre application CodeIgniter Skeleton. Les fonctionnalités incluses sont: télécharger de nouveaux fichiers, mettre à jour les détails des fichiers et supprimer les fichiers."</span>,
      <span style="color:#c03030">"admin_menu"</span>:<span style="color:#c03030">"Médias"</span>
    },
    <span style="color:#c03030">"arabic"</span>:{  
      <span style="color:#c03030">"name"</span>:<span style="color:#c03030">"إدارة الوسائط"</span>,
      <span style="color:#c03030">"description"</span>:<span style="color:#c03030">"يعد موديل إدارة الوسائط أداة لتحميل أو حذف الوسائط على تطبيق كوديجنتر سكلتون الخاص بك. الأدوات المضمنة هي: تحميل ملف (ملفات) جديد(ة)، تحديث تفاصيل الملف (الملفات) وحذف الملف (الملفات)."</span>,
      <span style="color:#c03030">"admin_menu"</span>:<span style="color:#c03030">"الوسائط"</span>
    }
  }
}
</pre>
EOT;
	echo $content;
});

// ------------------------------------------------------------------------

/**
 * If you want to add an info panel just like ones use to display
 * users, themes, plugins or languages count, you can use the
 * "admin_index_stats" action where you echo the info-box element.
 * @see 	the example below and try to follow it.
 * @since 	2.1.0
 */
add_action('admin_index_stats', function() {
	$output = '<div class="col-xs-6 col-sm-6 col-md-3" rel="tooltip" title="Added by Dummy Module">';
	$output .= info_box(
		1235,
		'Dummy Stuff',
		'smile-o',
		'javascript:void(0)',
		'olive'
	);
	$output .= '</div>';

	echo $output;
}, 99);
