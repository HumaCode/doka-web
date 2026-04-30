<?php

namespace App\Http\Requests\Master\UnitKerja;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitKerjaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_instansi' => 'required|string|max:255',
            'singkatan'     => 'required|string|max:50',
            'jenis_opd'     => 'required|string',
            'nama_kepala'   => 'nullable|string|max:255',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'website'       => 'nullable|url|max:255',
            'alamat'        => 'nullable|string',
            'deskripsi'     => 'nullable|string',
            'icon'          => 'nullable|string',
            'warna'         => 'nullable|integer',
            'status'        => 'nullable|in:active,inactive',
        ];
    }
}
