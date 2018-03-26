<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'color', 'cover_photo', 'is_active'];
    
    public function parent() 
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }
    
    public function categories() 
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }
    
    public function events()
    {
        return $this->hasMany('App\Models\Events');
    }
}
