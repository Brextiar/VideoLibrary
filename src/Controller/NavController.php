<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\FilmCounterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NavController extends AbstractController
{
    
    public function index(FilmCounterService $filmCounter, CategoryRepository $categoryRepository): Response
    {
        
        return $this->render('nav/index.html.twig', [
            'count' => $filmCounter->count(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
