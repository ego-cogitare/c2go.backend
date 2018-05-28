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
    
    protected $appends = [
        'age', 
        'rank',
        'settings'
    ];

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
        'password', 
        'remember_token',
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
    
    public function prices()
    {
        return $this->hasMany('App\Models\EventProposal');
    }
    
    public function reviews() 
    {
        return $this->hasMany('App\Models\UserReview', 'user_about_id');
    }
    
    public function getFullName() 
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }
    
    public function getSettingsAttribute() 
    {
        $settings = UserSetting::where('user_id', $this->id)
            ->get()
            ->pluck('value', 'section');
        
        foreach ($settings as $section => $value) {
            switch ($section) {
                case 'location':
                    $settings[$section] = json_decode($value);
                break;
                
                case 'profile_settings':
                    $settings[$section] = [];
                break;
            
                case 'profile_interests':
                    $data = json_decode($value);
                    $categories = [];
                    
                    if (!empty($data->categories)) {
                        $settings[$section] = Category::with([
                                'categories' => function($query) use ($data) {
                                    $query->whereIn('id', $data->categories);
                                }
                            ])
                            ->where('is_active', 1)
                            ->whereNull('parent_id')
                            ->orderBy('order', 'ASC')
                            ->get()
                            ->toArray();
                        
                        /*$settings[$section] = Category::whereIn('id', $data->categories)
                            ->get()
                            ->toArray();*/
                    }
                break;
            }
        }
        
        return $settings;
    }
}
