<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage MyBaby
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php get_sidebar( 'footer' ); ?>

			<div id="site-generator">
				<?php do_action( 'mybaby_credits' ); ?>
				<?php printf( __( 'Proudly powered by ', 'mybaby' )); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'mybaby' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'mybaby' ); ?>" rel="generator">Wordpress</a> and <a href="<?php echo esc_url( __( 'http://www.etrecos.com/index.php/themes/', 'mybaby' ) ); ?>" title="MyBaby Theme">MyBaby Theme</a>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>