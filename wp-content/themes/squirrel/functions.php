<?php

include_once get_template_directory() . '/functions/squirrel-functions.php';
$functions_path = get_template_directory() . '/functions/';
/* These files build out the options interface.  Likely won't need to edit these. */
require_once ($functions_path . 'admin-functions.php');  // Custom functions and plugins
require_once ($functions_path . 'admin-interface.php');  // Admin Interfaces (options,framework, seo)
/* These files build out the theme specific options and associated functions. */
require_once ($functions_path . 'theme-options.php');   // Options panel settings and custom settings
?>
<?php
/* ----------------------------------------------------------------------------------- */
/* Styles Enqueue */
/* ----------------------------------------------------------------------------------- */

function squirrel_add_stylesheet() {
     wp_enqueue_style('coloroptions', get_template_directory_uri() . "/color/blue.css", '', '', 'all');
}

add_action('wp_enqueue_scripts', 'squirrel_add_stylesheet');
/* ----------------------------------------------------------------------------------- */
/* jQuery Enqueue */
/* ----------------------------------------------------------------------------------- */
function squirrel_wp_enqueue_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('squirrel-ddsmoothmenu', get_stylesheet_directory_uri() . '/js/ddsmoothmenu.js', array('jquery'));
        wp_enqueue_script('squirrel-slides', get_stylesheet_directory_uri() . '/js/slides.min.jquery.js', array('jquery'));
        wp_enqueue_script('squirrel-cunfon-yui', get_stylesheet_directory_uri() . '/js/cufon-yui.js', array('jquery'));
        wp_enqueue_script('squirrel-museo-cufon', get_stylesheet_directory_uri() . '/js/Museo_500_400.font.js', array('jquery'));       
        wp_enqueue_script('squirrel-custom', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'));
    } elseif (is_admin()) {
        
    }
}
add_action('wp_enqueue_scripts', 'squirrel_wp_enqueue_scripts');
function squirrel_get_option( $name ) {
	$options = get_option( 'squirrel_options' );
	if ( isset( $options[ $name ] ) )
		return $options[ $name ];
}
function squirrel_update_option( $name, $value ) {
	$options = get_option( 'squirrel_options' );
	$options[ $name ] = $value;
	
	return update_option( 'squirrel_options', $options );
}
function squirrel_delete_option( $name ) {
	$options = get_option( 'squirrel_options' );
	unset( $options[ $name ] );
	
	return update_option( 'squirrel_options', $options );
}
?>
