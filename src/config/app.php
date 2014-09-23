<?php
/**
 * Created by PhpStorm.
 * User: Jordan
 * Date: 04/07/14
 * Time: 3:54 PM
 */

return array(
    /*
      |--------------------------------------------------------------------------
      | Absolute path to location where parsed swagger annotations will be stored
      |--------------------------------------------------------------------------
    */
    'doc-dir' => app_path() . '/storage/docs',

    /*
      |--------------------------------------------------------------------------
      | Relative path to access parsed swagger annotations.
      |--------------------------------------------------------------------------
    */
    'doc-route' => '/docs',

    /*
      |--------------------------------------------------------------------------
      | Absolute path to directory containing the swagger annotations are stored.
      |--------------------------------------------------------------------------
    */
    "target-dirs" => array(
        app_path() . '/controllers',
        app_path() . '/models',
    ),

    "api-key" => "auth_token",
    "default-base-path" => "",

    /*"viewHeaders" => array(
        'Content-Type' => 'text/plain'
    ),*/
);