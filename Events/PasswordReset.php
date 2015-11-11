<?php namespace Mrcore\Auth\Events;

use Mrcore\Auth\Events\Event;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

}
