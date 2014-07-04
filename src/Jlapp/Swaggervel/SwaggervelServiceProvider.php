<?php namespace Jlapp\Swaggervel;

use Illuminate\Support\ServiceProvider;
use Jlapp\Swaggervel\SwaggervelInstallCommand;

use Config;

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
	public function boot()
	{
		$this->package('jlapp/swaggervel');

        require __DIR__ .'/routes.php';

        $this->app->bind('swaggervel::install', function($app) {
            return new SwaggervelInstallCommand();
        });
        $this->commands(array(
            'swaggervel::install'
        ));

        if (Config::get('app.debug')) {
            $appdir = base_path().Config::get('swaggervel::app.app-dir');
            $docdir = base_path().Config::get('swaggervel::app.doc-dir');
            exec("php ".base_path()."/vendor/zircote/swagger-php/swagger.phar ".$appdir." -o ".$docdir);
        }
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
