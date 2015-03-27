Swaggervel
==========

Swagger for Laravel

### For Laravel 5, please use the [1.0 branch](https://github.com/slampenny/Swaggervel.git)!

This package combines [Swagger-php](https://github.com/zircote/swagger-php) and [swagger-ui](https://github.com/wordnik/swagger-ui) into one Laravel-friendly package.

When you run your app in debug mode, Swaggervel will scan your app folder (or any folder that is set under the "app-dir" variable in the packages config), generate swagger json files and deposit them to the doc-dir folder (default is `/docs`). Files are then served by swagger-ui under the api-docs directory.

Installation
============

- Add `Jlapp\Swaggervel\SwaggervelServiceProvider` to your providers array in `app/config/app.php`
- Run `php artisan swaggervel:install` to push swagger-ui to your public folder.
- Run `php artisan config:publish jlapp/swaggervel` to push config files to your app folder.

Example
=======
- www.example.com/docs  <- swagger JSON files are visible
- www.example.com/api-docs <- swagger ui is visible.

Options
=======
Uncomment the "viewHeaders" option in the Config file to add headers to your view.

How to Use Swagger-php
======================
The actual Swagger spec is beyond the scope of this package. All Swaggervel does is package up swagger-php and swagger-ui in a Laravel-friendly fashion, and tries to make it easy to serve. For info on how to use swagger-php [look here](http://zircote.com/swagger-php/). For good examples of swagger-php in action [look here](https://github.com/zircote/swagger-php/tree/master/Examples/Petstore).
