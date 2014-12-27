<?php

Route::any($self->getSettings($group, 'doc-route').'/{page?}', function($page='api-docs.json') use ($self, $group) {
    $filePath = $self->getSettings($group, 'doc-dir') . "/{$page}";

    if (!File::Exists($filePath)) {
        App::abort(404, "Cannot find {$filePath}");
    }

    $content = File::get($filePath);
    return Response::make($content, 200, array(
        'Content-Type' => 'application/json'
    ));
});

Route::get($self->getSettings($group, 'api-docs-route'), function() use ($self, $group) {
    if ($self->getSettings($group, 'generateAlways')) {
        $appDir = base_path()."/".$self->getSettings($group, 'app-dir');
        $docDir = $self->getSettings($group, 'doc-dir');

        if (!File::exists($docDir) || is_writable($docDir)) {
            // delete all existing documentation
            if (File::exists($docDir)) {
                File::deleteDirectory($docDir);
            }

            File::makeDirectory($docDir);

            $basepath       = "";
            $apiVersion     = "";
            $swaggerVersion = "";
            $excludes       = "";

            $defaultBasePath = $self->getSettings($group, 'default-base-path');
            if ( ! empty($defaultBasePath)) {
                $basepath .= " --default-base-path '{$defaultBasePath}'";
            }

            $defaultApiVersion = $self->getSettings($group, 'default-api-version');
            if ( ! empty($defaultApiVersion)) {
               $apiVersion = " --default-api-version '{$defaultApiVersion}'";
            }

            $defaultSwaggerVersion = $self->getSettings($group, 'default-swagger-version');
            if ( ! empty($defaultSwaggerVersion)) {
               $swaggerVersion = " --default-swagger-version '{$defaultSwaggerVersion}'";
            }

            $exludeDirs = $self->getSettings($group, 'excludes');
            if (is_array($exludeDirs) && ! empty($exludeDirs)){
                $excludes = " -e " . implode(":", $exludeDirs);
            }

            $cmd = "php " . base_path() . "/vendor/zircote/swagger-php/swagger.phar $appDir -o {$docDir} {$apiVersion} {$swaggerVersion} {$basepath} {$excludes}";

            $result = shell_exec($cmd);

            //display all swagger-php error messages so that it doesn't fail silently
            if ((strpos($result, "[INFO]") != FALSE) || (strpos($result, "[WARN]") != FALSE) || (strpos($result, "[ERROR]") != FALSE)) {
                throw new \Exception($result);
            }
        }
    }

    if ($self->getSettings($group, 'behind-reverse-proxy')) {
        $proxy = Request::server('REMOTE_ADDR');
        Request::setTrustedProxies(array($proxy));
    }

    Blade::setEscapedContentTags('{{{', '}}}');
    Blade::setContentTags('{{', '}}');

    //need the / at the end to avoid CORS errors on Homestead systems.
    $response = Response::make(
        View::make('swaggervel::index', array(
            'secure'         => Request::secure(),
            'urlToDocs'      => url($self->getSettings($group, 'doc-route')),
            'requestHeaders' => $self->getSettings($group, 'requestHeaders'),
            'apiKey'         => $self->getSettings($group, 'api-key'),
            )
        ),
        200
    );

    if ($self->getSettings($group, 'viewHeaders')) {
        foreach ($self->getSettings($group, 'viewHeaders') as $key => $value) {
            $response->header($key, $value);
        }
    }

    return $response;
});
