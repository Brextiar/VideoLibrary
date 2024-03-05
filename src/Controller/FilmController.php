<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Films/', name: 'films_')]
class FilmController extends AbstractController
{
    #[Route('add', name: 'add', methods: ['GET'])]
    public function addForm(SessionInterface $session): Response
    {
        $categories = $session->get('categories');
        $addFilmForm = $this->createForm(FilmType::class);

        return $this->render('film/add_film.html.twig', [
            'controller_name' => 'FilmController',
            'categories' => $categories,
            'addFilmForm' => $addFilmForm,
            
        ]);
    }
}
