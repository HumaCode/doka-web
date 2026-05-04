<?php

namespace App\Repositories\Master\SystemSetting;

interface SystemSettingRepositoryInterface
{
    public function getAll();
    public function getByGroup(string $group);
    public function getByKey(string $key);
    public function updateByKey(string $key, $value);
    public function updateBatch(array $settings);
}
