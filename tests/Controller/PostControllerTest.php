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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest
 *
 * Testuje dostępność strony listy postów i poprawność zwracanego HTML.
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Testuje, że metoda /posts zwraca poprawną odpowiedź HTML.
     *
     * Weryfikuje, że odpowiedź HTTP jest sukcesem (200)
     * oraz że Content-Type zawiera 'html'.
     */
    public function testListReturnsResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/posts');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }
}
