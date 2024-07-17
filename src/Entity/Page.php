<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use App\Repository\InfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
#[ORM\Table('info')]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", nullable: false)]
    private ?string $title = null;

    #[ORM\Column(type: "smallint", nullable: true)]
    private ?bool $see_title = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $text = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    #[Timestampable]
    private ?DateTime $dateTime = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\Column(type: "string", nullable: true)]
    #[Slug(fields: ['title'])]
    private ?string $block = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBlock(): ?string
    {
        return $this->block;
    }

    public function setBlock(?string $block): Page
    {
        $this->block = $block;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSeeTitle(): ?bool
    {
        return $this->see_title;
    }

    public function setSeeTitle(?bool $see_title): self
    {
        $this->see_title = $see_title;
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

    public function getDate(): ?DateTime
    {
        return $this->dateTime;
    }

    public function setDate(?DateTime $date): self
    {
        $this->dateTime = $date;
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
}
