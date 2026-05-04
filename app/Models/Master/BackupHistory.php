<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BackupHistory extends Model implements HasMedia
{
    use InteractsWithMedia, HasUlids;

    protected $fillable = [
        'name',
        'type',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('backup_file')
            ->useDisk('local') // Or 'private' if they have it
            ->singleFile();
    }
}
