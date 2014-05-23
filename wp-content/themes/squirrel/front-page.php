
<?php
/**
 * The template for displaying front page pages.
 *
 */
?>
<?php get_header(); ?>
<!--Start Header info-->
<div class="header-info">
    <?php if (squirrel_get_option('squirrel_first_head') != '') { ?>
        <h1><?php echo stripslashes(squirrel_get_option('squirrel_first_head')); ?></h1>
    <?php } else { ?>
        <h1><?php _e('WordPress Theme to easily create your Website', 'squirrel'); ?></h1>
    <?php } ?>    
    <?php if (squirrel_get_option('squirrel_second_head') != '') { ?>
        <h2><?php echo stripslashes(squirrel_get_option('squirrel_second_head')); ?></h2>
    <?php } else { ?>
        <h2><?php _e('Just few Clicks and your website is <a href="#">ready for go.', 'squirrel'); ?></a></h2>
    <?php } ?>
</div>
<!--End Header info-->
<div class="clear"></div>
<!--Start Slider-->
<div class="slider-wrapper">
    <div id="container">
        <div id="example">
            <div id="slides">
                <div class="slides_container">
                    <?php
                    //The strpos funtion is comparing the strings to allow uploading of the Videos & Images in the Slider
                    $mystring1 = squirrel_get_option('squirrel_image1');
                    $value_img = array('.jpg', '.png', '.jpeg', '.gif', '.bmp', '.tiff', '.tif');
                    $check_img_ofset = 0;
                    foreach ($value_img as $get_value) {
                        if (preg_match("/$get_value/", $mystring1)) {
                            $check_img_ofset = 1;
                        }
                    }
                    // Note our use of ===.  Simply == would not work as expected
                    // because the position of 'a' was the 0th (first) character.
                    ?>
                    <?php if ($check_img_ofset == 0 && squirrel_get_option('squirrel_image1') != '') { ?>
                        <div class="slide"><?php echo squirrel_get_option('squirrel_image1'); ?></div>
                    <?php } else { ?>
                        <?php if (squirrel_get_option('squirrel_image1') != '') { ?>
                            <div class="slide"><img src="<?php echo squirrel_get_option('squirrel_image1'); ?>"  alt="Slide 1"/></a> </div>
                        <?php } else { ?>
                            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/slide-1.jpg"  alt="Slide 1"/></div>
                        <?php }
                    } ?>   
                </div>
            </div>
        </div>
    </div>
    <div class="slider-info">
        <?php if (squirrel_get_option('squirrel_slidehead') != '') { ?>
            <h1><?php echo stripslashes(squirrel_get_option('squirrel_slidehead')); ?></h1>
        <?php } else { ?>
            <h1><?php _e('We are scope, a design firm in England', 'squirrel'); ?></h1>
        <?php } ?>            
        <?php if (squirrel_get_option('squirrel_slidedesc') != '') { ?>
            <p><?php echo stripslashes(squirrel_get_option('squirrel_slidedesc')); ?></p>            
        <?php } else { ?>
            <p><?php _e('Newfoundland dogs are good to save children from drowning, but you must have a pond of water handy and a child.', 'squirrel') ?></p>
            <p><?php _e('From drowning, but you must have a pond of water handy and a child.', 'squirrel'); ?></p>
        <?php } ?>            
    </div>
</div>
<!--End Slider-->
<div class="clear"></div>
<!--Start Index-->
<div class="full-content">
    <div class="text-featute">
        <div class="grid_12 alpha">
            <div class="text-featute-one">
                <?php if (squirrel_get_option('squirrel_leftcolhead') != '') { ?>
                    <h3><?php echo stripslashes(squirrel_get_option('squirrel_leftcolhead')); ?></h3>
                <?php } else { ?>
                    <h3><?php _e('Powerful Reporting', 'squirrel'); ?></h3>
                <?php } ?>                
                <?php if (squirrel_get_option('squirrel_leftcoldesc') != '') { ?>
                    <p><?php echo stripslashes(squirrel_get_option('squirrel_leftcoldesc')); ?></p>
                <?php } else { ?>
                    <p><?php _e('Product Developers/ Internet Marketer make more products sales when they can easily display their products with the buy links in the perfecter location.', 'squirrel'); ?></p>
                <?php } ?>                
            </div>
        </div>
        <div class="grid_12 omega"></div>
        <div class="text-featute-two">
            <?php if (squirrel_get_option('squirrel_rightcolhead') != '') { ?>
                <h3><?php echo stripslashes(squirrel_get_option('squirrel_rightcolhead')); ?></h3>
            <?php } else { ?>
                <h3><?php _e('Mobile Device Friendly', 'squirrel'); ?></h3>
            <?php } ?>              
            <?php if (squirrel_get_option('squirrel_rightcoldesc') != '') { ?>
                <p><?php echo stripslashes(squirrel_get_option('squirrel_rightcoldesc')); ?></p>
            <?php } else { ?>
                <p><?php _e('Product Developers Internet Marketer make more sales when and they can easily display their products with the buy links in the perfect location.', 'squirrel'); ?></p>
            <?php } ?>             
        </div>
    </div>
    <div class="clear"></div>
    <div class="index-fullwidth">
        <?php if (squirrel_get_option('squirrel_fullcolhead') != '') { ?>
            <h3><?php echo stripslashes(squirrel_get_option('squirrel_fullcolhead')); ?></h3>
        <?php } else { ?>
            <h3><?php _e('Google Apps & Ms Exchange', 'squirrel'); ?></h3>
        <?php } ?>            
        <?php if (squirrel_get_option('squirrel_fullcoldesc') != '') { ?>
            <p><?php echo stripslashes(squirrel_get_option('squirrel_fullcoldesc')); ?></p>
        <?php } else { ?>
            <p><?php _e("Product Developers/ Internet Marketer make more sales when they can easily display their products with the buy links in the perfect location. Products with the buy link.My husband and I are either goinuy a dog or have a child. We can't decide whether to ruin our carpets or ruin our lives. ", 'squirrel'); ?></p>
        <?php } ?>            
    </div>
</div>
</div>
<div class="clear"></div>
<!--End Index-->
<?php get_footer(); ?>