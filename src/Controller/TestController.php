<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/hello', name: 'hello_world', methods: ['GET'])]

    public function list(): JsonResponse
    {
        return new JsonResponse(
            [
                'content' => 'hello world',
            ]
        );
    }
}
