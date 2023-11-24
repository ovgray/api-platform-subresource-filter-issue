<?php


namespace App\ApiPlatform;


use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Engagement;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

class EngagementBagItemQuantityFilter extends AbstractFilter
{

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        if (
            Engagement::class !== $resourceClass ||
            'min' !== $property ||
            empty($value)
        ) {
            return;
        }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $value = (int) $value;
        $queryBuilder->join($rootAlias.'.bag', 'bg');
        if ($value) {
            $queryBuilder->join('bg.items', 'it');
        } else {
            $queryBuilder->leftJoin('bg.items', 'it');
        }
        if (1 < $value) {
            $parameterName = $queryNameGenerator->generateParameterName('min');
            $queryBuilder->groupBy($rootAlias.'.id')
                ->having(sprintf('count(it.name) >= :%s', $parameterName))
                ->setParameter($parameterName, $value)
            ;
        }
//        dd($value, $queryBuilder->getDQL());
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'min' => [
                'property' => null,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter for minimum number of items engagement\'s bag',
                'openapi' => [
                    'allowReserved' => true,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => false,
                ],
            ],

        ];
    }
}