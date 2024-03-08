<?php

namespace App\Service;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FilmCounterService
 */
class FilmCounterService
{
    /**
     * @param FilmRepository $filmRepository
     */
    public function __construct(private FilmRepository $filmRepository)
    {
    }
    
    /**
     * @return int
     */
    public function count(): int
    {
        return $this->filmRepository->count();
    }
}