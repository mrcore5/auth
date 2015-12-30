<?php namespace Mrcore\Auth\Database\Seeds;

use DB;
use Hash;
use Mrcore\Wiki\Models\User;
use Mreschke\Helpers\Str;
use Illuminate\Database\Seeder;
use Mrcore\Wiki\Models\UserRole;
use Mrcore\Wiki\Models\UserPermission;

class AuthUserSeeder extends Seeder
{

	public function run()
	{
		#DB::table('users')->delete();
		#DB::table('user_roles')->delete();

		// 1 Anonymous User
		User::create(array(
			'uuid'     => Str::getGuid(),
			'email'    => 'anonymous@anonymous.com',
			'password' => Hash::make(md5(microtime())),
			'first'    => 'Anonymous',
			'last'     => 'Anonymous',
			'alias'    => 'anonymous',
			'avatar'   => 'avatar_user1.png',
			'global_post_id' => null,
			'home_post_id'   => null,
			'login_at'  => '1900-01-01 00:00:00',
			'disabled'       => true
		));
		UserRole::create(array('user_id' => 1, 'role_id' => 1)); #public
		UserPermission::create(array('user_id' => 1, 'permission_id' => 3)); # comment

		// 2 Admin
		User::create(array(
			'uuid'     => Str::getGuid(),
			'email'    => 'mail@mreschke.com',
			'password' => Hash::make('password'),
			'first'    => 'Admin',
			'last'     => 'Istrator',
			'alias'    => 'admin',
			'avatar'   => 'avatar_user2.png',
			'global_post_id' => 4,
			'home_post_id'   => 3,
			'login_at'  => '1900-01-01 00:00:00',
			'disabled'       => false
		));
		UserRole::create(array('user_id' => 2, 'role_id' => 1)); #public
		UserRole::create(array('user_id' => 2, 'role_id' => 2)); #user
		UserPermission::create(array('user_id' => 2, 'permission_id' => 4)); # admin

	}

}
