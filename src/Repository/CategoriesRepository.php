<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Category::class));
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

    public function categoriesQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
        ;
    }

    public function categoryByAlias(string $alias): ?Category
    {
        return $this->findOneBy(['name_url' => $alias]);
    }
}
