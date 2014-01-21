
	<!-- <nav class="post-nav post-nav-posts"> -->
		<?php
		if ( get_next_posts_link() ) {
			echo '<span class="post-nav-item post-nav-next post-nav-next-posts">';
			next_posts_link( __( '&lang;', 'defenestrate' ) );
			echo '</span>';
		}
		if ( get_previous_posts_link() ) {
			echo '<span class="post-nav-item post-nav-prev post-nav-prev-posts">';
			previous_posts_link( __( '&rang;', 'defenestrate' ) );
			echo '</span>';
		}
		?>
	<!-- </nav> -->