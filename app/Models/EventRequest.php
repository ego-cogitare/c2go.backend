<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequest extends Model
{
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
        'is_active',
    ];
    
    public function author() 
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }
}
