<?php

namespace App\Models\Sys;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use App\Models\SysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModule extends BaseModel
{
    use HasFactory;

    public $fillable = [
    ];

    const VALIDATION_RULES = [
    ];
}
