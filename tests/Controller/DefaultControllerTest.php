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

use App\Service\DefaultServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for DefaultController.
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Tests that the root path ("/") redirects to the default locale.
     */
    public function testRedirectToDefaultLocale(): void
    {
        $client = static::createClient();

        $defaultServiceMock = $this->createMock(DefaultServiceInterface::class);
        $defaultServiceMock
            ->expects($this->once())
            ->method('getRedirectToDefaultLocale')
            ->willReturn(new RedirectResponse('/pl/'));

        $client->getContainer()->set(DefaultServiceInterface::class, $defaultServiceMock);

        $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/pl/', $response->getTargetUrl());
    }

    /**
     * Tests that the index page for the default locale renders successfully.
     */
    public function testIndex(): void
    {
        $client = static::createClient();

        $data = ['key' => 'value'];
        $defaultServiceMock = $this->createMock(DefaultServiceInterface::class);
        $defaultServiceMock
            ->expects($this->once())
            ->method('getHomepageData')
            ->willReturn($data);

        $client->getContainer()->set(DefaultServiceInterface::class, $defaultServiceMock);

        $client->request('GET', '/pl/');
        $response = $client->getResponse();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertResponseIsSuccessful();
    }
}
