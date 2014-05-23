<?php

function omega_shortcodes() {
	remove_shortcode( 'entry-published',     'hybrid_entry_published_shortcode' );
	remove_shortcode( 'entry-author',        'hybrid_entry_author_shortcode' );

	add_shortcode( 'entry-published',     'omega_entry_published_shortcode' );
	add_shortcode( 'entry-author',        'omega_entry_author_shortcode' );
}

add_action( 'init', 'omega_shortcodes' );

/**
 * Displays the published date of an individual post.
 */ 
function omega_entry_published_shortcode( $attr ) {
	$attr = shortcode_atts( array( 'before' => '', 'after' => '', 'format' => get_option( 'date_format' ) ), $attr );

	$published = '<time class="published" datetime="'. get_the_time( 'c' ) .'" title="' . get_the_time( esc_attr__( 'l, F jS, Y, g:i a', 'hybrid-core' ) ) . '" itemprop="datePublished">' . get_the_time( $attr['format'] ) . '</time>';
	
	if (get_the_title()=='' && !is_singular()) {
		$published = '<a href="'. get_permalink() . '">' . $published . '</a>';
	}

	return $attr['before'] . $published . $attr['after'];
}

/**
 * Displays an individual post's author with a link to his or her archive.
 */
function omega_entry_author_shortcode( $attr ) {
	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
	$author = '<span class="entry-author" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author"><a class="entry-author-link" rel="author" itemprop="url" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '"><span itemprop="name" class="entry-author-name">' . get_the_author_meta( 'display_name' ) . '</span></a></span>';
	return $attr['before'] . $author . $attr['after'];
}