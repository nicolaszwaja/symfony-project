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

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Interface for default application service.
 */
interface DefaultServiceInterface
{
    /**
     * Get a redirect response to the default locale.
     *
     * @return RedirectResponse
     */
    public function getRedirectToDefaultLocale(): RedirectResponse;

    /**
     * Get data for the homepage template.
     *
     * @return array<string, mixed>
     */
    public function getHomepageData(): array;
}
