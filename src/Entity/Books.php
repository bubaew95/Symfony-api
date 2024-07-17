<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    public $dispatch;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $year = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $file = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $keywords = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $text = null;

    #[ORM\Column(type: "smallint", nullable: true)]
    private ?int $recomented = null;

    #[ORM\ManyToOne(targetEntity: Categories::class, inversedBy: "books")]
    private ?Categories $categories = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $author = null;

    #[ORM\OneToMany(mappedBy: "books", targetEntity: Review::class, cascade: ['persist', 'remove'])]
    private Collection $review;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $dateTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publisher = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $other = null;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private ?int $pages = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Favorite::class, fetch: 'EXTRA_LAZY')]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: UserBooksRead::class, cascade: ['persist', 'remove'])]
    private Collection $userBooksReads;

    public function __construct() {
        $this->review = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->userBooksReads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getRecomented(): ?int
    {
        return $this->recomented;
    }

    public function setRecomented(?int $recomented): self
    {
        $this->recomented = $recomented;

        return $this;
    }

    public function getDispatch(): ?int
    {
        return $this->dispatch;
    }

    public function setDispatch(?int $dispatch): self
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->categories;
    }

    public function setCategory(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->dateTime = $date;

        return $this;
    }

    public function getReview(): Collection
    {
        return $this->review;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(?string $other): self
    {
        $this->other = $other;

        return $this;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(?int $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    /**
     * @return Collection<int, UserBooksRead>
     */
    public function getUserBooksReads(): Collection
    {
        return $this->userBooksReads;
    }
}
