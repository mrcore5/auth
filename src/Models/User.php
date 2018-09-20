<?php namespace Mrcore\Auth\Models;

use DB;
use Auth;
use Config;
use Session;
use Mrcore\Foundation\Support\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's full name
     * @param  string $value
     * @return string
     */
    public function getNameAttribute()
    {
        // mReschke
        return $this->first.' '.$this->last;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotificationXX($token)
    {
        // mReschke override
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Find a model by its primary key.  Mrcore cacheable eloquent override.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public static function find_NOT_NEEDED($id, $columns = array('*'))
    {
        // Cache NOT needed becuase I already cache Auth::user, so this only hits
        // if you query OTHER users, which is vary rare.
        // mReschke override to cache results
        $cacheID = $id;
        if (is_array($cacheID)) {
            $cacheID = implode('-', $cacheID);
        }
        return Cache::remember(strtolower(get_class())."$cacheID", function () use ($id,$columns) {
            return static::query()->find($id, $columns); // Use this instead of parent::find()
        });
    }

    /**
     * Get all roles linked to this user
     *
     * @return array of Role
     */
    public function getRoles()
    {
        #obsolete, I don't wnat user roles, I want the permission those roles are linked to
        # so I just need a getPermissions once, store those constants in a small session array
        #$roles = $this->roles;

        #d($roles);

        #foreach ($roles as $role) {
        #    echo $role->name;
        #}
    }

    /**
     * Get permissions for this user (not post permissions)
     *
     * @return simple array of permission constants
     */
    public function getPermissions()
    {
        /*
        SELECT
            DISTINCT p.constant
        FROM
            user_permissions up
            INNER JOIN permissions p on up.permission_id = p.id
        WHERE
            up.user_id = 2
        */
        $userPermissions = DB::table('user_permissions')
            ->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
            ->where('user_permissions.user_id', '=', $this->id)
            ->select('permissions.constant')
            ->distinct()
            ->get();

        // Convert results to single dimensional array of permission constants
        $perms = array();
        foreach ($userPermissions as $permission) {
            $perms[] = $permission->constant;
        }
        return $perms;
    }

    /**
     * Check if user has this permission item (by permission constant)
     * Uses the Session::get('user.perms') array set at login
     *
     * @return boolean
     */
    public static function hasPermission($constant)
    {
        if (Auth::admin()) {
            return true;
        } else {
            if (Session::has('user.perms')) {
                if (in_array(strtolower($constant), Session::get('user.perms'))) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if user has this role constant
     *
     * @return boolean
     */
    public function hasRole($constant)
    {
        #obsolete?? don't care, I care about permissions
        #required the function roles() to be enabled above, a many-to-many relationship
        #or query it yourself (probably better since I won't really use this function much?)

        #make a hasPermission which simply checks the existing session(user.perms) array
        #foreach ($this->roles as $role) {
        #    if (strtolower($constant) == strtolower($role->constant)) {
        #        return true;
        #    }
        #}
        #return false;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    #public function getReminderEmail()
    #{
    #    return $this->email;
    #}
}
