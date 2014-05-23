<!-- template to displaying a search form -->
<div class="search-wrap">
		<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input class="search-field" type="text" placeholder="<?php esc_attr_e( 'Enter search keyword', 'central' ); ?>" name="s"  value="<?php the_search_query(); ?>"/>
		</form>
</div>
