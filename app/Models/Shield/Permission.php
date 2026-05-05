<?php

namespace App\Models\Shield;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Permission\Models\Permission as ModelsPermission;

#[Fillable(['name', 'group', 'description', 'is_active', 'guard_name'])]

class Permission extends ModelsPermission
{
    use HasUlids;
}
