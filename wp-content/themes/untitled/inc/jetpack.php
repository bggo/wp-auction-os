<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package untitled
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function untitled_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'untitled_infinite_scroll_setup' );

/**
 * Add support for the Featured Content Plugin
 *
 * @since untitled 1.0
 */
add_theme_support( 'featured-content', array(
	'featured_content_filter' => 'untitled_get_featured_posts',
	'description'             => __( 'The featured content section displays on the front page above the first post in the content area.', 'untitled' ),
	'max_posts'               => 10,
) );

/**
 * Featured Posts
 *
 * @since untitled 1.0
 */
function untitled_has_multiple_featured_posts() {
	$featured_posts = apply_filters( 'untitled_get_featured_posts', array() );
	if ( is_array( $featured_posts ) && 1 < count( $featured_posts ) )
		return true;

	return false;
}

function untitled_get_featured_posts() {
	return apply_filters( 'untitled_get_featured_posts', false );
}