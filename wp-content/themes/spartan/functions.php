<?php
if ( ! isset( $content_width ) )
	$content_width = 520;

$Spartan_themename = "Spartan";
$Spartan_textdomain = "Spartan";

function Spartan_setup(){
  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'mainmenu' => __( 'Main Navigation', 'Spartan' )
  ) );

  // This theme uses post thumbnails
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'Spartanthumb', 450, 300, true );  
  add_image_size( 'Spartansingle', 1200, 500, true );    
  // Add default posts and comments RSS feed links to head
  add_theme_support( 'automatic-feed-links' );
  add_filter( 'use_default_gallery_style', '__return_false' );   
  if ( of_get_option('skin_style') ) {
  	$custombgargsskin = of_get_option('skin_style');
  }else {
  	$custombgargsskin = 'silver';
  }
  $custombgargs = array(
	'default-color' => 'f9f7ea',
	'default-image' => get_template_directory_uri() . '/images/'.$custombgargsskin.'/page_bg.png',
	);
  add_theme_support( 'custom-background', $custombgargs );
  $customhargs = array(
	'flex-width'    => true,
	'width'         => 1200,
	'flex-height'    => true,
	'height'        => 500,
	'header-text'   => false,
  );
  add_theme_support( 'custom-header', $customhargs );
  add_editor_style();
  add_theme_support( 'post-formats', array( 'quote' ) );
  load_theme_textdomain('Spartan', get_template_directory() . '/languages');
    
}
add_action( 'after_setup_theme', 'Spartan_setup' );

/* 
 * Loads the Options Panel
 */
 
if ( !function_exists( 'optionsframework_init' ) ) {

	/* Set the file path based on whether we're in a child theme or parent theme */


		define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');


	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>

<?php
}













/**
 * Get ID of the page, if this is current page
 */
function Spartan_get_page_id() {
	global $wp_query;

	$page_obj = $wp_query->get_queried_object();

	if ( isset( $page_obj->ID ) && $page_obj->ID >= 0 )
		return $page_obj->ID;

	return -1;
}

/**
 * Get custom field of the current page
 * $type = string|int
 */
function Spartan_get_custom_field($filedname, $id = NULL, $single=true)
{
	global $post;
	
	if($id==NULL)
		$id = get_the_ID();
	
	if($id==NULL)
		$id = Spartan_get_page_id();

	$value = get_post_meta($id, $filedname, $single);
	
	if($single)
		return stripslashes($value);
	else
		return $value;
}

/**
 * Get Limited String
 * $output = string
 * $max_char = int
 */
function Spartan_get_limited_string($output, $max_char=100, $end='...')
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);
    $output = strip_shortcodes($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).$end;
		return $output;
   }
   else
   {
      return $output;
   }
}

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param mixed $cats The target categories. Integer ID or array of integer IDs
 * @param mixed $_post The post
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Gets descendants of target category
 * @uses in_category() Tests against descendant categories
 * @version 2.7
 */
function Spartan_post_is_in_descendant_category( $cats, $_post = null )
{
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

/**
 * Custom comments for single or page templates
 */
function Spartan_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   
   <div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">  <?php echo get_avatar($comment,'82'); ?> <cite class="fn"><?php echo get_comment_author_link(); ?></cite></div>
		<div class="comment-meta commentmetadata"><a href="<?php echo esc_html( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s','Spartan'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)','Spartan'),'  ','') ?></div>
      <?php if ($comment->comment_approved == '0') : ?>
         <p><em><?php _e('Your comment is awaiting moderation.','Spartan') ?></em></p>
      <?php endif; ?>
		<div class="entry">
		<?php comment_text() ?>
		</div>
		<div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
	</div>
<?php
}

/**
 * Browser detection body_class() output
 */
function Spartan_browser_body_class($classes) {
	global $is_Spartan, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_Spartan) $classes[] = 'Spartan';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}
/**
 * Add StyleSheets
 */
function Spartan_add_stylesheets( ) {
	
	if( !is_admin() ) {

								wp_enqueue_style('Spartan_dropdowncss', get_stylesheet_directory_uri().'/css/dropdown.css');
								wp_enqueue_style('Spartan_rtldropdown', get_stylesheet_directory_uri().'/css/dropdown.vertical.rtl.css');
								wp_enqueue_style('Spartan_advanced_dropdown', get_stylesheet_directory_uri().'/css/default.advanced.css');

								
								echo '<!--[if lte IE 7]>
<style type="text/css">
html .jquerycssmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]--> ';

								wp_enqueue_style('Spartan_wilto', get_stylesheet_directory_uri().'/css/wilto.css');
									



									if( of_get_option('skin_style') == 'black' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/black.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/blackresponsive.css');										
									}elseif( of_get_option('skin_style') == 'blue' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolor', get_template_directory_uri().'/skins/blue.css');																														
									}elseif( of_get_option('skin_style') == 'brown' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/brown.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'green' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/green.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'orange' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/orange.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'pink' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_stylesheet_directory_uri().'/css/slider/pink.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'purple' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/purple.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'red' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/red.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																				
									}elseif( of_get_option('skin_style') == 'yellow' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/yellow.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																			
									}elseif( of_get_option('skin_style') == 'silver' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_sliderbg', get_template_directory_uri().'/css/slider/silver.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/responsive.css');																			
									}elseif( of_get_option('skin_style') == 'oren' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_template_directory_uri().'/skins/oren.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_template_directory_uri().'/skins/orenresponsive.css');																			
									}elseif( of_get_option('skin_style') == 'bred' ) {
										wp_enqueue_style('Spartan_bredstyle', get_template_directory_uri().'/skins/bred.css');
										wp_enqueue_style('Spartan_bredresponsive', get_template_directory_uri().'/skins/bredresponsive.css');																			
									}elseif( of_get_option('skin_style') == 'gren' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_grenstyle', get_template_directory_uri().'/skins/gren.css');
									}elseif( of_get_option('skin_style') == 'aqua' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/aqua.css');																		
									}elseif( of_get_option('skin_style') == 'bgre' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/bgre.css');																		
									}elseif( of_get_option('skin_style') == 'blby' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/blby.css');																		
									}elseif( of_get_option('skin_style') == 'blbr' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/blbr.css');																		
									}elseif( of_get_option('skin_style') == 'brow' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/brow.css');																		
									}elseif( of_get_option('skin_style') == 'yrst' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/yrst.css');																		
									}elseif( of_get_option('skin_style') == 'grun' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/grun.css');																		
									}elseif( of_get_option('skin_style') == 'kafe' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/kafe.css');																		
									}elseif( of_get_option('skin_style') == 'slek' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/slek.css');																		
									}elseif( of_get_option('skin_style') == 'krem' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/krem.css');																		
									}elseif( of_get_option('skin_style') == 'grngy' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/grngy.css');																		
									}elseif( of_get_option('skin_style') == 'kopr' ) {
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/skins/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/skins/responsive.css');
										wp_enqueue_style('Spartan_Defaultcolors', get_stylesheet_directory_uri().'/skins/kopr.css');																		
									}else {
										wp_enqueue_style('Spartan_sliderbg', get_stylesheet_directory_uri().'/css/slider/silver.css');
										wp_enqueue_style('Spartan_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
										wp_enqueue_style('Spartan_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');										
									}
									
									?>
										<style type="text/css">
                                                .magfive_title h2 a{ color:<?php echo esc_attr( of_get_option('post_title_color') ); ?> }
												.actual_post_title h2 a{ color:<?php echo esc_attr( of_get_option('post_title_color') ); ?> !important}
												.actual_post_title_page h2{ color:<?php echo esc_attr( of_get_option('post_title_color') ); ?> !important}
                                        </style>	
									<?php  									

	}
}
/**
 * Add JS scripts
 */
function Spartan_add_javascript( ) {

	if (is_singular() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');
		
	wp_enqueue_script('jquery');
	
	if( !is_admin() ) {

		wp_enqueue_script('Spartan_jquery', get_template_directory_uri().'/js/respond.min.js' );
		wp_enqueue_script('Spartan_respmenu', get_template_directory_uri().'/js/tinynav.min.js' );	
		wp_enqueue_script('Spartan_wilto', get_template_directory_uri().'/js/wilto.js');
		wp_enqueue_script('Spartan_wiltoint', get_template_directory_uri().'/js/wilto.int.js');

	}

}



/**
 * Register widgetized areas
 */
function Spartan_the_widgets_init() {

    
    $before_widget = '<div id="%1$s" class="sidebar_widget %2$s">
																			
																			<div class="widget">';
    $after_widget = '</div>
																			
																		</div>';
    $before_title = '<h3 class="widgettitle">';
    $after_title = '</h3>';

	
	

    register_sidebar(array('name' => __('Default','Spartan'),'id' => 'default','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));
   
}

/**
 * Filter for get_the_excerpt
 */
 
function Spartan_get_the_excerpt($content){
	return str_replace(' [...]','',$content);
}

/**
 * Get the sidebar ID
 */
 
function Spartan_get_sidebar_id(){
	global $post;
	$sidebar_id = 'sidebar-default';
	if(isset($post->ID))
		if(is_active_sidebar('sidebar-'.$post->ID))
			$sidebar_id = 'sidebar-'.$post->ID;
	return $sidebar_id;
}

function Spartan_backupmenu() {
	 	if ( current_user_can('edit_theme_options') ) {
				echo '	<ul id="Main_nav" class="dropdown dropdown-horizontal">
							<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">
								<a href="'.get_admin_url().'nav-menus.php">'.__("Select a Menu to appear here in Dashboard->Appearance->Menus", "Spartan").'</a>
							</li>
		
						</ul>	';
		} else {
				echo '	<ul id="Main_nav" class="dropdown dropdown-horizontal">
							<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">
								<a href="'.esc_url( get_home_url() ).'">'.__("Home", "Spartan").'</a>
							</li>
		
						</ul>	';			
		}
}

/* Wp Title */
function Spartan_doc_title( $doc_title ) {
        if( is_category() ) {
                $doc_title = __( 'Category: ', 'Spartan' ) . $doc_title . ' - ';
        } elseif( is_tag() ) {
                $doc_title = single_tag_title( __( 'Tag Archive for &quot;', 'Spartan'), false ) . '&quot; - ';
        } elseif( is_archive() ) {
                $doc_title .= __( ' Archive - ', 'Spartan' );
        } elseif( is_page() ) {
                $doc_title .= ' - ';
        } elseif( is_search() ) {
                $doc_title = __('Search for &quot;','Spartan') . get_search_query() . '&quot; - ';
        } elseif( ! is_404() && is_single() || is_page() ) {
                $doc_title .= ' - ';
        } elseif( is_404() ) {
                $doc_title = __( 'Not Found - ', 'Spartan' );
        }
        $doc_title .= get_bloginfo('name');
        return $doc_title;
}

add_filter( 'wp_title', 'Spartan_doc_title' );

add_filter( 'the_content_more_link', 'Spartan_more_link', 10, 2 );

function Spartan_more_link( $more_link, $more_link_text ) {
	return '<br /><br />'.$more_link;
}

add_filter('the_title','Spartan_has_title');
function Spartan_has_title($title){
	global $post;
	if($title == ''){
		return get_the_time(get_option( 'date_format' ));
	}else{
		return $title;
	}
}




if (!is_admin()){
	add_action( 'wp_print_styles', 'Spartan_add_stylesheets' );	
	add_action( 'wp_enqueue_scripts', 'Spartan_add_javascript' );
}

add_filter('body_class','Spartan_browser_body_class');
add_filter('the_excerpt', 'Spartan_get_the_excerpt');
add_filter('get_the_excerpt', 'Spartan_get_the_excerpt');
add_action( 'widgets_init', 'Spartan_the_widgets_init' );

// Allow Shortcodes in Sidebar Widgets
add_filter('widget_text', 'do_shortcode');

/**
 * Add default options and show Options Panel after activate
 */
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	
	//Do redirect

	wp_redirect( admin_url( 'admin.php?page=options-framework' ) ); exit;
	
}

?>