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

<?php
	if ( ! is_home() ) {
		$links = array();
		$links[] = '<a href="'. esc_url( home_url() ) .'" class="genericon genericon-home home-link" title="Home"></a>';
		echo '<p class="linkbar">';
		echo implode( $links );
		echo '</p>';
	}
?>

<div class="menubar">
	<span class="hint">&middot; &middot; &middot;</span>
	<ul>
		<li><a href="<?php echo esc_url( home_url() ); ?>" class="genericon genericon-home" title="Home"></a></li>
		<li><?php get_search_form(); ?></li>
	</ul>

</div>