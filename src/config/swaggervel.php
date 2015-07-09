<?php
/**
 * Created by PhpStorm.
 * User: Jordan
 * Date: 04/07/14
 * Time: 3:54 PM
 */

return array(
    'active' => true,

    /*
      |--------------------------------------------------------------------------
      | Absolute path to location where parsed swagger annotations will be stored
      |--------------------------------------------------------------------------
    */
    'doc-dir' => storage_path() . '/docs',

    /*
      |--------------------------------------------------------------------------
      | Relative path to access parsed swagger annotations.
      |--------------------------------------------------------------------------
    */
    'doc-route' => 'docs',

    /*
      |--------------------------------------------------------------------------
      | Relative path to access documentation.
      |--------------------------------------------------------------------------
    */
    'api-docs-route' => 'api-docs',

    /*
      |--------------------------------------------------------------------------
      | Absolute path to directory containing the swagger annotations are stored.
      |--------------------------------------------------------------------------
    */
    "app-dir" => "app",

    /*
      |--------------------------------------------------------------------------
      | Absolute path to directories that you would like to exclude from swagger generation
      |--------------------------------------------------------------------------
    */
    "excludes" => array(
        storage_path(),
        base_path()."/tests",
        base_path()."/resources/views",
        base_path()."/config"
    ),

    /*
      |--------------------------------------------------------------------------
      | Turn this off to remove swagger generation on production
      |--------------------------------------------------------------------------
    */
    "generateAlways" => true,

    "api-key" => "auth_token",

    /*
      |--------------------------------------------------------------------------
      | Edit to set the api's version number
      |--------------------------------------------------------------------------
    */
    "default-api-version" => "",

    /*
      |--------------------------------------------------------------------------
      | Edit to set the swagger version number
      |--------------------------------------------------------------------------
    */
    "default-swagger-version" => "1.2",

    /*
      |--------------------------------------------------------------------------
      | Edit to set the api's base path
      |--------------------------------------------------------------------------
    */
    "default-base-path" => "",

    /*
      |--------------------------------------------------------------------------
      | Edit to trust the proxy's ip address - needed for AWS Load Balancer
      |--------------------------------------------------------------------------
    */
    "behind-reverse-proxy" => false,
    /*
      |--------------------------------------------------------------------------
      | Uncomment to add response headers when swagger is generated
      |--------------------------------------------------------------------------
    */
    /*"viewHeaders" => array(
        'Content-Type' => 'text/plain'
    ),*/

    /*
      |--------------------------------------------------------------------------
      | Uncomment to add request headers when swagger performs requests
      |--------------------------------------------------------------------------
    */
    /*"requestHeaders" => array(
        'TestMe' => 'testValue'
    ),*/
);
