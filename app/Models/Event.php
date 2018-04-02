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
        'is_top',
        'is_active'
    ];
    
    public function category() 
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function proposals() 
    {
        return $this->hasManyThrough('App\Models\User', 'App\Models\EventProposal', 'event_id', 'id', 'id', 'user_id');
    }
    
    public function prices() 
    {
        return $this->hasMany('App\Models\EventProposal');
    }
    
    public function requests() 
    {
        return $this->hasMany('App\Models\EventRequest');
    }
    
    /**
     * Get the event date.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format(env('DATETIME_FORMAT'));
    }
}
