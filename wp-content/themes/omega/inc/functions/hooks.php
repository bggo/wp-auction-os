<?php

if ( hybrid_get_setting( 'more_link_scroll' )) {
	add_filter( 'the_content_more_link', 'remove_more_link_scroll' );
}

function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}