<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

class MsBarang extends BaseModel
{
    use HasFactory;

    // overide default value
    protected $table = "ms_barang";

    public $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
    ];

    public $displayable = [
        'name', 'description', 'is_active',
    ];

    const VALIDATION_RULES = [
        'name' => 'required',
        'description' => 'nullable',
        'is_active' => 'required',
    ];

    const VALIDATION_MESSAGES = [];
}
