<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Film>
 *
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Film::class);
    }

    public function paginatorFilm(int $page, int $limit) :PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r')
                ->orderBy('r.id', 'ASC'),
            $page,
            $limit
        );
    }
    
    public function paginatorFilmByCategory(int $page, int $limit, int $idCategory) :PaginationInterface {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r')
                ->andWhere('r.categories = :idCategory')
                ->setParameter('idCategory', $idCategory)
                ->orderBy('r.id', 'ASC'),
            $page,
            $limit
        );
    }
    
}
