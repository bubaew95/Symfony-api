<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'LAZY', inversedBy: "review")]
    private User $user;

    #[ORM\Column(type: "text", nullable: false)]
    private string $text;

    #[ORM\Column(type: "string", nullable: true)]
    private ?int $rating = null;

    #[ORM\OneToMany(mappedBy: "reviews", targetEntity: Review::class)]
    private Collection $parent;

    #[ORM\ManyToOne(targetEntity: Review::class, inversedBy: "parent")]
    private ?Review $reviews = null;

    #[ORM\ManyToOne(targetEntity: Books::class, fetch: 'EXTRA_LAZY', inversedBy: "review")]
    private Books $books;

    #[ORM\Column(nullable: true)]
    private ?int $likes = null;

    #[ORM\Column(nullable: true)]
    private ?int $dislikes = null;

    public function __construct() {
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function getReviews(): ?Review
    {
        return $this->reviews;
    }

    public function setReviews(?Review $reviews): self
    {
        $this->reviews = $reviews;
        return $this;
    }

    public function getBooks(): Books
    {
        return $this->books;
    }

    public function setBooks(Books $books): self
    {
        $this->books = $books;
        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislike(?int $dislikes): static
    {
        $this->dislikes = $dislikes;

        return $this;
    }
}
