<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'podcast_id',
        'password_hint',

        'android_device_token',
        'ios_device_token',
    ];

    //protected $with = ['state'];

    //protected $appends = ['stat'];
    
    public static function boot()
    {
        parent::boot();
        
        self::created(function (User $user) {

            // Seed user with default settings
            UserSetting::whereNull('user_id')->get()->each(function($setting) use ($user) {
                UserSetting::create(array_merge(
                    $setting->toArray(), ['user_id' => $user->id]
                ));
            });
        });
        
        self::deleted(function (User $user) {

            // Remove user settings
            UserSetting::where([ 'user_id' => $user->id, ])->delete();
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function podcast()
    {
        return $this->belongsTo('\App\Models\Podcast');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany('\App\Models\UserSetting', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('\App\Models\Answer');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
