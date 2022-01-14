<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $comment = new Comment();
            $comment->setContent('contenu-'. $i);
            $comment->setDate(new \DateTime('@'.strtotime('now')));
            $comment->setValid(1);
            $comment->setTrick($this->getReference('figure'. $i));
            $comment->setUser($this->getReference('utilisateur'. $i));
            $manager->persist($comment);

            $this->addReference('commentaire'. $i, $comment);
        }

        $manager->flush();
    }
}