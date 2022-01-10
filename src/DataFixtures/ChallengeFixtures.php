<?php

namespace App\DataFixtures;

use App\Entity\Challenges;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChallengeFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create();

        for ($i = 0; $i < 10 ; $i++) {
            $object = (new Challenges())
                ->setName($this->faker->name)
                ->setCreationDate($this->faker->dateTimeBetween('-2 years', '-1 month'))
                ->setDeadline($this->faker->dateTimeBetween('+1 month', '+2 years'));

            $manager->persist($object);
        }

        $manager->flush();
    }
}
