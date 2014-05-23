<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to omega_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Omega
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
	return;

if ( is_singular( 'post' ) && ( !hybrid_get_setting( 'trackbacks_posts' ) && !hybrid_get_setting( 'comments_posts' ) ) )
	return;
elseif ( is_singular( 'page' ) && ( !hybrid_get_setting( 'trackbacks_pages' ) && !hybrid_get_setting( 'comments_pages' ) ) )
	return;

?>

<div id="comments" class="entry-comments">

	<?php get_template_part( 'partials/comments-loop' ); // Loads the comments-loop.php template. ?>

</div><!-- #comments -->

<?php comment_form(); ?>
