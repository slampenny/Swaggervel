<?php namespace Jlapp\Swaggervel;

use Illuminate\Support\ServiceProvider;
use Jlapp\Swaggervel\Installer;

use File;
use Config;

class SwaggervelServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('jlapp/swaggervel');

        $this->commands(array('Jlapp\Swaggervel\InstallerCommand'));

        $configPath = app_path() . "/config/packages/jlapp/swaggervel";
        Config::addNamespace('swaggervel', $configPath);

        $configFiles = File::glob($configPath . "/*.php");
        foreach ($configFiles as $file) {
            $configName = pathinfo($file, PATHINFO_FILENAME);

            require_once __DIR__ .'/routes.php';
        }
    }
}
