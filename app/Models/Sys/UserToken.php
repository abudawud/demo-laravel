<?php

namespace App\Models\Sys;

use App\Models\SysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserToken extends SysModel
{
    use HasFactory;

    public $fillable = [
        'user_id', 'token', 'apps',
        'status',
    ];
}
