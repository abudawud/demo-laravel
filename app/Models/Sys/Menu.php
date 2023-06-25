<?php

namespace App\Models\Sys;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends BaseModel
{
    use HasFactory;

    protected $table = 'menu_builders';

    public $fillable = [
        'parent_id', 'module_id', 'text',
        'target', 'order', 'icon', 'is_active',
        'created_by', 'role_id', 'route_id',
    ];

    public $displayable = [
        'text', 'module_id', 'parent_id',
        'url', 'order', 'icon', 'is_active',
    ];

    const VALIDATION_RULES = [
        'module_id' => 'required|exists:App\Models\Sys\Module,id',
        'text' => 'required|max:100',
        'can' => 'required',
        'order' => 'required',
        'active' => 'nullable',
        'target' => 'nullable',
        'icon' => 'nullable',
        'url' => 'required',
        'parent_id' => 'nullable|exists:App\Models\Sys\Menu,id',
    ];

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function parent() {
        return $this->belongsTo(static::class);
    }

    public function getDisplayableFields($withTable = true)
    {
        $collection = collect($this->displayable)->push($this->primaryKey);
        if ($withTable) {
            return $collection->map(function ($field) {
                return "{$this->getTable()}.{$field}";
            })->toArray();
        } else {
            return $collection->toArray();
        }
    }
}
