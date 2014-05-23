<?php
/**
 *
 * Silverclean WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013 Mathieu Sarrasin - Iceable Media
 *
 * 404 Page Template
 *
 */
?>

<?php get_header(); 

	if ( get_custom_header()->url ) :
?>
	<div id="header-image" class="container">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	</div>
	
<?php endif; ?>

	<div class="container" id="main-content">

		<div id="page-container" class="left with-sidebar">

			<div <?php post_class(); ?>>
				<h1 class="page-title"><?php _e('404', 'silverclean'); ?></h1>

				<h2><?php _e('Page Not Found', 'silverclean'); ?></h2>
				<p><?php _e('What you are looking for isn\'t here...', 'silverclean'); ?></p>
				<p><?php _e('Maybe a search will help ?', 'silverclean'); ?></p>
				<?php get_search_form(); ?>
				
			</div>

		</div>
		<!-- End page container -->

		<div id="sidebar-container" class="right">
			<ul id="sidebar">
			   <?php dynamic_sidebar( 'sidebar' ); ?>
			</ul>
		</div><!-- End sidebar -->

	</div>
	<!-- End main content -->
<?php get_footer(); ?>