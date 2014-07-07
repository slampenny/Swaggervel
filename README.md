Swaggervel
==========

Swagger for Laravel

This package combines <a href="https://github.com/zircote/swagger-php">Swagger-php</a> and <a href="https://github.com/wordnik/swagger-ui">swagger-ui</a> into one Laravel-friendly package.

When you run your app in debug mode, Swaggervel will scan your app folder (or any folder that is set under the "app-dir" variable in the packages config), generate swagger json files, and deposit them to the "doc-dir" folder (default is "/docs"). Files are then served by swagger-ui under the api-docs director.


Make sure to run php artisan swaggervel:install to push swagger-ui and your config files to your public folder.

Example:

www.example.com/docs  <- swagger JSON files are visible
www.example.com/api-docs <- swagger ui is visible.