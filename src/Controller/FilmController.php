<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Film;
use App\Form\FilmFormType;
use App\Form\FilmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/Films/', name: 'films_')]
class FilmController extends AbstractController
{
    #[Route('add', name: 'add', methods: ['GET'])]
    public function addForm(SessionInterface       $session,
                            Request                $request,
                            SluggerInterface       $slugger,
                            EntityManagerInterface $entityManager): Response
    {
        $categories = $session->get('categories');
        
        $film = new Film();
        $addFilmForm = $this->createForm(FilmFormType::class, $film);
        
        $addFilmForm->handleRequest($request);
      
        
        if ($addFilmForm->isSubmitted() && $addFilmForm->isValid()) {
            
            if ($addFilmForm->get('poster')->getData() instanceof UploadedFile) {
                $pictureFile = $addFilmForm->get('poster')->getData();
                $fileName = $slugger->slug($film->getTitle()) . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move($this->getParameter('poster_dir'), $fileName);
                $film->setPoster($fileName);
            }
            
            $entityManager->persist($film);
            $entityManager->flush();
            
            $this->addFlash('success', 'Un livre a été enregistré');
            
            return $this->redirectToRoute('home', [
                'categories' => $categories
            ]);
            
        }
        
        
        
        return $this->render('film/add_film.html.twig', [
            'categories' => $categories,
            'addFilmForm' => $addFilmForm,
            'film' => $film
        ]);
    }
}
