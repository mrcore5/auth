<?php namespace Mrcore\Auth\Database\Seeds;

use DB;
use Hash;
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
            'uuid' => $this->getGuid(),
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
            'uuid' => $this->getGuid(),
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

    /**
     * Generate a new v4 36 (or 38 with brackets) char GUID.
     * Ex: 9778d799-b37b-7bfc-2685-47b3d28aa7af
     * @param bool $includeBrackets
     * @return string v4 character guid
     */
    protected function getGuid($includeBrackets = false)
    {
        if (function_exists('com_create_guid')) {
            //If on a windows platform use Windows COM
            if ($includeBrackets) {
                return com_create_guid();
            } else {
                return trim(com_create_guid(), '{}');
            }
        } else {
            //If on a *nix platform, build v4 GUID using PHP
            mt_srand((double)microtime()*10000);
            $charid = md5(uniqid(rand(), true));
            $hyphen = chr(45);
            $uuid =  substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid, 12, 4).$hyphen
                    .substr($charid, 16, 4).$hyphen
                    .substr($charid, 20, 12);
            if ($includeBrackets) {
                $uuid = chr(123) . $uuid . chr(125);
            }
            return $uuid;
        }
    }
}
