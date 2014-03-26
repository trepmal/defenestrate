<?php

$defenestrate_options = new Defenestrate_Options();
/**
 * This class just sets up the options page and readies a settings section
 * Use the settings API to hook in and add options
 * See head-tags.php as example
 */
class Defenestrate_Options {

	function __construct() {
		add_action( 'init', array( &$this, 'init' ) );
	}

	function init() {

		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		add_action( 'admin_menu', array( &$this, 'menu' ) );

		wp_register_script( 'defenestrate-media', get_template_directory_uri() .'/inc/js/options-media.js', array('jquery') );
		wp_register_script( 'defenestrate-repeater', get_template_directory_uri() .'/inc/js/options-repeater.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable') );
	}

	function register_settings() {

		// second arg would be the section heading, such as "General"
		add_settings_section( 'defenestrate_section_general', '', '__return_empty_string', __CLASS__ );

	}

	function menu() {
		add_theme_page( __( 'Defenestrate', 'defenestrate' ), __( 'Defenestrate Options', 'defenestrate' ), 'edit_posts', __CLASS__, array( &$this, 'page' ) );
	}

	function page() {
		?><div class="wrap">
		<h2><?php _e( 'Defenestrate Options', 'defenestrate' ); ?></h2>
		<?php
		echo '<form method="post" action="options.php">';
		settings_fields( 'defenestrate_group_general' );
		do_settings_sections( __CLASS__ );
		submit_button();
		echo '</form>';
		?>
		</div><?php
	}

}


class Defenestrate_Option {

	var $page = 'Defenestrate_Options';
	var $option_name = '';

	function __construct( ) {

		if ( empty( $this->option_name ) ) {
			die( 'You must define $option_name in your subclass' );
		}

		if ( empty( $this->option_sanitization ) ) {
			$this->option_sanitization = 'strip_tags';
		}

		if ( empty( $this->option_label ) ) {
			$this->option_label = '';
		}

		if ( empty( $this->option_callback ) ) {
			$this->option_callback = array( $this, 'input_form_field' );
		} elseif ( is_string( $this->option_callback ) && method_exists( $this, $this->option_callback ) ) {
			$this->option_callback = array( $this, $this->option_callback );
		}

		add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
	}

	function register_fields() {

		register_setting( 'defenestrate_group_general', $this->option_name, $this->option_sanitization );
		add_settings_field("_$this->option_name", $this->option_label , $this->option_callback , $this->page, 'defenestrate_section_general', $this->option_name );

	}

	function input_form_field( $name ) {
		$this->before_form_field();

		$value = esc_attr( get_option( $name ) );
		$name = esc_attr( $name );
		echo "<input name='$name' id='$name' type='text' value='$value' class='regular-text' />";

		$this->after_form_field( );
	}

	function input_repeater_form_field( $name ) {
		$this->before_form_field();

		wp_enqueue_script( 'defenestrate-repeater' );

		$value = (array) get_option( $name, array() );
		$name = esc_attr( $name );
		echo '<div class="repeater-group">';
		foreach( $value as $k => $v ) {
			$v    = esc_attr( $v );
			$k    = esc_attr( $k );
			echo "<p><input name='{$name}[]' id='$name' type='text' value='$v' class='regular-text repeater' /><span style='line-height:30px;' class='genericon genericon-draggable'></span></p>";
		}
		echo "<p class='new-field'><input name='{$name}[]' id='$name' type='text' value='' class='regular-text repeater' /><span style='line-height:30px;' class='genericon genericon-draggable'></span></p>";

		echo '</div>';
		$this->repeater_button( $name );

		$this->after_form_field( );
	}

	function repeater_button( $name = '', $class = '', $wrap = true ) {
		$text  = esc_attr__( 'Add new', 'defenestrate' );
		$name  = esc_attr( $name );
		$class = esc_attr( $class );

		$button = '<input type="button" name="'. $name .'-add-new" id="'. $name .'-add-new" class="button button-small add-new-button '. $class .'" value="'. $text .'"  />';

		if ( $wrap ) {
			$button = "<p class='submit'>$button</p>";
		}
		echo $button;
	}

	function textarea_form_field( $name ) {
		$this->before_form_field();

		$value = get_option( $name, '' );
		$value = esc_textarea( $value );
		$value = stripslashes( $value );
		$name = esc_attr( $name );
		echo "<textarea id='$name' class='large-text' name='$name'>$value</textarea>";

		$this->after_form_field();
	}

	function image_form_field( $name ) {
		$this->before_form_field();

		$value = intval( get_option( $name, '' ) );
		$name = esc_attr( $name );

		wp_enqueue_media();
		wp_enqueue_script( 'defenestrate-media' );

		echo "<input type='text' id='$name-value'  class='small-text'       name='$name'            value='$value' />";
		echo "<input type='button' id='$name'        class='button defenestrate-upload-button'        value='Upload' />";
		echo "<input type='button' id='$name-remove' class='button defenestrate-upload-button-remove' value='Remove' />";

		$value = ! $value ? '' : wp_get_attachment_image( $value, 'full', false, array('style' => 'max-width:100%;height:auto;') );

		echo "<div class='image-preview'>$value</div>";

		$this->after_form_field();
	}

	function color_form_field( $name ) {
		$this->before_form_field();

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		?>
		<script>
			jQuery(document).ready(function($){
				$('.colorpicker').wpColorPicker({
					change: function( event, ui ) {
						$(this).val( ui.color.toString() );
					}
				});
			});
		</script>
		<?php
		$value = esc_attr( get_option( $name ) );
		$name = esc_attr( $name );
		echo "<input type='text' name='$name' class='regular-text colorpicker' value='$value' />";

		$this->after_form_field();
	}

	function checkbox_form_field( $name ) {
		$this->before_form_field();

		$value = esc_attr( get_option( $name ) );
		$name = esc_attr( $name );
		echo "<input type='checkbox' value='1' name='$name'";
		checked( $value );
		echo " class='checkbox'>";

		$this->after_form_field();
	}

	function before_form_field() { }
	function after_form_field() { }

}

require_once( plugin_dir_path(__FILE__) .'options-footer-links.php' );