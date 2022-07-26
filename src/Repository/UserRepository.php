<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * return le nombre de challenge par date
     * @return void
     */
    public function countByDate()
    {
        $query = $this->createQueryBuilder('u');
        //select par la date au format Y-m-d
        $query->select('DATE(u.createdAt) as dateUser, COUNT(u.id) as count');
        $query->groupBy('dateUser');
        $query->orderBy('dateUser', 'ASC');
        return $query->getQuery()->getResult();
    }

    public function findRecentUser()
    {
        $query = $this->createQueryBuilder('u');
        $query->select('u.username');
        $query->orderBy('u.createdAt', 'ASC');
        $query->setMaxResults(1);
        return $query->getQuery()->getResult();
    }

//    public function findByMaxChallenge()
//    {
//        $query = $this->createQueryBuilder('u');
//        $query->select('u.username, COUNT(u.username)');
//        $query->join('u.challenge', 'cu');
//        $query->groupBy('u.username');
//        $query->having('count(u.username)');
//        $query->select('max(countuser) as usercount');
//        $query->select('u.username, COUNT(u.username)');
//        $query->join('u.challenge', 'cus');
//        $query->groupBy('u.username');
//
//
//
//        return $query->getQuery()->getResult();
//
//    }

//SELECT username, COUNT(username)
//FROM "user"   join challenges_user on "user".id = challenges_user.user_id GROUP BY username
//HAVING COUNT (username)=(
//SELECT MAX(countuser)
//FROM (
//SELECT username, COUNT(username) countuser
//FROM "user" join challenges_user on "user".id = challenges_user.user_id
//GROUP BY username) as usercount);

    // public function findOrCreateFromOauth (GithubResourceOwner $resourceOwner)
    // {
    //     $user = $this->createQueryBuilder('u')
    //         ->where('u.githubId = :githubId')
    //         ->setParameters([
    //             'githubId' => $resourceOwner->getId()
    //         ])
    //         ->getQuery()
    //         ->getOneOrNullResult();
    //     if ($user){
    //         return $user;
    //     }
    //     $user = (new User())
    //         ->setGithubId($resourceOwner->getId())
    //         ->setEmail($resourceOwner->getEmail())
    //         ->setUsername($resourceOwner->getNickname());
    //     $em = $this->getEntityManager();
    //     $em->persist($user);
    //     $em->flush();

    //     return $user;
    // }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findUsers($usr)
    {
        return $this->createQueryBuilder('u')
            ->where('LOWER(u.username) LIKE LOWER(:usr)')
            ->setParameter('usr', '%' . $usr . '%')
            ->getQuery()
            ->getResult();
    }
}
