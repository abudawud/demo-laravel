<?php

namespace App\Models\Sys;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends BaseModel
{
    use HasFactory;

    public $fillable = [
        'name', 'description', 'url',
        'color', 'order', 'is_active',
        'created_by',
    ];

    public $displayable = [
        'name', 'url', 'color',
        'description', 'is_active',
    ];

    const VALIDATION_RULES = [
        'name' => 'required',
        'url' => 'required',
        'is_active' => 'required',
        'color' => 'nullable',
        'description' => 'nullable',
    ];

    public function getDisplayableFields($withTable = true)
    {
        $collection = collect($this->displayable)->push($this->primaryKey);
        if ($withTable) {
            return $collection->map(function ($field) {
                return "{$this->table}.{$field}";
            })->toArray();
        } else {
            return $collection->toArray();
        }
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
