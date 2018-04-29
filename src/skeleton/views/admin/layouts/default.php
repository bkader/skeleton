<nav class="navbar navbar-default navbar-fixed-top navbar-admin">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle sidebar-toggle">
				<span class="sr-only">Sidebar</span>
				<i class="fa fa-toggle-right"></i>
			</button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Menu</span>
				<i class="fa fa-bars"></i>
			</button>
			<?php
			/**
			 * Apply filter on the displayed brand on dashboard.
			 * @since 	1.4.0
			 */
			$brand = apply_filters('admin_logo', get_option('site_name', 'Skeleton'));
			echo admin_anchor('', $brand, 'class="navbar-brand"');
			?>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<?php
			/**
			 * Fires on the left secion of the admin navbar.
			 * @since 	1.4.0
			 */
			do_action('admin_navbar');
			?>
			<ul class="nav navbar-nav navbar-right">
				<?php
				/**
				 * Fires on the right section of the admin navbar.
				 * @since 	1.4.0
				 */
				do_action('admin_navbar_right');

				// Display languages dropdown menu.
				if (isset($site_languages) && count($site_languages) >= 1):
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $current_language['name']; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php foreach($site_languages as $folder => $lang): ?>
						<li><a href="<?php echo site_url('language/change/'.$folder); ?>"><small class="text-muted pull-right"><?php echo $lang['name']; ?></small><?php echo $lang['name_en']; ?></a></li>
					<?php endforeach; unset($folder, $lang); ?>
					</ul>
				</li>
			<?php endif; ?>
				<li><?php echo anchor('', lang('view_site')) ?></li>
				<li class="user-menu dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $c_user->first_name; ?><?php echo user_avatar(24, $c_user->id, 'class="img-circle"'); ?></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo admin_url('users/edit/'.$c_user->id); ?>"><?php _e('edit_profile'); ?></a></li>
						<?php
						/**
						 * Fires inside admin users menu.
						 * @since 	1.4.0
						 */
						do_action('admin_user_menu');
						?>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><?php _e('logout'); ?></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="csk-wrap">
	<aside class="csk-sidebar" id="csk-sidebar" role="complementay">
		<?php
		/**
		 * Fires before the admin sidebar menu.
		 * @since 	1.4.0
		 */
		do_action('before_admin_menu');
		?>
		<ul class="nav nav-sidebar">
			<li<?php echo (get_the_module() == null) ? ' class="active"' : '' ?>><?php echo admin_anchor('', lang('dashboard')) ?></li>
			<?php
			/**
			 * Fires inside the admin menu.
			 * Useful if you want to add links.
			 * @since 	1.4.0
			 */
			do_action('admin_menu');
			?>
		</ul>
		<?php
		/**
		 * Fires after the admin sidebar menu.
		 * @since 	1.4.0
		 */
		do_action('after_admin_menu');
		?>
	</aside>

	<main class="wrapper" id="wrapper" role="main">
		<div class="container-fluid">
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
			<div class="footer clearfix" id="kbfooter" role="contentinfo">
				<?php
				/**
				 * Fires right after the opening tag of the admin footer.
				 * @since 	1.4.0
				 */
				do_action('in_admin_footer');
				?>
				<span class="text-muted" id="footer-thankyou">
					<?php
					$thankyou = sprintf(line('admin_footer_text'), 'https://goo.gl/jb4nQC');
					/**
					 * Filters the "Thank you" text displayed in the admin footer.
					 * @since 	1.3.3
					 */
					echo apply_filters('admin_footer_text', $thankyou);
					?>
				</span>
				<span class="text-muted pull-right" id="footer-upgrade">
					<?php
					$version = sprintf(line('admin_version_text'), KB_VERSION);
					/**
					 * Filters the version text displayed in the admin footer.
					 * @since 	1.4.0
					 */
					echo apply_filters('admin_version_text', $version);
					?>
				</span>
			</div>
		</div>
	</main>
</div><!--/.csk-wrap-->



<?php the_alert(); ?>
