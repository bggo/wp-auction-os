<?php
/**
 * MyBaby Theme Options
 *
 * @package WordPress
 * @subpackage MyBaby
 */

/* enqueue styles and scripts for our theme options page. */
function mybaby_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'mybaby-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'mybaby-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'mybaby_admin_enqueue_scripts' );

/* Register the form setting for our mybaby_options array. */
function mybaby_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === mybaby_get_theme_options() )
		add_option( 'mybaby_theme_options', mybaby_get_default_theme_options() );

	register_setting(
		'mybaby_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'mybaby_theme_options', // Database option, see mybaby_get_theme_options()
		'mybaby_theme_options_validate' // The sanitization callback, see mybaby_theme_options_validate()
	);
}
add_action( 'admin_init', 'mybaby_theme_options_init' );

/**
 * Change the capability required to save the 'mybaby_options' options group. */
function mybaby_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_mybaby_options', 'mybaby_option_page_capability' );

/* Add heme options page to the admin menu */
function mybaby_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'mybaby' ),   // Name of page
		__( 'Theme Options', 'mybaby' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'mybaby_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
}
add_action( 'admin_menu', 'mybaby_theme_options_add_page' );

/* Returns the default options */
function mybaby_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   =>  mybaby_get_default_link_color( 'light' )
	);

	return apply_filters( 'mybaby_default_theme_options', $default_theme_options );
}

/* Returns the default link color */
function mybaby_get_default_link_color( $color_scheme = null ) {
	
	return "#339999";
}

/* Returns the options array */
function mybaby_get_theme_options() {
	return get_option( 'mybaby_theme_options', mybaby_get_default_theme_options() );
}

function mybaby_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'mybaby' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'mybaby_options' );
				$options = mybaby_get_theme_options();
				$default_options = mybaby_get_default_theme_options();
			?>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'mybaby' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'mybaby' ); ?></span></legend>
							<input type="text" name="mybaby_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
							<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
							<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'mybaby' ); ?>" />
							<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
							<br />
							<span><?php printf( __( 'Default color: %s', 'mybaby' ), '<span id="default-color">' . mybaby_get_default_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
						</fieldset>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/* Sanitize and validate form input. Accepts an array, return a sanitized array. */
function mybaby_theme_options_validate( $input ) {
	$output = $defaults = mybaby_get_default_theme_options();

	// Our defaults for the link color may have changed, based on the color scheme.
	$output['link_color'] = $defaults['link_color'] = mybaby_get_default_link_color( $output['color_scheme'] );

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );
	
	return apply_filters( 'mybaby_theme_options_validate', $output, $input, $defaults );
}

/* Add a style block to the theme for the current link color. */
function mybaby_print_link_color_style() {
	$options = mybaby_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = mybaby_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover {
			color: <?php echo $link_color; ?>;
		}
		section.recent-posts .other-recent-posts .comments-link a:hover {
			border-color: <?php echo $link_color; ?>;
		}
		article.feature-image.small .entry-summary p a:hover,
		.entry-header .comments-link a:hover,
		.entry-header .comments-link a:focus,
		.entry-header .comments-link a:active,
		.feature-slider a.active {
			background-color: <?php echo $link_color; ?>;
		}
		#access {
			background-color: <?php echo $link_color; ?>; /* Show a solid color for older browsers */
			background: -moz-linear-gradient(<?php echo $link_color; ?>, #333333);
			background: -o-linear-gradient(<?php echo $link_color; ?>, #333333);
			background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $link_color; ?>), to(#333333)); /* older webkit syntax */
			background: -webkit-linear-gradient(<?php echo $link_color; ?>, #333333);
		}
	</style>
<?php
}
add_action( 'wp_head', 'mybaby_print_link_color_style' );
