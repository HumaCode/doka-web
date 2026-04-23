<?php

namespace App\Models\Shield;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'is_active', 'guard_name'])]

class Permission extends Model
{
    use HasUlids;
}
