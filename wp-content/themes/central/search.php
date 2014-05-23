<?php /* the template to display search results */
	get_header();
	get_sidebar();
?>
<div id="content" role="main">
	<?php if ( have_posts() ) : ?>
		<div class="post">
			<div class="block-header">
				<h2 class="page-title">
					<?php printf( __( 'Search Results for: %s', 'central' ), '<span>'. get_search_query() . '</span>' ); ?>
				</h2><!-- .page-title -->
			</div><!-- .block-header -->
		</div>
		<?php /* post navigation */ 
		central_content_nav( 'nav-above' ); 
		/* start the loop */
		 while ( have_posts() ) : the_post(); ?>
			<div class="post">
				<div class="block-header">
					<a class="post-link" href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</div><!-- block-header-->
				<div class="post-text"><?php the_content(); ?></div>
			</div><!-- .post -->
		<?php endwhile; 
		/* end the loop
		 post navigation */ 
		central_content_nav( 'nav-below' ); ?>
	<?php else : /* if nothing found */ ?>
		<div class="post">
			<div class="block-header">
				<h1 class="page-title">
					<?php  printf( __( 'You were trying to look for: %s', 'central' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1><!-- .page-title -->
			</div>
			<div class="post-text">
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'central' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .post-text -->
		</div><!-- .post -->
	<?php endif; ?>
</div><!-- #content -->
<?php get_footer(); ?>
