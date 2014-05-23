

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">
               			<?php if(of_get_option('custom_header_home') == 'true') : ?>                      
                        <div id="featured_section_header">                            
                            	<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
                        </div>              
                        <?php endif; ?>

               			<?php if( !of_get_option('custom_header_home') || of_get_option('custom_header_home') == 'false' ) : ?>                      
							<?php if(!of_get_option('show_magpro_slider_home') || of_get_option('show_magpro_slider_home') == 'true') : ?>  
                            <?php get_template_part( 'slider', 'wilto' ); ?>                
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section_magthree">
                
                                    <!--Left column starts here-->
                                    <div id="magthree_left">			
                                    <?php if (have_posts()) : ?>
                                    <?php while (have_posts()) : the_post(); ?>	
                                    	<?php 
													$magprorecentthumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'Spartanthumb', false, '' ); 

										
										?>				
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
                                            
                                            <?php if( !empty($magprorecentthumb) && ( !of_get_option('show_postthumbnail_mageight') || of_get_option('show_postthumbnail_mageight') == 'true' ) ) :?>
                                            <div class="magthree_featured_image_full">
                                                <img src="<?php echo $magprorecentthumb[0]; ?>" alt="<?php echo Spartan_get_limited_string(get_the_title(), 40, '...') ?>" />
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
                                    <!--Left column ends here--> 
                                    
                                    <!--Right column starts here-->					
                                    <div id="magthree_right">

                                        <div id="vertical_category_box_holder">
                                        <?php
                                            
											if ( !of_get_option('mageight_catbox_id') ) {
												$cats_ids = '1';
											}else {
												$cats_ids = of_get_option('mageight_catbox_id');
											}
                                            $cats_ids = explode(',',$cats_ids);
                                            for($i=0; $i<count($cats_ids); $i++)
                                            if(isset($cats_ids[0]) && $cats_ids[0]>0)
                                            {
                                        
                                        ?>
                                        
                                        <!--Category column starts here-->
                                                            <?php
                                                                
                                                                echo '<div class="magseven_category_column_vertical">';
                                                                
                                        
                                                                $postcount = 1;
                                                                $the_query = new WP_Query('cat='.$cats_ids[$i].'&posts_per_page='.$postcount);
                                                                    if (have_posts()) : while ($the_query->have_posts() ) : $the_query->the_post(); ?>
                                                                <div class="mag_category_column_title_vertical">
                                                                    <h2><?php echo get_cat_name($cats_ids[$i]); ?></h2>
                                                                </div>
                                                                <!--first post starts-->
                                                                <div class="mag_category_column_firstpost_vertical">
                                                                    <div class="mag_category_column_individual_post_vertical">
                                                                        <div class="titlemag_category_column_vertical">
                                                                            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                                                        </div>
                                                                        <?php if ( function_exists('the_ratings') && (!of_get_option('show_ratings_mageight_cat') || of_get_option('show_ratings_mageight_cat') == 'true')) : ?>
                                                                        <div class="metadatamag_category_column_vertical">
                                                                        <?php the_ratings(); ?>
                                                                        </div>
                                                                        <?php endif; ?>
                                                                        <div class="mag_category_column_featured_image_vertical">
                                                                            <?php 
                                                                                            $magprocatvertthumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'Spartanthumb', false, '' ); 
                                                                            ?>	
                                                                            <img src="<?php echo $magprocatvertthumb[0]; ?>" alt="<?php echo Spartan_get_limited_string(get_the_title(), 40, '...') ?>" />
                                                                        </div>
                                                                        <div class="excerpt_mag_category_column_vertical">
                                                                                <?php echo Spartan_get_limited_string(get_the_excerpt(), 150, '...') ?>
                                                
                                                
                                                                        </div>
                                        
                                                                    </div>
                                                                    <?php endwhile; endif; wp_reset_postdata();  ?>
                                                                
                                                                </div>
                                                                <!-- first posts ends-->
                                                                
                                                                <!-- second posts starts-->
                                                                <div class="mag_category_column_secondpost_vertical">
                                                                    <?php 
                                                                    $postcount = of_get_option('mageight_catbox_num') -1;
                                                                    $the_query = new WP_Query('cat='.$cats_ids[$i].'&offset=1&posts_per_page='.$postcount);
                                                                    if (have_posts()) : while ($the_query->have_posts() ) : $the_query->the_post(); ?>
                                                                    <div class="mag_category_column_secondindividual_post_vertical">
                                                                        <div class="titlemag_category_secondcolumn_vertical">
                                                                            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                                                        </div>
                                                                        
                                                                        
                                                                        
                                                                        
                                                                    </div>
                                                                    <?php endwhile; endif; wp_reset_postdata();  ?>
                                                                
                                                                </div>
                                                                
                                                                
                                                                <!-- second posts ends-->
                                                                
                                                            
                                                            
                                                            </div>
                                                            <!--Category column ends here-->
                                        
                                            <?php
                                            }
                                        ?>					
                                        </div>   
                                    
                                    </div>	
                                    <!--Right column ends here-->                                                   				

                
                
                        </div>	
                        <!-- Main Content Section ends here -->

                        <!-- Sidebar Section starts here -->
                        <?php get_sidebar(); ?> 
                        <!-- Sidebar Section ends here -->



                    </div>	
                    <!-- Inner Content Section ends here -->
							
								
									
