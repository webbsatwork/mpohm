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
