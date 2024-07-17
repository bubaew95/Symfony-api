<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Banner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookController extends AbstractController
{
    /**
     * @Route('/index', name="test_app")
     */
    public function index(): Response
    {
        return new Response('test');
    }
}
