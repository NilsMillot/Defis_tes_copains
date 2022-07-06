<?php

namespace App\DataFixtures;

use App\Entity\UserLikeChallenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserLikeChallengeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $userLikeChallenge = (new UserLikeChallenge())
            ->setUserWhoLikedChallenge($this->getReference(UserFixtures::USER_TEST_1))
            ->setChallengesLiked($this->getReference(ChallengeFixtures::CHALLENGE_TEST_1));

        $manager->persist($userLikeChallenge);

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
