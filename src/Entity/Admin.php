<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\Column(type:'string', length:180, unique:true)]
    private string $username;

    #[ORM\Column(type:'text')]
    private string $roles = '[]';

    #[ORM\Column(type:'string', length:255)]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        return json_decode($this->roles, true);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
        // np. $this->plainPassword = null;
    }
}
