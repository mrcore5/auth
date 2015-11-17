<?php namespace Mrcore\Auth\Providers;

use Gate;
use Event;
use Layout;
use Module;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Kernel $kernel, Router $router)
	{
		// Mrcore Module Tracking
		Module::trace(get_class(), __function__);

		// Register publishers
		$this->registerPublishers();

		// Register Policies
		$this->registerPolicies();

		// Register global and route based middleware
		$this->registerMiddleware($kernel, $router);

		// Register event listeners and subscriptions
		$this->registerListeners();

		// Register mrcore layout overrides
		$this->registerLayout();
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

		// Register facades
		#class_alias('Mrcore\Appstub\Facades\Appstub', 'Appstub');

		// Register configs
		$this->registerConfigs();

		// Register IoC bind aliases
		// Laravel has auth.attemp, auth.login, auth.logout.  Added auth.reset
		$this->app->alias(Mrcore\Auth\Events\PasswordReset::class, 'auth.reset');

		// Register other service providers
		#$this->app->register(Mrcore\Appstub\Providers\OtherServiceProvider::class);

		// Register artisan commands
		$this->registerCommands();

		// Register testing environment
		$this->registerTestingEnvironment();
	}

	/**
	 * Define the published resources and configs.
	 *
	 * @return void
	 */
	protected function registerPublishers()
	{
		if (!$this->app->runningInConsole()) return;
		/*
		// Register additional css assets with mrcore Layout
		Layout::css('css/wiki-bundle.css');

		// App base path
		$path = realpath(__DIR__.'/../');

		// Config publishing rules
		// ./artisan vendor:publish --tag="mrcore.appstub.configs"
		$this->publishes([
			"$path/Config" => base_path('/config/mrcore'),
		], 'mrcore.appstub.configs');

		// Migration publishing rules
		// ./artisan vendor:publish --tag="mrcore.appstub.migrations"
		$this->publishes([
			"$path/Database/Migrations" => base_path('/database/migrations'),
		], 'mrcore.appstub.migrations');

		// Seed publishing rules
		// ./artisan vendor:publish --tag="mrcore.appstub.seeds"
		$this->publishes([
			"$path/Database/Seeds" => base_path('/database/seeds'),
		], 'mrcore.appstub.seeds');
		*/
	}

	/**
	 * Register permission policies.
	 *
	 * @return void
	 */
	public function registerPolicies()
	{
		// Define permissions (closure or Class@method)
		#Gate::define('update-post', function($user, $post) {
		#	return $user->id === $post->user_id;
		#});

		#Gate::before(function ($user, $ability) {
		#	if ($user->isSuperAdmin()) {
		#		return true;
		#	}
		#});
		# ->after() is also available

		// Or define an entire policy class
		#Gate::policy(App\Post::class, App\Policies\PostPolicy::class);
	}

	/**
	 * Register global and route based middleware.
	 *
	 * @param Illuminate\Contracts\Http\Kernel $kernel
	 * @param \Illuminate\Routing\Router $router
	 * @return  void
	 */
	protected function registerMiddleware(Kernel $kernel, Router $router)
	{
		// Register global middleware
		#$kernel->pushMiddleware('Mrcore\Appstub\Http\Middleware\DoSomething');

		// Register route based middleware
		#$router->middleware('auth.appstub', 'Mrcore\Appstub\Http\Middleware\Authenticate');
	}

	/**
	 * Register event listeners and subscriptions.
	 *
	 * @return void
	 */
	protected function registerListeners()
	{
		// Login event listener
		#Event::listen('auth.login', function($user) {
			//
		#});

		// Logout event subscriber
		#Event::subscribe('Mrcore\Appstub\Listeners\MyEventSubscription');
	}

	/**
	 * Register mrcore layout overrides.
	 *
	 * @return void
	 */
	protected function registerLayout()
	{
		if ($this->app->runningInConsole()) return;

		// Register additional css assets with mrcore Layout
		#Layout::css('css/wiki-bundle.css');
	}

	/**
	 * Register additional configs and merges.
	 *
	 * @return void
	 */
	protected function registerConfigs()
	{
		// Append or overwrite configs
		#config(['test' => 'hi']);

		// Merge configs
		#$this->mergeConfigFrom(__DIR__.'/../Config/appstub.php', 'mrcore.appstub');
	}

	/**
	 * Register artisan commands.
	 * @return void
	 */
	protected function registerCommands()
	{
		if (!$this->app->runningInConsole()) return;
		$this->commands([
			\Mrcore\Auth\Console\Commands\AppCommand::class
		]);
	}

	/**
	 * Register test environment overrides
	 *
	 * @return void
	 */
	public function registerTestingEnvironment()
	{
		// Register testing environment
		if ($this->app->environment('testing')) {
			//
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		// Only required if $defer = true and you add bindings
		//return ['Mrcore\Appstub\Stuff', 'other bindings...'];
	}

}
