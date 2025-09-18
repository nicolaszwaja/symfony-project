<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testListRouteReturnsResponse(): void
    {
        $client = static::createClient();

        // Wyślij GET na route listy kategorii
        $client->request('GET', '/admin/categories/');

        $response = $client->getResponse();

        // Sprawdź, że odpowiedź HTTP została zwrócona (200, 302 redirect też można sprawdzić)
        $this->assertTrue(
            $response->isSuccessful() || $response->isRedirect(),
            'Odpowiedź powinna być udana lub redirect'
        );

        // Możesz też sprawdzić Content-Type
        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }

    public function testNewRouteReturnsResponse(): void
    {
        $client = static::createClient();

        // Wyślij GET na route tworzenia nowej kategorii
        $client->request('GET', '/admin/categories/new');

        $response = $client->getResponse();

        $this->assertTrue(
            $response->isSuccessful() || $response->isRedirect(),
            'Odpowiedź powinna być udana lub redirect'
        );

        $this->assertStringContainsString('html', $response->headers->get('Content-Type'));
    }
}
