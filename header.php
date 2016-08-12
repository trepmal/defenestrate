<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page">

<div class="menubar">
	<div class="liner">
	<ul class="mainmenu">
<!-- 		<li><a href="<?php echo esc_url( home_url() ); ?>" class="genericon genericon-home" title="Home"></a></li>
 -->		<li><a href="<?php echo esc_url( home_url() ); ?>" title="Home"><?php bloginfo('name'); ?></a></li>
	</ul>

	<?php get_search_form(); ?>
	</div>
</div>
