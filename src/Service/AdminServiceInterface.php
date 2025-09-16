<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Service;

/**
 * Interface for the AdminService providing methods for dashboard data access.
 */
interface AdminServiceInterface
{
    /**
     * Get all data for the admin dashboard.
     *
     * @return array<string, array<int, object>> Array containing 'posts', 'categories', and 'comments'
     */
    public function getDashboardData(): array;
}
