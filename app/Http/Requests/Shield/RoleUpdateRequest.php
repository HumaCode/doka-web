<?php

namespace App\Http\Requests\Shield;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role_permission'); // assuming route parameter name
        return [
            'name' => 'required|string|max:50|unique:roles,name,' . $roleId,
            'slug' => 'required|string|max:50|unique:roles,slug,' . $roleId,
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string',
            'grad_id' => 'required|integer|min:0',
        ];
    }
}
