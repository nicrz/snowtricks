<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname('prenom-'. $i);
            $user->setLastname('nom-'. $i);
            $user->setNickname('pseudo-'. $i);
            $user->setEmail('email-'. $i);
            $user->setPassword('motdepasse-'. $i);
            $user->setActive(1);
            $manager->persist($user);

            $this->addReference('utilisateur'. $i, $user);
        }

        $manager->flush();
    }
}