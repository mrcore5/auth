## Mrcore Auth Module v5.7

`mrcore/auth` is a module for the [mRcore Framework](https://github.com/mrcore5/framework)

This module provides auth functionality.


## Installation

Assuming you already have a Laravel and [mRcore Framework](https://github.com/mrcore5/framework) installed
```bash
composer require mrcore/auth:5.7.*
```

Edit your `config/modules.php` file and ensure `'Mrcore\Auth' => [],` is set in your `modules` array
```php
'modules' => [
    #...
    'Mrcore\Auth' => []
    #...
]
```

And ensure `Mrcore\Auth` is set in all 3 `assets, views and routes` arrays under the "Loading Order / Override Management" section
```php
#...
'assets' => [
    '%app%',
    'Mrcore\BootswatchTheme',
    'Mrcore\Auth',
],

'views' => [
    '%app%',
    'Mrcore\BootswatchTheme',
    'Mrcore\Auth',
],

'routes' => [
    '%app%',
    'Mrcore\Auth',
    'Mrcore\Foundation',
],
#...
```



## What Is mRcore

mRcore is a module/package system for Laravel allowing you to build all your applications as reusable modules.
Modules resemble the Laravel folder structure and can be plugged into a single Laravel instance.
mRcore solves module loading dependency order and in-place live asset handling.  Modules can be
full web UIs, REST APIs and/or full Console command line apps.  A well built module is not only your
UI and API, but a shared PHP library, a native API or repository which can be reused as dependencies in other modules.

We firmly believe that all code should be built as modules and not in Laravel's directory structure itself.
Laravel simply becomes the "package server".  A single Laravel instance can host any number of modules.

See https://github.com/mrcore5/framework for details and installation instructions.


## Versions

* 1.0 is for Laravel 5.1 and below
* 2.0 is for Laravel 5.3, 5.4, 5.5
* 5.6 is for Laravel 5.6
* 5.7 is for Laravel 5.7
* ... Following Laravel versions from here on

## Contributing

Thank you for considering contributing to the mRcore framework!  Fork and pull!

### License

mRcore is open source software licensed under the [MIT license](http://mreschke.com/license/mit)
