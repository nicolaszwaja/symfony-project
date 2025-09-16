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
use Symfony\Component\Routing\RouterInterface;

/**
 * Service providing default behavior and data for the application.
 */
class DefaultService implements DefaultServiceInterface
{
    /**
     * DefaultService constructor.
     *
     * @param RouterInterface $router The router service
     */
    public function __construct(private readonly RouterInterface $router)
    {
    }

    /**
     * Get a redirect response to the default locale.
     *
     * @return RedirectResponse
     */
    public function getRedirectToDefaultLocale(): RedirectResponse
    {
        return new RedirectResponse(
            $this->router->generate('homepage', ['_locale' => 'pl'])
        );
    }

    /**
     * Get data for the homepage template.
     *
     * @return array<string, mixed>
     */
    public function getHomepageData(): array
    {
        // Currently returns an empty array, can be extended in the future
        return [];
    }
}
