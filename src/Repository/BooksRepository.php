<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Book::class);
    }

    public function findAllWithCategory(?string $slug = null, User|int|null $user = null, string $sort = 'id'): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->addSelect('c', 'f')
            ->innerJoin('b.category', 'c')
            ->leftJoin('b.favorites', 'f', Join::WITH, 'f.user = :user')
            ->setParameter('user', $user)
        ;

        if (!is_null($slug)) {
            $queryBuilder->andWhere('c.name_url = :slug')->setParameter('slug', $slug);
        }

        return $queryBuilder->orderBy('b.'.$sort, 'DESC');
    }

    public function oneCategory(string $slug, User|int|null $user = null, int $limit = 8): mixed
    {
        return $this->findAllWithCategory($slug, $user)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function latestBooks(int $limit = 5, User|int|null $user = null): mixed
    {
        return $this->findAllWithCategory(user: $user)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function search($q): mixed
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.category', 'category')
            ->addSelect('category')
            ->andWhere('b.name LIKE :q or b.author LIKE :q')
            ->setParameter('q', sprintf('%%%s%%', $q))
        ;
    }

    public function findBookById(int $id): Book
    {
        if ($id === 0) {
            throw new InvalidArgumentException();
        }

        $book = $this->find($id);
        if (null === $book) {
            throw new NotFoundHttpException('Документ не найден.');
        }

        return $book;
    }

    public function similarBooks()
    {
        $queryBuilder = $this->_em->createQuery('SELECT b FROM App\Entity\Books b ORDER BY RAND()');

        return $queryBuilder
            ->setMaxResults(5)
            ->getResult()
        ;
    }

    public function booksQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
        ;
    }
}
