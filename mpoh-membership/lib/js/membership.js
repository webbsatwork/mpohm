jQuery( document ).ready(function( $ ) {

  var form = $( '#mpohm-join-membership' );
  var btn = $( '#mpohm-login-button' );
  var em = $( '#mpohm-signin-input-email' );
  var pw = $( '#mpohm-signin-input-password' );
  var dots = $( '#mpohm-loading-dots' );
  var status = $( '#mpohm-status-message' );

  $( '#mpohm-signin-input-email, #mpohm-signin-input-password' ).on( 'input', function() {


    if( mpohm_val_dat( 'email', em.val() ) === true && pw.val().length > 0 ) btn.prop( 'disabled', false );
    else btn.prop( 'disabled', true );

  });

  btn.on( 'click', function( e ) {
    e.preventDefault();
    btn.addClass( 'mpohm-zero-opacity' ).prop( 'disabled', true );
    dots.removeClass( 'mpohm-zero-opacity' );
    status.html( 'Checking ...' );

    form.mpohmAjax( 'mpohm_login', 'return_login_value' );
  });


  // Change active panel on dashboard
  $( '.mpohm-change-panel' ).on( 'click', function( e ) {
    e.preventDefault();
    var item = $( this );
    var par = item.parent( 'li' );
    var tgt = item.attr( 'rel' );

    // Change active panel
    var panel = $( '#' + tgt );
    var psibs = panel.siblings();

    psibs.removeClass( 'active-panel' );
    panel.delay( 200 ).addClass( 'active-panel' );
  });

});





jQuery.fn.extend({

  mpohmAjax: function( func, success ) {
    var form = jQuery( this );
    var form_data = new FormData( form[0] );

    // Important line; will return 400 error otherwise
    form_data.append( 'action', 'mpohm_action' );

    // Tells the function which callback to use
    form_data.append( 'func', func );

    jQuery.ajax({
        url: mpohm_ajax.ajax_url,
        type: 'POST',
        contentType: false,
        processData: false,
        data: form_data
      }).done( function( r ) {
        window[success]( r );
    });
  }
});


function mpohm_val_dat( type, value )
{
  var pattern = {};
  pattern.date = /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/;
  pattern.email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  pattern.minlength1 = /^[\s\S]+$/;
  pattern.minlength2 = /^[\s\S]{2,}$/;
  pattern.minlength5 = /^[\s\S]{5,}$/;
  pattern.number = /^\d+$/;
  pattern.tel = /^[0-9\s-\(\)]{7,}$/;
  pattern.time = /^\d{1,2}:*\d{2}\s*([AM|PM|am|pm]{2})*$/;
  pattern.url = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&=]*)/;

  return pattern[type].test( value );

}


function return_login_value( res )
{

  var obj = JSON.parse( res );

  console.log( obj );

  if( obj.error == true )
  {
    jQuery( '#mpohm-status-message' ).html( '<span class="mpohm-error-msg">' + obj.status + '</span>' );
    jQuery( '#mpohm-loading-dots' ).addClass( 'mpohm-zero-opacity' );
    jQuery( '#mpohm-login-button' ).removeClass( 'mpohm-zero-opacity' ).prop( 'disabled', false );
  }
  else
  {
    jQuery( '#mpohm-status-message' ).html( '<span class="mpohm-success-msg">Success!</span>' );
    document.cookie = 't=' + obj.token + '; path=/process-login';
    window.location.href = 'process-login';
  }
  // jQuery( '#mpohm-test-data-return' ).html( res );
}
