<?php

/**
 * Mrcore App Configuration File
 *
 * All configs use env() so you can override in your own .env
 * You can also publish the entire configuration with
 * ./artisan vendor:publish --tag="mrcore.auth.configs"
 * This config is merged, meaning it handles partial overrides
 * Access with config('mrcore.auth.test')
 */
// Return this modules config
return [

    #'test' => env('ONEOFYOUR_ENV_VARS', 'this is a test'),

    // These app paths for module and console command usage
    'paths' => [
        'psr4' => 'src',
        'assets' => null,
        'public' => null,
        'config' => 'config',
        'database' => 'database',
        'migrations' => 'database/migrations',
        'factories' => 'database/factories',
        'seeds' => 'database/seeds',
        'tests' => null,
        'routes' => 'routes/web.php',
        'route_prefix' => null,
        'views' => 'resources/views',
        'view_prefix' => null,
    ],

];
