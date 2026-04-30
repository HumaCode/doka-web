<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'username'  => $this->username,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'gender'    => $this->gender,
            'is_active' => $this->is_active,
            'roles'     => RoleResource::collection($this->whenLoaded('roles')),
            'unit_kerja'=> [
                'id'    => $this->unit_kerja_id,
                'nama'  => $this->unitKerja ? $this->unitKerja->nama_instansi : ($this->unit_kerja_id ? 'Instansi Tidak Ditemukan' : 'Instansi Belum Dipilih'),
                'sing'  => $this->unitKerja ? $this->unitKerja->singkatan : '-',
            ],
        ];
    }
}
