<?php

namespace App\Services\Master\SystemSetting;

interface SystemSettingServiceInterface
{
    public function getSettings();
    public function updateSettings(array $data, ?string $group = null);
    public function updateLogo(string $type, $file);
    public function getSecurityStats();
    public function getActivityLogs();
}
