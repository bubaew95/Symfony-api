<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function usersQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
        ;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function analytics(): array
    {
        $thirtyDaysAgo = new \DateTime();
        $thirtyDaysAgo->modify('-30 days');

        return $this->_em->createQuery(
            'SELECT count(u.id) count_all,
                    (SELECT count(a.id) FROM App\Entity\User a WHERE a.actived = 1) count_active,
                    (SELECT count(d.id) FROM App\Entity\User d WHERE d.actived = 0) count_deactive,
                    (SELECT count(n.id) FROM App\Entity\User n WHERE n.date >= :thirtyDaysAgo) count_new
                FROM App\Entity\User u'
        )->setParameter('thirtyDaysAgo', $thirtyDaysAgo)
        ->getSingleResult();
    }
}
