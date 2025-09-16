<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Controller;

use App\Service\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller responsible for user authentication (login and logout).
 */
class SecurityController extends AbstractController
{
    /**
     * SecurityController constructor.
     *
     * @param SecurityServiceInterface $securityService The security service
     */
    public function __construct(private readonly SecurityServiceInterface $securityService)
    {
    }

    /**
     * Handles the login form and authentication.
     *
     * @param AuthenticationUtils $authenticationUtils The authentication helper
     *
     * @return Response
     */
    #[Route(path: '/login', name: 'admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Jeśli użytkownik jest już zalogowany, przekieruj go na dashboard
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $data = $this->securityService->getLoginData($authenticationUtils);

        return $this->render('security/login.html.twig', $data);
    }

    /**
     * Logout action (intercepted by Symfony firewall).
     *
     * @return void
     *
     * @throws \LogicException Always
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method is intercepted by the firewall logout.');
    }
}
