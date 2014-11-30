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

        // add swaggervel_extra namespace
        $configPath = app_path() . "/config/packages/jlapp/swaggervel";
        Config::addNamespace('swaggervel_extra', $configPath);

        $configFiles = File::glob($configPath . "/*.php");
        $self = $this;
        foreach ($configFiles as $file) {
            $group = pathinfo($file, PATHINFO_FILENAME);
            require __DIR__ .'/routes.php';
        }
    }


    /**
     * Get configuration value
     *
     * @param string $group
     * @param string $key
     * @return $value
     */
    public function getSettings($group, $key)
    {
        return Config::get("swaggervel_extra::$group.$key", Config::get("swaggervel::$group.$key"));
    }
}
