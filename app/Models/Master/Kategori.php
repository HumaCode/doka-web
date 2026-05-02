<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['nama_kategori', 'slug', 'deskripsi', 'icon', 'warna', 'status'])]
class Kategori extends Model
{
    use HasFactory, HasUlids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    /**
     * Get the activities for the category.
     */
    public function kegiatans()
    {
        return $this->hasMany(\App\Models\Kegiatan\Kegiatan::class, 'kategori_id');
    }
}
