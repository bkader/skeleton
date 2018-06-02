<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Separated dashboard header.
 * @since 	2.1.2
 */
echo get_partial('admin_header');

// Display the page content.
the_content();

/**
 * Separated dashboard footer.
 * @since 	2.1.2
 */
echo get_partial('admin_footer');
