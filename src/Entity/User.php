<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ORM\Entity(repositoryClass: UserRepository::class),
    UniqueEntity(
        fields: ['email'],
        message: 'Такой емайл уже зарегистрирован'
    )
]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
    ],
    normalizationContext: [
        'groups' => ['user:read'],
    ],
    denormalizationContext: [
        'groups' => ['user:write'],
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const STATUS_PASSWORD_UPDATE = 'password_update';

    public const STATUS_ACTIVED = 'actived';

    public const STATUS_DEACTIVATED = 'deactivated';

    public const STATUS_BAN = 'ban';

    public const STATUSES = [
        self::STATUS_PASSWORD_UPDATE => [
            'color' => 'warning',
            'text' => 'Необходимо обновить пароль',
        ],
        self::STATUS_ACTIVED => [
            'color' => 'success',
            'text' => 'Активен',
        ],
        self::STATUS_DEACTIVATED => [
            'color' => 'danger',
            'text' => 'Деактивирован',
        ],
        self::STATUS_BAN => [
            'color' => 'danger',
            'text' => 'Заблокирован',
        ],
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Groups(['user:read', 'user:write', 'books:read'])]
    #[
        Assert\NotBlank(message: 'Поле Email не может быть пустым'),
        Assert\Email(message: 'Некорректный формат Email'),
        ORM\Column(type: 'string', length: 180, unique: true)
    ]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[Groups(['user:write'])]
    #[ORM\Column(type: 'string')]
    private string $password;

    #[Groups(['user:read', 'user:write'])]
    #[
        Assert\NotBlank(message: 'Поле {{ label }} не может быть пустым', groups: ['registration']),
        ORM\Column(type: 'string', length: 20, nullable: true),
        Assert\Regex('/^((8|\+?7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'Некорректный формат номера телефона.')
    ]
    private ?string $phone = null;

    #[
        Assert\NotBlank(message: 'Поле {{ label }} не может быть пустым', groups: ['registration']),
        ORM\Column(type: 'string', length: 255, nullable: true)
    ]
    private ?string $work_or_school = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $is_admin = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $actived = null;

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $user_agent = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $home_address = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?string $isSubscribe = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $last_sur_name = null;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $hash = null;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'user')]
    private Collection $review;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Favorite::class)]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserBooksRead::class)]
    private Collection $userBooksReads;

    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank(message: 'Поле {{ label }} не может быть пустым', groups: ['registration'])]
    #[ORM\Column(length: 60)]
    private ?string $first_name = null;

    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank(message: 'Поле {{ label }} не может быть пустым', groups: ['registration'])]
    #[ORM\Column(length: 60)]
    private ?string $middle_name = null;

    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank(message: 'Поле {{ label }} не может быть пустым', groups: ['registration'])]
    #[ORM\Column(length: 60)]
    private ?string $last_name = null;

    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->userBooksReads = new ArrayCollection();
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWorkOrSchool(): ?string
    {
        return $this->work_or_school;
    }

    public function setWorkOrSchool(?string $work_or_school): self
    {
        $this->work_or_school = $work_or_school;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(?bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getActived(): ?bool
    {
        return $this->actived;
    }

    public function setActived(?bool $actived): self
    {
        $this->actived = $actived;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function setUserAgent(?string $user_agent): self
    {
        $this->user_agent = $user_agent;

        return $this;
    }

    public function getHomeAddress(): ?string
    {
        return $this->home_address;
    }

    public function setHomeAddress(?string $home_address): self
    {
        $this->home_address = $home_address;

        return $this;
    }

    public function getIsSubscribe(): ?bool
    {
        return $this->isSubscribe;
    }

    public function setIsSubscribe(?bool $isSubscribe): self
    {
        $this->isSubscribe = $isSubscribe;

        return $this;
    }

    #[Groups(['books:read'])]
    public function getFullName(): ?string
    {
        return sprintf('%s %s %s', $this->getFirstName(), $this->getMiddleName(), $this->getLastName());
    }

    public function getUserNameFromReview(): ?string
    {
        $middleName = mb_substr((string) $this->getMiddleName(), 0, 1);

        return sprintf('%s %s.', $this->getFirstName(), $middleName);
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getReview(): Collection
    {
        return $this->review;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        // set the owning side to null (unless already changed)
        if ($this->favorites->removeElement($favorite) && $favorite->getUser() === $this) {
            $favorite->setUser(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserBooksRead>
     */
    public function getUserBooksReads(): Collection
    {
        return $this->userBooksReads;
    }

    public function addUserBooksRead(UserBooksRead $userBooksRead): static
    {
        if (!$this->userBooksReads->contains($userBooksRead)) {
            $this->userBooksReads->add($userBooksRead);
            $userBooksRead->setUser($this);
        }

        return $this;
    }

    public function removeUserBooksRead(UserBooksRead $userBooksRead): static
    {
        // set the owning side to null (unless already changed)
        if ($this->userBooksReads->removeElement($userBooksRead) && $userBooksRead->getUser() === $this) {
            $userBooksRead->setUser(null);
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(?string $middle_name): static
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }
}
