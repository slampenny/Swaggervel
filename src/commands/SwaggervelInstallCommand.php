SwaggervelServiceProvider.php<?php
/**
 * Created by PhpStorm.
 * User: Jordan
 * Date: 04/07/14
 * Time: 4:24 PM
 */

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SwaggervelInstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'swaggervel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pushes views to public folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->call(
            'config:publish',
            array('jlapp/swaggervel')
        );
        $this->call(
            'asset:publish',
            array('jlapp/swaggervel')
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
    }
}