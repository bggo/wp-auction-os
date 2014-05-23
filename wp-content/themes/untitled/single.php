<?php
/**
 * The Template for displaying all single posts.
 *
 * @package untitled
 */

get_header();  ?>

	<?php if ( '' != get_the_post_thumbnail() ) { ?>
	<div class="singleimg"><?php the_post_thumbnail( 'slider-img' ); ?></div>
		<div class="minislides">
  			<div class="carousel">
  			<ul class="slides">
  			<?php
				$currentID = get_the_ID();
				$mini_args = array(
					'posts_per_page' => 18,
					'post__not_in'	=>	array( $currentID ),
				);

				$count = 0; // Set up a variable to count the number of posts so that we can break them up into rows

				$mini_query = new WP_Query( $mini_args );

				while ( $mini_query->have_posts() ) : $mini_query->the_post();
				if ( '' != get_the_post_thumbnail() ) :
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail-img' ); // get the thumbnail image
							?>
    		<li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'untitled' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail-img' ); ?></a></li>
			<?php
			endif;
    // Reset the post data
    wp_reset_postdata();
			endwhile;
			?></ul>

		</div>
	</div>

	<?php } ?>

	<div id="single-main" class="site-main">

		<div id="single-primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php untitled_content_nav( 'nav-below' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>