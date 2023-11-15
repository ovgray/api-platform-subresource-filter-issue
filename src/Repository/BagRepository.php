<?php

namespace App\Repository;

use App\Entity\Bag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bag>
 *
 * @method Bag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bag[]    findAll()
 * @method Bag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bag::class);
    }

//    /**
//     * @return Bag[] Returns an array of Bag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bag
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
