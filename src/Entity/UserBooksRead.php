<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use App\Repository\UserBooksReadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: UserBooksReadRepository::class)]
class UserBooksRead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBooksReads')]
    private ?Books $books = null;

    #[ORM\ManyToOne(inversedBy: 'userBooksReads')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $dateTime = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $page = null;

    #[ORM\Column(nullable: true)]
    private ?int $count = null;

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

    public function getDate(): ?DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDate(DateTimeInterface $date): static
    {
        $this->dateTime = $date;

        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(?string $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
