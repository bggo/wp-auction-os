<?php /* the template to dislaying a single page */
	get_header();
	get_sidebar();
?>
<div id="content" role="main">
	<?php if( have_posts() ) : the_post(); ?>
		<div class="post">
			<?php /* show post thumbnail */
				if ( has_post_thumbnail() ) : ?>
					<div class="left-top"></div>
					<div class="right-top"></div>
					<div class="featured-image">
						<?php the_post_thumbnail( 'post-thumb' ); ?>
					</div>
					<div class="featured-image-title">
						<?php central_featured_img_title(); ?>
					</div>
			<?php endif; ?>
			<div class="block-header">
				<h2><?php the_title(); ?></h2>
			</div>
			<p class="post-date">
				<?php /* show date of publication of current page */
				_e( 'Posted on ', 'central' ); ?><a href="<?php the_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>" rel="bookmark"><span id="date"><?php the_date(); ?></span></a>
			</p>
				<div class="post-text">
					<?php /* show the content */
					the_content(); 
					/*show page navigation*/
					wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'central' ) . '</span>', 'after' => '</div>' ) );
					/* show "edit" link */
					edit_post_link( __( 'Edit page', 'central' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .post-text -->
				<div class="clear"></div>
				<?php comments_template( '', true ); ?>
				<div class="more-links">
					<?php /* show tags and anchors */
					the_tags( '<span class="tag-image"></span>', ', ', '' ); ?> 
					<a class="anchor" href="javascript:scroll(0,0);">[<?php _e( 'Top' , 'central' ) ; ?>]</a>
				</div>
		</div><!-- .post -->
	<?php endif; ?>
</div><!-- #content-->
<?php get_footer(); ?>
