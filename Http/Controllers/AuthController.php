<?php namespace Mrcore\Auth\Http\Controllers;

use Event;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();

		if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->getCredentials($request);

		// Login using alias if not full email
		$userField = (str_contains($credentials['email'], "@")) ? 'email' : 'alias';

		if ($this->auth->attempt([$userField => $credentials['email'], 'password' => $credentials['password'], 'disabled' => false], $request->has('remember')))
		{
			return $this->handleUserWasAuthenticated($request, $throttles);

			/*if ($throttles) {
				$this->clearLoginAttempts($request);
			}

			if (method_exists($this, 'authenticated')) {
				return $this->authenticated($request, Auth::guard($this->getGuard())->user());
			}

			// Redirect to intended url or home page if not found
			// Never could get laravels redirect()->intended() to work so I manage manually
			#return redirect()->intended($this->redirectPath());
			return redirect(($request->input('referer') ?: route('home')));*/
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		if ($throttles && ! $lockedOut) {
			$this->incrementLoginAttempts($request);
		}

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();
		return redirect('/');
	}
}
