<?php
/* set the content width based on the theme's design and stylesheet */
if ( ! isset( $content_width ) )
	$content_width = 560;


/* sets up the theme by registering support for various features in WordPress, such as post thumbnails, navigation menus, and the like */
function central_setup() {
	/* load_theme_textdomain() for translation/localization support */
	load_theme_textdomain( 'central', get_template_directory().'/languages' );
	/* add_editor_style() to style the visual editor */
	add_editor_style();
	/* add_theme_support() to add support for post thumbnails, automatic feed links, custom headers, backgrounds, menues and post formats */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'video', 'audio', 'chat' ) );
	add_theme_support('menus');	
	/* register_nav_menus() to add support for navigation menus*/
	register_nav_menu( 'main', __( 'main menu', 'central' ) );	
	/* add_action for include stylesheets and javascripts of theme */
	add_theme_support( 'custom-background', array( 'default-color' => 'f8f6f5', ) );	
	$args = array( 'width' => 940, 'height' => 220, 'default-text-color' => '333','uploads' => true, );
	add_theme_support( 'custom-header', $args );
	add_theme_support( 'post-thumbnails' );
	/* add_image_size() to custom image size */
	add_image_size( 'slider-thumb', 900, 218 ); //for slider
	add_image_size( 'medium', 300, 300 ); //for gallery or another
	add_image_size( 'large', 500, 500 ); //for gallery or another
}

/* show in the <title> tag based on what is being viewed */
function central_title( $title, $sep ){
	global $paged, $page;
	if ( is_feed() )
		return $title;
	// Add the site name.
	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	// Add a page number if necessary.
	if ( 2 <= $paged || 2 <= $page )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'central' ), max( $paged, $page ) );
	return $title;
}

/* some javascript variables for the translation */
function central_js_variables(){ ?>
	<script>
		var chooseFile='<?php _e( 'Choose file..' , 'central' ); ?>';
		var fileSelected='<?php _e( 'File selected' , 'central' ); ?>';
		var fileNotSelected='<?php _e( 'File is not selected' , 'central' ); ?>';
		var blogName='<?php echo get_bloginfo( 'name' ) ?>';
	</script>
<?php }

/* including the javascript of the theme */
function central_scripts(){
	wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'jquery-shadow', get_template_directory_uri() . '/js/jquery.shadow.js', array( 'jquery' ) );
	wp_enqueue_script( 'variables', central_js_variables() );
	wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/js/script.min.js', array( 'jquery', 'jquery-color', 'jquery-shadow' ) );
	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );
}

/* get wp_nav_menu() fallback, wp_page_menu(), to show a home link. */
function central_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
/* function to add menu of slier in admin page*/
function central_slider_menu() {
	add_theme_page( __( 'Slider', 'central' ), __( 'Slider', 'central' ), 'edit_themes', 'central_slider', 'central_slider_page' );
}
/* register slider settings */ 
function central_slider_settings() {
	global $central_option_default, $central_option;
	$central_option_default = array (
		'slider_category' => '1',
	);
	if ( ! get_option( 'central_slider' ) )
		add_option( 'central_slider', $central_option_default, '', 'yes'  );
	$central_option = get_option( 'central_slider' );
	$central_option = array_merge( $central_option_default, $central_option );
	update_option( 'central_slider', $central_option );
}
/* admin page of slider */
function central_slider_page() { 
	global $central_option;
	$error = '';
	if( isset( $_POST['central_form_submit'] ) && check_admin_referer( get_template_directory_uri(), 'central_nonce_name' ) ) {
		$central_form_submit['slider_category'] = isset( $_POST['slider_category'] ) ? $_POST['slider_category'] : 0;
		$central_option = array_merge( $central_option, $central_form_submit );
		if ( $error == '' ) {
			update_option( 'central_slider', $central_option, '', 'yes' );
			$message = __( "Settings saved.", 'central' );
		}
	}
	$categories = get_categories(); ?>
	<div class="wrap">
		<h2><?php _e( 'Slider', 'central' ) ?></h2>
		<div class="updated fade" <?php if( ! isset( $_POST['central_form_submit'] ) || $error != "" ) echo 'style="display:none"'; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error" <?php  if( "" == $error ) echo 'style="display:none"'; ?>><p><strong><?php echo $error; ?></strong></p></div>
		<form method="post" action="admin.php?page=central_slider">
			<label><?php _e( 'Choose category which you want display in slider', 'central' ); ?></label><br/>
			<span class="central-tips" style="font-size: 0.85em; color: #999;"><?php _e( '( for displaying a slides you need set a status "draft" for posts of chosen category which you want to see in slider )', 'central' ); ?></span><br/>
			<select name="slider_category">
				<?php foreach ( $categories as $category ) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if ( $category->cat_ID == $central_option['slider_category'] ) echo 'selected="selected"'; ?>><?php echo $category->name . ' (' . $category->category_count . ')'; ?></option>
				<?php }?>
			</select>
			<input type="hidden" name="central_form_submit" value="submit"/>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'central' ); ?>" />
			</p>
			<?php wp_nonce_field( get_template_directory_uri(), 'central_nonce_name' ); ?>
		</form>

	</div><!-- .wrap -->
<?php }

/* the template to displaying the sider*/
function central_slider_template(){
	global $wp_query, $central_option;
	/* save old value of variable wp_query */
	$original_query = $wp_query;
	/*add new and change value of variable wp_query*/
	$wp_query = null;
	$args = array( 
			'cat' => $central_option['slider_category'],
			'post_status'    => 'draft',
			'posts_per_page' => '-1',
	);
	$wp_query = new WP_Query( $args );
	if ( $wp_query->have_posts() ) : ?>
		<div class="slider-wrap">
			<div class="slider">
				<!-- list of slides in the loop -->
				<ul class="slides">
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<li><!-- show featured image, title and text-content of slides -->
							<?php if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'slider-thumb' ); ?>
								<p class="slider-title"><?php the_title(); ?></p>
								<?php the_content();
							else : /* if no thumbnail */ ?>
								<p class="no-image-message">
									<?php _e( 'Slide ', 'central' ); ?><strong><?php the_title(); ?></strong><?php _e( ' have not chosen image. </br>You need to add an featured image for this post from "Dashboard" ', 'central' ); ?>
								</p>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
				</ul>
				<!-- end the loop-->
			</div><!-- .slider -->
			<div class="slider-nav"></div>
		</div><!-- .slider-wrap -->
		<div class="clear"></div>
	<?php endif; /* restore the old value of variable wp_query*/
	$wp_query = null;
	$wp_query = $original_query;
	wp_reset_postdata(); 
}

/*register sidebar*/
function central_widget_init() {
	register_sidebar( array(
		'name'          => __( 'sidebar', 'central' ),
		'description'   => __( 'Left column to display the widgets', 'central' ),
		'id'            => 'sidebar',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
		) );
}

/* show featured image title in posts */
function central_featured_img_title() {
	global $post;
	$thumbnail_id = get_post_thumbnail_id( $post -> ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment', 'post_status' => 'any' ) );
	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		echo '<p>' . $thumbnail_image[0] -> post_title . '</p>';
	}
}

/* returns a "Continue reading" link for excerpts */
function central_continue_reading_link(){
	return ' <a href="'.esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'central' ) . '</a>';
}

/* replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and central_continue_reading_link() */
function central_auto_excerpt_more( $more ) {
	return ' &hellip;' . central_continue_reading_link();
}

/* adds a "Continue reading" link to custom post excerpts */
function central_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= central_continue_reading_link();
	}
	return $output;
}

/* template for comments and pingbacks */
function central_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// display trackbacks differently than normal comments. ?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'central' ); comment_author_link();  edit_comment_link( __( '(Edit)', 'central' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php break;
		default :
			// proceed with normal comments.
			global $post; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
							echo get_avatar( $comment, 44 );
							printf( '<cite class="fn">%1$s %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'central' ) . '</span>' : '' );
							echo '</br>';
							printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'central' ), get_comment_date(), get_comment_time() )
							);
						?>
					</header><!-- .comment-meta -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'central' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text();
							 edit_comment_link( __( 'Edit', 'central' ), '<p class="edit-link">', '</p>' );
						 ?>
					</section><!-- .comment-content -->
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'central' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->
			<?php break;
	endswitch; // end comment_type check
}

/* display navigation to next/previous pages when applicable */
function central_content_nav( $html_id ) {
	global $wp_query;
	if ( 1 < $wp_query -> max_num_pages ) : ?>
		<div class="post">
			<div class="post-text">
				<nav id="<?php echo esc_attr( $html_id ); ?>">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'central' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'central' ) ); ?></div>
				</nav><!-- #nav-above -->
			</div><!-- .post-text -->
		</div><!-- .post -->
	<?php endif;
}

/* add all hooks */
add_action( 'after_setup_theme', 'central_setup' );
add_filter( 'wp_title', 'central_title', 10, 2 );
add_action( 'wp_enqueue_scripts', 'central_scripts' );
add_filter( 'wp_page_menu_args', 'central_page_menu_args' );
add_action( 'init', 'central_slider_settings' );
add_action( 'admin_menu', 'central_slider_menu' );
add_action( 'widgets_init', 'central_widget_init' );
add_filter( 'excerpt_more', 'central_auto_excerpt_more' );
add_filter( 'get_the_excerpt', 'central_custom_excerpt_more' );
?>
