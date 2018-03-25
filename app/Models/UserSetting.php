<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
//    table->string('section', 32);
//            $table->unsignedInteger('user_id');
//            $table->string('value');

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['section', 'user_id', 'value'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
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
