<div class="entry-meta">
	<?php 
	if (is_multi_author()) {
		echo apply_atomic_shortcode( 'entry_author', __( 'Posted by [entry-author] ', 'omega' ) ); 
	} else {
		echo apply_atomic_shortcode( 'entry_author', __( 'Posted ', 'omega' ) ); 
	}?>
	<?php
	if (  hybrid_get_setting( 'trackbacks_posts' ) || hybrid_get_setting( 'comments_posts' ) ) {
		echo apply_atomic_shortcode( 'entry_byline', __( 'on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'omega' ) ); 
	} else {
		echo apply_atomic_shortcode( 'entry_byline', __( 'on [entry-published] [entry-edit-link before=" | "]', 'omega' ) ); 				
	}	
	
	?>
</div><!-- .entry-meta -->