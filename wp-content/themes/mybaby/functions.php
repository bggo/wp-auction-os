<?php
/**
 * MyBaby functions and definitions
 *
 * @package WordPress
 * @subpackage MyBaby
 */


/*  content width  */
if ( ! isset( $content_width ) )
	$content_width = 600;
	
add_action( 'after_setup_theme', 'mybaby_setup' );

if ( ! function_exists( 'mybaby_setup' ) ):
function mybaby_setup() {

	/* Translations can be added to the /languages/ directory. */
	load_theme_textdomain( 'mybaby', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'mybaby' ) );

	// Add support for custom backgrounds
	add_custom_background('myBaby_background', 'my_custom_background','');	
	function my_custom_background(){
			?>
            <style type="text/css">
			#custom-background h3,
			#custom-background .form-table{display: none;}
			#custom-background form .form-table{display: block;}
			</style>
	<?php		
	}
	function myBaby_background() {	
		/* Get the background color. */
		$color = get_background_color();
	
		/* If no background color, return. */
		if ( empty( $color ) )
			return;
	
		/* Use 'background' instead of 'background-color'. */
		$style = "background-color: #{$color};";
	
	?>
	<style type="text/css">
		#bg-gradient{ <?php echo trim( $style ); ?> }
    </style>
	<?php
	}

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// The next four constants set how Twenty Eleven supports custom headers.

	// The default header text color
	define( 'HEADER_TEXTCOLOR', '333' );

	// By leaving empty, we allow for random image rotation.
	define( 'HEADER_IMAGE', '' );

	// The height and width of your custom header.
	// Add a filter to mybaby_header_image_width and mybaby_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'mybaby_header_image_width', 412 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'mybaby_header_image_height', 272 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add Twenty Eleven's custom image sizes
	add_image_size( 'large-feature', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true ); // Used for large feature (header) images
	add_image_size( 'small-feature', 150, 99 ); // Used for featured posts if a large-feature doesn't exist

	// Turn on random header image rotation by default.
	add_theme_support( 'custom-header', array( 'random-default' => true ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See mybaby_admin_header_style(), below.
	add_custom_image_header( '', 'mybaby_admin_header_style', 'mybaby_admin_header_image' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	// Baby images courtesy of webweaver (http://www.webweaver.nu/)
	register_default_headers( array(
		'new-baby' => array(
			'url' => '%s/images/headers/new-baby.jpg',
			'thumbnail_url' => '%s/images/headers/new-baby-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Welcome our new baby', 'mybaby' )
		)
	) );
}
endif; // mybaby_setup

if ( ! function_exists( 'mybaby_admin_header_style' ) ) :
/* Styles the header image displayed on the Appearance > Header admin panel. */
function mybaby_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		display:none;
	}
	.wrap form .form-table{
		display: none;
	}
	.wrap form .form-table:first-child{
		display: block;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 472px;
		height: auto;
	}
	</style>
<?php
}
endif; // mybaby_admin_header_style

if ( ! function_exists( 'mybaby_admin_header_image' ) ) :
/* Custom header image markup displayed on the Appearance > Header admin panel. */
function mybaby_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // mybaby_admin_header_image

/* Sets the post excerpt length to 40 words. */
function mybaby_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'mybaby_excerpt_length' );

/*  Returns a "Continue Reading" link for excerpts */
function mybaby_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'mybaby' ) . '</a>';
}

/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and mybaby_continue_reading_link().  */
function mybaby_auto_excerpt_more( $more ) {
	return ' &hellip;' . mybaby_continue_reading_link();
}
add_filter( 'excerpt_more', 'mybaby_auto_excerpt_more' );

/* Adds a pretty "Continue Reading" link to custom post excerpts. */
function mybaby_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= mybaby_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'mybaby_custom_excerpt_more' );

/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link. */
function mybaby_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'mybaby_page_menu_args' );

/*  Register our sidebars and widgetized areas. Also register the default Epherma widget. */
function mybaby_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'mybaby' ),
		'id' => 'sidebar-1',
		'description' => __( 'An optional widget area for your site footer', 'mybaby' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'mybaby' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'mybaby' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'mybaby' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'mybaby' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'mybaby_widgets_init' );

/* Display navigation to next/previous pages when applicable */
function mybaby_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'mybaby' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'mybaby' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'mybaby' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/* Return the URL for the first link found in the post content. */
function mybaby_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/* Count the number of footer sidebars to enable dynamic classes for the footer */
function mybaby_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-1' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;
		
	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'mybaby_comment' ) ) :
/* Template for comments and pingbacks. */
function mybaby_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'mybaby' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'mybaby' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 50;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'mybaby' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'mybaby' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'mybaby' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mybaby' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'mybaby' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for mybaby_comment()

if ( ! function_exists( 'mybaby_posted_on' ) ) :
/* Prints HTML with meta information for the current post-date/time and author. */
function mybaby_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'mybaby' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'mybaby' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
endif;

/* Adds two classes to the array of body classes: The first is if the site has only had one author with published posts, The second is if a singular post being displayed */
function mybaby_body_classes( $classes ) {
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}
	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'mybaby_body_classes' );

