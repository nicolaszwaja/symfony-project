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
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Represents an admin user in the system.
 */
#[ORM\Entity]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $username;

    #[ORM\Column(type: 'text')]
    private string $roles = '[]';

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    /**
     * Returns the unique identifier of the admin.
     *
     * @return int|null The admin ID or null if not persisted
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the username.
     *
     * @return string The admin username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $username The new username for the admin
     *
     * @return self Fluent interface
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns the roles granted to the admin.
     *
     * @return array List of roles
     */
    public function getRoles(): array
    {
        return json_decode($this->roles, true);
    }

    /**
     * Sets roles for the admin.
     *
     * @param array $roles Array of roles to assign
     *
     * @return self Fluent interface
     */
    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

        return $this;
    }

    /**
     * Returns the hashed password.
     *
     * @return string The hashed password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Sets the hashed password.
     *
     * @param string $password The hashed password to store
     *
     * @return self Fluent interface
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the identifier for this user (used by Symfony security).
     *
     * @return string The username identifier
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * Removes any sensitive temporary data from the user.
     *
     * Example: clear plain-text passwords
     */
    public function eraseCredentials(): void
    {
        // For example, $this->plainPassword = null;
    }
}
