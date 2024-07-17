<?php

namespace App\Controller;

use App\Entity\Banner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookController extends AbstractController
{
    /**
     * @Route('/index', name="test_app")
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return new \Symfony\Component\HttpFoundation\Response\Response('test');
    }
}