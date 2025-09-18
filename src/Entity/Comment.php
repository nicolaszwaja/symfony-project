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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a comment on a post.
 */
#[ORM\Entity]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Post $post;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nickname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * Returns the ID of the comment.
     *
     * @return int|null The unique identifier or null if not persisted
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the post associated with the comment.
     *
     * @return Post The post to which this comment belongs
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * Sets the post associated with the comment.
     *
     * @param Post $post The related post entity
     *
     * @return self Fluent interface
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Returns the nickname of the commenter.
     *
     * @return string The display name of the author
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * Sets the nickname of the commenter.
     *
     * @param string $nickname The display name chosen by the user
     *
     * @return self Fluent interface
     */
    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Returns the email of the commenter.
     *
     * @return string The email address of the author
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the email of the commenter.
     *
     * @param string $email The email address provided by the user
     *
     * @return self Fluent interface
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns the content of the comment.
     *
     * @return string The text body of the comment
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets the content of the comment.
     *
     * @param string $content The text body provided by the author
     *
     * @return self Fluent interface
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns the creation date of the comment.
     *
     * @return \DateTimeImmutable The timestamp when the comment was created
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation date of the comment.
     *
     * @param \DateTimeImmutable $createdAt The timestamp of comment creation
     *
     * @return self Fluent interface
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
