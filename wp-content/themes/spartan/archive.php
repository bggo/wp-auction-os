<?php get_header(); ?>

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">

                        
               			<?php if(of_get_option('custom_header_home') == 'true') : ?>                      
                        <div id="featured_section_header">                            
                            	<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
                        </div>              
                        <?php endif; ?>

               			<?php if( !of_get_option('custom_header_home') || of_get_option('custom_header_home') == 'false' ) : ?>                      
							<?php if(!of_get_option('show_magpro_slider_archive') || of_get_option('show_magpro_slider_archive') == 'true') : ?>  
                            <?php get_template_part( 'slider', 'wilto' ); ?>                
                            <?php endif; ?>
                        <?php endif; ?>                        
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section">
                        
                        				<div class="archiveheading">
                                        
											<h2>
											
											<?php _e('Archives for : ', 'Spartan') ?>
                                        
                                            <?php 
                                            
                                            if ( is_category() ) {
                                                echo single_cat_title(); 
                                            }elseif ( is_tag() ) {
                                                echo single_tag_title();	
                                            }elseif ( is_date() ) {
                                                echo single_month_title();	
                                            }
                                            
                                            
                                            ?>
                                            
                                            </h2>                                         
                                        
                                        </div>                        
                

										<?php if (have_posts()) : ?>
											<?php $count = 0; while (have_posts()) : the_post(); $count++; ?>
												<!-- Actual Post starts here -->
												<div <?php post_class('actual_post') ?> id="post-<?php the_ID(); ?>">
													<div class="actual_post_title">
														<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
													</div>
                                                    <?php if ( function_exists('the_ratings') && (!of_get_option('show_ratings_standard') || of_get_option('show_ratings_standard') == 'true')) : ?>
                                                    <div class="actual_post_ratings">
                                                    	<?php the_ratings(); ?>
													</div>   
                                                    <?php endif; ?>                                                      
													<div class="actual_post_author">
														<div class="actual_post_posted"><?php _e('Posted by :','Spartan'); ?><span><?php the_author() ?></span> <?php _e('On :','Spartan'); ?> <span><?php the_time(get_option( 'date_format' )) ?></span></div>
														<div class="actual_post_comments"><?php comments_number( '0', '1', '%' ); ?></div>
													</div>
                                					<?php if(!of_get_option('show_ctags_standard') || of_get_option('show_ctags_standard') == 'true') : ?>                                                                        
													<div class="metadata">
														<p>
															<span class="label"><?php _e('Category:', 'Spartan') ?></span>
															<span class="text"><?php the_category(', ') ?></span>
														</p>
														<?php the_tags('<p><span class="label">'.__('Tags:','Spartan').'</span><span class="text">', ', ', '</span></p>'); ?>
														
													</div><!-- /metadata -->
                                                    <?php endif; ?>
													
													<div class="post_entry">

														<div class="entry">
															<?php the_content(__('<span>Continue Reading >></span>', 'Spartan')); ?>
															<div class="clear"></div>
															<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'Spartan' ) . '</span>', 'after' => '</div>' ) ); ?>																				
														</div>


													
													</div>
												</div>
												<!-- Actual Post ends here -->		
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

                        <!-- Sidebar Section starts here -->
                        <?php get_sidebar(); ?> 	
                        <!-- Sidebar Section ends here -->

                        <!-- Footer Sidebar Section starts here -->
               			<?php if(!of_get_option('show_footer_widgets_archive') || of_get_option('show_footer_widgets_archive') == 'true') : ?>                    
                        <?php get_template_part( 'magpro', 'footerwidgets' ); ?>	
                  		<?php endif; ?>                        
                        <!-- Footer Sidebar Section ends here -->




                    </div>	
                    <!-- Inner Content Section ends here -->
                    
           			<?php get_footer(); ?>
							
								
									

							
								
									
