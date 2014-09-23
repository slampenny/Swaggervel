<?php namespace Jlapp\Swaggervel;

use Illuminate\Support\ServiceProvider;
use Jlapp\Swaggervel\Installer;

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

        require_once __DIR__ .'/routes.php';
    }

}
