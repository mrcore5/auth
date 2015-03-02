<?php namespace Mrcore\Modules\Auth\Http\Controllers;

use Input;
use Event;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
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

	#use AuthenticatesAndRegistersUsers; #no becuase I don't want to register

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('auth.login');
	}	

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		// Validate Input and redirect if Invalidated
		$this->validate($request, [
			'email' => 'required', 'password' => 'required',
		]);

		// Pull only email/password from input
		$credentials = $request->only('email', 'password');

		// Login using alias if not full email
		$userField = (str_contains($credentials['email'], "@")) ? 'email' : 'alias';

		if ($this->auth->attempt([$userField => $credentials['email'], 'password' => $credentials['password'], 'disabled' => false], $request->has('remember')))
		{
			// Laravels auth.attempt event fired on every attempt
			// Laravels auth.login event fired on successful login

			// Redirect to intended url or home page if not found
			// Never could get laravels redirect()->intended() to work so I manage manually
			return redirect((Input::get('referer') ?: route('home')));
		}

		// Invalid login, redirect with error message
		return redirect('/auth/login')
			->withInput($request->only('email'))
			->withErrors(['email' => 'These credentials do not match our records.']);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		// Log user out
		$this->auth->logout();

		// Laravels auth.logout event fired here

		return redirect('/');
	}	
}
