<?php

namespace App\Http\Requests\Master\SystemSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemSettingRequest extends FormRequest
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
            'app_name' => 'sometimes|required|string|max:255',
            'app_url' => 'sometimes|required|url',
            'app_description' => 'nullable|string',
            'default_language' => 'sometimes|required|string|in:id,en',
            'timezone' => 'sometimes|required|string',
            'date_format' => 'sometimes|required|string',
            
            // SEO Fields
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords' => 'nullable|string|max:255',
            'seo_google_analytics' => 'nullable|string|max:50',
            'app_copyright' => 'nullable|string|max:255',
            
            // Email Fields
            'mail_mailer' => 'sometimes|required|string',
            'mail_host' => 'sometimes|required|string',
            'mail_port' => 'sometimes|required|numeric',
            'mail_username' => 'sometimes|required|string',
            'mail_password' => 'sometimes|required|string',
            'mail_encryption' => 'sometimes|required|string|in:tls,ssl,none',
            'mail_from_address' => 'sometimes|required|email',
            'mail_from_name' => 'sometimes|required|string|max:255',

            // Backup Settings
            'backup_schedule' => 'nullable|string',
            'backup_retention' => 'nullable|integer',
            'backup_notification_email' => 'nullable|email',

            // Activity Log
            'activity_log_enabled' => 'nullable|in:0,1',
        ];
    }
}
