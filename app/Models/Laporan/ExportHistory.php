<?php

namespace App\Models\Laporan;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExportHistory extends Model implements HasMedia
{
    use HasUlids, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'params',
        'page_count',
    ];

    protected $casts = [
        'params' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('export_files')
            ->singleFile();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
