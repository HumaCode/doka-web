<?php

namespace App\Http\Resources\Galeri;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GaleriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'thumb' => $this->thumb,
            'kegiatan' => $this->kegiatan,
            'kegiatan_id' => $this->kegiatan_id,
            'unit' => $this->unit,
            'tanggal' => $this->tanggal,
            'bulan' => $this->bulan,
            'size' => $this->size,
            'caption' => $this->caption,
            'is_main' => $this->is_main,
            'gradId' => $this->gradId,
            'emoji' => $this->emoji,
        ];
    }
}
