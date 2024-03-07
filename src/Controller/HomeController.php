<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('')]
    #[Route('/home_page', name: 'home', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        
        $films = $entityManager->getRepository(Film::class)->findAll();
        
        return $this->render('home/index.html.twig', [
            'films' => $films,
            
        ]);
    }
    
}
