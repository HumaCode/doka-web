<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitKerjaResource extends JsonResource
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
            'nama' => $this->nama_instansi,
            'singkatan' => $this->singkatan,
            'jenis' => $this->jenis_opd,
            'kepala' => $this->nama_kepala,
            'telp' => $this->telp,
            'email' => $this->email,
            'web' => $this->website,
            'alamat' => $this->alamat,
            'deskripsi' => $this->deskripsi,
            'icon' => $this->icon,
            'warna' => $this->warna,
            'status' => $this->status,
            'pengguna' => $this->users_count ?? $this->users()->count(),
            'kegiatan' => 0, // Placeholder for now
            'foto' => 0,     // Placeholder for now
        ];
    }
}
