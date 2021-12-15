<?php

namespace App\Repository;

use App\Entity\RoleChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoleChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleChallenge[]    findAll()
 * @method RoleChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleChallenge::class);
    }

    // /**
    //  * @return RoleChallenge[] Returns an array of RoleChallenge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoleChallenge
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
