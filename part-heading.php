<?php

if ( ! is_archive() &&  ! is_search() ) return;

?>

<header class="archive-header">
	<div class="liner">
	<h1 class="archive-title">

	<?php

		if ( is_category() ) :
			printf( __( 'Category Archives: %s', 'defenestrate' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		elseif ( is_search() ) :
			printf( __( 'Search Results for: %s', 'defenestrate' ), get_search_query() );
		elseif ( is_author() ) :
			printf( __( 'Author Archives: %s', 'defenestrate' ), '<span>' . get_the_author() . '</span>' );
		elseif ( is_day() ) :
			printf( __( 'Daily Archives: %s', 'defenestrate' ), '<span>' . get_the_date() . '</span>' );
		elseif ( is_month() ) :
			printf( __( 'Monthly Archives: %s', 'defenestrate' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'defenestrate' ) ) . '</span>' );
		elseif ( is_year() ) :
			printf( __( 'Yearly Archives: %s', 'defenestrate' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'defenestrate' ) ) . '</span>' );
		else :
			_e( 'Archives', 'defenestrate' );
		endif;

	?>
	</h1>
	<?php
		if ( category_description() ) : // Show an optional category description
			?><div class="archive-meta"><?php echo category_description(); ?></div> <?php
		endif;
	?>

	</div>
</header>