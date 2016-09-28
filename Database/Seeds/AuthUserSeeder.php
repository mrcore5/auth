<?php namespace Mrcore\Auth\Database\Seeds;

use DB;
use Hash;
use Mreschke\Helpers\Str;
use Mrcore\Auth\Models\User;
use Illuminate\Database\Seeder;

class AuthUserSeeder extends Seeder
{
    public function run()
    {
        #DB::table('users')->delete();
        #DB::table('user_roles')->delete();

        // 1 Anonymous User
        User::create(array(
            'uuid' => Str::getGuid(),
            'email' => 'anonymous@anonymous.com',
            'password' => Hash::make(md5(microtime())),
            'first' => 'Anonymous',
            'last' => 'Anonymous',
            'alias' => 'anonymous',
            'avatar' => 'avatar_user1.png',
            'login_at' => '1900-01-01 00:00:00',
            'global_post_id' => null,
            'home_post_id' => null,
            'disabled' => true,
            'created_by' => 1,
            'updated_by' => 1
        ));

        // 2 Admin
        User::create(array(
            'uuid' => Str::getGuid(),
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'first' => 'Admin',
            'last' => 'Istrator',
            'alias' => 'admin',
            'avatar' => 'avatar_user2.png',
            'login_at' => '1900-01-01 00:00:00',
            'global_post_id' => 4,
            'home_post_id' => 3,
            'disabled' => false,
            'created_by' => 1,
            'updated_by' => 1
        ));
    }
}
