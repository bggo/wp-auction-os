<?php
/**
 *
 * Silverclean WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013 Mathieu Sarrasin - Iceable Media
 *
 * Main Index
 *
 */
?>

<?php get_header();

	if ( get_custom_header()->url ) :
		if (	( is_front_page() && silverclean_get_option('home_header_image') != 'Off' ) ||
				( !is_front_page() && silverclean_get_option('blog_header_image') != 'Off' )	):
?>

	<div id="header-image" class="container">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	</div>
	
<?php
		endif;
	endif;
?>

	<div id="main-content" class="container">

		<div id="page-container" class="left with-sidebar">

		<?php /* SEARCH CONDITIONAL TITLE */ ?>
		<?php if ( is_search() ) :	?>
		<h1 class="page-title"><?php _e('Search Results for ', 'silverclean'); ?>"<?php the_search_query() ?>"</h1>
		<?php endif; ?>
		
		<?php /* TAG CONDITIONAL TITLE */ ?>
		<?php if ( is_tag() ) :	?>			
		<h1 class="page-title"><?php _e('Tag: ', 'silverclean'); single_tag_title(); ?></h1>
		<?php endif; ?>
					
		<?php /* CATEGORY CONDITIONAL TITLE */ ?>
		<?php if ( is_category() ) : ?>			
		<h1 class="page-title"><?php _e('Category: ', 'silverclean'); single_cat_title(); ?></h1>
		<?php endif; ?>	

		<?php /* DEFAULT CONDITIONAL TITLE */ ?>
		<?php if (!is_front_page() && !is_search() && !is_tag() && !is_category()) { ?>
		<h1 class="page-title"><?php echo get_the_title(get_option('page_for_posts')); ?></h1>
		<?php }	/* is_front_page endif */ ?>

		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="post-contents">

					<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>

					<div class="post-content">
					<?php if ( get_post_format() || post_password_required() ) the_content();
						else the_excerpt();
					?>
					</div>
		
				</div>

				<div class="postmetadata">
					<?php if (has_post_thumbnail()) : ?>
						<div class="thumbnail">
						<?php
						echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">'; ?>
						<?php the_post_thumbnail('post-thumbnail', array('class' => 'scale-with-grid')); ?></a>
						</div>
					<?php endif; ?>
					<span class="meta-date"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_time(get_option('date_format')); ?></a></span>
					<span class="meta-author"><?php _e('By ', 'silverclean'); the_author(); ?></span>
					<span class="meta-category"><?php _e('In ', 'silverclean'); the_category(', ') ?></span>
					<span class="meta-comments"><?php comments_popup_link( __( 'No Comment', 'silverclean' ), __( '1 Comment', 'silverclean' ), __( '% Comments', 'silverclean' ) ); ?></span>
					<?php if (has_tag()) { echo '<span class="tags">'; the_tags('<span class="tag">', '</span><span>', '</span></span>'); } ?>
					<span class="editlink"><?php edit_post_link(__('Edit', 'silverclean'), '', ''); ?></span>
				</div>

			</div><!-- end div post -->

			<hr />

		<?php endwhile; ?>
		<?php else : ?>

			<?php if (is_search() ): ?>

				<h2><?php _e('Nothing Found', 'silverclean'); ?></h2>
				<p><?php _e('Maybe a search will help ?', 'silverclean'); ?></p>
				<?php get_search_form(); ?>
			
			<?php else : ?>

				<h2><?php _e('Not Found', 'silverclean'); ?></h2>
				<p><?php _e('What you are looking for isn\'t here...', 'silverclean'); ?></p>

			<?php endif; ?>

		<?php endif; ?>

			<div class="page_nav">
				<div class="previous"><?php next_posts_link( __('Previous Posts', 'silverclean') ); ?></div>
				<div class="next"><?php previous_posts_link( __('Next Posts', 'silverclean') ); ?></div>
			</div>

		</div>
		<!-- End page container -->

		<div id="sidebar-container" class="right">
			<?php get_sidebar(); ?>
		</div>		
		<!-- End sidebar -->

	</div>
	<!-- End main content -->

<?php get_footer(); ?>