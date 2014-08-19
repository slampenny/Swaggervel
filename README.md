Swaggervel
==========

Swagger for Laravel

This package combines <a href="https://github.com/zircote/swagger-php">Swagger-php</a> and <a href="https://github.com/wordnik/swagger-ui">swagger-ui</a> into one Laravel-friendly package.

When you run your app in debug mode, Swaggervel will scan your app folder (or any folder that is set under the "app-dir" variable in the packages config), generate swagger json files and deposit them to the doc-dir folder (default is "/docs"). Files are then served by swagger-ui under the api-docs director.

Installation
============

- Add 'Jlapp\Swaggervel\SwaggervelServiceProvider' to your providers array in app/config/app.php
- Run php artisan swaggervel:install to push swagger-ui to your public folder.
- Run php artisan config:publish jlapp/swaggervel to push config files to your app folder.

Example
=======
- www.example.com/docs  <- swagger JSON files are visible
- www.example.com/api-docs <- swagger ui is visible.

Options
=======
Uncomment the "viewHeaders" option in the Config file to add headers to your view.

How to Use Swagger-php
======================
The actual Swagger spec is beyond the scope of this package. All Swaggervel does is package up swagger-php and swagger-ui in a Laravel-friendly fashion, and tries to make it easy to serve. For info on how to use swagger-php <a href="http://zircote.com/swagger-php/">look here</a>. For good examples of swagger-php in action <a href="https://github.com/zircote/swagger-php/tree/master/Examples/Petstore">look here</a>.