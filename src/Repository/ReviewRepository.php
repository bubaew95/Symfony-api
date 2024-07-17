<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Review::class);
    }

    public function getReviewsWithBook(int $id, int $page, int $limit) : array
    {
        $queryBuilder = $this->_em->createQuery(
            'SELECT r, u FROM App\Entity\Review r INNER JOIN r.user u WHERE r.books = :id ORDER BY r.id DESC'
        );

        return $queryBuilder
            ->setParameter('id', $id)
            ->setFirstResult($page)
            ->setMaxResults($limit)
            ->getResult()
        ;
    }

    public function getReviewRatingWithBookById(int $id) : mixed
    {
        $queryBuilder = $this->_em->createQuery(
            'SELECT COUNT(r.id) as voter, SUM(r.rating) as rating FROM App\Entity\Review r WHERE r.books = :id '
        );

        return $queryBuilder
            ->setParameter('id', $id)
            ->getOneOrNullResult()
        ;
    }

    public function getReviewStarsById(int $id) : mixed
    {
        $queryBuilder = $this->_em->createQuery(
            'SELECT COUNT(r.id) as count, r.rating FROM App\Entity\Review r WHERE r.books = :id GROUP BY r.rating ORDER BY r.rating DESC'
        );

        return $queryBuilder
            ->setParameter('id', $id)
            ->getResult()
        ;
    }

    public function reviewsQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->addSelect('b, u')
            ->innerJoin('r.books', 'b')
            ->innerJoin('r.user', 'u')
            ->orderBy('r.id', 'DESC')
        ;
    }

}
