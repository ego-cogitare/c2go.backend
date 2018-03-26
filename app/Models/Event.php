<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 
        'user_id', 
        'name', 
        'description', 
        'event_location_human', 
        'event_location_latlng', 
        'event_destination_human', 
        'event_destination_latlng', 
        'date',
        'price', 
        'is_active'
    ];
    
    public function category() 
    {
        return $this->hasOne('App\Models\Category');
    }
    
    public function user() 
    {
        return $this->hasOne('App\Models\User');
    }
}
