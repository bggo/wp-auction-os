<?php
/**
 * Comment Template
 *
 * The comment template displays an individual comment. This can be overwritten by templates specific
 * to the comment type (comment.php, comment-{$comment_type}.php, comment-pingback.php, 
 * comment-trackback.php) in a child theme.
 *
 * @package Omega
 * @subpackage Template
 */
?>
<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

	<article itemtype="http://schema.org/UserComments" class="comment-item" itemscope="itemscope" itemprop="comment">
		<p class="comment-author" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="creator">
			<?php echo hybrid_avatar(); ?>
			<?php echo apply_atomic_shortcode( 'comment_author', '[comment-author]' ); ?>
		</p>
		<p class="comment-meta"> 
			<?php echo apply_atomic_shortcode( 'comment_meta', '[comment-published] [comment-permalink before="| "] [comment-edit-link before="| "]' ); ?>
		<p>
		<div class="comment-content">
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php echo hybrid_comment_reply_link_shortcode( array() ); ?>
		
	</article>	

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>