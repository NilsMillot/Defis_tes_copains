<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USER_TEST = 'USER_TEST';
    const USER_SUPER_ADMIN = 'USER_SUPER_ADMIN';

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHaser = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setUsername('John Doe')
            ->setEmail('test@gmail.com')
            ->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHaser->hashPassword($user, 'test'));
        $manager->persist($user);
        $this->setReference(self::USER_TEST, $user);

        $superAdmin = (new User())
            ->setUsername('John Doe SUPER ADMIN')
            ->setEmail('superadmin@gmail.com')
            ->setRoles(["ROLE_SUPER_ADMIN"]);
        $superAdmin->setPassword($this->userPasswordHaser->hashPassword($superAdmin, 'superadmin'));
        $manager->persist($superAdmin);
        $this->setReference(self::USER_SUPER_ADMIN, $superAdmin);

        $manager->flush();
    }
}
