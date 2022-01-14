<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $trick = new Trick();
            $trick->setName('nomfigure-'. $i);
            $trick->setDescription('descriptionfigure-'. $i);
            $manager->persist($trick);

            $this->addReference('figure'. $i, $trick);
        }

        $manager->flush();
    }
}