<?php

namespace App\Http\Requests\Master\Pengguna;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');
        
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:l,p',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'is_active' => 'required|boolean',
        ];
    }
}
