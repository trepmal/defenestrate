<?php

$footer_links_defenestrate_option = new Footer_Links_Defenstrate_Option();

class Footer_Links_Defenstrate_Option extends Defenestrate_Option {

	function __construct() {
		$this->option_name     = 'footer_links';
		$this->option_label    = 'Footer Links';
		$this->option_callback = array( $this, 'form_field' );
		$this->option_sanitization = array( $this, 'sanitize' );
		parent::__construct();
	}

	function form_field( $name ) {
		$this->before_form_field();

		wp_enqueue_style( 'font-genericons', get_stylesheet_directory_uri(). '/genericons/genericons.css' );

		wp_enqueue_script( 'defenestrate-repeater' );

		$all = array( 'github', 'dribbble', 'twitter', 'facebook', 'facebook-alt', 'wordpress', 'googleplus', 'linkedin', 'linkedin-alt', 'pinterest', 'pinterest-alt', 'flickr', 'vimeo', 'youtube', 'tumblr', 'instagram', 'codepen', 'polldaddy', 'googleplus-alt', 'path', 'skype', 'digg', 'reddit', 'stumbleupon', 'pocket', 'dropbox' );

		// only show a subset to start
		$defaults = array(
			'twitter'    => '',
			'github'     => '',
			'wordpress'  => '',
			'instagram'  => '',
			'googleplus' => '',
			'facebook'   => '',
			'mail'       => '',
		);

		$values = (array) get_option( $name, array() );
		$values = wp_parse_args( $values, $defaults );

		echo '<div class="repeater-group">';
		$name = esc_attr( $name );
		foreach( $values as $k => $v ) {
			$v    = esc_attr( $v );
			$k    = esc_attr( $k );
			echo "<p><span class='genericon genericon-$k' style='line-height:30px;'></span> <input name='{$name}[$k]' id='$name' type='text' value='$v' class='regular-text' /><span class='genericon genericon-draggable' style='line-height:30px;'></span></p>";
		}

		echo '</div>';

		$list = array_diff( $all, array_keys( $values ) );

		echo '<p class="submit">';
			echo "<select class='insert-type of-type of-type-$name'>";
			foreach( $list as $k => $v ) {
				$v = esc_attr( $v );
				echo "<option value='$v'>$v</option>";
			}
			echo '</select>';
			$this->repeater_button( $name, 'of-type', false );
		echo '</p>';

		$this->after_form_field( );
	}


	/**
	 * Sanitize
	 *
	 * This option expects only urls and possibly email addresses
	 *
	 * @param array $input Raw values
	 * @return array Sanitzed values
	 */
	function sanitize( $input ) {
		foreach ( $input as $k => $value ) {
			if ( strpos( $value, '@' !== false ) ) {
				$input[$k] == sanitize_email( $value );
			} else {
				$input[$k] == esc_url_raw( $value );
			}
		}
		$input = array_filter( $input );
		return $input;
	}

}
