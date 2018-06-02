<?php
/**
 * Separated dashboard header.
 * @since 	2.1.2
 */
echo get_partial('admin_header');
?><main class="wrapper" role="main">
	<div class="container">
		<?php
		/**
		 * The alert is displayed outside the wraper.
		 * @since 	2.0.0
		 */
		the_alert();
		?>
		<div id="wrapper">
		<?php
		/**
		 * Fires at the top of page content.
		 * @since 	1.4.0
		 */
		do_action('admin_page_header');

		// Display the page content.
		the_content();

		/**
		 * Fires at the end of page content.
		 * @since 	1.4.0
		 */
		do_action('admin_page_footer');
		?>
		</div>
	</div>
</main>
<?php
/**
 * Separated dashboard footer.
 * @since 	2.1.2
 */
echo get_partial('admin_footer');
