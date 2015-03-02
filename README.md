# mrcore-modules-auth
Mrcore Auth Module


# Events

This auth module fires these events:

* auth.attemp fires during an attempt, before login success or fail
* auth.login fires on successful login
* auth.logout fires on logout
* auth.reset fires on password reset

Becuase auth.attempt fires before actual login, this is the best place to
intercept the request before it is attempted.  If you cannot override
the auth system from these events, then just make your own Auth module
and use that one instead of Mrcore\Modules\Auth.
