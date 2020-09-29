<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    public function get3LastMovie(): ?array
    {
        return $this->createQueryBuilder('m')
            ->join('m.realisator', 'p')
            ->addSelect("p")
            ->orderBy("m.releaseDate","DESC")
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

    }
    public function getMovies(): ?array
    {
        return $this->createQueryBuilder('m')
            ->join('m.realisator', 'p')
            ->addSelect("p")
            ->getQuery()
            ->getResult();

    }

    public function getMoviesByCategory($id): ?array
    {
        return $this->createQueryBuilder('m')
            ->join('m.category', 'c')
            ->where('m.category = ?1')
            ->join('m.realisator', 'p')
            ->addSelect("p")
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();

    }

    public function getMovieDetail($slug): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->where('m.slug = ?1')
            ->join('m.realisator', 'p')
            ->addSelect("p")
            ->setParameter(1, $slug)
            ->getQuery()
            ->getSingleResult();

    }
}
