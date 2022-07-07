<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create('us_US');

        for ($i = 0; $i < 3; $i++) {
            $groupWithOneUser = (new Group())
                ->setName($this->faker->name)
                ->addUser($this->getReference(UserFixtures::USER_TEST_1));
            $groupWithOneUser->setNumberUser(sizeof($groupWithOneUser->getUsers()));

            $manager->persist($groupWithOneUser);
        }
        for ($i = 0; $i < 3; $i++) {
            $groupWithManyUsers = (new Group())
                ->setName($this->faker->name)
                ->addUser($this->getReference(UserFixtures::USER_TEST_1))
                ->addUser($this->getReference(UserFixtures::USER_TEST_2))
                ->addUser($this->getReference(UserFixtures::USER_TEST_3))
                ->addUser($this->getReference(UserFixtures::USER_ADMIN));
            $groupWithManyUsers->setNumberUser(sizeof($groupWithManyUsers->getUsers()));
            $manager->persist($groupWithManyUsers);
        }

        $manager->flush();
    }

    // allows to load this fixture only after UserFixtures
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
