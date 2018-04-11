<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_about_id',
        'user_id',
        'message',
        'is_active',
    ];
    
    public function userAbout() 
    {
        return $this->belongsTo('App\Models\User', 'user_about_id', 'id');
    }
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }
}
