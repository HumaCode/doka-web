<?php

namespace Database\Seeders\Master;

use App\Models\Master\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // SMTP Settings
            [
                'key' => 'mail_mailer',
                'value' => env('MAIL_MAILER', 'smtp'),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_host',
                'value' => env('MAIL_HOST', 'smtp.mailtrap.io'),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_port',
                'value' => env('MAIL_PORT', '587'),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_encryption',
                'value' => env('MAIL_ENCRYPTION', 'tls'),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_username',
                'value' => env('MAIL_USERNAME', ''),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_password',
                'value' => env('MAIL_PASSWORD', ''),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_from_address',
                'value' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'group' => 'email',
                'type' => 'string',
            ],
            [
                'key' => 'mail_from_name',
                'value' => env('MAIL_FROM_NAME', 'DokaWeb'),
                'group' => 'email',
                'type' => 'string',
            ],
            // Activity Log
            [
                'key' => 'activity_log_enabled',
                'value' => '1',
                'group' => 'keamanan',
                'type' => 'boolean',
            ],
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'DokaWeb',
                'group' => 'umum',
                'type' => 'string',
            ],
            [
                'key' => 'app_description',
                'value' => 'Dokumentasi Kegiatan Web',
                'group' => 'umum',
                'type' => 'string',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
