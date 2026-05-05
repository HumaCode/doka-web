<?php

namespace App\Http\Requests\Shield;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:roles,name',
            'slug' => 'required|string|max:50|unique:roles,slug',
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string',
            'grad_id' => 'required|integer|min:0',
            'copy_from' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah digunakan.',
            'slug.required' => 'Kode role wajib diisi.',
            'slug.unique' => 'Kode role sudah digunakan.',
            'icon.required' => 'Ikon wajib dipilih.',
            'grad_id.required' => 'Warna wajib dipilih.',
        ];
    }
}
