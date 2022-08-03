<?php


// Add "member" role if not defined
add_action( 'init', 'mpohm_add_member_role' );
function mpohm_add_member_role()
{
  // Check for member role
  $roles = $GLOBALS['wp_roles']->roles;

  // If the role 'member' doesn't exist ...
  if( ! array_key_exists( 'member', $roles ) )
  {
    // ... add it
    add_role( 'member', 'Member', array( 'read' => 1, 'mpoh_member' => 1 ) );
  }
}


// Create necessary pages
add_action( 'init', 'mpohm_create_pages' );
function mpohm_create_pages()
{
  // Create member, member-login,
}



// Hide admin bar from members
add_filter( 'show_admin_bar', 'mpohm_hide_admin_bar' );
function mpohm_hide_admin_bar()
{
    // Add the roles to exclude from having admin bar.
    $excluded_roles = [ 'member' ];

    if( array_intersect( wp_get_current_user()->roles, $excluded_roles ) )
    {
      show_admin_bar( false );
    }
}




// Redirect admin page for members
add_filter( 'admin_init', 'mpohm_redirect_member_from_admin_page' );
function mpohm_redirect_member_from_admin_page()
{
  // Add the roles to exclude from having admin bar.
  $excluded_roles = [ 'member' ];

  if( array_intersect( wp_get_current_user()->roles, $excluded_roles ) )
  {
    wp_redirect( '/member' );
  }
}





// Localize ajax
add_action( 'wp_enqueue_scripts', 'mpohm_localize_ajax' );
function mpohm_localize_ajax()
{
  // Make the WP ajax url available on the frontend
	$mpohm_ajarr = array( 'ajax_url' => admin_url( 'admin-ajax.php' ) );
	wp_localize_script( 'membership', 'mpohm_ajax', $mpohm_ajarr );
}




// Login page content
add_action( 'the_content', 'mpohm_output_member_content' );
function mpohm_output_member_content( $content )
{
  if( is_singular() && in_the_loop() && is_main_query() )
  {
    if( is_page( 'member-login' ) ) return mpohm_login_form();
    elseif( is_page( 'member' ) ) return mpohm_member_page();
    elseif( is_page( 'new-member' ) ) return mpohm_new_member( $content );
  }
  return $content;
}





// Check if user is logged in on Login page
add_action( 'template_redirect', 'mpohm_check_user_login_page' );
function mpohm_check_user_login_page()
{
  if( is_page( 'member-login' ) && is_user_logged_in() )
  {
    wp_redirect( '/member');
    exit;
  }
}



// Log user out
add_action( 'wp', 'mpohm_do_action_page' );
function mpohm_do_action_page()
{
  if( is_page( 'do-action' ) )
  {
    // echo '<p>Hello!</p>';
    if( is_user_logged_in() )
    {
      if( $_GET['a'] == 'logout' )
      {
        wp_logout();
        wp_redirect( '/member-login');
        exit;
      }
      else
      {
        wp_redirect( '/member');
        exit;
      }
    }
    else
    {
      wp_redirect( '/');
      exit;
    }
  }
}



// Check if user is logged in on Member page
add_action( 'template_redirect', 'mpohm_check_if_user_logged_in' );
function mpohm_check_if_user_logged_in()
{
  if( is_page( 'member' ) && ! is_user_logged_in() )
  {
    wp_redirect( '/member-login');
    exit;
  }
}



// Process login if credentials have been approved
add_action( 'template_redirect', 'mpohm_process_login' );
function mpohm_process_login()
{
  if( is_page( 'process-login' ) )
  {
    $mem = new Membership();
    $mem->process_login();
    exit;
  }
}
