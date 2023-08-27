<?php

namespace App\Models;

use App\Models\Traits\HasCacheTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasCacheTrait;

    protected $fillable = [
        'title',
        'content',
        'image_url',
    ];

}
