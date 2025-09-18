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
 * Interface for the default application service.
 *
 * Provides methods for redirecting to the default locale and for retrieving
 * data needed to render the homepage template.
 */
interface DefaultServiceInterface
{
    /**
     * Returns a RedirectResponse to the default locale homepage.
     *
     * @return RedirectResponse Redirect response pointing to the homepage in default locale
     */
    public function getRedirectToDefaultLocale(): RedirectResponse;

    /**
     * Provides data to be used in the homepage template.
     *
     * @return array<string, mixed> Array containing key-value pairs for rendering the homepage
     */
    public function getHomepageData(): array;
}
