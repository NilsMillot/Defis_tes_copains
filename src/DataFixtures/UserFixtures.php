<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USER_TEST_1 = 'USER_TEST_1';
    const USER_TEST_2 = 'USER_TEST_2';
    const USER_TEST_3 = 'USER_TEST_3';
    const USER_ADMIN = 'USER_ADMIN';

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHaser = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 4; $i++) {
            $user = (new User())
                ->setUsername('user test' . $i)
                ->setEmail('test' . $i . '@gmail.com')
                ->setRoles(['ROLE_USER'])
                ->setStatut(true)
                ->setInitials('T' . $i);
            $user->setPassword($this->userPasswordHaser->hashPassword($user, 'test'));

            $manager->persist($user);
            $this->setReference("USER_TEST_" . $i, $user);
        }

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
