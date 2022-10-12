<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Eleve;
use App\DataFixtures\GendreFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EleveFixtures extends Fixture  implements DependentFixtureInterface
{
    public const ElEVE_REFERENCE = 'eleve';

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create("fr_FR");

        for($i=0; $i<=25; $i++){
            $eleve = new Eleve();
            $eleve->setName($faker->name())
                ->setSurname($faker->name())
                ->setDateInsriptionAt($faker->dateTimeBetween('-3 week', '+1 day'))
                ->setGendre($this->getReference("gendre".mt_rand(0,1)))
                ->setDateNaissance($faker->dateTimeBetween('-13 year', '-5 year'))
                ->setDesciption($faker->sentence(8))
                ->setGuardian($this->getReference("guardian".mt_rand(0,10)))
                ->setPhoto($faker->imageUrl(80, 70, 'flags', true))

            ;

        $manager->persist($eleve);
        $this->addReference("eleve".$i, $eleve);

        }

        $manager->flush();


    }

    public function getDependencies()
    {
        return [
            GendreFixtures::class,
            GuardianFixtures::class
        ];
    }

}
