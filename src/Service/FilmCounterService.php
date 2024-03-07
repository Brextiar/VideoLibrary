<?php

namespace App\Service;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;

class FilmCounterService
{
    public function __construct(private FilmRepository $filmRepository)
    {
    }
    
    public function count(): int
    {
        return $this->filmRepository->count();
    }
}