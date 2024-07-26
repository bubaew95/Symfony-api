<?php

namespace App\Factory;

use App\Entity\Book;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Book::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'file' => 'file.pdf',
            'image' => 'image.png',
            'name' => self::faker()->text(50),
            'user' => UserFactory::new(),
            'visible' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Book $book): void {})
        ;
    }
}
