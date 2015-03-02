<?php namespace Mrcore\Modules\Auth\Events;

use Mrcore\Modules\Auth\Events\Event;
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
