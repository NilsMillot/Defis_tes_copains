<?php

namespace App\Repository;

use App\Entity\UserLikePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserLikePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLikePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLikePost[]    findAll()
 * @method UserLikePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLikePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLikePost::class);
    }

    // /**
    //  * @return UserLikePost[] Returns an array of UserLikePost objects
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
    public function findOneBySomeField($value): ?UserLikePost
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
