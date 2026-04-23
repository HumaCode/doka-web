<?php

namespace App\Models\Shield;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Permission\Models\Role as ModelsRole;


#[Fillable(['name', 'slug', 'type_role', 'description', 'is_active',  'guard_name'])]
class Role extends ModelsRole
{
    use HasUlids;
}
