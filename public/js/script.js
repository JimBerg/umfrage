/**
 * MODUL 133 | WEBUMFRAGE
 *
 * a tiny little bit of javascript
 * evaluate question form
 * set chart data
 * well and blur and focus and scroll some stuff
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */

/**
 * check if every radio button was set
 * process form if every question was answered
 * @return {Boolean}
 */
function validateForm() {
    var valid = true;
    if( $( '#question-form' ).find( '.error' ).length ){
        $( 'li.error' ).remove();
    }

    $( ':radio' ).each( function() { // iterate over each radio button
        var group = $( this ).attr( 'name' );
        var parent = $( ':radio[name="'+group+'"]' ).closest( 'ul' );
        if ( !$( ':radio[name="'+group+'"]:checked' ).length ) { //check if one of this group is set
            valid = false;
            if( !$( parent ).find( '.error' ).length ) {
                $( '<li class="error">Bitte auswählen.</li>' ).appendTo( $( parent ) );
            }
        }
    });
    if( !valid ) {
        var target = $( '#question-form' ).find( '.error' ).offset().top;
        $( 'html, body' ).animate( { scrollTop: target - 180 }, 600, 'swing' );
    }
    return valid;
}

/** input fields */
var $fields = $( 'input[type="text"], input[type="password"]' );

/** placeholder values for input fields */
var placeholder = function( name ) {
    if( name == 'username' || name == 'username-register' ) {
        return 'Benutzername';
    } else if ( name =='pwd' | name == 'pwd-register' ) {
        return 'Passwort';
    } else if ( name == 'pwd-register-confirm' ) {
        return 'Passwort bestätigen';
    }
};

/**
 * remove placeholder on focus
 * add placeholder on blur if input is empty
 */
$.each( $fields, function() {
    $( this ).live( 'focus', function() {
        $( this ).attr( 'placeholder', '' );
        $( this ).removeClass( 'error' );
        $( this ).next( '.error-msg' ).html( '' );
    });

    $( this ).live( 'blur', function() {
        if( $.trim( $( this ).val() ) == '' ) {
            var name = $( this ).attr( 'name' );
            $( this ).attr( 'placeholder', placeholder( name ) );
        }
    });
});

/***
 * set chart data
 * @type {*|jQuery|HTMLElement}
 */
var charts = $( '.chart' );
$( charts ).each( function( index ) {
    var canvas = document.getElementById( 'chart_'+index );
    var ctx = canvas.getContext( '2d' );
    var data = $.parseJSON( $( canvas ).attr( 'data-chart' ) );
    var options = {};
    var pie = new Chart( ctx ).Pie( data, options );
});