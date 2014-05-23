<?php /* the template for displaying comments */
	if ( post_password_required() ) : ?>
		<div id="comments" class="comments-area">
			<p class="password-required"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'central' ); ?></p>
		</div>
		<?php return;
	endif;
	if ( comments_open() ) : 
		 if ( have_comments() ) : ?>
			<div id="comments" class="comments-area">
				<h2 class="comments-title">
					<?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'central' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?>
				</h2>
				<ol class="commentlist">
					<?php /* show coments list */
						wp_list_comments( array( 'callback' => 'central_comment', 'style' => 'ol' ) ); ?>
				</ol><!-- .commentlist -->
				<?php /* show comments navigation */
					if ( 1 < get_comment_pages_count() && get_option( 'page_comments' ) ) : ?>
					<nav id="comment-nav-below" class="navigation" role="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'central' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'central' ) ); ?></div>
					</nav>
				<?php endif; 
				/* show comment form */
				comment_form(); ?>
			</div><!-- #comments .comments-area -->
		<?php else: ?>
			<div id="comments" class="comments-area">
				<?php /* show comment form */
				comment_form(); ?>
			</div><!-- #comments .comments-area -->
	<?php endif; ?>
<?php else: /*show message if comments are closed and is not a page*/
		if ( ! is_page() ) : ?>
		<div id="comments" class="comments-area">
			<p class="nocomments"><?php _e( 'Comments are closed.' , 'central' ); ?></p>
		</div>
		<?php endif; ?>
<?php endif; //comments_open() ?>




