<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'nama_instansi',
    'singkatan',
    'jenis_opd',
    'nama_kepala',
    'telp',
    'email',
    'website',
    'alamat',
    'deskripsi',
    'icon',
    'warna',
    'status',
])]
class UnitKerja extends Model
{
    use HasFactory, HasUlids, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('unit_kerja')
            ->setDescriptionForEvent(fn(string $eventName) => "Unit Kerja has been {$eventName}");
    }

    protected $table = 'unit_kerja';

    /**
     * Get the users for the unit kerja.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'unit_kerja_id');
    }
}
