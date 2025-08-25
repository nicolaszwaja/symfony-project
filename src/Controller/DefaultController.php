<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    // / -> przekierowanie do domyślnego języka (pl)
    #[Route('/', name: 'homepage_redirect')]
    public function redirectToDefaultLocale(): Response
    {
        return $this->redirectToRoute('homepage', ['_locale' => 'pl']);
    }

    // /pl/ lub /en/
    #[Route('/{_locale}/', name: 'homepage', requirements: ['_locale' => 'pl|en'])]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
