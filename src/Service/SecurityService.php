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

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Service handling security-related operations.
 *
 * Provides helper methods for authentication, such as retrieving
 * data for the login form, including last attempted username
 * and authentication errors.
 */
class SecurityService implements SecurityServiceInterface
{
    /**
     * Get data needed for the login form, including last username and error.
     *
     * @param AuthenticationUtils $authenticationUtils Helper service to get last login info
     *
     * @return array<string, mixed> Array with 'last_username' and 'error' keys
     */
    public function getLoginData(AuthenticationUtils $authenticationUtils): array
    {
        return [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ];
    }
}
