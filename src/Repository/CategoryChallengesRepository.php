<?php

namespace App\Repository;

use App\Entity\CategoryChallenges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryChallenges|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryChallenges|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryChallenges[]    findAll()
 * @method CategoryChallenges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryChallengesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryChallenges::class);
    }

    // /**
    //  * @return CategoryChallenges[] Returns an array of CategoryChallenges objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryChallenges
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
