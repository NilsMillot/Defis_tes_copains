<?php

namespace App\DataFixtures;

use App\Entity\Challenges;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    const CHALLENGE_TEST_1 = 'CHALLENGE_TEST_1';
    const CHALLENGE_TEST_2 = 'CHALLENGE_TEST_2';
    const CHALLENGE_TEST_3 = 'CHALLENGE_TEST_3';

    public function load(ObjectManager $manager): void
    {
        $this->faker = \Faker\Factory::create('us_US');
        $filesInPublicImages = scandir(__DIR__ . '/../../public/images');
        $filesInPublicImages = array_slice($filesInPublicImages, 2);

        for ($i = 1; $i < 4; $i++) {
            $challenge = (new Challenges())
                ->setName($this->faker->name)
                ->setCreationDate($this->faker->dateTime)
                ->setDescription('Amet officia sit dolore ad excepteur deserunt nisi labore non Lorem. Dolore occaecat incididunt culpa minim velit enim voluptate laborum deserunt sunt id. Elit laborum veniam ea tempor proident.')
                ->setDeadline($this->faker->dateTimeBetween('now', '+1 year'))
//                ->setPicture($this->faker->imageUrl(640, 480, 'technics'))
                ->setCategory($this->getReference(CategoryFixtures::SPORT_CATEGORY))
                ->setStatus(true)
                ->addUser($this->getReference(UserFixtures::USER_TEST_1))
                ->setImageName($filesInPublicImages[$i] ?? '');

            $manager->persist($challenge);
            $this->setReference("CHALLENGE_TEST_" . $i, $challenge);
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
