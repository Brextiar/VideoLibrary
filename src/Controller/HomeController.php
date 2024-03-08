<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Film;
use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use App\Service\FilmCounterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @param FilmRepository        $filmRepository
     * @param Request               $request
     * @param FilmCounterService    $filmCounter
     * @param SluggerInterface      $slugger
     *
     * @return Response
     */
    #[Route('')]
    #[Route('/home_page', name: 'home', methods: ['GET'])]
    public function index(FilmRepository     $filmRepository,
                          Request            $request,
                          FilmCounterService $filmCounter,
                          SluggerInterface   $slugger): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $films = $filmRepository->paginatorFilm($page, $limit);
        $maxFilms = round($filmCounter->count() / $limit);
        return $this->render('home/index.html.twig', [
            'films' => $films,
            'maxFilms' => $maxFilms,
            'page' => $page
        ]);
    }
    
    #[Route('/{categories}-{id}', name: 'category',  requirements: ['id' => '\d+', 'categories' => '.+'])]
    public function listByCategory(FilmRepository     $filmRepository,
                                   Request            $request,
                                   FilmCounterService $filmCounter,
                                   SluggerInterface   $slugger,
                                   CategoryRepository $categoryRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $films = $filmRepository->paginatorFilmByCategory($page, $limit, $request->get('id'));
        $maxFilms = round(count($films) / $limit);
        return $this->render('home/categories.html.twig', [
            'films' => $films,
            'maxFilms' => $maxFilms,
            'page' => $page,
            'category' => $categoryRepository->find($request->get('id'))
        ]);
    }
    
}
