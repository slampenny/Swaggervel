<?php namespace Jlapp\Swaggervel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Installer extends Command {

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
        $this->info("pushing config files to public");
        $this->call(
            'config:publish',
            array('package', 'jlapp/swaggervel')
        );
        $this->info("Pushing swagger-ui assets to public folder");
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
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
