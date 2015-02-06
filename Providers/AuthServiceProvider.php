<?php namespace Mrcore\Modules\Auth\Providers;

use View;
use Illuminate\Routing\Router;
use Mrcore\Modules\Foundation\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{
		// Register additional views
		View::addLocation(__DIR__.'/../Views');

		// Register additional routes
		$router->group(['namespace' => 'Mrcore\Modules\Auth\Http\Controllers'], function($router) {
			require __DIR__.'/../Http/routes.php';
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//		
	}

}
