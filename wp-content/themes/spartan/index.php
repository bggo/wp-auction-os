<?php get_header(); ?>

			<?php
							
								if ( of_get_option('homepage_layout') == 'magseven' ) {
									$homelayout = 'magseven';
								} elseif ( of_get_option('homepage_layout') == 'mageight' ) {
									$homelayout = 'mageight';
								} else {
									$homelayout = 'standard';
								}
							
								get_template_part( 'index', $homelayout );
							
							
			?>					

							
								
									
			<?php get_footer(); ?>