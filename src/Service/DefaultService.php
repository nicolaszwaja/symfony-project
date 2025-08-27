<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class DefaultService implements DefaultServiceInterface
{
    public function __construct(private readonly RouterInterface $router)
    {
    }

    /**
     * Get redirect to default locale.
     */
    public function getRedirectToDefaultLocale(): RedirectResponse
    {
        return new RedirectResponse(
            $this->router->generate('homepage', ['_locale' => 'pl'])
        );
    }

    /**
     * Data for homepage template (in future could contain more logic).
     */
    public function getHomepageData(): array
    {
        // Na razie nic specjalnego, ale serwis może przygotowywać dane do szablonu
        return [];
    }
}
