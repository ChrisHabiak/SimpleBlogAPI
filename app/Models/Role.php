<?php

namespace App\Models;

use App\Models\Traits\HasCacheTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasCacheTrait;

    protected $casts = [
        'permissions' => 'array',
    ];


    public static function getAdminRoleID(): int
    {
        return 1;
    }


    public static function getEditorRoleID(): int
    {
        return 2;
    }
}
