<?php

namespace App\Entity;
 
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JetBrains\PhpStorm\Pure;

#[Gedmo\Tree(type: "nested")]
#[ORM\Table(name: "categories")]
#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 150)]
    private ?string $name_url = null;

    #[ORM\Column(type: "string", length: 6)]
    private ?string $bbk = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $directory = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $position = null;

    #[ORM\OneToMany(mappedBy: "category", targetEntity: Books::class)]
    private Collection $books;

    #[
        Gedmo\TreeLeft,
        ORM\Column(name: "lft", type: "integer")
     ]
    private ?int $lft = null;

    #[
        Gedmo\TreeLevel,
        ORM\Column(name: "lvl", type: "integer")
    ]
    private ?int $lvl = null;

    #[
        Gedmo\TreeRight,
        ORM\Column(name: "rgt", type: "integer")
    ]
    private ?int $rgt = null;

    #[
        Gedmo\TreeRoot,
        ORM\ManyToOne(targetEntity: "Categories"),
        ORM\JoinColumn(name: "tree_root", referencedColumnName: "id", onDelete: "CASCADE")
    ]
    private ?Categories $root = null;

    #[
        Gedmo\TreeParent,
        ORM\ManyToOne(targetEntity: "Categories", inversedBy: "children"),
        ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", onDelete: "CASCADE")
    ]
    private ?Categories $parent = null;

    #[
        ORM\OneToMany(mappedBy: "parent", targetEntity: "Categories"),
        ORM\OrderBy(['lft' => 'ASC'])
    ]
    private Collection $children;

    #[ORM\Column(type: "smallint", nullable: true)]
    private ?int $block = null;

    public function __construct() {
        $this->books = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setParent(?Categories $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Categories
    {
        return $this->parent;
    }

    public function getBlock(): ?int
    {
        return $this->block;
    }

    public function setBlock(?int $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNameUrl(): ?string
    {
        return $this->name_url;
    }

    public function setNameUrl(string $name_url): self
    {
        $this->name_url = $name_url;

        return $this;
    }

    public function getBbk(): ?string
    {
        return $this->bbk;
    }

    public function setBbk(string $bbk): self
    {
        $this->bbk = $bbk;

        return $this;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Books $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setCategory($this);
        }

        return $this;
    }

    public function removeBook(Books $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getCategory() === $this) {
                $book->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
