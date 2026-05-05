<?php

namespace App\Services\Master\SystemSetting;

use App\Repositories\Master\SystemSetting\SystemSettingRepositoryInterface;
use App\Models\Master\SystemSetting;
use Illuminate\Support\Facades\Cache;

class SystemSettingService implements SystemSettingServiceInterface
{
    protected $repository;

    public function __construct(SystemSettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSettings()
    {
        return Cache::remember('system_settings', 3600, function () {
            $settings = $this->repository->getAll()->pluck('value', 'key')->toArray();
            
            // Inject cached media URLs
            $assets = SystemSetting::where('key', 'system_assets')->first();
            $settings['logo_light_url'] = $assets ? $assets->getFirstMediaUrl('logo_light') : null;
            $settings['logo_dark_url'] = $assets ? $assets->getFirstMediaUrl('logo_dark') : null;
            $settings['favicon_url'] = $assets ? $assets->getFirstMediaUrl('favicon') : null;
            
            return $settings;
        });
    }

    public function updateSettings(array $data, ?string $group = null)
    {
        $this->repository->updateBatch($data, $group);
        
        // Log the activity
        \App\Models\Master\SystemLog::create([
            'user_id' => auth()->id(),
            'event_type' => 'update_setting',
            'severity' => 'info',
            'description' => "Memperbarui pengaturan sistem pada bagian: " . strtoupper($group ?? 'umum'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'path' => request()->path(),
            'method' => request()->method()
        ]);

        Cache::forget('system_settings');
        Cache::forget('system_settings_config');
        return true;
    }

    public function updateLogo(string $type, $file)
    {
        $setting = SystemSetting::firstOrCreate(['key' => 'system_assets', 'group' => 'tampilan']);
        
        $setting->clearMediaCollection($type);
        $setting->addMedia($file)->toMediaCollection($type);
        
        // Log the activity
        \App\Models\Master\SystemLog::create([
            'user_id' => auth()->id(),
            'event_type' => 'update_setting',
            'severity' => 'info',
            'description' => "Mengunggah aset sistem baru: " . str_replace('_', ' ', $type),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        Cache::forget('system_settings');
        Cache::forget('system_settings_config');
        return $setting->getFirstMediaUrl($type);
    }

    public function getSecurityStats()
    {
        return Cache::remember('security_monitor_stats', 300, function() {
            $attackCount = \App\Models\Master\SystemLog::where('event_type', 'attack_attempt')->count();
            $failedLoginCount = \App\Models\Master\SystemLog::where('event_type', 'failed_login')->count();
            $recentAttacks = \App\Models\Master\SystemLog::where('event_type', 'attack_attempt')
                ->latest()
                ->limit(10)
                ->get()
                ->map(function($log) {
                    return [
                        'ip_address' => $log->ip_address,
                        'path' => $log->path,
                        'time_ago' => $log->created_at->diffForHumans()
                    ];
                });
            
            return [
                'attack_count' => $attackCount,
                'failed_login_count' => $failedLoginCount,
                'recent_attacks' => $recentAttacks
            ];
        });
    }

    public function getActivityLogs()
    {
        return \App\Models\Master\SystemLog::whereIn('event_type', ['activity', 'update_setting', 'login', 'logout'])
            ->latest()
            ->limit(20)
            ->with('user')
            ->get()
            ->map(function($log) {
                $color = '#6366f1'; 
                $icon = 'bi bi-info-circle';

                if ($log->event_type === 'attack_attempt') {
                    $color = '#ef4444';
                    $icon = 'bi bi-exclamation-triangle';
                } elseif ($log->event_type === 'failed_login') {
                    $color = '#f59e0b';
                    $icon = 'bi bi-shield-exclamation';
                } elseif ($log->event_type === 'login') {
                    $color = '#10b981';
                    $icon = 'bi bi-person-check';
                }

                return [
                    'user_name' => $log->user ? $log->user->name : 'System',
                    'description' => $log->description,
                    'time_ago' => $log->created_at->diffForHumans(),
                    'color' => $color,
                    'icon' => $icon
                ];
            });
    }
}
