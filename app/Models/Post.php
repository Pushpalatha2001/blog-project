<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $table ='posts';

     public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
