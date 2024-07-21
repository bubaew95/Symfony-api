<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return User::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'date' => self::faker()->dateTime(),
            'email' => self::faker()->email(),
            'first_name' => self::faker()->text(60),
            'last_name' => self::faker()->text(60),
            'middle_name' => self::faker()->text(60),
            'password' => '123123',
            'roles' => ['ROLE_ADMIN'],
        ];
    }

    protected function initialize(): static
    {
        return $this
             ->afterInstantiate(function (User $user): void {
                 $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
             })
        ;
    }
}
