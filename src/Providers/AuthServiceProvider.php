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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Mrcore Module Tracking
        Module::trace(get_class(), __function__);

        // Register facades and class aliases
        #$this->registerFacades();

        // Register configs
        $this->registerConfigs();

        // Register services
        $this->registerServices();

        // Register testing environment
        #$this->registerTestingEnvironment();

        // Register mrcore modules
        #$this->registerModules();
    }

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
        #$this->registerPublishers();

        // Register migrations
        $this->registerMigrations();

        // Register Policies
        #$this->registerPolicies();

        // Register global and route based middleware
        #$this->registerMiddleware($kernel, $router);

        // Register event listeners and subscriptions
        #$this->registerListeners();

        // Register scheduled tasks
        #$this->registerSchedules();

        // Register mrcore layout overrides
        #$this->registerLayout();

        // Override laravels notification views that were at:
        // vendor/laravel/framework/src/Illuminate/Notifications/resources/views
        // Used by vendor/laravel/framework/src/Illuminate/Notifications/Messages/MailMessage.php
        ###$this->loadViewsFrom(__DIR__.'/../Views/notifications', 'notifications');

        // Register artisan commands
        $this->registerCommands();
    }

    /**
     * Register facades and class aliases.
     *
     * @return void
     */
    protected function registerFacades()
    {
        #$facade = AliasLoader::getInstance();
        #$facade->alias('Appstub', \Mrcore\Appstub\Facades\Appstub::class);
        #class_alias('Some\Long\Class', 'Short');
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
        $this->mergeConfigFrom(__DIR__.'/../../config/auth.php', 'mrcore.auth');
    }

    /**
     * Register the application and other services.
     *
     * @return void
     */
    protected function registerServices()
    {
        // Register IoC bind aliases and singletons

        // Laravel has auth.attemp, auth.login, auth.logout.  Added auth.reset
        $this->app->alias(Mrcore\Auth\Events\PasswordReset::class, 'auth.reset');

        #$this->app->alias(\Mrcore\Appstub\Appstub::class, \Mrcore\Appstub::class)
        #$this->app->singleton(\Mrcore\Appstub\Appstub::class, \Mrcore\Appstub::class)

        // Register other service providers
        #$this->app->register(\Mrcore\Appstub\Providers\OtherServiceProvider::class);
    }

    /**
     * Register test environment overrides
     *
     * @return void
     */
    public function registerTestingEnvironment()
    {
        // Does not apply if NOT running in 'testing' mode
        if (!$this->app->environment('testing')) return;
    }

    /**
     * Register mrcore modules
     *
     * @return void
     */
    public function registerModules()
    {
        // Register mrcore modules
        #Module::register('Mrcore\Other', true);
        #Module::loadViews('Mrcore\Other'); // If you need to use this modules view::
    }

    /**
     * Define the published resources and configs.
     *
     * @return void
     */
    protected function registerPublishers()
    {
        // Only applies if running in console
        if (!$this->app->runningInConsole()) return;

        /*
        // App base path
        $path = realpath(__DIR__.'/../../');

        // Config publishing rules
        // ./artisan vendor:publish --tag="mrcore.auth.configs"
        $this->publishes([
            "$path/config" => base_path('/config/mrcore'),
        ], 'mrcore.auth.configs');

        // Migration publishing rules
        // ./artisan vendor:publish --tag="mrcore.auth.migrations"
        $this->publishes([
            "$path/database/migrations" => base_path('/database/migrations'),
        ], 'mrcore.auth.migrations');

        // Seed publishing rules
        // ./artisan vendor:publish --tag="mrcore.auth.seeds"
        $this->publishes([
            "$path/database/seeds" => base_path('/database/seeds'),
        ], 'mrcore.auth.seeds');
        */
    }

    /**
     * Register the migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        // Only applies if running in console
        if (!$this->app->runningInConsole()) return;

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
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
        #    return $user->id === $post->user_id;
        #});

        #Gate::before(function ($user, $ability) {
        #    if ($user->isSuperAdmin()) {
        #        return true;
        #    }
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
        // Does not apply if running in console
        if ($this->app->runningInConsole()) return;

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
     * Register the scheduled tasks
     *
     * @return void
     */
    protected function registerSchedules()
    {
        // Only applies if running in console
        if (!$this->app->runningInConsole()) return;

        // Register all task schedules for this hostname ONLY if running from the schedule:run command
        /*if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'schedule:run') {

            // Defer until after all providers booted, or the scheduler instance is removed from Illuminate\Foundation\Console\Kernel defineConsoleSchedule()
            $this->app->booted(function() {

                // Get the scheduler instance
                $schedule = app('Illuminate\Console\Scheduling\Schedule');

                // Define our schedules
                $schedule->call(function() {
                    echo "hi";
                })->everyMinute();

            });
        }*/
    }

    /**
     * Register mrcore layout overrides.
     *
     * @return void
     */
    protected function registerLayout()
    {
        // Does not apply if running in console
        if ($this->app->runningInConsole()) return;

        // Register additional css assets with mrcore Layout
        #Layout::css('css/wiki-bundle.css');

        // Share data wiht all views
        #View::share('key', 'value');
    }

    /**
     * Register artisan commands.
     * @return void
     */
    protected function registerCommands()
    {
         // Only applies if running in console
         if (!$this->app->runningInConsole()) return;

        // Register Commands
        $this->commands([
            \Mrcore\Auth\Console\Commands\AppCommand::class
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // Only required if $defer = true and you add bindings in register()
        // Only use if the provier is super simple and basically only has a simle binding
        //return ['Mrcore\Auth\Stuff', 'other bindings...'];
    }
}
