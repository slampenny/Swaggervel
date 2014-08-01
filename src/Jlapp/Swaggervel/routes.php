<?php

Route::get(Config::get('swaggervel::app.doc-dir').'/{page?}', function($page='index.php') {
    header('Access-Control-Allow-Origin: *');
    $parts = pathinfo($page);
    $path = $_SERVER["DOCUMENT_ROOT"];


    if (substr($path, -1) === "/") {
        $path = trim($path, "/");
    }

    $path = preg_replace('/public$/', '/', $path);

    $path .="/";

    $path .= Config::get('swaggervel::app.doc-dir')."/$page";
    if ($parts['extension'] === 'php') {
        require($path);
    } else {
        return file_get_contents($path);
    }
});

Route::get('api-docs', function() {
    if (Config::get('app.debug')) {
        $appdir = base_path()."/".Config::get('swaggervel::app.app-dir');
        $docdir = base_path()."/".Config::get('swaggervel::app.doc-dir');


        if (!File::exists($docdir) || is_writable($docdir)) {
            //delete all existing documentation
            if (File::exists($docdir)) {
                File::deleteDirectory($docdir);
            }

            File::makeDirectory($docdir);

            $basepath = "";
            $defaultBasePath = Config::get('swaggervel::app.default-base-path');
            if ((isset($defaultBasePath)) && ($defaultBasePath !== '')) {
                $basepath .= ' --default-base-path "'.$defaultBasePath.'"';
            }
            $result = shell_exec("php ".base_path()."/vendor/zircote/swagger-php/swagger.phar ".$appdir." -o ".$docdir.$basepath);

            //display all swagger-php error messages so that it doesn't fail silently
            if ((strpos($result, "[INFO]") != FALSE) || (strpos($result, "[WARN]") != FALSE)) {
                throw new \Exception($result);
            }
        }
    }
    return View::make('swaggervel::index');
});