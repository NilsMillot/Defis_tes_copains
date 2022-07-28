<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    const USER_ADMIN = 'USER_ADMIN';

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHaser = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setUsername('Admin user')
            ->setEmail('admin@gmail.com')
            ->setRoles(["ROLE_ADMIN"])
            ->setStatut(true)
            ->setInitials('AU');
        $admin->setPassword($this->userPasswordHaser->hashPassword($admin, 'admin'));
        $manager->persist($admin);
        $this->setReference(self::USER_ADMIN, $admin);

        $manager->flush();
    }
}
