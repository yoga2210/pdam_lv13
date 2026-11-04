<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'cover', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}