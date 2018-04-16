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
        'psr4' => '',
        'assets' => null,
        'public' => null,
        'config' => 'Config',
        'database' => 'Database',
        'migrations' => 'Database/Migrations',
        'factories' => 'Database/Factories',
        'seeds' => 'Database/Seeds',
        'tests' => null,
        'routes' => 'Http/routes.php',
        'route_prefix' => null,
        'views' => 'Views',
        'view_prefix' => null,
    ],

];
