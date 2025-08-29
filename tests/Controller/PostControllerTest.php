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
        $this->assertSelectorExists('h1');
    }

    public function testShowPageIsSuccessful(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('post_show', ['_locale' => 'pl', 'id' => 1]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h1');
    }

    public function testNewPostPageIsSuccessful(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('post_new', ['_locale' => 'pl']);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function testEditPostPageIsSuccessful(): void
    {
        $client = static::createClient();
        // Zakładamy, że post o id=1 istnieje
        $url = $client->getContainer()->get('router')->generate('post_edit', ['_locale' => 'pl', 'id' => 1]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form'); // formularz edycji
    }

    public function testDeletePostRedirects(): void
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine')->getManager();

        // Utworzenie testowego posta
        $category = $em->getRepository(\App\Entity\Category::class)->find(1);
        $post = new \App\Entity\Post();
        $post->setTitle('Test Post');
        $post->setContent('Test content');
        $post->setCreatedAt(new \DateTimeImmutable());
        $post->setCategory($category);
        $em->persist($post);
        $em->flush();

        // Pobranie istniejącego admina
        $admin = $em->getRepository(\App\Entity\Admin::class)->findOneBy([
            'username' => 'admin' // użyj pola istniejącego w Admin
        ]);

        $client->loginUser($admin);


        // Wywołanie akcji delete
        $url = $client->getContainer()->get('router')->generate('post_delete', [
            '_locale' => 'pl',
            'id' => $post->getId(),
        ]);
        $client->request('POST', $url);

        // Sprawdzenie przekierowania po usunięciu
        $this->assertResponseRedirects('/admin'); // docelowa strona po usunięciu
    }

    public function testShowNonExistentPostReturns404(): void
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('post_show', ['_locale' => 'pl', 'id' => 9999]);
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(404);
    }
}
