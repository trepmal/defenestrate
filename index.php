<?php
	get_header();
?>
	<div class="container">
		<?php
		if ( have_posts() ) :

			get_template_part( 'part', 'heading' );

			echo '<section class="posts-container">';

			while( have_posts() ) : the_post();

				get_template_part( 'content' );

			endwhile;

			echo '</section>';

			get_template_part( 'part', 'post-nav' );

		else :
			echo '<section class="posts-container">';

			get_template_part( 'content', '404' );

			echo '</section>';
		endif;
	?>
	</div>

<?php
	get_footer();
?>