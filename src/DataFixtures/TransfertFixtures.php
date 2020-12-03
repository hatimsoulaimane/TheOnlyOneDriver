<?php

namespace App\DataFixtures;

use App\Entity\Transfert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TransfertFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $faker = Factory::create('fr_FR');
//
//        for($i = 0; $i < 4; $i++){
//            $transfert = new Transfert();
//            $transfert->setTitre($faker->unique(true)->company);
//            $transfert->setDescription($faker->unique(true)->firstName);
//            $transfert->setDestination($faker->unique(true)->address);
//            $transfert->setPrix($faker->unique(true)->randomNumber(2));
//            $transfert->setNbBagage($faker->unique(true)->randomNumber(2));
//            $transfert->setNbPassager($faker->unique(true)->randomNumber(2));
//            $manager->persist($transfert);
//        }
//
//        $manager->flush();
    }
}
