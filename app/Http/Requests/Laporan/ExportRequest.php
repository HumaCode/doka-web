<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'type' => 'required|string|in:laporan-bulanan,daftar-kegiatan,galeri-foto,rekap-unit,detail-kegiatan,kustom',
            'title' => 'nullable|string|max:255',
            'filters' => 'required|array',
            'filters.bulan_mulai' => 'nullable|integer|between:1,12',
            'filters.bulan_akhir' => 'nullable|integer|between:1,12',
            'filters.tahun' => 'nullable|integer',
            'filters.unit_id' => 'nullable|string',
            'filters.kategori_id' => 'nullable|string',
            'filters.status' => 'nullable|string|in:selesai,berjalan,draft',
            'options' => 'nullable|array',
        ];
    }
}
