                        <!-- Featured Section starts here -->
                        <div id="featured_section_wilto">	
                        
                            <div class="slidecont">	
                                <div class="slidewrap2">
                                    
									<?php 
                                        if ( of_get_option('magpro_slidernumposts') ) {
                                            $slidernumposts = of_get_option('magpro_slidernumposts');
                                        } else {
                                            $slidernumposts = '5';	
                                        }
                                        $slidercat = of_get_option('magpro_slidercat');
                                        
                                        $the_query = new WP_Query('ignore_sticky_posts=1&cat='.$slidercat.'&post_type=post&showposts='.$slidernumposts); ?>
                                    <?php if (have_posts()) : ?>                                    
                                    <ul class="slider">
                                    <?php while ($the_query->have_posts() ) : $the_query->the_post(); ?>
                                    
                                        <li class="slide">	
                                            <?php 
											
											
											if ( has_post_thumbnail()) { 
                                                                    
													$wiltoimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'Spartanthumb', false, '' );
													$wiltoimagealt = Spartan_get_limited_string(get_the_title(), 40, '...');											
													echo '<div class="wrimg"><img alt="'.$wiltoimagealt.'" src="'.$wiltoimage[0].'" /></div>';													
                                            }else {
													$wiltoimage = get_template_directory_uri().'/images/sliderdefault.png';
													$wiltoimagealt = Spartan_get_limited_string(get_the_title(), 40, '...');											
													echo '<div class="wrimg"><img alt="'.$wiltoimagealt.'" src="'.$wiltoimage.'" /></div>';													
											}												
											
                                            ?>                                        	
                                            <div class="wrtext">
                                            	<div class="wrsubtexth2">
                                                    <h2>
                                                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo Spartan_get_limited_string(get_the_title(), 40, '...') ?></a>
                                                    </h2>
                                                </div>
                                                
                                                <div class="wrsubtext">
                                                    <p>
                                                        <?php echo Spartan_get_limited_string(get_the_excerpt(), 150, '...') ?>
                                                    </p>
                                                </div>
                                                
                                                <div class="wrsubtextmore">
                                                    <p>
                                                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spartan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e('Read More','Spartan'); ?></a>
                                                    </p> 
                                                </div>                                           
                                            </div>
                                        </li>
                                    
                                    <?php endwhile;  ?>    
                                        
                                    </ul>
                                    <?php endif; wp_reset_postdata(); ?>  
                                    
                                </div>
                            </div>	

                        </div>	
                        <!-- Featured Section ends here -->	                      
