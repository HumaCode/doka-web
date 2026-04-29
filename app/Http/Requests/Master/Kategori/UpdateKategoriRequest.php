<?php

namespace App\Http\Requests\Master\Kategori;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
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
        $kategori = $this->route('kategori');
        $id = $kategori instanceof \App\Models\Master\Kategori ? $kategori->id : $kategori;

        return [
            'nama_kategori' => ['required', 'string', 'max:255'],
            'slug'          => [
                'required', 
                'string', 
                \Illuminate\Validation\Rule::unique('categories', 'slug')->ignore($id)
            ],
            'deskripsi'     => ['nullable', 'string'],
            'icon'          => ['nullable', 'string'],
            'warna'         => ['nullable', 'string'],
            'status'        => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'slug.required'          => 'Slug wajib diisi.',
            'slug.unique'            => 'Slug sudah digunakan, silakan gunakan nama lain.',
            'status.required'        => 'Status wajib dipilih.',
            'status.in'              => 'Status tidak valid.',
        ];
    }
}
