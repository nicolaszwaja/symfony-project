<?php

namespace App\Controller;

use App\Service\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    public function __construct(private readonly SecurityServiceInterface $securityService)
    {
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $data = $this->securityService->getLoginData($authenticationUtils);

        return $this->render('security/login.html.twig', $data);
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Controller can be blank: it will be intercepted by the firewall.
        throw new \Exception('This should never be reached!');
    }
}
