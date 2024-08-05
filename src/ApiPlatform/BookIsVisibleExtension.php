<?php

namespace App\ApiPlatform;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Book;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class BookIsVisibleExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->addIsVisibleWhere($resourceClass, $queryBuilder);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addIsVisibleWhere($resourceClass, $queryBuilder);
    }

    public function addIsVisibleWhere(string $resourceClass, QueryBuilder $queryBuilder): void
    {
        if (Book::class !== $resourceClass) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->security->getUser();
        if ($user instanceof UserInterface) {
            $queryBuilder
                ->andWhere(sprintf('%s.visible=:visible OR %s.user=:user', $rootAlias, $rootAlias))
                ->setParameter('user', $user);
        } else {
            $queryBuilder->andWhere(sprintf('%s.visible=:visible', $rootAlias));
        }
        $queryBuilder->setParameter('visible', true);
    }
}
