<!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	<body  <?php body_class(); ?>>
		<div class="page-wrapper">
			<div class="main">
				<header id="branding" role="banner">
					<div id="headerimg">
						<h1 id="site-title">
							<span>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" style="color:#<?php header_textcolor(); ?>">
									<noscript><?php bloginfo( 'name' ); ?></noscript>
								</a>
							</span>
						</h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php if( get_header_image() ) : ?>
							<img src="<?php header_image(); ?>" title="<?php _e( 'image for header', 'central' ); ?>" alt="<?php _e( 'there is no image', 'central' ); ?>"/>
						<?php endif; ?>
					</div><!-- #headerimg -->
				</header>
	 		</div><!-- .main -->
			<div class="clear"></div>
			<div class="white-stripe">
				<div class="main nav">
					<?php wp_nav_menu( array(
								'theme_location' => 'main',
								'menu'           => 'main',
								'menu_class'     => 'main-menu',
						) );
					?>
				</div><!--main-nav-->
			</div><!-- .white-stripe -->
			<div class="clear"></div>
			<div class="main" id="page-content">
				<noscript>
					<p id="no-script-message"><?php _e( 'For a more correct display of information on the site you need to enable support of the JavaScript in the browser.', 'central' ); ?></p>
				</noscript>
				<?php if ( is_home() )
					central_slider_template(); ?>
