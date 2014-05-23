<?php

function omega_theme_inc() {

	// Set template directory
	define( 'OMEGA_INC', get_template_directory() . '/inc' );
	define( 'OMEGA_FUNCTIONS', OMEGA_INC . '/functions' );
	define( 'OMEGA_ADMIN', OMEGA_INC . '/admin' );
	define( 'OMEGA_EXTENSIONS', OMEGA_INC . '/extensions' );

	/* Custom template tags for this theme. */
	require OMEGA_FUNCTIONS . '/template-tags.php';

	/* Custom functions that act independently of the theme templates. */
	require OMEGA_FUNCTIONS . '/extras.php';

	/* Customizer additions. */
	require OMEGA_FUNCTIONS . '/customizer.php';

	/* override hybrid code. */
	require OMEGA_FUNCTIONS . '/override.php';

	/* image function */
	require OMEGA_FUNCTIONS . '/image.php';

	/* Function Hooks */
	require OMEGA_FUNCTIONS . '/hooks.php';

	if ( is_admin() ) {
		/* Load  theme settings page */		
		require  OMEGA_ADMIN . '/meta-box-theme-options.php';		
		require  OMEGA_ADMIN . '/meta-box-theme-comments.php';
		require  OMEGA_ADMIN . '/meta-box-theme-archives.php';
		require  OMEGA_ADMIN . '/meta-box-theme-general.php';		
	}

	/* Load  child themes page if supported. */
	require_if_theme_supports( 'omega-child-themes-page', OMEGA_EXTENSIONS . '/child-themes-page.php' );

	/* Load wraps extension if supported. */
	require_if_theme_supports( 'omega-wraps', OMEGA_EXTENSIONS . '/wraps.php' );

	/* Load custom footer extension if supported. */
	require_if_theme_supports( 'omega-custom-footer', OMEGA_EXTENSIONS . '/custom-footer.php' );

	/* Load custom css extension if supported. */
	require_if_theme_supports( 'omega-custom-css', OMEGA_EXTENSIONS . '/custom-css.php' );

	/* Load custom logo extension if supported. */
	require_if_theme_supports( 'omega-custom-logo', OMEGA_EXTENSIONS . '/custom-logo.php' );

	/* Load reponsive support. */
	require_if_theme_supports( 'omega-responsive', OMEGA_EXTENSIONS . '/responsive.php' );

	/* Load  footer widgets extension if supported. */
	require_if_theme_supports( 'omega-footer-widgets', OMEGA_EXTENSIONS . '/footer-widgets.php' );

	remove_action( 'wp_head', 'hybrid_meta_template', 4 );

}

add_action( 'after_setup_theme', 'omega_theme_inc', 20 );