<?php

/**
 * Set up the theme
 *
 * Theme Support
 *  - menus
 *  - background
 *  - featured images
 *
*/
function defenestrate_theme_setup() {

	// register_nav_menus( array(
	// 	'primary'   => __( 'Top primary menu', 'defenestrate' ),
	// 	'secondary' => __( 'Secondary menu in left sidebar', 'defenestrate' ),
	// ) );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', apply_filters( 'defenestrate_custom_background_args', array(
		'default-color' => 'fcfcfc',
	) ) );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 9999, 600, true );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}

}
add_action( 'after_setup_theme', 'defenestrate_theme_setup' );


/**
 * CSS and JS Assets
 *
 * Stylesheets
 *  - fonts
 *  - main
 *
 * Javascript
 *  - main
 *  - comment-reply
 *
*/
function defenestrate_css_js() {

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		wp_enqueue_style( 'src-font-sourcesanspro', get_template_directory_uri(). '/src_css/sourcesanspro.css' );
		wp_enqueue_style( 'src-font-anticslab',     get_template_directory_uri(). '/src_css/anticslab.css' );
		wp_enqueue_style( 'src-font-genericons',    get_template_directory_uri(). '/src_css/genericons.css' );
		wp_enqueue_style( 'src-font-sourcecodepro', get_template_directory_uri(). '/src_css/sourcecodepro.css' );
		wp_enqueue_style( 'src-prism',              get_template_directory_uri(). '/src_css/prism.css' );
		wp_enqueue_style( 'src-defenestrate',       get_template_directory_uri(). '/src_css/style.css', array( 'src-font-sourcesanspro', 'src-font-anticslab', 'src-font-genericons', 'src-font-sourcecodepro' ) );

		wp_enqueue_script( 'src-prism',        get_template_directory_uri(). '/src_js/prism.js', array( 'jquery' ), 1, true );
		wp_enqueue_script( 'src-defenestrate', get_template_directory_uri(). '/src_js/functions.js', array( 'jquery' ), 1, true );

	} else {
		// concat's and minify'd with grunt
		wp_enqueue_style( 'defenestrate',  get_template_directory_uri() .'/css/defenestrate.min.css', array(), '01' );
		wp_enqueue_script( 'defenestrate', get_template_directory_uri() .'/js/defenestrate.min.js', array( 'jquery' ), '01', true );

	}

	if ( is_single() ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'defenestrate_css_js' );

/**
 * Load main stylesheet asynchronously
 */
function defenestrate_async_styles( $tag, $handle ) {
	if ( 'defenestrate' != $handle && 'src-defenestrate' != $handle ) return $tag;

	$attr = wp_kses_hair( $tag, array( 'http', 'https' ) );
	return "
	<script>
	  var cb = function() {
		var l = document.createElement('link'); l.rel = 'stylesheet';
		l.href = '". esc_js( $attr['href']['value'] ) ."';
		var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
	  };
	  var raf = requestAnimationFrame || mozRequestAnimationFrame ||
		  webkitRequestAnimationFrame || msRequestAnimationFrame;
	  if (raf) raf(cb);
	  else window.addEventListener('load', cb);
	</script>";
}
// add_filter( 'style_loader_tag', 'defenestrate_async_styles', 10, 2 );


/**
 * Relocate core scripts to footer
 */
function defenestrate_css_js_hack() {
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', array(), '1.11.0', true );


	$suffix = SCRIPT_DEBUG ? '' : '.min';
	wp_deregister_script('comment-reply');
	wp_register_script( 'comment-reply', "/wp-includes/js/comment-reply$suffix.js", array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'defenestrate_css_js_hack' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function defenestrate_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'defenestrate' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'defenestrate_wp_title', 10, 2 );


function defenestrate_wp_link_pages_link( $link ) {
	$link = str_replace( '<a ', '<a class="paged-item-link" ', $link );
	return $link;
}
// add_filter( 'wp_link_pages_link', 'defenestrate_wp_link_pages_link' );

/**
 * Add post class indicating if it has a featured image
 */
function defenestrate_post_class( $classes, $class, $post_id ) {
	if ( has_post_thumbnail( $post_id) ) {
		$classes[] = 'has-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'defenestrate_post_class', 10, 3 );

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own defenestrate_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function defenestrate_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'defenestrate' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'defenestrate' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					// edit_comment_link( __( 'Edit', 'defenestrate' ), ' <span class="edit-link">', '</span>' );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						''
						// ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'defenestrate' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'defenestrate' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'defenestrate' ); ?></p>
			<?php endif; ?>

			<section class="comment-content">
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<!--<footer class="comment-meta comment-author comment-timestamp">
				<?php
					// echo get_avatar( $comment, 44 );
					// printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
					// 	get_comment_author_link(),
					// 	// If current post author is also comment author, make it known visually.
					// 	( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'defenestrate' ) . '</span>' : ''
					// );
					// printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
					// 	esc_url( get_comment_link( $comment->comment_ID ) ),
					// 	get_comment_time( 'c' ),
					// 	/* translators: 1: date, 2: time */
					// 	sprintf( __( '%1$s at %2$s', 'defenestrate' ), get_comment_date(), get_comment_time() )
					// );
				?>
			</footer>--><!-- .comment-meta -->
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'defenestrate' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}


require_once( plugin_dir_path( __FILE__ ) . 'inc/options.php' );