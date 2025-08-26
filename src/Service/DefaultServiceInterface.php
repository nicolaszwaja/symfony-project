<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;

interface DefaultServiceInterface
{
    public function getRedirectToDefaultLocale(): RedirectResponse;

    public function getHomepageData(): array;
}
