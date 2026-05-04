<?php

namespace App\Repositories\Master\SystemSetting;

use App\Models\Master\SystemSetting;

class SystemSettingRepository implements SystemSettingRepositoryInterface
{
    public function getAll()
    {
        return SystemSetting::all();
    }

    public function getByGroup(string $group)
    {
        return SystemSetting::where('group', $group)->get();
    }

    public function getByKey(string $key)
    {
        return SystemSetting::where('key', $key)->first();
    }

    public function updateByKey(string $key, $value)
    {
        return SystemSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function updateBatch(array $settings, ?string $group = null)
    {
        foreach ($settings as $key => $value) {
            $data = ['value' => $value];
            if ($group) {
                $data['group'] = $group;
            }

            SystemSetting::updateOrCreate(
                ['key' => $key],
                $data
            );
        }
    }
}
