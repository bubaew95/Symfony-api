<?php

namespace App\Tests\Functional;

use App\Factory\BookFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserResourceTest extends ApiTestCase
{
    use ResetDatabase;

    public function testPostToCreateUser(): void
    {
        $this->browser()
            ->post('/api/users', [
                'json' => [
                    'email' => 'test-2@mail.ru',
                    'password' => 'password',
                    'phone' => '79999999999',
                    'first_name' => 'test',
                    'middle_name' => 'test',
                    'last_name' => 'test',
                ],
            ])
            ->assertStatus(201)
            ->post('/login', [
                'json' => [
                    'email' => 'test-2@mail.ru',
                    'password' => 'password',
                ],
            ])
            ->assertSuccessful()
        ;
    }

    public function testPostToUpdateUser(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/users/'.$user->getId(), [
                'headers' => ['Content-Type' => 'application/merge-patch+json'],
                'json' => [
                    'email' => 'test-4@mail.ru',
                ],
            ])
            ->assertStatus(200)
        ;
    }

    public function testBooksCannotBeStolen(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);
        $otherUser = UserFactory::createOne();
        $book = BookFactory::createOne(['user' => $otherUser]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/users/'.$user->getId(), [
                'headers' => ['Content-Type' => 'application/merge-patch+json'],
                'json' => [
                    'email' => 'test-4@mail.ru',
                    'books' => [
                        '/api/books/'.$book->getId(),
                    ],
                ],
            ])
            ->assertStatus(422)
        ;
    }
}
