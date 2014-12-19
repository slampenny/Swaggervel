<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
?>
<html>
<head>
    {{ HTML::style('https://fonts.googleapis.com/css?family=Droid+Sans:400,700'); }}
    {{ HTML::style('packages/jlapp/swaggervel/css/reset.css', array('media' => 'screen'), $secure); }}
    {{ HTML::style('packages/jlapp/swaggervel/css/reset.css', array('media' => 'print'), $secure); }}
    {{ HTML::style('packages/jlapp/swaggervel/css/screen.css', array('media' => 'screen'), $secure); }}
    {{ HTML::style('packages/jlapp/swaggervel/css/screen.css', array('media' => 'print'), $secure); }}

    {{ HTML::script('packages/jlapp/swaggervel/lib/shred.bundle.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/jquery-1.8.0.min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/jquery.slideto.min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/jquery.wiggle.min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/jquery.ba-bbq.min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/handlebars-1.0.0.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/underscore-min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/backbone-min.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/swagger.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/swagger-ui.js', array(), $secure); }}
    {{ HTML::script('packages/jlapp/swaggervel/lib/highlight.7.3.pack.js', array(), $secure); }}

    <!-- enabling this will enable oauth2 implicit scope support -->
    {{--    {{ HTML::script('packages/jlapp/swaggervel/lib/swagger-oauth.js' , array(), $secure); }}--}}

    <script type="text/javascript">
        $(function () {
            window.swaggerUi = new SwaggerUi({
                url: "{{{ $urlToDocs }}}",
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete'],
                onComplete: function (swaggerApi, swaggerUi) {
                    log("Loaded SwaggerUI");
                    @if(isset($requestHeaders))
                    @foreach($requestHeaders as $requestKey => $requestValue)
                    window.authorizations.add("{{$requestKey}}", new ApiKeyAuthorization("{{$requestKey}}", "{{$requestValue}}", "header"));
                    @endforeach
                @endif
                if (typeof initOAuth == "function") {
                        /*
                         initOAuth({
                         clientId: "your-client-id",
                         realm: "your-realms",
                         appName: "your-app-name"
                         });
                         */
                    }
                    $('pre code').each(function (i, e) {
                        hljs.highlightBlock(e)
                    });
                },
                onFailure: function (data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none"
            });

            $('#input_apiKey').change(function () {
                var key = $('#input_apiKey')[0].value;
                log("key: " + key);
                if (key && key.trim() != "") {
                    log("added key " + key);
                    window.authorizations.add("key", new ApiKeyAuthorization("{{Config::get('swaggervel::app.api-key')}}", key, "query"));
                }
            })
            window.swaggerUi.load();
        });
    </script>
</head>
<body class="swagger-section">
<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.wordnik.com">swagger</a>

        <form id='api_selector'>
            <div class='input icon-btn'>
                {{ HTML::image('packages/jlapp/swaggervel/images/pet_store_api.png', "", array('id' => 'show-pet-store-icon', 'title' => 'Show Swagger Petstore Example Apis'), $secure); }}
            </div>
            <div class='input icon-btn'>
                {{ HTML::image('packages/jlapp/swaggervel/images/wordnik_api.png', "", array('id' => 'show-wordnik-dev-icon', 'title' => 'Show Wordnik Developer Apis'), $secure); }}
            </div>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl"
                                      type="text"/></div>
            <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
            <div class='input'><a id="explore" href="#">Explore</a></div>
        </form>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap">&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
</body>
</html>
