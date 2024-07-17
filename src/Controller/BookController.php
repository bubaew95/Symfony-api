<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BooksRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(UserRepository $booksRepository): Response
    {

        $books = $booksRepository->findAll();
        dd($books);
        return new Response('test');
    }
}
