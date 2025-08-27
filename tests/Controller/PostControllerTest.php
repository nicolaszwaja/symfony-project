<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testListPageIsSuccessful(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('post_list', ['_locale' => 'pl']);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1'); // nagłówek na liście postów
    }

    public function testShowPageIsSuccessful(): void
    {
        $client = static::createClient();

        // Zakładamy, że w bazie jest post o id=1
        $url = $client->getContainer()->get('router')->generate('post_show', ['_locale' => 'pl', 'id' => 1]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1'); // tytuł posta
    }

    public function testNewPostPageIsSuccessful(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('post_new', ['_locale' => 'pl']);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }
}
