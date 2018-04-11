<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequest extends Model
{
    const STATE_NEW = 1;
    const STATE_ACCEPTED = 2;
    const STATE_REJECTED = 3;
    
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_user_id',
        'user_id',
        'event_id',
        'message',
        'state',
        'is_active',
    ];
    
    /**
     * Author of the event
     */
    public function author() 
    {
        return $this->belongsTo('App\Models\User', 'event_user_id');
    }
    
    /**
     * Author of the request
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function event() 
    {
        return $this->belongsTo('App\Models\Event');
    }
}
