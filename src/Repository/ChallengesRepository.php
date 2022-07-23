<?php

namespace App\Repository;

use App\Entity\Challenges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Challenges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenges[]    findAll()
 * @method Challenges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Challenges::class);
    }

    /**
     * Recherche des challenges en fonction du titre
     * @return void
     */
    public function search($name = null, $category = null){
        $query = $this->createQueryBuilder('c');
        $query->where('c.status=1');
        if($name !== null){
            $query->andWhere('LOWER(c.name) LIKE LOWER(:name)');
            $query->setParameter('name', '%'.$name.'%');
        }
        if($category !== null){
            $query->leftJoin('c.category','ca');
            $query->andWhere('ca.id = :id');
            $query->setParameter('id',$category);
        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Challenges[] Returns an array of Challenges objects
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
    public function findOneBySomeField($value): ?Challenges
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
