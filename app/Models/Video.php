<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'youtube_url', 'thumbnail', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}