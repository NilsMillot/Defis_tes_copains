<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    const POST_TEST_1 = 'POST_TEST_1';

    public function load(ObjectManager $manager): void
    {
        $post = (new Post())
            ->setName('Adipisicing minim Lorem reprehenderit dolor aliqua qui.')
            ->setContent('Amet officia sit dolore ad excepteur deserunt nisi labore non Lorem. Dolore occaecat incididunt culpa minim velit enim voluptate laborum deserunt sunt id. Elit laborum veniam ea tempor proident.')
            ->addUserId($this->getReference(UserFixtures::USER_TEST_1))
            ->setChallengeId($this->getReference(ChallengeFixtures::CHALLENGE_TEST_1));

        $manager->persist($post);
        $this->setReference(self::POST_TEST_1, $post);

        $manager->flush();
    }

    // allows to load this fixture only after UserFixtures and ChallengeFixtures
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ChallengeFixtures::class,
        ];
    }
}
