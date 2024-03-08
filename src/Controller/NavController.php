<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\FilmCounterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class NavController
 */
class NavController extends AbstractController
{
    
    /**
     * @param FilmCounterService $filmCounter
     * @param CategoryRepository $categoryRepository
     *
     * @return Response
     */
    public function index(FilmCounterService $filmCounter, CategoryRepository $categoryRepository): Response
    {
        return $this->render('nav/index.html.twig', [
            'count' => $filmCounter->count(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
