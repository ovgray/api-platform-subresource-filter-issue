<?php


namespace App\ApiPlatform;


use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Engagement;
use Doctrine\ORM\QueryBuilder;

class EngagementExtension implements QueryCollectionExtensionInterface
{

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $queryNameGenerator, $resourceClass, $context);
    }
    private function addWhere(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass, array $context)
    {
        if (Engagement::class !== $resourceClass) {
            return;
        }
        // If an "active" Filter is not expressly requested, apply a restriction to the QueryBuilder
        if ($context['filters']['active'] ?? null) {
            return;
        }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $parameterName = $queryNameGenerator->generateParameterName('active');
        $queryBuilder->andWhere(sprintf('%s.active = :%s', $rootAlias, $parameterName));
        $queryBuilder->setParameter($parameterName, true);
    }
}