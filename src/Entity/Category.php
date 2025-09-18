<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a category for posts.
 */
#[ORM\Entity]
#[ORM\Table(
    name: 'category',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'unique_name',
            columns: ['name'],
        ),
    ],
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    /**
     * Returns the ID of the category.
     *
     * @return int|null The unique identifier or null if not persisted
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the name of the category.
     *
     * @return string|null The category name or null if not set
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of the category.
     *
     * @param string $name The new name of the category
     *
     * @return self Fluent interface
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
