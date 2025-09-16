<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture for creating sample posts and categories.
 */
class AppFixtures extends Fixture
{
    /**
     * Loads sample categories and posts into the database.
     *
     * @param ObjectManager $manager The Doctrine object manager
     */
    public function load(ObjectManager $manager): void
    {
        // ---------------------
        // Usuwamy wszystkie posty i kategorie
        // ---------------------
        $manager->createQuery('DELETE FROM App\Entity\Post')->execute();
        $manager->createQuery('DELETE FROM App\Entity\Category')->execute();

        // ---------------------
        // Tworzymy nowe kategorie
        // ---------------------
        $names = ['Technologia', 'Sport', 'Kultura'];
        $categories = [];

        foreach ($names as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // ---------------------
        // Tworzymy 15 przykładowych postów
        // ---------------------
        for ($i = 1; $i <= 15; ++$i) {
            $post = new Post();
            $post->setTitle("Przykładowy post #$i");
            $post->setContent("To jest treść przykładowego posta numer $i.");
            $post->setCreatedAt(new \DateTimeImmutable());

            // losowa kategoria
            $post->setCategory($categories[array_rand($categories)]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
