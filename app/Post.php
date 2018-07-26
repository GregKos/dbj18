<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'subtitle', 'content', 'published', 'published_at', 'filename'];

    /**
     * Get the categories for this post
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
