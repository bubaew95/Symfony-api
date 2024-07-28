<?php

namespace App\Tests\Functional;

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
}
