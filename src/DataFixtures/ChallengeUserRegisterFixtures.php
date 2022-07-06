<?php

namespace App\DataFixtures;

use App\Entity\ChallengesUserRegister;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChallengeUserRegisterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $challengeUserRegister = (new ChallengesUserRegister())
            ->setUserRegister($this->getReference(UserFixtures::USER_TEST_2))
            ->setChallengeRegister($this->getReference(ChallengeFixtures::CHALLENGE_TEST_1));

        $manager->persist($challengeUserRegister);

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
