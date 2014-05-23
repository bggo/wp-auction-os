<?php /* the template to dislaying a sidebar */
?>
<div class="widget-area" role="complementary">
<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
	<aside  class="widget">
		<?php get_search_form(); ?>
	</aside>
	<aside  class="widget">
		<h3><?php _e( 'Recent Posts' , 'central' ); ?></h3>
		<ul>
			<?php $args = array( 'numberposts' => '5' );
			$recent_posts = wp_get_recent_posts( $args );
			foreach ( $recent_posts as $recent ) {
				echo'<li><a href="' . get_permalink($recent["ID"]) . '" title="Look ' . esc_attr($recent["post_title"]) . '" >' . $recent["post_title"] . '</a></li>';
			}; ?>
		</ul>
	</aside><!-- .widget -->
	<aside  class="widget">
		<h3><?php _e( 'Recent Comments', 'central' ); ?></h3>
		<ul>
			<?php $args = array('number' => 5 );
			$comments = get_comments($args);
			foreach($comments as $comment) {
				echo( '<li><a href="' . $comment->comment_author_url . '">' . $comment->comment_author . '</a><span>');
				_e( ' on ', 'central' ); 
				echo( '</span> <a href="' . get_permalink( $comment->comment_post_ID ) . '">' . get_post( $comment -> comment_post_ID )->post_title . '</a></li>' );
			}; ?>
		</ul>
	</aside><!-- .widget -->
	<aside class="widget">
		<h3><?php _e( 'Archives', 'central' ); ?></h3>
		<ul>
			<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
		</ul>
	</aside><!-- .widget -->
	<aside class="widget">
		<h3><?php _e( 'Categories', 'central' ); ?></h3>
		<ul>
			<?php $args = array( 'orderby' => 'name', 'parent' => 0 );
			$categories = get_categories();
			foreach ( $categories as $category ){
				echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
			}; ?>
		</ul>
	</aside><!-- .widget -->
<?php endif; // end sidebar widget area ?>
</div><!-- .widget-area -->

