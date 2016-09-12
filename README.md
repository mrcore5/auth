## Mrcore Auth Module v2.0

This is an mRcore module that provides auth functionality.

## What Is Mrcore

Mrcore is a set of Laravel components used to build various systems.
It is a framework, a development platform and a CMS.  It is a modularized version of Laravel
providing better package development support.  Think of Laravel 4.x workbenches on steroids.

See https://github.com/mrcore5/framework for details and installation instructions.

## Official Documentation

For this wiki module, well, there is not much.  See also https://github.com/mcore5/framework

### Events

This auth module fires regular laravel events found here https://laravel.com/docs/5.2/authentication#events

Because `attempting` fires before actual login, this is the best place to
intercept the request before it is attempted.  If you cannot override
the auth system from these events, then just make your own Auth module
and use that one instead of Mrcore\Auth.

## Versions

* 1.0 is for Laravel 5.1 and below
* 2.0 is for Laravel 5.3 and above

## Contributing

Thank you for considering contributing to the mRcore framework!  Fork and pull!

### License

Mrcore is open-sourced software licensed under the [MIT license](http://mreschke.com/license/mit)
