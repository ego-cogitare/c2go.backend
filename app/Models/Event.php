<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Attributes that should be mass-assignable.
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
    
    /**
     * @var array 
     */
    protected $appends = [
        'proposals_count'
    ];
    
    public function category() 
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function bestProposal() 
    {
        return $this->hasOne('App\Models\EventProposal')->orderBy('price', 'ASC');
    }
    
    public function proposals() 
    {
        return $this->hasMany('App\Models\EventProposal');
    }
    
    public function requests() 
    {
        return $this->hasMany('App\Models\EventRequest');
    }
    
    /**
     * Get the event date.
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format(env('DATETIME_FORMAT'));
    }
    
    /**
     * Get event proposals amount
     * @return int
     */
    public function getProposalsCountAttribute()
    {
        return EventProposal::where('event_id', $this->id)->count();
    }
}
