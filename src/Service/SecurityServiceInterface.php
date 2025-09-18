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
 * Interface for services handling security operations.
 *
 * Provides methods for retrieving authentication-related data,
 * such as last username attempted and login errors, to support
 * login forms and security workflows.
 */
interface SecurityServiceInterface
{
    /**
     * Get login form data, including last username and authentication errors.
     *
     * @param AuthenticationUtils $authenticationUtils Helper service for last login info
     *
     * @return array<string, mixed> Array containing:
     *                              - 'last_username': string|null The last entered username
     *                              - 'error'        : \Symfony\Component\Security\Core\Exception\AuthenticationException|null Last login error
     */
    public function getLoginData(AuthenticationUtils $authenticationUtils): array;
}
