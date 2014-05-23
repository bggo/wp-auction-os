<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php hybrid_document_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body class="<?php hybrid_body_class(); ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php do_atomic( 'before' ); // omega_before ?>

<div class="<?php echo apply_atomic( 'site_container_class', 'site-container' );?>">

	<?php do_atomic( 'before_header' ); // omega_before_header ?>
	<?php do_atomic( 'header' ); // omega_header ?>
	<?php do_atomic( 'after_header' ); // omega_after_header ?>

	<div class="site-inner">

		<?php do_atomic( 'before_main' ); // omega_before_main ?>