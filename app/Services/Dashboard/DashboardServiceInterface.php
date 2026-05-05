<?php

namespace App\Services\Dashboard;

interface DashboardServiceInterface
{
    public function getAdminStats();
    public function getFrontendStats();
    public function searchAll($query, $user);
}
