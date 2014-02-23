	<header class="page-footer">
		<p><a href="<?php esc_url( home_url() ); ?>"><?php bloginfo(); ?></a></p>

		<?php
			$links = array();
			foreach ( get_option( 'footer_links' ) as $network => $value ) {
				$href = is_email( $value ) ? "mailto:$value" : $value;
				$links[] = '<a href="'. esc_url( $href ) .'" class="genericon genericon-'. esc_attr( $network ) .'">'. esc_html( $network ) .'</a>';
			}
			if ( $links ) {
				echo '<p>'. implode( ' ', $links ) .'</p>';
			}
		?>

		<p class="little"><?php echo esc_html( get_bloginfo('description') ); ?></p>

		<p><a href="#" class="genericon genericon-collapse back-to-top"></a></p>
	</header>

<?php wp_footer(); ?>
</body>
</html>