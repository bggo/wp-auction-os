<footer class="entry-footer">
	<div class="entry-meta">
		<?php
		echo apply_atomic_shortcode( 'entry_meta', __( '[entry-terms taxonomy="category" before="Posted in: "] [entry-terms before="| Tagged: "]', 'omega' ) );
		?>
	</div><!-- .entry-meta -->
</footer>