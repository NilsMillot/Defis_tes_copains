<?php

namespace App\Repository;

use App\Entity\UserLikeRemark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserLikeRemark|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLikeRemark|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLikeRemark[]    findAll()
 * @method UserLikeRemark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLikeRemarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLikeRemark::class);
    }

    // /**
    //  * @return UserLikeRemark[] Returns an array of UserLikeRemark objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserLikeRemark
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
