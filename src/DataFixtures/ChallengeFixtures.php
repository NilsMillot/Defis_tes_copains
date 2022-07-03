<?php

namespace App\DataFixtures;

use App\Entity\Challenges;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create('us_US');

        for ($i = 0; $i < 3; $i++) {
            $challengeWithOneUser = (new Challenges())
                ->setName($this->faker->name)
                ->setCreationDate($this->faker->dateTime)
                ->setDescription('Amet officia sit dolore ad excepteur deserunt nisi labore non Lorem. Dolore occaecat incididunt culpa minim velit enim voluptate laborum deserunt sunt id. Elit laborum veniam ea tempor proident.')
                ->setDeadline($this->faker->dateTimeBetween('now', '+1 year'))
                ->setPicture($this->faker->imageUrl(640, 480, 'technics'))
                ->setCategory($this->getReference(CategoryFixtures::SPORT_CATEGORY))
                ->addUser($this->getReference(UserFixtures::USER_TEST_1));

            $manager->persist($challengeWithOneUser);
        }

        $manager->flush();
    }

    // allows to load this fixture only after UserFixtures
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GroupFixtures::class,
        ];
    }
}
