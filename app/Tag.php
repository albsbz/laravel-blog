<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;
    protected $fillable=['title'];
    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_tags',
            'tag_id',
            'post_id'
        ); //many to many relationthiships through post_tags table
        
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
