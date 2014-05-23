<?php /* the template to displaying information about the author of posts */
	get_header();
	get_sidebar();
?>
	<div id="content" role="main">
		<div class="post">
			<div class="block-header">
				<h2>
					<?php /* get author nickname */
						$curauth = ( isset($_GET['author_name']) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); 
						/* show author nickname */
						_e( 'About: ', 'central' );  
						echo $curauth->nickname; 
					?>
				</h2>
			</div><!-- .block-header -->
			<div class="post-text">
				<dl>
					<dt>
						<?php /* show url and description of the author */
							_e( 'Website', 'central' );
						?>
					</dt>
						<dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
					<dt><?php _e( 'Profile', 'central' ); ?></dt>
						<dd><?php echo $curauth->user_description; ?></dd>
				</dl>
				<h3><?php echo ( __( 'Posts by ', 'central' ) . $curauth->nickname ); ?>:</h3>
				<ul><!-- show list of the author`s posts-->
					<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post(); ?>
								<li>
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
									<?php the_title(); ?></a>, <?php the_date(); _e( ' in ', 'central' ); the_category( '&' ); ?>
								</li>
						<?php endwhile;
						else: ?>
							<p>
								<?php /* show the message if author has no posts */
								_e( 'No posts by this author.', 'central' ); ?>
							</p>
					<?php endif; ?>
				</ul>
			</div><!-- .post-text --> 
		</div><!-- .post -->
	</div><!-- #content -->
<div class="clear"></div>
<?php get_footer(); ?>
