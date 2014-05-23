                                                    
                                                    
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