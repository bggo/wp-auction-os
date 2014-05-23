<?php
/*
 * The Template for displaying all single posts.
 *
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */

get_header();?>
	<div id="primary" class="site-content">
	
	<?
global $post;
wdm_auction_listing($post->ID);?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>