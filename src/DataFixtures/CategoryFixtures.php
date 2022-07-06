<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const SPORT_CATEGORY = 'SPORT_CATEGORY';
    const CUISINE_CATEGORY = 'CUISINE_CATEGORY';
    const VOITURE_CATEGORY = 'VOITURE_CATEGORY';

    public function load(ObjectManager $manager): void
    {

        $sportCategory = (new Category())
            ->setName('Sport');
        $manager->persist($sportCategory);
        $this->setReference(self::SPORT_CATEGORY, $sportCategory);

        $cuisineCategory = (new Category())
            ->setName('Cuisine');
        $manager->persist($cuisineCategory);
        $this->setReference(self::CUISINE_CATEGORY, $cuisineCategory);

        $voitureCategory = (new Category())
            ->setName('Voiture');
        $manager->persist($voitureCategory);
        $this->setReference(self::VOITURE_CATEGORY, $voitureCategory);


        $manager->flush();
    }
}
