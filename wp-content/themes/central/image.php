<?php /* the template to displaying image attachments*/
	get_header();
	get_sidebar();
?>
	<div id="content" role="main">
		<?php while ( have_posts() ) : the_post(); /*start the loop*/ ?>
			<div class="post"> 
				<div class="nav-single">
					<span class="nav-previous"><?php previous_image_link( false, __( '&larr; Previous image', 'central' ) ); ?></span>
					<span class="nav-next"><?php next_image_link( false, __( 'Next image &rarr;', 'central' ) ); ?></span>
				</div>
				<div class="clear"></div>
				<div class="block-header">
					<h2><?php the_title(); ?></h2>
				</div>
				<p class="post-date">
					<?php /* show date publication and post of current image */ _e( 'Posted on ', 'central' );?><span id="date"><?php the_date(); ?></span><?php _e( ' in ', 'central' ); ?><a href="<?php echo esc_url( get_permalink( $post -> post_parent ) ); ?>" title="<?php _e( 'Back to ', 'central' ); echo esc_attr( strip_tags( get_the_title( $post -> post_parent ) ) ); ?>"><?php echo get_the_title( $post -> post_parent ); ?></a>
				</p>
				<div class="post-text">
					<p>
						<?php _e( 'See in full size: ', 'central' ); ?><a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="<?php _e( 'full size of ', 'central'); the_title(); ?>"><?php $metadata = wp_get_attachment_metadata(); echo $metadata['width'] . ' &times; ' . $metadata['height'] . ' '; ?></a><?php _e( 'px', 'central' ); ?>
					</p>
					<?php
					/**
					 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
					 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
	 				*/
					$attachments = array_values( get_children( array( 'post_parent'    => $post->post_parent,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => 'ASC',
						'orderby'        => 'menu_order ID',
					) ) );
					foreach ( $attachments as $k => $attachment ) {
						if ( $attachment -> ID == $post -> ID )
							break;
					}
					$k++;
					// If there is more than 1 attachment in a gallery
					if ( 1 < count( $attachments ) ) {
						if ( isset( $attachments[ $k ] ) )
							// get the URL of the next image attachment
							$next_attachment_url = get_attachment_link( $attachments[ $k ] -> ID );
						else
							// or get the URL of the first image attachment
							$next_attachment_url = get_attachment_link( $attachments[ 0 ] -> ID );
					} else {
						// or, if there's only 1 image, get the URL of the image
						$next_attachment_url = wp_get_attachment_url();
					} ?>
					<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
						<?php echo wp_get_attachment_image( $post->ID, 'large' ); ?>
					</a>
					<?php if ( ! empty( $post->post_excerpt ) ) 
						the_excerpt();
					 	the_content();
						wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'central' ) . '</span>', 'after' => '</div>' ) );
					?>
				</div><!-- .post-text -->
				<?php comments_template(); ?>
				<div class="more-links">
					<a class="anchor" href="javascript:scroll(0,0);">[<?php _e( 'Top', 'central' ) ; ?>]</a>
				</div>
			</div><!-- .post -->
		<?php endwhile; // end of the loop. ?>
	</div><!-- #content -->
<?php get_footer(); ?>
