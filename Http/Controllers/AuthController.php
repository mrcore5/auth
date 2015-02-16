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

	use AuthenticatesAndRegistersUsers;

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
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{

		$this->validate($request, [
			'email' => 'required', 'password' => 'required',
		]);

		// Fire UserLogin Event
		Event::fire('Mrcore\Modules\Auth\Events\UserLogin');

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			// Fire UserLoggedIn Event
			Event::fire('Mrcore\Modules\Auth\Events\UserLoggedIn');

			// Redirect to intended url
			#return redirect()->intended($this->redirectPath());

			// Redirect to intended url or home page if not found
			// Never could get laravels redirect()->intended() to work so I manage manually
			return redirect((Input::get('referer') ?: route('home')));
		}

		return redirect('/auth/login')
			->withInput($request->only('email'))
			->withErrors([
				'email' => 'These credentials do not match our records.',
			]);



		// OLD mrcore5 auth stuff - keep for awhile, organize soon
		
		#$app = app();
		#$username = Input::get('email');
		#$password = Input::get('password');
		#if (Input::has('referer')) {
		#	$referer = Input::get('referer');
		#} else {
		#	$referer = route('home');
		#}

		#if (isset($app['login'])) {
			// Login override service provider exists, use it!
		#	$login = $app->make('login');
		#	return $login->validate($username, $password, $referer);

		#} else {
			// Default mrcore login
			#$userField = 'email';
			#if (strpos($username, '@') === false) {
			#	$userField = 'alias';
			#}

			#if ($this->auth->attempt(array($userField => $username, 'password' => $password, 'disabled' => false)))
			#{
				//Authentication Successful
				#Auth::user()->login();

				// Redirect to intended url or home page if not found
				#return Redirect::to($referer);

			#	return redirect()->intended($this->redirectPath());
			#} else {
				// Invalid Login
				#sleep(3);
				#return Redirect::route('login')
				#	->with('message', 'Invalid username/password')
				#	->with('referer', $referer);
			#}
		#}

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

		// Fire UserLoggedOut Event
		Event::fire('Mrcore\Modules\Auth\Events\UserLoggedOut');

		return redirect('/');
	}	
}
