<?php namespace Mrcore\Auth\Database\Seeds;

use App;
use Illuminate\Database\Seeder;
use Mrcore\Auth\Database\Seeds;
use Illuminate\Database\Eloquent\Model;

class AuthSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Production saftey
		if (app()->environment('production')) {
			exit('You cannot run the seeder in production');
		}

		// Allow mass assignment
		Model::unguard();

		// Order is critical
		$this->call(Seeds\AuthPermissionSeeder::class);
		$this->call(Seeds\AuthUserSeeder::class);
	}

}
