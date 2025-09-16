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
 * Interface for services handling security operations, e.g., login data.
 */
interface SecurityServiceInterface
{
    /**
     * Get login form data, including last username and authentication errors.
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return array<string, mixed>
     */
    public function getLoginData(AuthenticationUtils $authenticationUtils): array;
}
