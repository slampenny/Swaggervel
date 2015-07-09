<?php namespace Jlapp\Swaggervel;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SwaggervelServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__.'/../../config/swaggervel.php' => config_path('swaggervel.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../../public' => public_path('vendor/swaggervel'),
        ], 'public');


        $this->loadViewsFrom(__DIR__.'/../../views', 'swaggervel');

        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/swaggervel'),
        ]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/swaggervel.php', 'swaggervel'
        );

        foreach($this->getMultiKeys() as $configName) {
            if (Config::get("$configName.active")) {
                require __DIR__ .'/routes.php';
            }
        }
    }


    /**
     * Get additional configs
     *
     * @return array
     */
    public function getMultiKeys()
    {
        $result = ['swaggervel'];

        $additional = Config::get('swaggervel.additional');
        if ($additional) {
            is_array($additional) || ($additional = (array) $additional);

            $this->mergeConfigFrom(
                __DIR__.'/../../config/swaggervel.php', 'swagger.admin'
            );

            foreach ($additional as $key) {
                $this->mergeConfigFrom(
                    __DIR__.'/../../config/swaggervel.php', $key
                );

                $result[] = $key;
            }
        }

        return $result;
    }
}
