<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'event_date', 'event_time', 'location', 'is_published'];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];
}