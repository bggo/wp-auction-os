<?php

/* Load custom control classes. */
add_action( 'customize_register', 'omega_load_customize_controls', 1 );

function omega_load_customize_controls() {

	/**
	 * CSS customize control class.
	 *
	 * @since 0.3.0
	 */
	class Omega_Customize_Control_CSS extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since 0.3.0
		 */
		public $type = 'css';

		/**
		 * Displays the css on the customize screen.
		 *
		 * @since 0.3.0
		 */
		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="customize-control-content">
					<textarea class="widefat" cols="45" rows="10" id="custom_css" name="custom_css" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</div>
			</label>
		<?php }
	}

}

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'omega_customize_css_register' );

/* Output CSS into <head>. */
add_action( 'wp_head', 'print_custom_css' );

/* Delete the cached data for this feature. */
add_action( 'update_option_theme_mods_' . get_stylesheet(), 'custom_css_cache_delete' );

/**
 * Deletes the cached style CSS that's output into the header.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */

function custom_css_cache_delete() {
	wp_cache_delete( 'custom_css' );
}


function print_custom_css() {
	/* Get the cached style. */
	$style = wp_cache_get( 'custom_css' );

	/* If the style is available, output it and return. */
	if ( !empty( $style ) ) {
		echo $style;
		return;
	} else {
		/* Put the final style output together. */
		$style = "\n" . '<style type="text/css" id="custom-colors-css">' . trim( get_theme_mod( 'custom_css' ) ) . '</style>' . "\n";

		/* Cache the style, so we don't have to process this on each page load. */
		wp_cache_set( 'custom_css', $style );

		/* Output the custom style. */
		echo $style;
	}
}

/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 0.3.2
 * @access private
 * @param object $wp_customize
 */
function omega_customize_css_register( $wp_customize ) {

	/* Add the footer section. */
	$wp_customize->add_section(
		'layout',
		array(
			'title'      => esc_html__( 'Global Settings', 'omega' ),
			'priority'   => 150,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the 'custom_css' setting. */
	$wp_customize->add_setting(
		"custom_css",
		array(
			'default'              => '',
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'hybrid_customize_sanitize',
			'sanitize_js_callback' => 'hybrid_customize_sanitize',
			'transport'            => 'postMessage',
		)
	);

	/* Add the textarea control for the 'custom_css' setting. */
	$wp_customize->add_control(
		new Omega_Customize_Control_CSS(
			$wp_customize,
			'custom_css',
			array(
				'label'    => esc_html__( 'Custom CSS', 'omega' ),
				'section'  => 'layout',
				'settings' => "custom_css",
			)
		)
	);

	/* If viewing the customize preview screen, add a script to show a live preview. */
	if ( $wp_customize->is_preview() && !is_admin() ) {
		add_action( 'wp_footer', 'omega_customize_preview_script', 22 );
	}
}

/**
 * Handles changing settings for the live preview of the theme.
 *
 * @since 0.3.2
 * @access private
 */
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
?>