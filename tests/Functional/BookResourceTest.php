<?php

namespace App\Tests\Functional;

use App\Factory\BookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BookResourceTest extends KernelTestCase
{
    use ResetDatabase;
    use HasBrowser;
    use Factories;

    public function testGetCollectionOfBooks(): void
    {
        BookFactory::createMany(5);

        $json = $this->browser()
            ->get('/api/books', [
                'headers' => [
                    'Accept' => 'application/ld+json',
                ],
            ])
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->assertJsonMatches('length("hydra:member")', 5)
            ->json()
        ;

        //        $json->assertMatches('keys("hydra:member"[0])', [
        //            '@id', '@type', 'id', 'image', 'pdf', 'name', 'user', 'shortName',
        //        ]);

        $this->assertSame(array_keys($json->decoded()['hydra:member'][0]), [
            '@id', '@type', 'id', 'image', 'pdf', 'name', 'user', 'shortName',
        ]);
    }
}
