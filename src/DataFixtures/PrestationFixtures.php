<?php

namespace App\DataFixtures;

use App\Entity\Prestation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PrestationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $faker = Factory::create('fr_FR');
//
//        for($i = 0; $i < 4; $i++){
//            $prestation = new Prestation();
//            $prestation->setTitre($faker->unique(true)->company);
//            $prestation->setDescription($faker->unique(true)->firstName);
//            $prestation->setDestination($faker->unique(true)->address);
//            $prestation->setDispo($faker->unique(true)->boolean);
//            $prestation->setPrix($faker->unique(true)->randomNumber(2));
////            $prestation->setNbBagage($faker->unique(true)->colorName);
////            $prestation->setNbPassager($faker->unique(true)->colorName);
//            $manager->persist($prestation);
//        }
//
//
//        $manager->flush();
    }
}
