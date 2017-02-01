"use strict"

jQuery( "document" ).ready( function( $ ) {

   if( get_cookie( "privacy_policy_accepted" ) === "" ) {
       $( "#privacy_policy_cookies_notification" ).show();
       $( "#privacy_policy_cookies_notification .close" ).click(close_popup);
   }

    function close_popup () {
        check_cookie();

        $( "#privacy_policy_cookies_notification" ).hide();
    }

    function check_cookie() {
        if( get_cookie( "privacy_policy_accepted" ) === "" ) {
            set_cookie( "privacy_policy_accepted", true, 10 );
        }
    }

    function get_cookie( name ) {
        var cookie = decodeURIComponent( document.cookie );
        var attrs = cookie.split( ";" );
        var val = "";

        for( var ctr = 0; ctr < attrs.length; ctr++ ) {
            var attr = attrs[ctr];

            while( attr.charAt( 0 ) === " " ) {
                attr = attr.substring( 1 );
            }

            if( attr.indexOf( name ) === 0 ) {
                val = attr.substring( name.length, attr.length );
            }
        }

        return val;
    }

    function set_cookie( name, value, expiry ) {
        var date = new Date();

        date.setTime( date.getTime() + ( expiry * 24 * 60 * 60 * 1000 ) );
        document.cookie = name + "=" + value + ";expires" + date.toUTCString();
    }

} );

