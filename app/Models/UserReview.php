<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserReview
 * @package App\Models
 */
class UserReview extends Model
{
    /**
     * Attributes that should be mass-assignable.
     * @var array
     */
    protected $fillable = [
        'user_about_id',
        'user_id',
        'mark',
        'message',
        'is_active',
    ];


    /**
     * Get user which review was written about
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAbout() 
    {
        return $this->belongsTo('App\Models\User', 'user_about_id', 'id');
    }


    /**
     * Get reviewer user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
