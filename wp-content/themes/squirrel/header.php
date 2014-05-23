<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title> 
            <?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;
            wp_title('|', true, 'right');
// Add the blog name.
            bloginfo('name');
// Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && ( is_home() || is_front_page() ))
                echo " | $site_description";
// Add a page number if necessary:
            if ($paged >= 2 || $page >= 2)
                echo ' | ' . sprintf(__('Page %s', 'squirrel'), max($paged, $page));
            ?>
        </title>     
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />       
        <?php
        wp_head();
        ?>        
    </head>

    <body <?php body_class(); ?> style="<?php if (squirrel_get_option('squirrel_bodybg') != '') { ?>background:url(<?php echo squirrel_get_option('squirrel_bodybg'); ?>)<?php } else {
            
        }
        ?>" >
        <div class="main-container">
            <div class="container_24">
                <div class="grid_24">
                    <div class="main-content">
                        <!--Start Header-->
                        <div class="header">
                            <div class="logo"> <a href="<?php echo home_url(); ?>"><img src="<?php if (squirrel_get_option('squirrel_logo') != '') { ?><?php echo squirrel_get_option('squirrel_logo'); ?><?php } else { ?><?php echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" /></a></div>
                        </div>
                        <!--End Header-->
                        <div class="clear"></div>
                        <!--Start Menu wrapper-->
                        <div class="menu_wrapper">
                        <?php squirrel_nav(); ?>
                        </div>
                        <!--End Menu-->