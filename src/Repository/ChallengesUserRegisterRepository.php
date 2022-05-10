<?php

namespace App\Repository;

use App\Entity\ChallengesUserRegister;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChallengesUserRegister|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengesUserRegister|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengesUserRegister[]    findAll()
 * @method ChallengesUserRegister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengesUserRegisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengesUserRegister::class);
    }

    // /**
    //  * @return ChallengesUserRegister[] Returns an array of ChallengesUserRegister objects
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
    public function findOneBySomeField($value): ?ChallengesUserRegister
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
