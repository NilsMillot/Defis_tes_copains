<?php

namespace App\DataFixtures;

use App\Entity\Remark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RemarkFixtures extends Fixture implements DependentFixtureInterface
{
    const REMARK_TEST_1 = 'REMARK_TEST_1';

    public function load(ObjectManager $manager): void
    {
        $remark = (new Remark())
            ->setContentRemark('Mollit laboris eu anim qui sit proident ad nisi eu aliquip. Ex fugiat cillum ad magna cupidatat est amet dolor adipisicing nostrud reprehenderit consectetur. Pariatur reprehenderit proident velit tempor deserunt est nisi.')
            ->addUserId($this->getReference(UserFixtures::USER_TEST_1))
            ->setPost($this->getReference(PostFixtures::POST_TEST_1));

        $manager->persist($remark);
        $this->setReference(self::REMARK_TEST_1, $remark);

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
