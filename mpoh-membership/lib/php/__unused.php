<?php

return false;



static function new_member( $content )
{
  // $content = apply_filters( 'the_content', __( $content ) );
  ?>

  <script type="text/javascript">

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

    });

    function return_login_value( res )
    {
      jQuery( '#mpohm-loading-dots' ).addClass( 'mpohm-zero-opacity' );
      jQuery( '#mpohm-login-button' ).removeClass( 'mpohm-zero-opacity' ).prop( 'disabled', false );

      var obj = JSON.parse( res );

      console.log( obj );

      if( obj.error == true )
      {
        jQuery( '#mpohm-status-message' ).html( '<span class="mpohm-error-msg">' + obj.status + '</span>' );
      }
      else
      {
        document.cookie = 't=' + obj.token + '; path=/process-login';
        window.location.href = 'process-login';
      }
      // jQuery( '#mpohm-test-data-return' ).html( res );
    }

  </script>


  <div id="mpohm-membership-area">

    <?php echo wp_get_attachment_image( 298, 'large', 0, array( 'class' => 'mpohm-login-img' ) ) ?>

    <h3 style="text-align:center">Support Your Local Theatre Today!</h3>

    <?php _e( $content ) ?>

    <p id="mpohm-status-message" class="mpohm-strong">
      Already a member? <a href="#">Sign in here</a>.
    </p>

    <p class="mpohm-form-nav">
      <span class="current-panel">1. Amount</span> &raquo;
      <span class="future-panel">2. Contact Info</span> &raquo;
      <span class="future-panel">3. Payment Info</span>
    </p>

    <form id="mpohm-join-membership" action="" method="post" enctype="multipart/form-data" autocomplete="off">

      <!-- Where the form dynamically changes -->
      <div class="mpohm-form-stage" id="mpohm-form-stage">

        <div class="mpohm-form-panel" id="mpohm-panel-1">

          <div class="mpohm-form-area">

            <div class="mpohm-form-line" id="mpohm-form-line-email">
              <label for="mpohm-level-member">
                <input type="radio" class="mpohm-large-radio-button" id="mpohm-level-member" name="mpohm-member-level" value="member" data-amount="35.00" />
                Member ($35-$99)
              </label>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-email">
              <label for="mpohm-level-enthusiast">
                <input type="radio" class="mpohm-large-radio-button" id="mpohm-level-enthusiast" name="mpohm-member-level" value="enthusiast" data-amount="100.00" checked />
                Enthusiast ($100-$299)
              </label>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-email">
              <label for="mpohm-level-patron">
                <input type="radio" class="mpohm-large-radio-button" id="mpohm-level-patron" name="mpohm-member-level" value="patron" data-amount="300.00" />
                Patron ($300-$499)
              </label>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-email">
              <label for="mpohm-level-director">
                <input type="radio" class="mpohm-large-radio-button" id="mpohm-level-director" name="mpohm-member-level" value="director" data-amount="500.00" />
                Director ($500-$999)
              </label>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-email">
              <label for="mpohm-level-producer">
                <input type="radio" class="mpohm-large-radio-button" id="mpohm-level-producer" name="mpohm-member-level" value="producer" data-amount="1000.00" />
                Producer ($1,000+)
              </label>
            </div>

          </div>

          <div class="mpohm-form-area">

            <p>
              <label for="mpohm-renewing-membership">
                <input type="checkbox" id="mpohm-renewing-membership" name="mpohm_renew_membership" value="renew" checked />
                I'd like to renew my membership annually
              </label>
            </p>

            <p>
              <label for="mpohm-join-mailing-list">
                <input type="checkbox" id="mpohm-join-mailing-list" name="mpohm_join_mailing_list" value="join" checked />
                I'd like to receive updates from MPOH via email
              </label>
            </p>

          </div><!-- end .mpohm-form-area -->

        </div><!-- end panel 1 -->

        <!-- begin panel 2 -->
        <div class="mpohm-form-panel" id="mpohm-panel-2">

          <div class="mpohm-form-area">

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-first-name">
              <label>First Name</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-first-name" name="mpohm_new_user_first_name" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-last-name">
              <label>Last Name</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-last-name" name="mpohm_new_user_last_name" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-email">
              <label>Email Address</label>
              <input type="email" class="mpohm-text-input email-input" id="mpohm-new-user-email" name="mpohm_new_user_email" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-phone">
              <label>Phone</label>
              <input type="text" class="mpohm-text-input phone-input" id="mpohm-new-user-phone" name="mpohm_new_user_phone" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-address-1">
              <label>Address Line 1</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-address-1" name="mpohm_new_user_address_1" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-address-2">
              <label>Address Line 2</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-address-2" name="mpohm_new_user_address_2" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-city">
              <label>City</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-city" name="mpohm_new_user_city" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-state">
              <label>State</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-state" name="mpohm_new_user_state" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-postal">
              <label>Postal Code</label>
              <input type="text" class="mpohm-text-input" id="mpohm-new-user-postal" name="mpohm_new_user_postal" />
            </div>

          </div>

        </div><!-- end panel 2 -->

        <!-- begin panel 3 -->
        <div class="mpohm-form-panel" id="mpohm-panel-3">

          <div class="mpohm-form-area">

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-ccinfo">
              <label>Credit Card Number</label>
              <input type="text" class="mpohm-text-input credit-card" id="mpohm-new-user-ccinfo" name="mpohm_new_user_ccinfo" />
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-cctype">
              <label>Credit Card Type</label>
              <select class="mpohm-select" id="mpohm-new-user-cctype" name="mpohm_new_user_cctype">
                <option value="">Select ...</option>
                <option value="amex">American Express</option>
                <option value="discover">Discover</option>
                <option value="mastercard">Mastercard</option>
                <option value="visa">Visa</option>
              </select>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-ccexpire">
              <label>Expiration Date</label>
              <select class="mpohm-select" id="mpohm-new-user-ccexpire-month" name="mpohm_new_user_ccexpire_month">
                <option value="">Select ...</option>
                <option value="01">1 - January</option>
                <option value="02">2 - February</option>
                <option value="03">3 - March</option>
                <option value="04">4 - April</option>
                <option value="05">5 - May</option>
                <option value="06">6 - June</option>
                <option value="07">7 - July</option>
                <option value="08">8 - August</option>
                <option value="09">9 - September</option>
                <option value="10">10 - October</option>
                <option value="11">11 - November</option>
                <option value="12">12 - December</option>
              </select>
              <select class="mpohm-select" id="mpohm-new-user-ccexpire-year" name="mpohm_new_user_ccexpire_year">
                <option value="">Select ...</option>
                <option value="22">2022</option>
                <option value="23">2023</option>
                <option value="24">2024</option>
                <option value="25">2025</option>
                <option value="26">2026</option>
                <option value="27">2027</option>
                <option value="28">2028</option>
                <option value="29">2029</option>
              </select>
            </div>

            <div class="mpohm-form-line" id="mpohm-form-line-new-user-ccv">
              <label>CVV (Validation Code on Back of Card)</label>
              <input type="text" class="mpohm-text-input credit-card" id="mpohm-new-user-ccv" name="mpohm_new_user_ccv" />
            </div>

          </div><!-- end .mpohm-form-area -->

        </div><!-- end #mpohm-panel-3 -->

      </div><!-- end #mpohm-form-stage -->

      <div class="mpohm-form-line" id="mpohm-form-line-button">
        <div class="mpohm-button-stage">
          <div class="mpohm-button-area">
            <button class="button anim" id="mpohm-button-action">Next →</button>
          </div>
          <div class="mpohm-loading-area">
            <div id="mpohm-loading-dots" class="mpohm-zero-opacity dot-elastic anim"></div>
          </div>
        </div>
      </div>

    </form>

      <div id="mpohm-other-ways-to-give">

        <h5 style="text-align:center">Other Ways To Give</h5>

        <p>Join via phone: 608-987-3501</p>

        <p>Join by mail: <a href="#">Printable Form</a></p>

        <p><a href="#">Other ways to give</a> | <a href="#">Membership FAQ</a></p>

        <p>Member Services:<br />
          608-987-3501 | <a href="mailto:membership@mpoh.org">membership@mpoh.org</a>
        </p>

      </div>

    <div id="mpohm-test-data-return"></div>

  </div>

  <?php

  $user = wp_get_current_user();

  // print_array( $_COOKIE );
  // print_array( $user );

}





<?php

require 'vendor/autoload.php';


/* Object */

use MonkeyPod\Api\Client;
use MonkeyPod\Api\Resources\Entity;

// use Illuminate\Http\Client\Factory as Http;


class Remote extends Membership
{

  public $person;


  function __construct()
  {
    // Static configuration creates a global Client object that
    // will automatically be used for all API calls.

    $api_key = '47wMMALRbc4JuepXKHGh7X6h9amL890vlYjCiU8i';
    $subdomain = 'mineral-point-opera-house-inc';

    Client::configure( $api_key, $subdomain );
  }


  private function encode_obj( $obj )
  {
    $key = $this->private_key;
    $enc = base64_encode( $obj );
    return base64_encode( $enc . $key );
  }


  private function decode_obj( $obj )
  {
    $key = $this->private_key;
    $a = base64_decode( $obj );
    return base64_decode( substr( $a, 0, ( strlen( $a ) - strlen( $key ) ) ) );
  }




  function get_entity( $uuid )
  {
    $person = new Entity( $uuid );
    $person->retrieve();
    $this->person = $person;
  }








  // // don't use
  // function api_test()
  // {
  //
  //   $http = new Http();
  //
  //   $api_base = 'http://mineralpointoperahouse.org/wp-json/wp/v2/posts';
  //
  //   $ret->resp = $http->get( $api_base )
  //   ->onError(
  //       fn ($response) => $this->error( $response )
  //   )
  //   ->json();
  //
  //   print_array( $ret );
  // }




  // function get_entity( $uuid )
  // {
  //   $http = new Http();
  //
  //   $ret = $http->withToken( $this->api_key )
  //   ->get( $this->api_base . 'entities/' . $uuid )
  //   ->onError(
  //       fn ( $response ) => $this->error( $response )
  //   )
  //   ->json();
  //
  //   return $ret;
  // }



  // function api_mp_test()
  // {
  //   $http = new Http();
  //
  //   $entity_uuid = '96804282-34e9-430a-b699-bce48add0ee3';
  //
  //   $ret = $http->withToken( $this->api_key )
  //   ->get( $this->api_base . 'entities/' . $entity_uuid )
  //   ->onError(
  //       fn ( $response ) => $this->error( $response )
  //   )
  //   ->json();
  //
  //   print_array( $ret );
  // }




  function error( $response )
  {
    // do something
  }


}
