<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('category_index');
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1');
    }

}
