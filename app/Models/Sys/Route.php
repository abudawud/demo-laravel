<?php

namespace App\Models\Sys;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends BaseModel
{
    use HasFactory;

    protected $table = 'routes';
}
