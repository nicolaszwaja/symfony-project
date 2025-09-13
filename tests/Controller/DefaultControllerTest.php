<?php

namespace App\Tests\Controller;

use App\Service\DefaultServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testRedirectToDefaultLocale(): void
    {
        $client = static::createClient();

        // Mock serwisu po utworzeniu klienta
        $defaultServiceMock = $this->createMock(DefaultServiceInterface::class);
        $defaultServiceMock
            ->expects($this->once())
            ->method('getRedirectToDefaultLocale')
            ->willReturn(new RedirectResponse('/pl/'));

        // Nadpisanie serwisu w kontenerze testowym
        $client->getContainer()->set(DefaultServiceInterface::class, $defaultServiceMock);

        $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/pl/', $response->getTargetUrl());
    }

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
