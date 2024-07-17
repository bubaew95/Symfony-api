<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $registry)
    {
        parent::__construct($registry, $registry->getClassMetadata(Categories::class));
    }

    public function getMenu($value): Query
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.root, c.lft', 'ASC')
            ->addOrderBy('c.name', 'ASC')
            ->where('c.block = :val')
            ->setParameter('val', $value)
            ->getQuery()
        ;
    }

    public function categoriesQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
        ;
    }

    public function categoryByAlias(string $alias): ?Categories
    {
        return $this->findOneBy(['name_url' => $alias]);
    }
}
