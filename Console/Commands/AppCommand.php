<?php namespace Mrcore\Auth\Console\Commands;

use Mrcore\Foundation\Console\Commands\AppCommand as Command;

/**
 * Mrcore app/module helper command
 * @copyright 2015 Matthew Reschke
 * @license http://mreschke.com/license/mit
 * @author Matthew Reschke <mail@mreschke.com>
 */
class AppCommand extends Command
{
	protected $signature = 'mrcore:auth:app';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->app = 'auth';
		$this->ns = 'Mrcore\Auth';
		$this->path = ['vendor/mrcore/auth', '../Modules/Auth'];
		$this->connection = 'mysql';
		$this->seeder = 'Mrcore\Auth\Database\Seeds\AuthSeeder';
		parent::__construct();
	}

}
