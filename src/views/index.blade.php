<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Swagger UI</title>
        <link rel="icon" type="image/png" href="{{ url('/vendor/swaggervel/images/favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ url('/vendor/swaggervel/images/favicon-16x16.png') }}" sizes="16x16" />
        <link href='{{ url('/vendor/swaggervel/css/typography.css') }}' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ url('/vendor/swaggervel/css/reset.css') }}' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ url('/vendor/swaggervel/css/screen.css') }}' media='screen' rel='stylesheet' type='text/css'/>
        <link href='{{ url('/vendor/swaggervel/css/reset.css') }}' media='print' rel='stylesheet' type='text/css'/>
        <link href='{{ url('/vendor/swaggervel/css/print.css') }}' media='print' rel='stylesheet' type='text/css'/>
        <script src='{{ url('/vendor/swaggervel/lib/jquery-1.8.0.min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/jquery.slideto.min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/jquery.wiggle.min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/jquery.ba-bbq.min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/handlebars-2.0.0.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/underscore-min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/backbone-min.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/swagger-ui.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/highlight.7.3.pack.js') }}' type='text/javascript'></script>
        <script src='{{ url('/vendor/swaggervel/lib/marked.js') }}' type='text/javascript'></script>

        <script src='{{ url('/vendor/swaggervel/lib/swagger-oauth.js') }}' type='text/javascript'></script>

        <!-- Some basic translations -->
        <!-- <script src='lang/translator.js' type='text/javascript'></script> -->
        <!-- <script src='lang/ru.js' type='text/javascript'></script> -->
        <!-- <script src='lang/en.js' type='text/javascript'></script> -->

        <script type="text/javascript">

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }

            $(function () {
                var url = window.location.search.match(/url=([^&]+)/);
                        if (url && url.length > 1) {
                    url = decodeURIComponent(url[1]);
                } else {
                    url = "{!! $urlToDocs !!}";
                }

                // Pre load translate...
                if (window.SwaggerTranslator) {
                    window.SwaggerTranslator.translate();
                }
                window.swaggerUi = new SwaggerUi({
                    url: url,
                    dom_id: "swagger-ui-container",
                    supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                    onComplete: function (swaggerApi, swaggerUi) {

                        log("Loaded SwaggerUI");
                        @if (isset($requestHeaders))
                        @foreach($requestHeaders as $requestKey => $requestValue)
                        window.authorizations.add("{!!$requestKey!!}", new ApiKeyAuthorization("{!!$requestKey!!}", "{!!$requestValue!!}", "header"));
                        @endforeach
                        @endif

                        if (typeof initOAuth == "function") {
                            initOAuth({
                                clientId: "{!! $clientId !!}"||"my-client-id",
                                clientSecret: "{!! $clientSecret !!}"||"_",
                                realm: "{!! $realm !!}"||"_",
                                appName: "{!! $appName !!}"||"_",
                                scopeSeparator: ","
                            });

                            window.oAuthRedirectUrl = "{{ url('vendor/swaggervel/o2c.html') }}";
                            $('#clientId').html("{!! $clientId !!}"||"my-client-id");
                            $('#redirectUrl').html(window.oAuthRedirectUrl);
                        }

                        if (window.SwaggerTranslator) {
                            window.SwaggerTranslator.translate();
                        }

                        $('pre code').each(function (i, e) {
                            hljs.highlightBlock(e)
                        });

                        addApiKeyAuthorization();
                    },
                    onFailure: function (data) {
                        log("Unable to Load SwaggerUI");
                    },
                    docExpansion: "none",
                    apisSorter: "alpha",
                    showRequestHeaders: false
                });

                function addApiKeyAuthorization() {
                    var key = encodeURIComponent($('#input_apiKey')[0].value);
                    if (key && key.trim() != "") {
                        var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("api_key", key, "query");
                        window.swaggerUi.api.clientAuthorizations.add("api_key", apiKeyAuth);
                        log("added key " + key);
                    }
                }

                $('#input_apiKey').change(addApiKeyAuthorization);

                $('#init-oauth').click(function(){
                    if (typeof initOAuth == "function") {
                            initOAuth({
                                clientId: $('#input_clientId').val()||"my-client-id",
                                clientSecret: $('#input_clientSecret').val()||"_",
                                realm: $('#input_realm').val()||"_",
                                appName: $('#input_appName').val()||"_",
                                scopeSeparator: ","
                            });
                        }
                });

                window.swaggerUi.load();

            });
        </script>
    </head>

    <body class="swagger-section">
        <div id='header'>
            <div class="swagger-ui-wrap">
                <a id="logo" href="http://swagger.io">swagger</a>
                <form id='api_selector'>
                    <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
                    <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
                    <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
                </form>
            </div>
        </div>

        <div id="oauth2-settings" class="swagger-ui-wrap">
            <h2>OAuth2 settings</h2>
            <input placeholder="Client Id" id="input_clientId" name="clientId" type="text" value="{!! $clientId !!}"/>
            <input placeholder="Client Secret" id="input_clientSecret" name="clientSecret" type="text" value="{!! $clientSecret !!}"/>
            <input placeholder="Realm" id="input_realm" name="realm" type="text" value="{!! $realm !!}"/>
            <input placeholder="App Name" id="input_appName" name="appName" type="text" value="{!! $appName !!}"/>
            <button id="init-oauth" href="#" data-sw-translate value="">Init OAuth</button>
            <br/>
            <span class="note">Configure OAuth2 Client with id="<span id="clientId"></span>" and redirect url="<span id="redirectUrl"></span>"</span>
        </div>

        <div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
        <div id="swagger-ui-container" class="swagger-ui-wrap"></div>
    </body>
</html>
