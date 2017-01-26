"use strict"

jQuery( "document" ).ready( function ( $ ) {

    var checkbox = $( "#privacy_policy_third_party" );
    var section = $( 'input[name="privacy_policy_information_transfer[]"]' ).parents( 'tr' );

    if( !checkbox.attr( 'checked' ) ) {
        section.hide();
    }

    checkbox.change( function ( e, ui ) {
        section.toggle();
    } );

} );
