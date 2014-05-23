<?php get_header(); ?>

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">
               			<?php if(of_get_option('show_magpro_slider_page') == 'true') : ?>                    
						<?php get_template_part( 'slider', 'wilto' ); ?>
                  		<?php endif; ?>

                        <!-- Main Content Section starts here -->
                        <div id="main_content_section_search_title"> 
                        

                        		<h2 class="main_content_section_search_title"><?php _e('Search Results for : ', 'Spartan') ?><?php echo get_search_query(); ?></h2>

                        
                        </div>	
                        <!-- Main Content Section ends here --> 
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section_search">
                

			
                                    <?php if (have_posts()) : ?>
                                    <?php while (have_posts()) : the_post(); ?>	
                                    				
                                        <div class="magthree_left_individual_post">
                                            <div class="magfive_title">
                                                    <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                            </div>
                                            
                                            <?php if ( function_exists('the_ratings') && (!of_get_option('show_ratings_magseven') || of_get_option('show_ratings_magseven') == 'true')) : ?>
                                            <div class="magfive_title">
                                            
                                                    <div class="metadatamagthreeratings">
													<?php the_ratings();?>
                                                    </div>                                            
                                            
                                            </div>
                                            <?php endif; ?>                                            
                                            
                                            
                                            <div class="magfive_excerpt">
                                                    <p><?php echo Spartan_get_limited_string(get_the_excerpt(), 150, '...') ?></p>
                    								<p class="mag_post_excerpt_more"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Destro' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">Read More</a></p>
                    
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
												<?php 
													$next_page = get_next_posts_link(__('Previous', 'Spartan')); 
													$prev_pages = get_previous_posts_link(__('Next', 'Spartan'));
													if(!empty($next_page) || !empty($prev_pages)) :
													?>
													<div class="pagination">
														<?php if(!function_exists('wp_pagenavi')) : ?>
														<div class="al"><?php echo $next_page; ?></div>
														<div class="ar"><?php echo $prev_pages; ?></div>
														<?php else : wp_pagenavi(); endif; ?>
													</div><!-- /pagination -->
													<?php endif; ?>
													
												<?php else : ?>
													<div class="nopost">
														<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'Spartan') ?></p>
													 </div><!-- /nopost -->
												<?php endif; ?>


                
                
                        </div>	
                        <!-- Main Content Section ends here -->







                    </div>	
                    <!-- Inner Content Section ends here -->
							
			<?php get_footer(); ?>								
									

							
								
									
