<?php

namespace App\Tests\Functional;

use App\Entity\ApiToken;
use App\Entity\Book;
use App\Factory\ApiTokenFactory;
use App\Factory\BookFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BookResourceTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetCollectionOfBooks(): void
    {
        BookFactory::createMany(5, [
            'visible' => true,
        ]);

        BookFactory::createOne(['visible' => false]);

        $json = $this->browser()
            ->get('/api/books')
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->assertJsonMatches('length("hydra:member")', 5)
            ->json()
        ;
        //        $json->assertMatches('keys("hydra:member"[0])', [
        //            '@id', '@type', 'id', 'image', 'pdf', 'name', 'user', 'shortName',
        //        ]);

        $this->assertSame(array_keys($json->decoded()['hydra:member'][0]), [
            '@id', '@type', 'id', 'year', 'image', 'pdf', 'name', 'user', 'shortName',
        ]);
    }

    public function testPostToCreateBook(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->post('/api/books', [
                'json' => [],
            ])
            ->assertStatus(422)
            ->post('/api/books', [
                'json' => [
                    'file' => 'file.pdf',
                    'image' => 'image.png',
                    'name' => 'Test name',
                    'year' => 2023,
                    'visible' => false,
                ],
            ])
            ->assertStatus(201)
        ;
    }

    public function testPostToCreateBookWithApiKey(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_BOOK_CREATE],
        ]);

        $this->browser()
            ->post('/api/books', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token->getToken(),
                ],
                'json' => [],
            ])
            ->assertStatus(422)
        ;
    }

    public function testPostToCreateBookWithoutScope(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_BOOK_EDIT],
        ]);

        $this->browser()
            ->post('/api/books', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token->getToken(),
                ],
                'json' => [],
            ])
            ->assertStatus(403)
        ;
    }

    public function testPatchToUpdateBook(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);
        $book = BookFactory::createOne(['user' => $user]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 1234,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 1234)
        ;

        $user2 = UserFactory::createOne(['password' => 'password']);
        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user2->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 6789,
                ],
            ])
            ->assertStatus(403)
        ;

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user2->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'user' => '/api/users/'.$user2->getId(),
                ],
            ])
            ->assertStatus(403)
        ;

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'user' => '/api/users/'.$user2->getId(),
                ],
            ])
            ->assertStatus(422)
        ;
    }

    public function testAdminCanPatchToEditBook(): void
    {
        $admin = UserFactory::createOne(['roles' => ['ROLE_ADMIN'], 'password' => 'password']);
        $book = BookFactory::createOne([
            'visible' => true,
        ]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $admin->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 1234,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 1234)
            ->assertJsonMatches('visible', true)
        ;
    }

    public function testAdminCanSeeVisibleField(): void
    {
        $user = UserFactory::createOne(['password' => 'password', 'roles' => ['ROLE_ADMIN']]);
        $book = BookFactory::createOne([
            'visible' => true,
            'user' => $user,
        ]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 1234,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 1234)
            ->assertJsonMatches('visible', true)
        ;
    }

    public function testUserCanSeeVisibleField(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);
        $book = BookFactory::createOne([
            'visible' => true,
            'user' => $user,
        ]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 1234,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 1234)
            ->assertJsonMatches('visible', true)
        ;
    }

    public function testUserCanSeeVisibleAndIsMineFields(): void
    {
        $user = UserFactory::createOne(['password' => 'password']);
        $book = BookFactory::createOne([
            'visible' => true,
            'user' => $user,
        ]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$book->getId(), [
                'json' => [
                    'year' => 1234,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 1234)
            ->assertJsonMatches('visible', true)
            ->assertJsonMatches('isMine', true)
        ;
    }

    public function testGetOneUnpublishedBook404s(): void
    {
        $book = BookFactory::createOne([
            'visible' => false,
        ]);

        $this->browser()
            ->get('/api/books/'.$book->getId())
            ->assertStatus(404);
    }

    public function testPatchUnVisibleWorks()
    {
        $user = UserFactory::createOne(['password' => 'password']);
        $treasure = BookFactory::createOne([
            'user' => $user,
            'visible' => false,
        ]);

        $this->browser()
            ->post('/login', options: [
                'json' => [
                    'email' => $user->getEmail(),
                    'password' => 'password',
                ],
            ])
            ->patch('/api/books/'.$treasure->getId(), [
                'json' => [
                    'year' => 12345,
                ],
            ])
            ->assertStatus(200)
            ->assertJsonMatches('year', 12345)
        ;
    }
}
