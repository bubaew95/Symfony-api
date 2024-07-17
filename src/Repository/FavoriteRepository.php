<?php

namespace App\Repository;

use App\Entity\Favorite;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favorite>
 *
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

    public function favoriteQueryBuilder(User|int $user) : QueryBuilder
    {
        return $this->createQueryBuilder('f')
            ->addSelect('b', 'u')
            ->innerJoin('f.book', 'b')
            ->innerJoin('f.user', 'u')
            ->where('f.user = :userId')
            ->setParameter('userId', $user)
            ->orderBy('f.id', 'DESC')
        ;
    }
}
