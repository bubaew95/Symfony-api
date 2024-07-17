<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Page::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Page $page, bool $flush = true): void
    {
        $this->_em->persist($page);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Page $page, bool $flush = true): void
    {
        $this->_em->remove($page);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function pageQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
        ;
    }
}
