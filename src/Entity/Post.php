<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity]
class Post
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)] // ← teraz obowiązkowa kategoria
    #[Assert\NotNull(message: "Post musi mieć przypisaną kategorię.")]
    private ?Category $category = null;

    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank(message: "Tytuł nie może być pusty.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Tytuł musi mieć przynajmniej {{ limit }} znaków.",
        maxMessage: "Tytuł nie może być dłuższy niż {{ limit }} znaków."
    )]
    private string $title;

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank(message: "Treść posta nie może być pusta.")]
    private string $content;

    #[ORM\Column(type:"datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    // -------------------
    // Gettery i Settery
    // -------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
