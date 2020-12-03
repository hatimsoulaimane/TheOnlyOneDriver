<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
//            $faker = Factory::create('fr_FR');
//
//        for($i = 0; $i < 2; $i++){
//            $user = new User();
//            $user->setNom($faker->unique(true)->lastName);
//            $user->setPrenom($faker->unique(true)->firstName);
//            $user->setNomComplet($faker->unique(true)->firstName);
//            $user->setEmail($faker->unique(true)->email);
//            $user->setAdresse($faker->unique(true)->address);
//            $user->setPassword($this->passwordEncoder->encodePassword($user,"mdp123"));
//            $manager->persist($user);
//        }
        $admin = new User();
        $admin->setNom( "Hatim");
        $admin->setPrenom( "Soulaiman");
        $admin->setEmail("soulaiman.hatim@gmail.com");
        $admin->setAdresse("200 rue balard 75015 Paris");
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,"milla2020"));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $manager->flush();
    }
}
