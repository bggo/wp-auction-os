<?php /* the template to displaying list of post in category */
	get_header(); 
	get_sidebar();
?>
<div id="content" role="main">
	<?php if( have_posts() ) :  ?>
		<div class="post">
			<div class="block-header">
				<h2 class="page-title">
					<?php /* show title of category */
						printf( __( 'Category: %s', 'central' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?>
				</h2>
				<?php /* show category description */
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' .  $category_description . '</div>' ); ?>
			</div><!-- .block-header -->
		</div><!-- .post -->
		<?php /* show post navigation */
			central_content_nav( 'nav-above' ); 
			/* start the loop */
			while ( have_posts() ) : the_post(); ?>
				<div <?php post_class(); ?>>
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
						<a class="post-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php if ( comments_open() ) { /*show link to leave replay*/ 
							comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'central' ) . '</span>','<span class="leave-reply">' . __( '1 Reply', 'central' ) . '</span>', '<span class="leave-reply">' . __( '% Replies', 'central' ) . '</span>' ); 
						}; ?>
						<p class="post-date">
							<?php /* show date of publication */ 
								_e( 'Posted on ', 'central' ); ?><a href="<?php the_permalink( get_the_ID() ); ?>" title="<?php the_title(); ?>" rel="bookmark"><span id="date"><?php the_date(); ?></span></a><?php _e( ' in ', 'central' ); the_category( ', ' ); ?>
						</p>
					</div><!-- .block-header -->
					<div class="post-text">
						<?php /* show content of current post */ 
						the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'central' ) ); 
						/* show link pages of current post */
						wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'central' ) . '</span>', 'after' => '</div>' ) );
						/* show "edit" link */
						edit_post_link( __( 'Edit post', 'central' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .post-text -->
					<div class="clear"></div>
					<div class="more-links">
						<?php /* show tags and anchor */
							the_tags( '<span class="tag-image"></span>' , ', ' , '' ); ?> 
						<a class="anchor" href="javascript:scroll(0,0);">[<?php _e( 'Top', 'central' ) ; ?>]</a>
					</div><!-- .more-links -->
					<div class="clear"></div>
				</div><!-- .post -->
		<?php endwhile;
		/*  end the loop
				show page navigation */
			central_content_nav( 'nav-below' );
	else : /* if no posts in this category */ ?>
		<div class="post">
			<?php _e( 'Nothing found in this categpory', 'central' ); ?>
		</div>
	<?php endif; ?>	
</div><!-- #content -->
<?php get_footer(); ?>
