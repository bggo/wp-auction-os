<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

	<div class="entry-wrap">		

		<?php do_atomic( 'before_entry' ); // omega_before_entry ?>

		<div class="entry-content">
			
			<?php do_atomic( 'entry' ); // omega_entry ?>
			
		</div><!-- .entry-content -->

		<?php do_atomic( 'after_entry' ); // omega_after_entry ?>

	</div><!-- .entry-wrap -->

</article><!-- #post-## -->