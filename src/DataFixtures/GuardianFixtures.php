<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Guardian;
use App\DataFixtures\EleveFixtures;
use App\DataFixtures\GendreFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GuardianFixtures extends Fixture implements DependentFixtureInterface
{
    public const GUARDIAN_REFERENCE = 'gurdian';

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create("fr_FR");

        for($i=0; $i<=10; $i++){
            $guardian = new Guardian();
            $guardian->setName($faker->name())
                ->setSurname($faker->name())
                ->setEmail($faker->email())
                ->setAdresse($faker->Address())
                ->setCity($faker->City())
                ->setCodepostal($faker->postcode())
                ->setTelephone($faker->phoneNumber())
                ->setGendre($this->getReference("gendre".mt_rand(0,1)))

            ;

            $manager->persist($guardian);
             $this->addReference('guardian'.$i, $guardian);
        }

        $manager->flush();



    }

    public function getDependencies()
    {
        return [
            GendreFixtures::class,

        ];
    }


}
