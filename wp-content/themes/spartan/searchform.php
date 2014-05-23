<?php $search_query = get_search_query(); if(empty($search_query)) $search_query = __('Enter search query here...', 'Spartan'); $sgo = __('Go', 'Spartan'); ?>
							<div class="seach_section">
									<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<fieldset>
										<p class="searchtext"><input type="text" onblur="if(this.value=='') this.value='<?php echo $search_query ?>'" onfocus="if(this.value=='<?php echo $search_query ?>') this.value=''" value="<?php echo $search_query; ?>" name="s" class="text" /></p>
										<p class="searchsub"><input class="submit" type="submit" value="<?php echo $sgo ?>" /></p>
									</fieldset>
									</form>
							</div>