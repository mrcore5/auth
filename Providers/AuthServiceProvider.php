<?php namespace Mrcore\Modules\Auth\Providers;

use View;
use Module;
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
	public function boot()
	{
		// Mrcore Module Tracking
		Module::trace(get_class(), __function__);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// Mrcore Module Tracking
		Module::trace(get_class(), __function__);

		// Laravel has auth.attemp, auth.login, auth.logout.   I added auth.reset
		$this->app->bind('Mrcore\Modules\Auth\Events\PasswordReset', 'auth.reset');
	}

}
