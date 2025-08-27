<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Comment
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Post $post;

    #[ORM\Column(type:'string', length:255)]
    #[Assert\NotBlank(message: 'Nick nie może być pusty.')]
    private string $nickname;

    #[ORM\Column(type:'string', length:255)]
    #[Assert\NotBlank(message: 'Email nie może być pusty.')]
    #[Assert\Email(message: 'Nieprawidłowy format adresu email.')]
    private string $email;

    #[ORM\Column(type:'text')]
    #[Assert\NotBlank(message: 'Komentarz nie może być pusty.')]
    private string $content;

    #[ORM\Column(type:'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    // ------------------- Gettery i settery -------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
