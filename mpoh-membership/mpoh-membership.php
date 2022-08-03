<?php

/**
 * @package Wawza Simple Pay Plugin
 * version 0.9.0
 */

/*
Plugin Name:    MPOH Membership
Plugin URI:     https://mpoh.org
Description:    Plugin for membership at Mineral Point Opera House
Author:         Bill Webb
Version:        0.9.0
Author URI:     http://webbsites.net
*/


// Login stylesheets
function mpohm_scripts()
{
    wp_enqueue_script( 'membership', plugin_dir_url( __FILE__ ) . 'lib/js/membership.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'mpohm_scripts' );


require_once( 'lib/php/setup.php' );
require_once( 'lib/php/funcs.php' );
require_once( 'lib/php/Membership.php' );
// require_once( 'lib/php/Remote.php' );
