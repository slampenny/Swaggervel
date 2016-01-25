<?php

Route::any(Config::get('swaggervel.doc-route').'/{page?}', function($page='api-docs.json') {
    $filePath = Config::get('swaggervel.doc-dir') . "/{$page}";

    if (File::extension($filePath) === "") {
        $filePath .= ".json";
    }
    if (!File::Exists($filePath)) {
        App::abort(404, "Cannot find {$filePath}");
    }

    $content = File::get($filePath);
    return Response::make($content, 200, array(
        'Content-Type' => 'application/json'
    ));
});

Route::get(Config::get('swaggervel.api-docs-route'), function() {
    if (Config::get('swaggervel.generateAlways')) {
        $appDir = base_path()."/".Config::get('swaggervel.app-dir');
        $docDir = Config::get('swaggervel.doc-dir');

        if (!File::exists($docDir) || is_writable($docDir)) {
            // delete all existing documentation
            if (File::exists($docDir)) {
                File::deleteDirectory($docDir);
            }

            File::makeDirectory($docDir);

            $defaultBasePath = Config::get('swaggervel.default-base-path');
            $defaultApiVersion = Config::get('swaggervel.default-api-version');
            $defaultSwaggerVersion = Config::get('swaggervel.default-swagger-version');
            $excludeDirs = Config::get('swaggervel.excludes');

            $swagger =  \Swagger\scan($appDir, [
                'exclude' => $excludeDirs
                ]);

            $filename = $docDir . '/api-docs.json';
            file_put_contents($filename, $swagger);
        }
    }

    if (Config::get('swaggervel.behind-reverse-proxy')) {
        $proxy = Request::server('REMOTE_ADDR');
        Request::setTrustedProxies(array($proxy));
    }

    Blade::setEscapedContentTags('{{{', '}}}');
    Blade::setContentTags('{{', '}}');

    //need the / at the end to avoid CORS errors on Homestead systems.
    $response = response()->view('swaggervel::index', array(
        'secure'         => Request::secure(),
        'urlToDocs'      => url(Config::get('swaggervel.doc-route')),
        'requestHeaders' => Config::get('swaggervel.requestHeaders'),
        'clientId'       => Request::input("client_id"),
        'clientSecret'   => Request::input("client_secret"),
        'realm'          => Request::input("realm"),
        'appName'        => Request::input("appName"),
        )
    );

    //need the / at the end to avoid CORS errors on Homestead systems.
    /*$response = Response::make(
        View::make('swaggervel::index', array(
                'secure'         => Request::secure(),
                'urlToDocs'      => url(Config::get('swaggervel.doc-route')),
                'requestHeaders' => Config::get('swaggervel.requestHeaders') )
        ),
        200
    );*/

    if (Config::has('swaggervel.viewHeaders')) {
        foreach (Config::get('swaggervel.viewHeaders') as $key => $value) {
            $response->header($key, $value);
        }
    }

    return $response;
});
