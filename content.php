
	<article id="post-<?php the_id(); ?>" <?php post_class(); ?>>
		<div class="entry-title">
		<?php the_post_thumbnail('post-thumbnail'); ?>
		<h1 class="liner"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		</div>
		<div class="liner entry-content">
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
		<footer class="liner">
		Posted in <?php the_category( ', ' );  the_tags( ' as well as ', ', ' ); ?>.
		</footer>
		</div>
	</article>
		<!-- <div class="liner entry-comments"> -->
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			?>
		<!-- </div> -->
