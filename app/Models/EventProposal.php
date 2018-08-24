<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class EventProposal
 * @package App\Models
 */
class EventProposal extends Model
{
    /**
     * Attributes that should be mass-assignable.
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'user_id', 
        'price', 
        'message', 
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() 
    {
        return $this->belongsTo('App\Models\Event');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
