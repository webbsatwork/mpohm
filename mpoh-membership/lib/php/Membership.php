<?php

require '/home/webbsites/wp.webbsites.net/vendor/autoload.php';


/* Object */

use MonkeyPod\Api\Client;
use MonkeyPod\Api\Resources\Entity;



class Membership
{

  private $db_prefix = '_mpohm_';
  private $user_data;
  private $entity_uuid;

  private $fname;


  function __construct()
  {
    // Static configuration creates a global Client object that
    // will automatically be used for all API calls.

    $api_key = '47wMMALRbc4JuepXKHGh7X6h9amL890vlYjCiU8i';
    $subdomain = 'mineral-point-opera-house-inc';

    Client::configure( $api_key, $subdomain );
  }




  private function get_user_data()
  {
    $this->user_data = wp_get_current_user();
    $uuid = get_user_meta( $this->user_data->data->ID, '_mpohm_user_uuid', 1 );

    $person = new Entity( $uuid );
    $person->retrieve();
    $this->person = $person;

    // Save phones
    foreach( $person->phones as $phone )
    {
      $this->phones[] = $phone->number;
    }
  }




  public function member_page()
  {
    $this->get_user_data();

    ?>

    <div id="mpohm-user-dashboard" class="mpohm-input-area mpohm-stage mpohm-user-dashboard">

      <?php $this->membership_panel_sidebar() ?>

      <div id="mpohm-dashboard-content-area">

        <?php $this->membership_panel_membership() ?>
        <?php $this->membership_panel_information() ?>
        <?php $this->membership_panel_password() ?>
        <?php $this->membership_panel_faq() ?>
        <?php $this->membership_panel_terms() ?>
        <?php $this->membership_panel_support() ?>

      </div><!-- end #mpohm-dashboard-content-area -->

    </div><!-- end #mpohm-user-dashboard -->



    <?php

  }


  private function membership_panel_sidebar()
  {
    ?>
    <div id="mpohm-dashboard-sidebar">

      <h4>Hi <?php echo $this->person->first_name ?>!</h4>

      <ul id="mpohm-cp-nav">

        <li class="active-item"><a href="#" class="mpohm-change-panel ws-ico-users" rel="mpohm-cp-panel-membership">My Membership</a></li>
        <li><a href="#" class="mpohm-change-panel ws-ico-user" rel="mpohm-cp-panel-info">My Information</a></li>
        <li><a href="#" class="mpohm-change-panel ws-ico-key" rel="mpohm-cp-panel-password">Password</a></li>
        <li><a href="#" class="mpohm-change-panel ws-ico-question-circle" rel="mpohm-cp-panel-faq">FAQs</a></li>
        <li><a href="#" class="mpohm-change-panel ws-ico-search" rel="mpohm-cp-panel-terms">Terms</a></li>
        <li><a href="#" class="mpohm-change-panel ws-ico-life-ring" rel="mpohm-cp-panel-support">Support</a></li>

      </ul>

      <div id="mpohm-dashboard-sidebar-footer">
        <p><i class="ws-ico-unlock mpohm-logout"></i><a href="/do-action?a=logout">Logout</a></p>
      </div>

    </div><!-- end #mpohm-dashboard-sidebar -->

    <?php
  }



  private function membership_panel_membership()
  {

    $atts = $this->person->extra_attributes;

    //
    $today_unix = time();

    if( key_exists( 'membership-start-date', $atts ) )
    {
      $mem_start_date_unix = strtotime( $atts['membership-start-date'] );
      $mem_start_date = date("F j, Y", $mem_start_date_unix );
    }
    else
    {
      $mem_start_date = '&mdash;';
    }

    $mem_level = key_exists( 'membership-level', $atts ) ? $atts['membership-level'] : '&mdash;';

    if( key_exists( 'membership-paid-through-date', $atts ) )
    {
      $mem_expires_unix = strtotime( $atts['membership-paid-through-date'] );
      $mem_expires = date("F j, Y", $mem_expires_unix ) . ' <input type="button" class="small-btn anim" name="submit" value="Renew" />';
    }
    else
    {
      $mem_expired = true;
      $mem_expires = '&mdash; <input type="button" class="small-btn anim" name="submit" value="Join" />';
    }


    // check status
    if( $mem_start_date != '&mdash;' )
    {
      if( $mem_expires_unix > $today_unix )
      {
        $mem_status = '<span class="mpohm-success-msg">Current</span>';
      }
      else
      {
        $mem_status = '<span class="mpohm-error-msg">Expired</span>';
      }
    }
    else
    {
      $mem_status = '<span class="mpohm-error-msg">Not a member</span>';
    }



    ?>

    <div id="mpohm-cp-panel-membership" class="mpohm-cp-panel my-membership active-panel anim">

      <h2 class="mpohm-dashboard-header ws-ico-users">My Membership</h2>

      <div class="mpohm-dashboard-slider">

        <p>Check your current membership status, and renew during renewal period.</p>

          <form id="some-form-info-here">

            <div class="mpohm-form-input-area">

              <div class="mpohm-form-input-div">

                <dl class="mpohm-info-list">

                  <dt>Your Name</dt>
                  <dd><?php echo $this->person->first_name . ' ' . $this->person->last_name ?></dd>

                  <dt>Your Email</dt>
                  <dd><?php echo $this->person->email ?></dd>

                  <dt>Membership Status</dt>
                  <dd><?php echo $mem_status ?></dd>

                  <dt>Member Since</dt>
                  <dd><?php echo $mem_start_date ?></dd>

                  <dt>Membership Level</dt>
                  <dd><?php echo $mem_level ?></dd>

                  <dt>Membership Paid Through</dt>
                  <dd><?php echo $mem_expires ?></dd>

                </dl>

              </div>


            </div><!-- end .mpohm-form-input-area -->

          </form>

          <?php //print_array( $this ) ?>

        </div><!-- end .mpohm-dashboard-slider -->

      </div><!-- end #mpohm-cp-panel-membership -->

    <?php

  }




  private function membership_panel_information()
  {
    $atts = $this->person->extra_attributes;
    $phone = $this->phones[0];

    ?>

    <div id="mpohm-cp-panel-info" class="mpohm-cp-panel my-information anim">

      <h2 class="mpohm-dashboard-header ws-ico-user">My Information</h2>

      <div class="mpohm-dashboard-slider">

        <p>Update your current contact information in our system.</p>

          <form id="some-form-info-here">

            <div class="mpohm-form-input-area">

              <div class="mpohm-form-input-div flex10">

                <label>Title</label>
                <select>
                  <option></option>
                  <option>Mr.</option>
                  <option>Mrs.</option>
                  <option>Ms.</option>
                </select>
              </div>

              <div class="mpohm-form-input-div flex30">

                <label>First Name</label>
                <input type="text" name="" id="" value="<?php echo $this->person->first_name ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex30">

                <label>Middle Name</label>
                <input type="text" name="" id="" value="<?php echo $this->person->middle_name ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex30">

                <label>Last Name</label>
                <input type="text" name="" id="" value="<?php echo $this->person->last_name ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div">

                <label>Address</label>
                <input type="text" name="" id="" value="<?php echo $this->person->address ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex50">

                <label>City</label>
                <input type="text" name="" id="" value="<?php echo $this->person->city ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex20">

                <label>State</label>
                <?php mpohm_states_picker( 'mpohm_state', $this->person->state ) ?>

              </div>

              <div class="mpohm-form-input-div flex30">

                <label>Postal Code</label>
                <input type="text" name="" id="" value="<?php echo $this->person->postal_code ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div">

                <label>Country</label>
                <input type="text" name="" id="" value="<?php echo $this->person->country ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex50">

                <label>Email</label>
                <input type="email" name="" id="" value="<?php echo $this->person->email ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div flex50">

                <label>Phone</label>
                <input type="text" name="" id="" value="<?php echo $phone ?>" placeholder="" />

              </div>

              <div class="mpohm-form-input-div">

                <input type="button" class="anim" name="submit" value="Save" />

              </div>

            </div><!-- end .mpohm-form-input-area -->

          </form>

          <?php print_array( $this ) ?>

        </div><!-- end .mpohm-dashboard-slider -->

      </div><!-- end #mpohm-cp-panel-info -->

    <?php

  }




  private function membership_panel_password()
  {

    $current_email = $this->user_data->data->user_email;
    ?>

    <div id="mpohm-cp-panel-password" class="mpohm-cp-panel anim">

      <h2 class="mpohm-dashboard-header ws-ico-key">Password</h2>

      <div class="mpohm-dashboard-slider">

        <p>Update your password. If you do not know your current password, you can send a reset request <a href="#">here</a>.</p>

          <form id="some-form-info-here">

            <div class="mpohm-form-input-area">

              <div class="mpohm-form-input-div">

                <dl class="mpohm-info-list">

                  <dt>Email Address</dt>
                  <dd>
                    <input type="email" name="" id="" value="<?php echo $current_email ?>" placeholder="" />
                  </dd>

                  <dt>Current Password</dt>
                  <dd>
                    <input type="password" name="" id="" value="" placeholder="" />
                  </dd>

                  <dt>New Password</dt>
                  <dd>
                    <input type="password" name="" id="" value="" placeholder="" />
                  </dd>

                </dl>

              </div>


              <div class="mpohm-form-input-div">

                <input type="button" class="anim" name="submit" value="Update" />

              </div>

            </div><!-- end .mpohm-form-input-area -->

          </form>

        </div><!-- end .mpohm-dashboard-slider -->

      </div><!-- end #mpohm-cp-panel-password -->

    <?php

  }




  private function membership_panel_faq()
  {
    $faq_slug = 'mpohmfaq';

    $faq_args = array(
      'name'        => $faq_slug,
      'post_type'   => 'page',
      'post_status' => 'publish',
      'numberposts' => 1
    );

    $info = get_posts( $faq_args );

    $faq = wpautop( $info[0]->post_content );

    ?>

    <div id="mpohm-cp-panel-faq" class="mpohm-cp-panel anim">

      <h2 class="mpohm-dashboard-header ws-ico-question-circle">Frequently Asked Questions</h2>

      <div class="mpohm-dashboard-slider">

        <div id="mpohm-faq-list">

          <?php _e( $faq ) ?>

        </div>

        <?php // print_array( $info ) ?>

      </div><!-- end .mpohm-dashboard-slider -->

    </div><!-- end #mpohm-cp-panel-faq -->

    <?php

  }




  private function membership_panel_terms()
  {

    $terms_slug = 'mpohmterms';

    $terms_args = array(
      'name'        => $terms_slug,
      'post_type'   => 'page',
      'post_status' => 'publish',
      'numberposts' => 1
    );

    $tinfo = get_posts( $terms_args );

    $mpohm_terms = $tinfo[0]->post_content;

    ?>

    <div id="mpohm-cp-panel-terms" class="mpohm-cp-panel anim">

      <h2 class="mpohm-dashboard-header ws-ico-search">Terms &amp; Conditions</h2>

      <div class="mpohm-dashboard-slider">

        <div id="mpohm-terms-conditions">

          <?php _e( $mpohm_terms ) ?>

        </div>

      </div><!-- end .mpohm-dashboard-slider -->

    </div><!-- end #mpohm-cp-panel-terms -->

    <?php

  }




  private function membership_panel_support()
  {

    $current_email = $this->user_data->data->user_email;
    ?>

    <div id="mpohm-cp-panel-support" class="mpohm-cp-panel anim">

      <h2 class="mpohm-dashboard-header ws-ico-life-ring">Support</h2>

      <div class="mpohm-dashboard-slider">

        <p>
          For help managing your <strong>Friends of the MPOH</strong> membership, feel free to
          use the form below. You can also call us at <strong>(608) 987-3501</strong> or email
          us at <a href="mailto:member@mpoh.org">member@mpoh.org</a>.
        </p>

          <form id="some-form-info-here">

            <div class="mpohm-form-input-area">

              <div class="mpohm-form-input-div">

                <dl class="mpohm-info-list">

                  <dt>Your Name</dt>
                  <dd>
                    <input type="text" name="" id="" value="<?php echo $this->person->first_name . ' ' . $this->person->last_name ?>" placeholder="" />
                  </dd>

                  <dt>Email Address</dt>
                  <dd>
                    <input type="email" name="" id="" value="<?php echo $current_email ?>" placeholder="" />
                  </dd>

                  <dt>Support Issue Needed</dt>
                  <dd>
                    <select name="" id="">
                      <option value="">Select...</option>
                      <option></option>
                      <option>Website Problem</option>
                      <option>Password Issue</option>
                      <option>Eventbrite Question</option>
                      <option>Other ...</option>
                    </select>
                  </dd>

                  <dt>Details</dt>
                  <dd>
                    <textarea name="" id="" placeholder="Please explain your issue here ..."></textarea>
                  </dd>

                </dl>

              </div>


              <div class="mpohm-form-input-div">

                <input type="button" class="anim" name="submit" value="Report Issue" />

              </div>

            </div><!-- end .mpohm-form-input-area -->

          </form>

        </div><!-- end .mpohm-dashboard-slider -->

      </div><!-- end #mpohm-cp-panel-membership -->

    <?php

  }




  static function login_form()
  {
    ?>

    <div id="mpohm-login-area" class="mpohm-form-input-area mpohm-stage small-window">

      <div class="mpohm-login-window-header">
        <?php mpoh_logo( 'mpohm-login-logo' ) ?>
      </div>

      <div class="mpohm-login-window-content stage-content">

        <h4 id="mpohm-status-message" class="align-center">
          Sign in to Friends of the MPOH
        </h4>

        <form id="mpohm-join-membership" action="" method="post" enctype="multipart/form-data" autocomplete="off">

          <div class="mpohm-form-input-div" id="mpohm-form-line-email">
            <label class="mpohm-input-label">Email</label>
            <input type="email" class="mpohm-login-information no-autofill" id="mpohm-signin-input-email" name="mpohm_member_email" autocomplete="off" autocorrect="off" autocapitalize="off" autofocus />
          </div>

          <div class="mpohm-form-input-div" id="mpohm-form-line-password">
            <label class="mpohm-input-label">Password</label>
            <input type="password" id="mpohm-signin-input-password" class="anim slow" name="mpohm_member_pw" />
          </div>

          <div class="mpohm-form-input-div" id="mpohm-form-line-button">
            <div class="mpohm-button-stage">
              <div class="mpohm-button-area">
                <button class="button anim" id="mpohm-login-button" disabled>GO →</button>
              </div>
              <div class="mpohm-loading-area">
                <div id="mpohm-loading-dots" class="mpohm-zero-opacity dot-elastic anim"></div>
              </div>
            </div>
          </div>

          <p id="mpohm-form-line-persistent" class="align-center">
            <label class="mpohm-button-label" for="mpohm-signin-persistent">
              <input type="checkbox" name="mpohm-signin-persistent" id="mpohm-signin-persistent" value="stay_signed_in" />
              <span class="mpohm-checkmark"></span>
              Keep me signed in
            </label>
          </p>

        </form>

        <p class="mpohm-small-type align-center" id="mpohm-signin-forgot-email">
          <a href="#">Forgot email/password?</a>
        </p>
        <p class="mpohm-small-type align-center no-margin" id="mpohm-signin-signup">
          Don&rsquo;t have an account? <a href="#">Sign up</a>
        </p>

        <!-- <div id="mpohm-test-data-return"></div> -->

      </div>

    </div>

    <?php
  }



  public function login( $post )
  {

    $ret = new stdClass();

    // Sanitize login data
    $cookie['email'] = sanitize_email( $post['mpohm_member_email'] );
    $cookie['pw'] = sanitize_text_field( $post['mpohm_member_pw'] );

    $user = wp_authenticate( $cookie['email'], $cookie['pw'] );

    $obj_class = get_class( $user );

    if( $obj_class == 'WP_Error' )
    {
      $ret->error = true;
      $ret->status = 'Email/password combination does not exist';
    }
    else
    {
      $cred = array();

      // Save the user ID
      $cred['userid'] = $user->ID;

      // Check if user clicked remember
      if( array_key_exists( 'mpohm-signin-persistent', $post ) && $post['mpohm-signin-persistent'] == 'stay_signed_in' )
        $cred['stay_signed_in'] = true;
      else
        $cred['stay_signed_in'] = false;

      // Save JSON var
      $data = base64_encode( json_encode( $cred ) );

      // Save token for login
      $token = sha1( rand() );

      // Save temporary option in database, return error on failure
      if( ! add_option( $this->db_prefix . $token, $data ) )
      {
        $ret->error = true;
        $ret->status = 'Sorry, there was a problem with the database';
      }
      else
      {
        $ret->error = false;
        $ret->status = 'Credentials approved!';
        $ret->token = $token;
      }
    }


    // $ret->post = $post;

    echo json_encode( $ret );
  }


  public function process_login()
  {
    if( empty( $_COOKIE['t'] ) )
    {
      wp_redirect( '/member-login' );
      exit;
    }
    else
    {
      $token = $_COOKIE['t'];
    }

    if( ! $login_data = $this->retrieve_login_data( $token ) )
    {
      wp_redirect( '/member-login' );
      exit;
    }
    else
    {
      // Destroy the cookie
      setcookie( 't', time() - 3600 );

      // Get the information
      $login_data = json_decode( $login_data );
      $userid = $login_data->userid;
      $stay_signed_in = $login_data->stay_signed_in;

      // Log user in
      wp_set_current_user( $userid );
      wp_set_auth_cookie( $userid, $stay_signed_in, 1 );

      // Destroy the database entry
      delete_option( $this->db_prefix . $token );

      // Go to member page
      wp_redirect( '/member' );
      exit;
    }
  }


  private function retrieve_login_data( $token )
  {
    if( ! $data = get_option( $this->db_prefix . $token ) )
    {
      return false;
    }
    else
    {
      return base64_decode( $data );
    }
  }







  function update_entity( $uuid )
  {
    $person = new Entity( $uuid );
    $person->retrieve();

    $this->person = $person;
  }



  function new_entity()
  {
    $person = new Entity;
    $person->type = "Individual";                 // REQUIRED, one of "Individual", "Organization", "Foundation", "Corporate", "Government", or "Other"
    $person->first_name = "Bart";
    $person->last_name = "Simpson";               // REQUIRED, only when type is "Individual" and email is not provided
    $person->organization_name = "Acme, Inc.";    // REQUIRED, only when type is not "Individual"
    $person->email = "bart.simpson@example.com";  // REQUIRED, only when type is "Individual" and last_name is not provided
    $person->create();

    /**
     * If you didn't supply an ID, one will be assigned by MonkeyPod,
     * which you probably want to store for future reference (for example,
     * to associate it with a data record in your application that corresponds
     * or relates to the created entity).
     */
    $this->get_entity( $person->id );
  }




  function delete_entity( $uuid )
  {
    $person = new Entity( $uuid );

    $person->delete();

    print_array( $person );
  }




  function find_entity_by_email( $email )
  {
    $comparator = new Entity();
    $comparator->email = $email;

    $matches = new \MonkeyPod\Api\Resources\EntityCollection();
    $matches->match( $comparator );

    print_array( $matches );

    // // API will also match on ID or name
    // $comparator = new Entity();
    // $comparator->first_name = 'Jane';
    // $comparator->last_name = 'Smith';
    //
    // $matches = new \MonkeyPod\Api\Resources\EntityCollection();
    // $matches->match($comparator);
  }





  function find_entity_by_name( $lname, $fname )
  {
    // API will also match on ID or name
    $comparator = new Entity();

    $comparator->last_name = $lname;
    $comparator->first_name = $fname;

    $matches = new \MonkeyPod\Api\Resources\EntityCollection();
    $matches->match( $comparator );

    print_array( $matches );
  }







  static function the_states()
  {
    return array(
    	'AL'=>'ALABAMA',
    	'AK'=>'ALASKA',
    	'AS'=>'AMERICAN SAMOA',
    	'AZ'=>'ARIZONA',
    	'AR'=>'ARKANSAS',
    	'CA'=>'CALIFORNIA',
    	'CO'=>'COLORADO',
    	'CT'=>'CONNECTICUT',
    	'DE'=>'DELAWARE',
    	'DC'=>'DISTRICT OF COLUMBIA',
    	'FM'=>'FEDERATED STATES OF MICRONESIA',
    	'FL'=>'FLORIDA',
    	'GA'=>'GEORGIA',
    	'GU'=>'GUAM GU',
    	'HI'=>'HAWAII',
    	'ID'=>'IDAHO',
    	'IL'=>'ILLINOIS',
    	'IN'=>'INDIANA',
    	'IA'=>'IOWA',
    	'KS'=>'KANSAS',
    	'KY'=>'KENTUCKY',
    	'LA'=>'LOUISIANA',
    	'ME'=>'MAINE',
    	'MH'=>'MARSHALL ISLANDS',
    	'MD'=>'MARYLAND',
    	'MA'=>'MASSACHUSETTS',
    	'MI'=>'MICHIGAN',
    	'MN'=>'MINNESOTA',
    	'MS'=>'MISSISSIPPI',
    	'MO'=>'MISSOURI',
    	'MT'=>'MONTANA',
    	'NE'=>'NEBRASKA',
    	'NV'=>'NEVADA',
    	'NH'=>'NEW HAMPSHIRE',
    	'NJ'=>'NEW JERSEY',
    	'NM'=>'NEW MEXICO',
    	'NY'=>'NEW YORK',
    	'NC'=>'NORTH CAROLINA',
    	'ND'=>'NORTH DAKOTA',
    	'MP'=>'NORTHERN MARIANA ISLANDS',
    	'OH'=>'OHIO',
    	'OK'=>'OKLAHOMA',
    	'OR'=>'OREGON',
    	'PW'=>'PALAU',
    	'PA'=>'PENNSYLVANIA',
    	'PR'=>'PUERTO RICO',
    	'RI'=>'RHODE ISLAND',
    	'SC'=>'SOUTH CAROLINA',
    	'SD'=>'SOUTH DAKOTA',
    	'TN'=>'TENNESSEE',
    	'TX'=>'TEXAS',
    	'UT'=>'UTAH',
    	'VT'=>'VERMONT',
    	'VI'=>'VIRGIN ISLANDS',
    	'VA'=>'VIRGINIA',
    	'WA'=>'WASHINGTON',
    	'WV'=>'WEST VIRGINIA',
    	'WI'=>'WISCONSIN',
    	'WY'=>'WYOMING',
    	'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
    	'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
    	'AP'=>'ARMED FORCES PACIFIC'
    );
  }


}
