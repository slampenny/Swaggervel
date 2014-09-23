<?php

Route::any(Config::get('swaggervel::app.doc-route').'/{page?}', function($page='api-docs.json') {
    $filePath = Config::get('swaggervel::app.doc-dir') . "/{$page}";

    if (!File::Exists($filePath)) {
        App::abort(404, "Cannot find {$filePath}");
    }

    $content = File::get($filePath);
    return Response::make($content, 200, [
        'Content-Type' => 'application/json'
    ]);
});

Route::get('api-docs', function() {
    if (Config::get('app.debug')) {
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

            foreach (Config::get('swaggervel::app.target-dirs') as $targetDir) {

                $result = shell_exec("php " . base_path() . "/vendor/zircote/swagger-php/swagger.phar $targetDir -o {$docDir}{$basepath}");

                //display all swagger-php error messages so that it doesn't fail silently
                if ((strpos($result, "[INFO]") != FALSE) || (strpos($result, "[WARN]") != FALSE)) {
                    throw new \Exception($result);
                }
            }
        }
    }

    Blade::setEscapedContentTags('{{{', '}}}');
    Blade::setContentTags('{{', '}}');

    $response = Response::make(
        View::make('swaggervel::index', ['urlToDocs' => url(Config::get('swaggervel::app.doc-route')) ]),
        200
    );

    if (Config::has('swaggervel::app.viewHeaders')) {
        foreach (Config::get('swaggervel::app.viewHeaders') as $key => $value) {
            $response->header($key, $value);
        }
    }

    return $response;
});
