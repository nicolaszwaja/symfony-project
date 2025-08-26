<?php

namespace App\Service;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Comment;

interface AdminServiceInterface
{
    /**
     * Get all data for admin dashboard.
     *
     * @return array<string, array<int, object>>
     */
    public function getDashboardData(): array;
}
