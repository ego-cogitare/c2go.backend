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
        'event_proposals_id',
        'user_id',
        'message',
        'state',
        'is_active',
    ];
    
    /**
     * Author of the request
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    /**
     * Author of the request
     */
    public function proposal() 
    {
        return $this->hasOne('App\Models\EventProposal', 'id', 'event_proposals_id');
    }
}
