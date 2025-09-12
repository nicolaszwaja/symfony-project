<?php

namespace App\Controller;

use App\Service\DefaultServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function __construct(private readonly DefaultServiceInterface $defaultService)
    {
    }

    #[\Symfony\Component\Routing\Attribute\Route('/', name: 'homepage_redirect')]
    public function redirectToDefaultLocale(): Response
    {
        return $this->defaultService->getRedirectToDefaultLocale();
    }

    #[\Symfony\Component\Routing\Attribute\Route('/{_locale}/', name: 'homepage', requirements: ['_locale' => 'pl|en'])]
    public function index(): Response
    {
        $data = $this->defaultService->getHomepageData();

        return $this->render('default/index.html.twig', $data);
    }
}
