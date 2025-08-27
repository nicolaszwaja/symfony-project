<?php

namespace App\Service;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

interface SecurityServiceInterface
{
    /**
     * Get login form data.
     *
     * @return array<string, mixed>
     */
    public function getLoginData(AuthenticationUtils $authenticationUtils): array;
}
