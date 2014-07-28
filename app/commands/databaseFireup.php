<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class databaseFireup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:fireup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Runs all the needed migrations and seeds';

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
		//
        $this->info("\nMigrating default...\n");
        $this->call('migrate:refresh');
        $this->info("\nMigrating packages...\n");
        $this->call('migrate', array('--package' => 'lucadegasperi/oauth2-server-laravel'));
        $this->info("\nSeeding...\n");
        $this->call('db:seed');
        $this->info("\nDone!\n");
	}



}
