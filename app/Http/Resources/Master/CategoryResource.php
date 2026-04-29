<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'nama_kategori'  => $this->nama_kategori,
            'slug'           => $this->slug,
            'deskripsi'      => $this->deskripsi,
            'icon'           => $this->icon,
            'warna'          => $this->warna,
            'status'         => $this->status,
            // 'kegiatan_count' => $this->kegiatan_count ?? 0, // Placeholder for future use
            // 'foto_count'     => $this->foto_count ?? 0,     // Placeholder for future use
            'created_at'     => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
