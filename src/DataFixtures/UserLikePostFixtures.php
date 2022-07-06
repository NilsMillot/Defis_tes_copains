<?php

namespace App\DataFixtures;

use App\Entity\UserLikePost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserLikePostFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $userLikePost = (new userLikePost())
            ->setUserWhoLiked($this->getReference(UserFixtures::USER_TEST_1))
            ->setPostLiked($this->getReference(PostFixtures::POST_TEST_1));

        $manager->persist($userLikePost);

        $manager->flush();
    }

    // allows to load this fixture only after UserFixtures and PostFixtures
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
