<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?Books $books = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Books
    {
        return $this->books;
    }

    public function setBook(?Books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
