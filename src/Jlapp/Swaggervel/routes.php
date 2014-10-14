<?php

Route::any(Config::get('swaggervel::app.doc-route').'/{page?}', function($page='api-docs.json') {
    $filePath = Config::get('swaggervel::app.doc-dir') . "/{$page}";

    if (!File::Exists($filePath)) {
        App::abort(404, "Cannot find {$filePath}");
    }

    $content = File::get($filePath);
    return Response::make($content, 200, array(
        'Content-Type' => 'application/json'
    ));
});

Route::get('api-docs', function() {
    if (Config::get('swaggervel::app.generateAlways')) {
        $appDir = base_path()."/".Config::get('swaggervel::app.app-dir');
        $docDir = Config::get('swaggervel::app.doc-dir');

        if (!File::exists($docDir) || is_writable($docDir)) {
            //delete all existing documentation
            if (File::exists($docDir)) {
                File::deleteDirectory($docDir);
            }

            File::makeDirectory($docDir);

            $basepath = "";
            $defaultBasePath = Config::get('swaggervel::app.default-base-path');
            if ((isset($defaultBasePath)) && ($defaultBasePath !== '')) {
                $basepath .= ' --default-base-path "'.$defaultBasePath.'"';
            }

            $excludes = "";
            $found = false;
            foreach(Config::get('swaggervel::app.excludes') as $exclude) {
                if (!$found) {
                    $excludes .= "-e ";
                    $found = true;
                }
                $excludes .= $exclude.":";
            }

            if ($found) {
                $excludes = rtrim($excludes, ":");
            }

            $result = shell_exec("php " . base_path() . "/vendor/zircote/swagger-php/swagger.phar $appDir -o {$docDir} {$basepath} {$excludes}");

            //display all swagger-php error messages so that it doesn't fail silently
            if ((strpos($result, "[INFO]") != FALSE) || (strpos($result, "[WARN]") != FALSE)) {
                throw new \Exception($result);
            }
        }
    }

    Blade::setEscapedContentTags('{{{', '}}}');
    Blade::setContentTags('{{', '}}');

    $response = Response::make(
        View::make('swaggervel::index', array('urlToDocs' => url(Config::get('swaggervel::app.doc-route')), 'requestHeaders' => Config::get('swaggervel::app.requestHeaders') )),
        200
    );

    if (Config::has('swaggervel::app.viewHeaders')) {
        foreach (Config::get('swaggervel::app.viewHeaders') as $key => $value) {
            $response->header($key, $value);
        }
    }

    return $response;
});
