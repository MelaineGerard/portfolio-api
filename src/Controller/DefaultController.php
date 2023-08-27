<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    #[Route('/api', name: 'api')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => "Bienvenue sur l'API de mon portfolio !",
        ]);
    }
}
