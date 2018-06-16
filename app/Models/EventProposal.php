<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventProposal extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'user_id', 
        'price', 
        'message', 
    ];
    
    public function event() 
    {
        return $this->belongsTo('App\Models\Event');
    }
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
