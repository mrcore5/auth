## Mrcore Auth Module

This is an mRcore module that provides auth functionality.

## What Is Mrcore

Mrcore is a set of Laravel and Lumen components used to build various systems.
It is a framework, a development platform and a CMS.  It is a modularized version of Laravel
providing better package development support.  Think of Laravel 4.x workbenches on steroids.

See https://github.com/mrcore5/framework for details and installation instructions.

## Official Documentation

For this wiki module, well, there is not much.  See also https://github.com/mreschke/mrcore5

### Events

This auth module fires these events:

* auth.attemp fires during an attempt, before login success or fail
* auth.login fires on successful login
* auth.logout fires on logout
* auth.reset fires on password reset

Because auth.attempt fires before actual login, this is the best place to
intercept the request before it is attempted.  If you cannot override
the auth system from these events, then just make your own Auth module
and use that one instead of Mrcore\Auth.

## Contributing

Thank you for considering contributing to the mRcore framework!  Fork and pull!

### License

Mrcore is open-sourced software licensed under the [MIT license](http://mreschke.com/license/mit)
