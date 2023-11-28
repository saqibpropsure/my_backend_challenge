<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'end_point',
        'source',
        'author',
        'title',
        'description',
        'type',
        'url',
        'images',
        'published_at',
        'category',
        'content',
    ];
}
