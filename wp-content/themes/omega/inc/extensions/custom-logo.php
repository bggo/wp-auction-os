<?php

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'omega_customize_logo_register' );


/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 0.3.2
 * @access private
 * @param object $wp_customize
 */
function omega_customize_logo_register( $wp_customize ) {

	/* Add the footer section. */
	$wp_customize->add_section(
		'title_tagline',
		array(
			'title'      => esc_html__( 'Branding', 'omega' ),
			'priority'   => 1,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the 'custom_css' setting. */
	$wp_customize->add_setting(
		"custom_logo",
		array(
			'default'              => '',
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'hybrid_customize_sanitize',
			'sanitize_js_callback' => 'hybrid_customize_sanitize',
			//'transport'            => 'postMessage',
		)
	);

	/* Add the textarea control for the 'custom_css' setting. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'custom_logo',
			array(
				'label'    => esc_html__( 'Logo', 'omega' ),
				'section'  => 'title_tagline',
				'settings' => "custom_logo",
			)
		)
	);

	/* If viewing the customize preview screen, add a script to show a live preview. 
	if ( $wp_customize->is_preview() && !is_admin() ) {
		add_action( 'wp_footer', 'omega_customize_preview_script', 22 );
	}
	*/
}

/**
 * Handles changing settings for the live preview of the theme.
 *
 * @since 0.3.2
 * @access private
 
function omega_customize_preview_script() {

	?>
	<script type="text/javascript">
	wp.customize(
		'custom_css',
		function( value ) {
			value.bind(
				function( to ) {
					jQuery( '#custom-colors-css' ).html( to );
				}
			);
		}
	);
	</script>
	<?php
}
*/
?>