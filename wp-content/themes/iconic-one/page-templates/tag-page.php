<?php
/**
 * Template Name: Tag Page
 *
 * Description: lalalalalalaa
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php wp_tag_cloud('smallest=10&largest=50&number=0&unit=px&orderby=name'); ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>