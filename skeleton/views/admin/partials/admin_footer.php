<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fires at the end of page content.
 * @since 	1.4.0
 */
do_action('admin_page_footer');
?>
		</div>
	</div>
</main>
<footer class="footer" id="footer" role="contactinfo">
	<div class="container">
		<?php
		/**
		 * Fires right after the opening tag of the admin footer.
		 * @since 	1.4.0
		 */
		do_action('in_admin_footer');

		/**
		 * Filters the "Thank you" text displayed in the dashboard footer.
		 * @since 	1.3.3
		 * This line can be removed/overridden using the "admin_footer_text".
		 */
		$thankyou = sprintf(__('CSK_ADMIN_FOOTER_TEXT'), 'https://goo.gl/jb4nQC');
		$thankyou = apply_filters('admin_footer_text', $thankyou);
		if ( ! empty($thankyou))
		{
			echo html_tag('span', array(
				'class' => 'text-muted',
				'id'    => 'footer-thankyou',
			), $thankyou);
		}

		/**
		 * Footer version text.
		 * @since 	1.4.0
		 * Can be removed or overridden using the "admin_version_text" fitler.
		 */
		$version = sprintf(__('CSK_ADMIN_VERSION_TEXT'), KB_VERSION);
		$version = apply_filters('admin_version_text', $version);
		if ( ! empty($version))
		{
			echo html_tag('span', array(
				'class' => 'text-muted pull-right',
				'id'    => 'footer-upgrade',
			), $version);
		}
		?>
	</div>
</footer>
<script type="text/x-handlebars-template" id="csk-alert-template"><?php
echo html_tag('div', array(
	'class' => 'alert alert-{{type}} alert-dismissible fade show',
	'role'  => 'alert',
	'id'    => 'csk-alert',
), '{{{message}}}'.html_tag('button', array(
	'type'         => 'button',
	'class'        => 'close',
	'data-dismiss' => 'alert',
	'aria-label'   => __('CSK_BTN_CLOSE'),
), html_tag('span', array(
	'aria-hidden' => 'true',
), '&times;')));
?></script>
