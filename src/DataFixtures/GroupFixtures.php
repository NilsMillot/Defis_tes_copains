<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10 ; $i++) {
            $object = (new Group())
                ->setName($this->faker->name)
                ->setNumberUser(random_int(0, 1000))
                ->setPicture("https://picsum.photos/200/300");

            $manager->persist($object);
        }

        $manager->flush();
    }
}
