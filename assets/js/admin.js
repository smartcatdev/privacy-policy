"use strict"

jQuery( "document" ).ready( function ( $ ) {

    var checkbox = $( "#privacy_policy_info_transfer" );
    var section = $( 'input[name="privacy_policy_genius_personal-information-transfer-purpose[]"]' ).parents( 'tr' );

    if( !checkbox.attr( 'checked' ) ) {
        section.hide();
    }

    checkbox.change( function ( e, ui ) {
        section.toggle();
    } );

} );
