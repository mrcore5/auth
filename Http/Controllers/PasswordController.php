<?php namespace Mrcore\Auth\Http\Controllers;

use Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			// Set new password
			$user->password = bcrypt($password);
			$user->save();

			// Fire auth.reset Event
			Event::fire('auth.reset', [['email' => $user->email, 'password' => $password]]);

			// Log the user in
			# No, because this does not fire all the regular login events like auth.attempt...
			# So just ignore, and it will redirect back to main / page and not login, they can login manually
			#$this->auth->login($user);
		});

		switch ($response) {
			case Password::PASSWORD_RESET:
				return redirect($this->redirectPath())->with('status', trans($response));

			default:
				return redirect()->back()
					->withInput($request->only('email'))
					->withErrors(['email' => trans($response)]);
		}
	}
}
