<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepagePl(): void
    {
        $client = static::createClient();
        $client->request('GET', '/pl/');

        // sprawdzenie statusu 200
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // sprawdzenie nagłówka
        $this->assertSelectorTextContains('h1', 'Blog');

    }

    public function testHomepageEn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('h1', 'Blog'); 
    }

    public function testRedirectRoot(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        // sprawdzenie przekierowania
        $this->assertResponseRedirects('/pl/');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Blog');
    }

    public function testLocaleSwitchLinks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pl/');

        // Sprawdzenie, że linki do zmiany języka istnieją
        $this->assertSelectorExists('a.btn-outline-primary:contains("Polski")');
        $this->assertSelectorExists('a.btn-outline-primary:contains("Angielski")');
    }

}
