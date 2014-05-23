<?php if ( have_comments() ) : ?>
	<h3><?php comments_number( '', __( 'One Response', 'omega' ), __( '% Responses', 'omega' ) ); ?></h3>

	<?php get_template_part( 'partials/comments-loop-nav' ); // Loads the comment-loop-nav.php template. ?>	

	<ol class="comment-list">
		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use omega_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define omega_comment() and that will be used instead.
			 * See omega_comment() in lib/inc/template-tags.php for more.
			 */
			$args = array(
				'walker'            => null,
				'max_depth'         => '',
				'style'             => 'ul',
				'callback'          => 'omega_comment',
				'end-callback'      => null,
				'type'              => 'pingback',
				'reply_text'        => 'Reply',
				'page'              => '',
				'per_page'          => '',
				'avatar_size'       => 48,
				'reverse_top_level' => null,
				'reverse_children'  => '',
				'format'            => 'xhtml', //or html5 @since 3.6
				'short_ping'        => false // @since 3.6
			);
			// hybrid_list_comments_args()
			wp_list_comments( hybrid_list_comments_args() );
		?>
	</ol><!-- .comment-list -->

<?php endif; // have_comments() ?>

<?php get_template_part( 'partials/comments-loop-error' ); // Loads the comments-loop-error.php template. ?>