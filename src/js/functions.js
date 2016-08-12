jQuery(document).ready( function($) {

	$('a.back-to-top').click( function(ev) {
		ev.preventDefault();
		$('html, body').animate( { scrollTop: 0 }, 'slow' );
	});

});