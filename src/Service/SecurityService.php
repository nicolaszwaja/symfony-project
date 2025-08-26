<?php

namespace App\Service;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityService implements SecurityServiceInterface
{
    public function getLoginData(AuthenticationUtils $authenticationUtils): array
    {
        return [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ];
    }
}
