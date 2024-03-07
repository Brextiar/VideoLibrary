<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmFormType;
use App\Repository\FilmRepository;
use App\Service\FilmCounterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/Films/', name: 'films_')]
class FilmController extends AbstractController
{
    #[Route('add', name: 'add')]
    public function addForm(Request                $request,
                            SluggerInterface       $slugger,
                            EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $addFilmForm = $this->createForm(FilmFormType::class, $film);
        $addFilmForm->handleRequest($request);
        
        if ($addFilmForm->isSubmitted() && $addFilmForm->isValid()) {
            
            if ($addFilmForm->get('poster')->getData() instanceof UploadedFile) {
                $pictureFile = $addFilmForm->get('poster')->getData();
                $fileName = $this->getParameter('poster_dir') . '/' . $slugger->slug($film->getTitle()) . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move($this->getParameter('poster_dir'), $fileName);
                $film->setPoster($fileName);
            }
            
            $entityManager->persist($film);
            $entityManager->flush();
            
            $this->addFlash('success', 'Un livre a été enregistré');
            
            return $this->redirectToRoute('home', [
            ]);
            
        }
        return $this->render('film/add_film.html.twig', [
            //'categories' => $categories,
            'addFilmForm' => $addFilmForm,
            'film' => $film,
        ]);
    }
    
    #[Route('details/{id}', name: 'app_film_details', requirements: ['id' => '\d+'])]
    public function details(FilmRepository $filmRepository, Request $request): Response
    {
        $id = $request->get('id');
        $film = $filmRepository->find($id);
        return $this->render('film/details.html.twig', [
            'film' => $film,
        ]);
    }
}
