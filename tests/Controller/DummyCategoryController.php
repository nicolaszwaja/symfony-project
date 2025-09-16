<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Controller;

use App\Controller\CategoryController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dummy implementation of CategoryController used for tests.
 */
class DummyCategoryController extends CategoryController
{
    /**
     * Stores simulated rendered content.
     *
     * @var string
     */
    public string $renderedContent = '';

    /**
     * Simulates template rendering.
     *
     * @param string        $view
     * @param array         $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $this->renderedContent = sprintf(
            'View: %s | Data: %s',
            $view,
            json_encode($parameters)
        );

        return new Response($this->renderedContent, 200);
    }
}
