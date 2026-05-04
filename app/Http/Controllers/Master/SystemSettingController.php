<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\SystemSetting\UpdateSystemSettingRequest;
use App\Services\Master\SystemSetting\SystemSettingServiceInterface;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    protected $service;

    public function __construct(SystemSettingServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display the system settings page.
     */
    public function index()
    {
        $settings = $this->service->getSettings();
        
        return view('pages.setting.system-setting.index', [
            'settings' => $settings,
            'logo_light' => $settings['logo_light_url'] ?? null,
            'logo_dark' => $settings['logo_dark_url'] ?? null,
            'favicon' => $settings['favicon_url'] ?? null,
        ]);
    }

    /**
     * Update the system settings.
     */
    public function update(UpdateSystemSettingRequest $request)
    {
        try {
            $this->service->updateSettings($request->validated(), $request->section ?? 'umum');
            return $this->success('Pengaturan sistem berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Update system logo/assets.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:logo_light,logo_dark,favicon',
            'file' => 'required|image|mimes:jpg,jpeg,png,svg,ico|max:2048',
        ]);

        try {
            $url = $this->service->updateLogo($request->type, $request->file('file'));
            return $this->success('Logo berhasil diperbarui.', ['url' => $url]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Test email connection.
     */
    public function testEmail(Request $request)
    {
        try {
            $settings = $this->service->getSettings();
            $config = [
                'host' => $request->mail_host ?? $settings['mail_host'] ?? '',
                'port' => $request->mail_port ?? $settings['mail_port'] ?? 587,
                'encryption' => $request->mail_encryption ?? $settings['mail_encryption'] ?? 'tls',
                'username' => $request->mail_username ?? $settings['mail_username'] ?? '',
                'password' => $request->mail_password ?? $settings['mail_password'] ?? '',
                'from_address' => $request->mail_from_address ?? $settings['mail_from_address'] ?? config('mail.from.address'),
                'from_name' => $request->mail_from_name ?? $settings['mail_from_name'] ?? config('mail.from.name'),
            ];

            if (empty($config['host'])) throw new \Exception("Host SMTP belum diisi.");

            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $config['host'],
                'mail.mailers.smtp.port' => (int)$config['port'],
                'mail.mailers.smtp.encryption' => $config['encryption'],
                'mail.mailers.smtp.username' => $config['username'],
                'mail.mailers.smtp.password' => $config['password'],
                'mail.from.address' => $config['from_address'],
                'mail.from.name' => $config['from_name'],
            ]);

            \Illuminate\Support\Facades\Mail::raw('Email percobaan dari sistem DokaWeb.', function ($message) use ($config) {
                $message->from($config['from_address'], $config['from_name'])
                        ->to(auth()->user()->email)
                        ->subject('Test Koneksi SMTP DokaWeb');
            });

            return $this->success('Koneksi SMTP berhasil!');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get security monitoring stats.
     */
    public function getSecurityStats()
    {
        return $this->success(null, $this->service->getSecurityStats());
    }

    /**
     * Get user activity logs.
     */
    public function getActivityLogs()
    {
        return $this->success(null, $this->service->getActivityLogs());
    }
}
