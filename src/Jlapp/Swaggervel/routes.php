<?php

Route::get('docs/{page?}', function($page='index.php') {
    header('Access-Control-Allow-Origin: *');
    $parts = pathinfo($page);
    $path = $_SERVER["DOCUMENT_ROOT"] . "/../docs/$page";
    if ($parts['extension'] === 'php') {
        require($path);
    } else {
        return file_get_contents($path);
    }
});

Route::get('api-docs', function() {
    return View::make('swaggervel::index');
});