<?php

namespace App\Http\Requests\Kegiatan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKegiatanRequest extends FormRequest
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
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'unit_id' => 'nullable|exists:unit_kerja,id',
            'uraian' => 'required|string',
            'jumlah_peserta' => 'nullable|integer',
            'narasumber' => 'nullable|string|max:255',
            'status' => 'required|in:draft,berjalan,selesai',
            'petugas_id' => 'required|exists:users,id',
            'tags' => 'nullable|string',
            'photos.*' => 'image|max:5120',
            'attachments.*' => 'file|max:10240',
            'deleted_media' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul kegiatan wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'uraian.required' => 'Uraian kegiatan wajib diisi.',
            'petugas_id.required' => 'Petugas dokumentasi wajib dipilih.',
        ];
    }
}
