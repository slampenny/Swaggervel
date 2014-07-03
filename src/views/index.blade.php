@extends('layout')
@section('header')

{{ HTML::style('https://fonts.googleapis.com/css?family=Droid+Sans:400,700'); }}
{{ HTML::style('css/reset.css', array('media' => 'screen')); }}
{{ HTML::style('css/reset.css', array('media' => 'print')); }}
{{ HTML::style('css/screen.css', array('media' => 'screen')); }}
{{ HTML::style('css/screen.css', array('media' => 'print')); }}

{{ HTML::script('lib/shred.bundle.js'); }}
{{ HTML::script('lib/jquery-1.8.0.min.js'); }}
{{ HTML::script('lib/jquery.slideto.min.js'); }}
{{ HTML::script('lib/jquery.wiggle.min.js'); }}
{{ HTML::script('lib/jquery.ba-bbq.min.js'); }}
{{ HTML::script('lib/handlebars-1.0.0.js'); }}
{{ HTML::script('lib/underscore-min.js'); }}
{{ HTML::script('lib/backbone-min.js'); }}
{{ HTML::script('lib/swagger.js'); }}
{{ HTML::script('swagger-ui.js'); }}
{{ HTML::script('lib/highlight.7.3.pack.js'); }}

<!-- enabling this will enable oauth2 implicit scope support -->
{{ HTML::script('lib/swagger-oauth.js'); }}

<script type="text/javascript">
    $(function () {
        window.swaggerUi = new SwaggerUi({
            url: "http://nls.app:8000/docs",
            dom_id: "swagger-ui-container",
            supportedSubmitMethods: ['get', 'post', 'put', 'delete'],
            onComplete: function(swaggerApi, swaggerUi){
                log("Loaded SwaggerUI");

                if(typeof initOAuth == "function") {
                    /*
                     initOAuth({
                     clientId: "your-client-id",
                     realm: "your-realms",
                     appName: "your-app-name"
                     });
                     */
                }
                $('pre code').each(function(i, e) {
                    hljs.highlightBlock(e)
                });
            },
            onFailure: function(data) {
                log("Unable to Load SwaggerUI");
            },
            docExpansion: "none"
        });

        $('#input_apiKey').change(function() {
            var key = $('#input_apiKey')[0].value;
            log("key: " + key);
            if(key && key.trim() != "") {
                log("added key " + key);
                window.authorizations.add("key", new ApiKeyAuthorization("api_key", key, "query"));
            }
        })
        window.swaggerUi.load();
    });
</script>
@stop

@section('content')
<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.wordnik.com">swagger</a>
        <form id='api_selector'>
            <div class='input icon-btn'>
                {{ HTML::image('images/pet_store_api.png', "", array('id' => 'show-pet-store-icon', 'title' => 'Show Swagger Petstore Example Apis')); }}
            </div>
            <div class='input icon-btn'>
                {{ HTML::image('images/wordnik_api.png', "", array('id' => 'show-wordnik-dev-icon', 'title' => 'Show Wordnik Developer Apis')); }}
            </div>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
            <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
            <div class='input'><a id="explore" href="#">Explore</a></div>
        </form>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap">&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
@stop