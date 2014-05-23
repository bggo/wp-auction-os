<?php
/**
 * The sidebar containing the main widget area.
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */
?>

	<?php if ( is_active_sidebar( 'themonic-sidebar' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'themonic-sidebar' ); ?>
		</div><!-- #secondary -->
	<?php else : ?>	
	 		<div id="secondary" class="widget-area" role="complementary">
			<div class="widget widget_search">
				<?php get_search_form(); ?>
			</div>
<? /**
			<div class="widget widget_pages">
			<p class="widget-title"><?php _e( 'Páginas', 'themonic' ); ?></p>
          <ul><?php wp_list_pages('title_li='); ?></ul>
      </div>
**/ ?>	  
	  <div class="widget widget_tag_cloud">
       <p class="widget-title"><?php _e( 'Categorias', 'themonic' ); ?></p>
        <? //php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?>
	<?php
	$tags = get_tags();
	$html = '<ul>';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );
		
		$html .= "<li>";
		$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
		$html .= "{$tag->name}</a>";
		$html .= "</li>";
	}
	$html .= '</ul>';
	echo $html;
?>

<?
/**
global $wpdb;

$query = "SELECT * FROM ".$wpdb->prefix."term_taxonomy WHERE WHERE taxonomy = 'post_tag'";
$tags = $wpdb->get_results($query);

foreach ($tags as $tag) {
echo $tag;
echo '<p>Tag: <a href="' . get_tag_link( $tag->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $tag->name ) . '" ' . '>' . $tag->name.'</a> </p> ';
}
**/
?>
			</div>
		</div><!-- #secondary -->
	<?php endif; ?>