<?php
/**
 *
 * Silverclean WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013 Mathieu Sarrasin - Iceable Media
 *
 * Single Post Template
 *
 */
?>

<?php get_header(); 

	if ( get_custom_header()->url ) :
		if ( silverclean_get_option('single_header_image') != 'Off' ):
?>

	<div id="header-image" class="container">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	</div>
	
<?php
		endif;
	endif;
?>


	<div class="container" id="main-content">

		<div id="page-container" class="left with-sidebar">

			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class("single-post"); ?>>
		
			<div class="post-content">
			<div class="postmetadata">
				<?php if (has_post_thumbnail()) : ?>
				<div class="thumbnail">
					<?php the_post_thumbnail('post-thumbnail', array('class' => 'scale-with-grid')); ?>
				</div>
				<?php endif; ?>
				<span class="meta-date"><?php the_time(get_option('date_format')); ?></span>
				<span class="meta-author"><?php _e('By ', 'silverclean'); the_author(); ?></span>
				<?php if ( has_category() ): ?>
				<span class="meta-category"><?php _e('In ', 'silverclean'); the_category(', ') ?></span>
				<?php endif;
				if (has_tag()) { echo '<span class="tags">'; the_tags('<span class="tag">', '</span><span>', '</span></span>'); } ?>
				<?php edit_post_link(__('Edit', 'silverclean'), '<span class="editlink">', '</span>'); ?>
			</div>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
			</div><!-- end post content -->
			<div class="clear" /></div>
			<?php $args = array(
				'before'           => '<br class="clear" /><div class="paged_nav">' . __('Pages:', 'silverclean'),
				'after'            => '</div>',
				'link_before'      => '',
				'link_after'       => '',
				'next_or_number'   => 'number',
				'nextpagelink'     => __('Next page', 'silverclean'),
				'previouspagelink' => __('Previous page', 'silverclean'),
				'pagelink'         => '%',
				'echo'             => 1
			);
			wp_link_pages( $args ); ?>

			</div><!-- end div post -->
		
			<?php	// Display comments section only if comments are open or if there are comments already.
			if ( comments_open() || get_comments_number()!=0 ) : ?>
				<hr />
				<!-- comments section -->
				<div class="comments">
				<?php comments_template( '', true ); ?>
				</div>
				<!-- end comments section -->
			<?php endif; ?>

			<?php endwhile; ?>

			<?php else : ?>
		
			<h2><?php _e('Not Found', 'silverclean'); ?></h2>
			<p><?php _e('What you are looking for isn\'t here...', 'silverclean'); ?></p>

			<?php endif; ?>

			<div class="article_nav">

				<?php if ( is_attachment() ):
				// Use image navigation links on attachment pages, post navigation otherwise ?>

					<?php if ( silverclean_adjacent_image_link(false) ): // Is there a previous image ? ?>
					<div class="previous"><?php previous_image_link(0, __("Previous Image", 'silverclean') ); ?></div>
					<?php endif; ?>
					<?php if ( silverclean_adjacent_image_link(true) ): // Is there a next image ? ?>	
					<div class="next"><?php next_image_link(0, __("Next Image",'silverclean') ); ?></div>
					<?php endif; ?>

				<?php else: ?>

					<?php if ("" != get_adjacent_post( false, "", false ) ): // Is there a next post? ?>
					<div class="next"><?php next_post_link('%link', __("Next Post", 'silverclean') ); ?></div>
					<?php endif; ?>
					<?php if ("" != get_adjacent_post( false, "", true ) ): // Is there a previous post? ?>
					<div class="previous"><?php previous_post_link('%link', __("Previous Post", 'silverclean') ); ?></div>
					<?php endif; ?>

				<?php endif; ?>

				<br class="clear" />
			</div>

		</div>
		<!-- End page container -->
		
		<div id="sidebar-container" class="right">
			<?php get_sidebar(); ?>
		</div>		
		<!-- End sidebar column -->
		

	</div>
	<!-- End main content -->

<?php get_footer(); ?>