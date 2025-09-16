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

use App\Service\DefaultServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for handling the homepage and default locale redirection.
 */
class DefaultController extends AbstractController
{
    /**
     * DefaultController constructor.
     *
     * @param DefaultServiceInterface $defaultService
     */
    public function __construct(private readonly DefaultServiceInterface $defaultService)
    {
    }

    /**
     * Redirects to the default locale homepage.
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/', name: 'homepage_redirect')]
    public function redirectToDefaultLocale(): Response
    {
        return $this->defaultService->getRedirectToDefaultLocale();
    }

    /**
     * Displays the homepage for a given locale.
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/{_locale}/', name: 'homepage', requirements: ['_locale' => 'pl|en'])]
    public function index(): Response
    {
        $data = $this->defaultService->getHomepageData();

        return $this->render('default/index.html.twig', $data);
    }
}
