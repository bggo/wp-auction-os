<?php
/**
 *
 * Silverclean WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013 Mathieu Sarrasin - Iceable Media
 *
 * Template Name: Full-width Page Template, No Sidebar
 *
 */
?>

<?php get_header();

	if(have_posts()) :
	while(have_posts()) : the_post();

	if ( get_custom_header()->url ) :
		if (	( is_front_page() && silverclean_get_option('home_header_image') != 'Off' ) ||
				( silverclean_get_option('pages_header_image') != 'Off' ) ):
?>

	<div id="header-image" class="container">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	</div>
	
<?php
		endif;
	endif;
?>

	<div class="container" id="main-content">

		<div id="page-container" <?php post_class(); ?>>

				<h1 class="page-title"><?php the_title(); ?></h1>

				<?php the_content(); ?>
				<br class="clear" />
				<p class="editlink">
				<?php edit_post_link(__('Edit', 'silverclean'), '', ''); ?>
				</p>

			<?php	// Display comments section only if comments are open or if there are comments already.
				if ( comments_open() || get_comments_number()!=0 ) : ?>
				<!-- comments section -->
				<div class="comments">
				<?php comments_template( '', true ); ?>
				<?php next_comments_link(); previous_comments_link(); ?>
				</div>
				<!-- end comments section -->
			<?php endif; ?>

			<?php endwhile; ?>
				<?php else : ?>
				<h2><?php _e('Not Found', 'silverclean'); ?></h2>
				<p><?php _e('What you are looking for isn\'t here...', 'silverclean'); ?></p>

			<?php endif; ?>
		</div>
		<!-- End page container -->

	</div>
	<!-- End main content -->
<?php get_footer(); ?>