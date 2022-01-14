<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $media = new Media();
            $media->setIsmain(1);
            $media->setType(1);
            $media->setName('nommedia-'. $i);
            $media->setTrick($this->getReference('figure'. $i));
            $manager->persist($media);

            $this->addReference('media'. $i, $media);
        }

        $manager->flush();
    }
}