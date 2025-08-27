<?php

namespace App\Service;

interface AdminServiceInterface
{
    /**
     * Get all data for admin dashboard.
     *
     * @return array<string, array<int, object>>
     */
    public function getDashboardData(): array;
}
