<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class BookResourceTest extends KernelTestCase
{
    use HasBrowser;

    public function testGetCollectionOfBooks(): void
    {
        $this->browser()->get('/api/books')->dump();
    }

}