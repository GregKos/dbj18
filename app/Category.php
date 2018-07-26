<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the posts for this category
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
