<?php

namespace App\Repository;

use App\Entity\Books;
use App\Entity\User;
use App\Entity\UserBooksRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserBooksRead>
 *
 * @method UserBooksRead|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBooksRead|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBooksRead[]    findAll()
 * @method UserBooksRead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBooksReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBooksRead::class);
    }

    public function existsBookToUserList(Books|int $book, User|int $user): ?UserBooksRead
    {
        return $this->findOneBy(['book' => $book, 'user' => $user]);
    }

    public function findOrCreate(Books|int $book, User|int $user): UserBooksRead
    {
        $existsBookToUser = $this->existsBookToUserList($book, $user);

        if(!$existsBookToUser) {
            return new UserBooksRead();
        }

        return $existsBookToUser;
    }

    public function findUserReadBooksByUserId(User|int $user): array
    {
        return $this->createQueryBuilder('ur')
            ->addSelect('b')
            ->innerJoin('ur.book', 'b')
            ->where('ur.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
