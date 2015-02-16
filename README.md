# mrcore-modules-auth
Mrcore Auth Module


# Events

This auth module fires 3 events.

* Mrcore\Modules\Auth\Events\UserLogin fires just BEFORE the auth attempt
* Mrcore\Modules\Auth\Events\UserLoggedIn fires on successful login in
* Mrcore\Modules\Auth\Events\UserLoggedOut fires on successful logout

Becuase UserLogin fires before the auth attempt, this is the best place to
intercept the request before it is attempted.  If you cannot override
the auth system from these events, then just make your own Auth module
and use that one instead of Mrcore\Modules\Auth.
