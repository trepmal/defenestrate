jQuery(document).ready( function($) {

	var $repeaterGroup = $('.repeater-group'),
		$addNew = $('.add-new-button');

	$repeaterGroup.sortable();


	$addNew.on( 'click', function( ev ) {
		ev.preventDefault();

		$new = $(this).parent('p').prev('div').find('p:last');
		$nnew = $new.clone();
		if ( $(this).hasClass('of-type') ) {
			select = $(this).prev('select.of-type');
			val = select.val();
			$nnew.find('.genericon:first').attr( 'class', 'genericon genericon-' + val );
			name = $nnew.find('input').attr('name').replace(/\[.*?\]/, '['+val+']');
			$nnew.find('input').attr('name', name);
			select.find('option[value="'+ val +'"]').remove();
		} else {
		}
		$nnew.find('input').val('');
		$nnew.insertAfter( $new );

		$repeaterGroup.sortable();
	});


});