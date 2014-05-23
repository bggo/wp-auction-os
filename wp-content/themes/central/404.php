<?php /* the template to displaying 404 error page */
	get_header();
	get_sidebar();
?>
	<div id="content" role="main">
		<div class="post">
			<div class="post-text">
				<h2 class="center">
					<?php _e( 'Error 404 - Page Not Found', 'central' ); ?>
				</h2>
				<p>
					<?php _e( 'Bad link: ', 'central' ); ?>
					<strong><?php echo home_url() . $_SERVER['REQUEST_URI']; ?></strong>
				</p>
				<p>
					<?php _e( 'Sorry, but page you requested has not been found.', 'central' ); ?>
				</p>
				<p>
					<?php _e( 'You can click back, visit our ', 'central' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php _e( 'home page', 'central'); ?></a><?php _e( ', or use search form:', 'central' ); ?>
				</p>
				<?php get_search_form(); ?>
			</div><!-- .post-text -->
		</div><!-- .post -->
	</div><!-- #content -->
<?php get_footer(); ?>
