<?php

namespace App\DataFixtures;

use App\Entity\Gendre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GendreFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<=1; $i++){
            $gendre = new Gendre();
            if($i == 0) $gendre->setName('Masculin');
            else $gendre->setName('Femenin');
            $manager->persist($gendre);

            $this->addReference('gendre'.$i, $gendre);


         }





        $manager->flush();


    }
}
