<?php get_header(); ?>

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">
               			<?php if(of_get_option('show_magpro_slider_page') == 'true') : ?>                    
						<?php get_template_part( 'slider', 'wilto' ); ?>
                  		<?php endif; ?>
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section_search">
                


							<div class="fouroh">
                            	<h2><?php _e('Not Found!', 'Spartan') ?></h2>
                                <p><?php _e('You are looking for something that is not here. Please use the seach form below.', 'Spartan') ?></p>
                                <div class="fourohsearch">
                                	<?php get_search_form(); ?>
                                </div>
                                
                                
                            </div>	

                
                
                        </div>	
                        <!-- Main Content Section ends here -->







                    </div>	
                    <!-- Inner Content Section ends here -->
							
			<?php get_footer(); ?>								
									

							
								
									
