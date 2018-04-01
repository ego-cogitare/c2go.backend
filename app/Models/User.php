<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use SoftDeletes;
    
    protected $appends = ['age', 'rank'];

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
        'home_address',
        'birth_date',
        'progress',
        'is_subscribed',
        'android_device_token',
        'ios_device_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getAgeAttribute() 
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }
    
    public function getRankAttribute() 
    {
        return rand(1, 5);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    public function settings()
    {
        return $this->hasMany('App\Models\UserSetting');
    }
    
    public function prices()
    {
        return $this->hasMany('App\Models\EventProposal');
    }
    
    public function getFullName() 
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
