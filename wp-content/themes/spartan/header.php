<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php global $query_string; ?><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <title><?php wp_title(); ?></title>
	
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?> " type="text/css" media="all" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


    
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- Wrapper one starts here -->
	<div id="wrapper_one">	
	<!-- Wrapper four starts here -->
	<div id="wrapper_four">    

		<!-- Wrapper one starts here -->
		<div id="wrapper_two">


            
			<!-- Wrapper three starts here -->
			<div id="wrapper_three">
            

                 <!-- Logo Section starts here -->
                 <div id="logo_section">
                    

                            <div id="logo">
                                <p class="logo_title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a></p>
                                <p class="logo_desc"><?php bloginfo('description'); ?></p>
                            </div>
                           
            
                </div>	
                <!-- Logo Section ends here -->	                 			

                  
                <!-- Content Section starts here -->
                <div id="content_section">

                    
   
                    
                    <!-- Menu Section starts here -->
                    
            			<div id="menu">
							<?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_class' => 'dropdown dropdown-horizontal','fallback_cb' => 'Spartan_backupmenu', 'menu_id'=>'Main_nav', 'container'=>'') ); ?>			
                        </div>
 

                   
                    <!-- Menu Section ends here -->	                                      