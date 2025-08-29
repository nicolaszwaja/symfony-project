<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class CommentControllerTest extends WebTestCase
{
    private $client;
    private $em;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testAddCommentRedirects(): void
    {
        // 1. Tworzymy kategorię
        $category = new Category();
        $category->setName('Test Category');
        $this->em->persist($category);

        // 2. Tworzymy post
        $post = new Post();
        $post->setTitle('Test Post');
        $post->setContent('Test content');
        $post->setCreatedAt(new \DateTimeImmutable());
        $post->setCategory($category);
        $this->em->persist($post);

        $this->em->flush();

        // 3. Odwiedzamy stronę posta
        $crawler = $this->client->request('GET', '/posts/' . $post->getId());

        // 4. Wypełniamy formularz komentarza
        $form = $crawler->selectButton('Dodaj')->form([
            'comment_type_form[nickname]' => 'Tester',
            'comment_type_form[email]' => 'tester@example.com',
            'comment_type_form[content]' => 'This is a test comment',
        ]);

        // 5. Wysyłamy formularz
        $this->client->submit($form);

        // 6. Sprawdzamy, czy nastąpiło przekierowanie
        $this->assertTrue($this->client->getResponse()->isRedirect());

        // 7. Podążamy za przekierowaniem
        $crawler = $this->client->followRedirect();

        // 8. Sprawdzamy, czy komentarz pojawia się na stronie
        $this->assertStringContainsString('This is a test comment', $crawler->filter('body')->text());
    }
}
