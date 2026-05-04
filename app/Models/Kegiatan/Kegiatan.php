<?php

namespace App\Models\Kegiatan;

use App\Models\User;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'judul', 
    'tanggal', 
    'waktu', 
    'lokasi', 
    'kategori_id', 
    'unit_id', 
    'uraian', 
    'jumlah_peserta', 
    'narasumber', 
    'status', 
    'petugas_id', 
    'tags'
])]
class Kegiatan extends Model implements HasMedia
{
    use HasFactory, HasUlids, InteractsWithMedia, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('kegiatan')
            ->setDescriptionForEvent(fn(string $eventName) => "Kegiatan telah {$eventName}");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'tags' => 'array',
            'jumlah_peserta' => 'integer',
        ];
    }

    /**
     * Relationship with Category
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relationship with Unit Kerja
     */
    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'unit_id');
    }

    /**
     * Relationship with User (Petugas)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Register Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto_kegiatan')
             ->useFallbackUrl(asset('assets/img/placeholder-kegiatan.jpg'))
             ->useFallbackPath(public_path('assets/img/placeholder-kegiatan.jpg'));

        $this->addMediaCollection('lampiran_kegiatan')
             ->useDisk('local');
    }
}
