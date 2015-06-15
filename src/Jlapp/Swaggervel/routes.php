<?php

use Swagger\Swagger;

Route::any(Config::get("$configName.doc-route").'/{page?}', function($page='api-docs.json') use ($configName) {
    $filePath = Config::get("$configName.doc-dir") . "/{$page}";

    if (File::extension($filePath) !== "json") {
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

Route::get(Config::get("$configName.api-docs-route"), function() use ($configName) {
    if (Config::get("$configName.generateAlways")) {
        $appDir = base_path()."/".Config::get("$configName.app-dir");
        $docDir = Config::get("$configName.doc-dir");

        if (!File::exists($docDir) || is_writable($docDir)) {
            // delete all existing documentation
            if (File::exists($docDir)) {
                File::deleteDirectory($docDir);
            }

            File::makeDirectory($docDir);

            $defaultBasePath = Config::get("$configName.default-base-path");
            $defaultApiVersion = Config::get("$configName.default-api-version");
            $defaultSwaggerVersion = Config::get("$configName.default-swagger-version");
            $excludeDirs = Config::get("$configName.excludes");

            $swagger = new Swagger($appDir, $excludeDirs);

            $resourceList = $swagger->getResourceList(array(
                'output' => 'array',
                'apiVersion' => $defaultApiVersion,
                'swaggerVersion' => $defaultSwaggerVersion,
            ));
            $resourceOptions = array(
                'output' => 'json',
                'defaultSwaggerVersion' => $resourceList['swaggerVersion'],
                'defaultBasePath' => $defaultBasePath
            );

            $output = array();
            foreach ($swagger->getResourceNames() as $resourceName) {
                $json = $swagger->getResource($resourceName, $resourceOptions);
                $resourceName = str_replace(DIRECTORY_SEPARATOR, '-', ltrim($resourceName, DIRECTORY_SEPARATOR));
                $output[$resourceName] = $json;
            }

            $filename = $docDir . '/api-docs.json';
            file_put_contents($filename, Swagger::jsonEncode($resourceList, true));

            foreach ($output as $name => $json) {
                $name = str_replace(DIRECTORY_SEPARATOR, '-', ltrim($name, DIRECTORY_SEPARATOR));
                $filename = $docDir . '/'.$name . '.json';
                file_put_contents($filename, $json);
            }
        }
    }

    if (Config::get("$configName.behind-reverse-proxy")) {
        $proxy = Request::server('REMOTE_ADDR');
        Request::setTrustedProxies(array($proxy));
    }

    Blade::setEscapedContentTags('{{{', '}}}');
    Blade::setContentTags('{{', '}}');

    //need the / at the end to avoid CORS errors on Homestead systems.
    $response = response()->view('swaggervel::index', array(
        'secure'         => Request::secure(),
        'apiKey'         => Config::get("$configName.api-key"),
        'urlToDocs'      => url(Config::get("$configName.doc-route")),
        'requestHeaders' => Config::get("$configName.requestHeaders") )
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

    if (Config::has("$configName.viewHeaders")) {
        foreach (Config::get("$configName.viewHeaders") as $key => $value) {
            $response->header($key, $value);
        }
    }

    return $response;
});
