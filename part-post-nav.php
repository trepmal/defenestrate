
	<nav class="posts-nav">
		<?php
		if ( get_next_posts_link() ) {
			echo '<span class="posts-nav-item posts-nav-next posts-nav-next-posts">';
			next_posts_link( __( '&lang; Older posts', 'defenestrate' ) );
			echo '</span>';
		} else { echo '&nbsp;'; /* keeps other link from getting 'sucked in' when floated */ }
		if ( get_previous_posts_link() ) {
			echo '<span class="posts-nav-item posts-nav-prev posts-nav-prev-posts">';
			previous_posts_link( __( 'Newer posts &rang;', 'defenestrate' ) );
			echo '</span>';
		}
		?>
	</nav>