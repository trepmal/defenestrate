
	<article id="post-<?php the_id(); ?>" <?php post_class(); ?>>
		<?php
			if ( is_singular() ) {
				echo '<div class="entry-thumbnail">';
					the_post_thumbnail('full');
				echo '</div>';
			}
		?>
		<div class="entry-title">
		<?php // if ( is_singular() ) the_post_thumbnail('post-thumbnail'); ?>
		<h1><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		</div>
		<div class="entry-content">
			<?php get_template_part( 'part', 'byline' ); ?>
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before'           => '<nav class="paged-nav">',
				'after'            => '</nav>',
				'link_before'      => '<span class="paged-item">',
				'link_after'       => '</span>',
				// 'next_or_number'   => 'number',
				'separator'        => '',
				// 'nextpagelink'     => __( 'Next page' ),
				// 'previouspagelink' => __( 'Previous page' ),
				// 'pagelink'         => '%-',
				// 'echo'             => 1
			) ); ?>
			<?php if ( is_single() ) : ?>
		<footer>
			Posted in <?php the_category( ', ' );  the_tags( ' as well as ', ', ' ); ?>.
		</footer>
	<?php endif; ?>
		</div>
	</article>
	<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	?>
