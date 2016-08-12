<p class="byline">
	<?php the_date( get_option('date_format'), '<span class="meta"><time>' . __( 'Posted on ', 'defenestrate'), '</time></span>' ); ?>
// <?php
	/* @todo
	we should do magic here and only show the author if there's more than one author on the site
	*/ ?>
	<span class="meta"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php printf( __( 'By %s', 'defenestrate' ), get_the_author() ); ?>
	</a></span>
//
	<span class="meta"><?php
	ob_start();
	comments_number( __( 'Tell me what you think', 'defenestrate'), __( '1 response', 'defenestrate'), __( '% responses', 'defenestrate') );
	$comments_number = ob_get_clean();
	post_reply_link( array(
		'reply_text' => $comments_number
	) );
	?></span>
</p>