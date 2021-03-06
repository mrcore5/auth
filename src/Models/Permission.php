<?php namespace Mrcore\Auth\Models;

use Mrcore\Foundation\Support\Cache;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * This table does not use automatic timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find a model by its primary key.  Mrcore cacheable eloquent override.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public static function find($id, $columns = array('*'))
    {
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
     * Get all of the models from the database.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = array('*'))
    {
        return Cache::remember(strtolower(get_class()).":all", function () use ($columns) {
            return static::orderBy('constant')->get($columns);
        });
    }

    /*
     * Clear all cache
     *
     */
    public static function forgetCache($id = null)
    {
        Cache::forget(strtolower(get_class()).':all');
        if (isset($id)) {
            Cache::forget(strtolower(get_class()).":$id");
        }
    }
}
