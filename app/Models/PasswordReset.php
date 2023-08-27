<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'
    ];

    const UPDATED_AT = null;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token = Str::random(50);
        });
    }

    public function getToken(): string
    {
        return $this->token;
    }


}
