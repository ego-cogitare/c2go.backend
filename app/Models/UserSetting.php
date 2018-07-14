<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSetting
 * @package App\Models
 */
class UserSetting extends Model
{
    /**
     * Attributes that should be mass-assignable.
     * @var array
     */
    protected $fillable = [
        'section',
        'user_id',
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    /**
     * @param $user_id
     * @param $section
     * @param $value
     * @return mixed
     */
    public static function apply($user_id, $section, $value) 
    {
        return self::updateOrCreate([
            'section' => $section,
            'user_id' => $user_id,
        ], [
            'section' => $section,
            'user_id' => $user_id,
            'value' => $value
        ]);
    }


    /**
     * @param $user_id
     * @param $location
     * @return mixed
     */
    public static function location($user_id, $location) 
    {
        return self::updateOrCreate([
            'section' => 'location',
            'user_id' => $user_id,
        ], [
            'section' => 'location',
            'user_id' => $user_id,
            'value' => json_encode($location)
        ]);
    }


    /**
     * @param $user_id
     * @param $path
     * @return mixed
     */
    public static function profilePhoto($user_id, $path) 
    {
        return self::updateOrCreate([ 
            'section' => 'profile_photo',
            'user_id' => $user_id 
        ], [
            'section' => 'profile_photo',
            'user_id' => $user_id,
            'value' => $path
        ]);
    }
}
