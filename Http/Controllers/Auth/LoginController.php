<?php namespace Mrcore\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Mrcore\Auth\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		// mReschke override from /Users/mreschke/Code/mrcore5/System/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
		// To allow no @. If no @ use users.alias column, else use email column
		
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->credentials($request);

		// Login using alias if not full email
		$userField = (str_contains($credentials['email'], "@")) ? 'email' : 'alias';

		//if ($this->guard()->attempt($credentials, $request->has('remember'))) {
		// This ->attempt fires Illuminate\Auth\Events\Attempting event
		if ($this->guard()->attempt([$userField => $credentials['email'], 'password' => $credentials['password'], 'disabled' => false], $request->has('remember'))) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		if (! $lockedOut) {
			$this->incrementLoginAttempts($request);
		}

		return $this->sendFailedLoginResponse($request);
	}

}
